<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\NewsletterSubscription;
use App\Services\NewsletterEmailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class NewsletterController extends Controller
{
    protected $newsletterEmailService;

    public function __construct(NewsletterEmailService $newsletterEmailService)
    {
        $this->newsletterEmailService = $newsletterEmailService;
    }

    /**
     * Display newsletter subscriptions
     */
    public function index(Request $request)
    {
        $query = NewsletterSubscription::query();

        // Search functionality
        if ($request->has('search') && ! empty($request->search)) {
            $query->where('email', 'like', "%{$request->search}%");
        }

        // Status filter
        if ($request->has('status') && $request->status !== '') {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            } elseif ($request->status === 'verified') {
                $query->whereNotNull('email_verified_at');
            } elseif ($request->status === 'unverified') {
                $query->whereNull('email_verified_at');
            }
        }

        // Source filter
        if ($request->has('source') && $request->source !== '') {
            $query->where('source', $request->source);
        }

        // Date range filter
        if ($request->has('date_from') && ! empty($request->date_from)) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && ! empty($request->date_to)) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $subscriptions = $query->latest()->paginate(25)->withQueryString();

        // Get statistics
        $stats = [
            'total' => NewsletterSubscription::count(),
            'active' => NewsletterSubscription::active()->count(),
            'inactive' => NewsletterSubscription::where('is_active', false)->count(),
            'verified' => NewsletterSubscription::verified()->count(),
            'unverified' => NewsletterSubscription::unverified()->count(),
            'today' => NewsletterSubscription::whereDate('created_at', today())->count(),
            'this_week' => NewsletterSubscription::where('created_at', '>=', now()->startOfWeek())->count(),
            'this_month' => NewsletterSubscription::where('created_at', '>=', now()->startOfMonth())->count(),
        ];

        // Get sources
        $sources = NewsletterSubscription::distinct()
            ->pluck('source')
            ->filter()
            ->sort()
            ->values();

        return view('admin.newsletter.index', compact('subscriptions', 'stats', 'sources'));
    }

    /**
     * Export subscriptions to CSV
     */
    public function export(Request $request)
    {
        $query = NewsletterSubscription::query();

        // Apply same filters as index
        if ($request->has('search') && ! empty($request->search)) {
            $query->where('email', 'like', "%{$request->search}%");
        }

        if ($request->has('status') && $request->status !== '') {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            } elseif ($request->status === 'verified') {
                $query->whereNotNull('email_verified_at');
            } elseif ($request->status === 'unverified') {
                $query->whereNull('email_verified_at');
            }
        }

        if ($request->has('source') && $request->source !== '') {
            $query->where('source', $request->source);
        }

        if ($request->has('date_from') && ! empty($request->date_from)) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && ! empty($request->date_to)) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $subscriptions = $query->get();

        $filename = 'newsletter_subscriptions_'.now()->format('Y-m-d_H-i-s').'.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        return Response::stream(function () use ($subscriptions) {
            $handle = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($handle, [
                'Email',
                'Status',
                'Verified',
                'Source',
                'Subscribed Date',
                'Verified Date',
                'IP Address',
            ]);

            // Add data rows
            foreach ($subscriptions as $subscription) {
                fputcsv($handle, [
                    $subscription->email,
                    $subscription->is_active ? 'Active' : 'Inactive',
                    $subscription->hasVerifiedEmail() ? 'Yes' : 'No',
                    $subscription->source,
                    $subscription->created_at->format('Y-m-d H:i:s'),
                    $subscription->email_verified_at ? $subscription->email_verified_at->format('Y-m-d H:i:s') : '',
                    $subscription->ip_address,
                ]);
            }

            fclose($handle);
        }, 200, $headers);
    }

    /**
     * Handle bulk actions
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:activate,deactivate,delete',
            'subscriptions' => 'required|array|min:1',
            'subscriptions.*' => 'exists:newsletter_subscriptions,id',
        ]);

        $count = 0;
        $subscriptions = NewsletterSubscription::whereIn('id', $request->subscriptions);

        switch ($request->action) {
            case 'activate':
                $count = $subscriptions->update(['is_active' => true]);
                $message = "Activated {$count} subscription(s).";
                break;

            case 'deactivate':
                $count = $subscriptions->update(['is_active' => false]);
                $message = "Deactivated {$count} subscription(s).";
                break;

            case 'delete':
                $count = $subscriptions->delete();
                $message = "Deleted {$count} subscription(s).";
                break;
        }

        return redirect()
            ->route('admin.newsletter.index')
            ->with('success', $message);
    }

    /**
     * Send test newsletter
     */
    public function sendTestNewsletter(Request $request)
    {
        $request->validate([
            'article_id' => 'required|exists:articles,id',
            'test_email' => 'required|email',
        ]);

        $article = Article::with(['author', 'categories'])->findOrFail($request->article_id);

        $success = $this->newsletterEmailService->sendTestNewsletter($article, $request->test_email);

        if ($success) {
            return back()->with('success', 'Test newsletter sent successfully to '.$request->test_email);
        } else {
            return back()->with('error', 'Failed to send test newsletter. Check logs for details.');
        }
    }

    /**
     * Send immediate newsletter for article
     */
    public function sendNewsletterForArticle(Request $request)
    {
        $request->validate([
            'article_id' => 'required|exists:articles,id',
        ]);

        $article = Article::with(['author', 'categories'])->findOrFail($request->article_id);

        $success = $this->newsletterEmailService->sendImmediateNewsletter($article);

        if ($success) {
            return back()->with('success', 'Newsletter sent successfully to all subscribers!');
        } else {
            return back()->with('error', 'Failed to send newsletter. Check logs for details.');
        }
    }

    /**
     * Show newsletter settings
     */
    public function settings()
    {
        $stats = $this->newsletterEmailService->getNewsletterStats();
        $recentArticles = Article::with(['author', 'categories'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.newsletter.settings', compact('stats', 'recentArticles'));
    }

    /**
     * Get newsletter analytics data for dashboard
     */
    public function getAnalytics()
    {
        // Subscriptions over time (last 30 days)
        $subscriptionsOverTime = NewsletterSubscription::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date');

        // Subscriptions by source
        $subscriptionsBySource = NewsletterSubscription::selectRaw('source, COUNT(*) as count')
            ->groupBy('source')
            ->orderBy('count', 'desc')
            ->get()
            ->pluck('count', 'source');

        // Growth rate (comparing this month to last month)
        $thisMonth = NewsletterSubscription::where('created_at', '>=', now()->startOfMonth())->count();
        $lastMonth = NewsletterSubscription::whereBetween('created_at', [
            now()->subMonth()->startOfMonth(),
            now()->subMonth()->endOfMonth(),
        ])->count();

        $growthRate = $lastMonth > 0 ? (($thisMonth - $lastMonth) / $lastMonth) * 100 : 0;

        return [
            'subscriptions_over_time' => $subscriptionsOverTime,
            'subscriptions_by_source' => $subscriptionsBySource,
            'growth_rate' => round($growthRate, 2),
            'total_subscriptions' => NewsletterSubscription::count(),
            'active_subscriptions' => NewsletterSubscription::active()->count(),
            'verified_subscriptions' => NewsletterSubscription::verified()->count(),
        ];
    }
}
