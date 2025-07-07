<?php

namespace App\Http\Controllers;

use App\Services\NewsletterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class NewsletterController extends Controller
{
    protected $newsletterService;

    public function __construct(NewsletterService $newsletterService)
    {
        $this->newsletterService = $newsletterService;
    }

    /**
     * Subscribe to newsletter
     */
    public function subscribe(Request $request)
    {
        // Rate limiting to prevent spam
        $key = 'newsletter-subscribe:'.$request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            throw ValidationException::withMessages([
                'email' => "Too many subscription attempts. Please try again in {$seconds} seconds.",
            ]);
        }

        // Validate the request
        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'source' => 'sometimes|string|max:50',
        ]);

        try {
            $options = [
                'source' => $validated['source'] ?? 'website',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ];

            $subscription = $this->newsletterService->subscribe($validated['email'], $options);

            RateLimiter::hit($key, 300); // 5 minutes

            return back()->with('newsletter_success', 'Thank you for subscribing! You\'ll receive our latest news and updates.');

        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Newsletter subscription failed', [
                'email' => $validated['email'],
                'error' => $e->getMessage(),
                'ip' => $request->ip(),
            ]);

            return back()->with('newsletter_error', 'Something went wrong. Please try again later.');
        }
    }

    /**
     * Unsubscribe from newsletter
     */
    public function unsubscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'token' => 'sometimes|string',
        ]);

        try {
            $this->newsletterService->unsubscribe($validated['email']);

            return back()->with('newsletter_success', 'You have been successfully unsubscribed from our newsletter.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Newsletter unsubscription failed', [
                'email' => $validated['email'],
                'error' => $e->getMessage(),
                'ip' => $request->ip(),
            ]);

            return back()->with('newsletter_error', 'Something went wrong. Please try again later.');
        }
    }

    /**
     * Show unsubscribe form
     */
    public function showUnsubscribeForm()
    {
        return view('newsletter.unsubscribe');
    }

    /**
     * Get subscription statistics (for admin)
     */
    public function stats()
    {
        $stats = $this->newsletterService->getStatistics();
        return response()->json($stats);
    }

}
