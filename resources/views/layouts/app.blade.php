<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
      x-data="{ 
          darkMode: localStorage.getItem('darkMode') === 'true',
          sidebarOpen: false 
      }" 
      x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))" 
      x-bind:class="{ 'dark': darkMode }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 120 120'%3E%3Cdefs%3E%3ClinearGradient id='logoGradient' x1='0%25' y1='0%25' x2='100%25' y2='100%25'%3E%3Cstop offset='0%25' style='stop-color:%233B82F6;stop-opacity:1' /%3E%3Cstop offset='50%25' style='stop-color:%236366F1;stop-opacity:1' /%3E%3Cstop offset='100%25' style='stop-color:%238B5CF6;stop-opacity:1' /%3E%3C/linearGradient%3E%3ClinearGradient id='paperGradient' x1='0%25' y1='0%25' x2='100%25' y2='100%25'%3E%3Cstop offset='0%25' style='stop-color:%23FFFFFF;stop-opacity:1' /%3E%3Cstop offset='100%25' style='stop-color:%23F8FAFC;stop-opacity:1' /%3E%3C/linearGradient%3E%3C/defs%3E%3Ccircle cx='60' cy='60' r='56' fill='url(%23logoGradient)'/%3E%3Ccircle cx='60' cy='60' r='52' fill='none' stroke='rgba(255,255,255,0.2)' stroke-width='1'/%3E%3Crect x='25' y='30' width='70' height='60' rx='4' ry='4' fill='url(%23paperGradient)'/%3E%3Crect x='30' y='38' width='60' height='4' rx='2' fill='%231F2937'/%3E%3Crect x='30' y='46' width='45' height='2' rx='1' fill='%236B7280'/%3E%3Crect x='30' y='50' width='35' height='2' rx='1' fill='%236B7280'/%3E%3Crect x='30' y='58' width='25' height='2' rx='1' fill='%239CA3AF'/%3E%3Crect x='30' y='62' width='28' height='2' rx='1' fill='%239CA3AF'/%3E%3Crect x='30' y='66' width='22' height='2' rx='1' fill='%239CA3AF'/%3E%3Crect x='30' y='70' width='26' height='2' rx='1' fill='%239CA3AF'/%3E%3Crect x='62' y='58' width='25' height='2' rx='1' fill='%239CA3AF'/%3E%3Crect x='62' y='62' width='23' height='2' rx='1' fill='%239CA3AF'/%3E%3Crect x='62' y='66' width='28' height='2' rx='1' fill='%239CA3AF'/%3E%3Crect x='62' y='70' width='20' height='2' rx='1' fill='%239CA3AF'/%3E%3Crect x='78' y='75' width='12' height='8' rx='2' fill='%23EF4444'/%3E%3Ctext x='84' y='80.5' font-family='Arial, sans-serif' font-size='5' font-weight='bold' text-anchor='middle' fill='white'%3EN%3C/text%3E%3Ccircle cx='85' cy='35' r='3' fill='%2310B981'/%3E%3Ccircle cx='85' cy='35' r='2' fill='%2334D399' opacity='0.8'/%3E%3Crect x='25' y='30' width='70' height='60' rx='4' ry='4' fill='none' stroke='rgba(255,255,255,0.3)' stroke-width='1'/%3E%3C/svg%3E">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <style>
            body { font-family: 'Inter', sans-serif; }
            
            /* Custom scrollbar */
            ::-webkit-scrollbar {
                width: 8px;
                height: 8px;
            }
            
            ::-webkit-scrollbar-track {
                @apply bg-gray-100 dark:bg-gray-800;
            }
            
            ::-webkit-scrollbar-thumb {
                @apply bg-gray-300 dark:bg-gray-600 rounded-full;
            }
            
            ::-webkit-scrollbar-thumb:hover {
                @apply bg-gray-400 dark:bg-gray-500;
            }
            
            /* Smooth transitions */
            * {
                transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
                transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
                transition-duration: 150ms;
            }
            
            /* Glass morphism effects */
            .glass {
                backdrop-filter: blur(16px) saturate(180%);
                -webkit-backdrop-filter: blur(16px) saturate(180%);
                background-color: rgba(255, 255, 255, 0.75);
                border: 1px solid rgba(209, 213, 219, 0.3);
            }
            
            .glass-dark {
                backdrop-filter: blur(16px) saturate(180%);
                -webkit-backdrop-filter: blur(16px) saturate(180%);
                background-color: rgba(17, 24, 39, 0.75);
                border: 1px solid rgba(75, 85, 99, 0.3);
            }
            
            /* Animated background */
            .animated-bg {
                background: linear-gradient(-45deg, #667eea, #764ba2, #f093fb, #f5576c);
                background-size: 400% 400%;
                animation: gradient 15s ease infinite;
            }
            
            @keyframes gradient {
                0% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
                100% { background-position: 0% 50%; }
            }
            
            /* Loading animation */
            .loading {
                position: relative;
                overflow: hidden;
            }
            
            .loading::after {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
                animation: loading 1.5s infinite;
            }
            
            @keyframes loading {
                0% { left: -100%; }
                100% { left: 100%; }
            }


            .article-content h1, .article-content h2, .article-content h3, 
            .article-content h4, .article-content h5, .article-content h6 {
                color: #111827;
                margin-top: 2rem;
                margin-bottom: 1rem;
                font-weight: 700;
                line-height: 1.25;
            }

            .dark .article-content h1, .dark .article-content h2, .dark .article-content h3,
            .dark .article-content h4, .dark .article-content h5, .dark .article-content h6 {
                color: #F9FAFB;
            }

            .article-content h1 { font-size: 2.25rem; line-height: 2.5rem; }
            .article-content h2 { font-size: 1.875rem; line-height: 2.25rem; }
            .article-content h3 { font-size: 1.5rem; line-height: 2rem; }
            .article-content h4 { font-size: 1.25rem; line-height: 1.75rem; }
            .article-content h5 { font-size: 1.125rem; line-height: 1.75rem; }
            .article-content h6 { font-size: 1rem; line-height: 1.5rem; }

            .article-content p {
                margin-bottom: 1.5rem;
                line-height: 1.75;
            }

            .article-content ul, .article-content ol {
                margin: 1.5rem 0;
                padding-left: 2rem;
            }

            .article-content ul {
                list-style-type: disc;
            }

            .article-content ol {
                list-style-type: decimal;
            }

            .article-content li {
                margin-bottom: 0.5rem;
                line-height: 1.6;
            }

            .article-content ul ul, .article-content ol ol {
                margin: 0.5rem 0;
            }

            .article-content blockquote {
                border-left: 4px solid #3B82F6;
                padding-left: 1.5rem;
                margin: 2rem 0;
                font-style: italic;
                background: #F3F4F6;
                padding: 1.5rem;
                border-radius: 0.5rem;
                position: relative;
                font-size: 1.125rem;
                line-height: 1.7;
            }

            .dark .article-content blockquote {
                background: #374151;
                color: #E5E7EB;
            }

            .article-content blockquote::before {
                content: '"';
                font-size: 4rem;
                color: #3B82F6;
                position: absolute;
                top: -0.5rem;
                left: 1rem;
                font-family: serif;
                line-height: 1;
            }

            .article-content pre {
                background: #1F2937;
                color: #F9FAFB;
                padding: 1.5rem;
                border-radius: 0.5rem;
                overflow-x: auto;
                margin: 1.5rem 0;
                font-family: 'Courier New', monospace;
                font-size: 0.875rem;
                line-height: 1.7;
            }

            .article-content code {
                background: #F3F4F6;
                padding: 0.25rem 0.5rem;
                border-radius: 0.25rem;
                font-family: 'Courier New', monospace;
                font-size: 0.875rem;
                color: #E11D48;
            }

            .dark .article-content code {
                background: #374151;
                color: #F472B6;
            }

            .article-content pre code {
                background: transparent;
                padding: 0;
                color: inherit;
                font-size: inherit;
            }

            .article-content table {
                border-collapse: collapse;
                width: 100%;
                margin: 1.5rem 0;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
                border-radius: 0.5rem;
                overflow: hidden;
                font-size: 0.9rem;
            }

            .article-content th, .article-content td {
                border: 1px solid #D1D5DB;
                padding: 1rem;
                text-align: left;
                vertical-align: top;
            }

            .dark .article-content th, .dark .article-content td {
                border-color: #4B5563;
            }

            .article-content th {
                background: #F9FAFB;
                font-weight: 600;
                font-size: 0.875rem;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                color: #374151;
            }

            .dark .article-content th {
                background: #374151;
                color: #F9FAFB;
            }

            .article-content tr:nth-child(even) {
                background: #F9FAFB;
            }

            .dark .article-content tr:nth-child(even) {
                background: #374151;
            }

            .article-content img {
                max-width: 100%;
                height: auto;
                border-radius: 0.5rem;
                margin: 1.5rem 0;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                display: block;
            }

            .article-content a {
                color: #3B82F6;
                text-decoration: underline;
                text-decoration-color: rgba(59, 130, 246, 0.3);
                text-underline-offset: 0.125rem;
                transition: all 0.2s ease;
                font-weight: 500;
            }

            .article-content a:hover {
                color: #1D4ED8;
                text-decoration-color: #1D4ED8;
                text-decoration-thickness: 2px;
            }

            .dark .article-content a {
                color: #60A5FA;
            }

            .dark .article-content a:hover {
                color: #93C5FD;
            }

            .article-content strong {
                font-weight: 700;
                color: #111827;
            }

            .dark .article-content strong {
                color: #F9FAFB;
            }

            .article-content em {
                font-style: italic;
                color: #6B7280;
            }

            .dark .article-content em {
                color: #D1D5DB;
            }

            /* Responsive adjustments */
            @media (max-width: 768px) {
                .article-content h1 { font-size: 1.875rem; line-height: 2.25rem; }
                .article-content h2 { font-size: 1.5rem; line-height: 2rem; }
                .article-content h3 { font-size: 1.25rem; line-height: 1.75rem; }
                
                .article-content blockquote {
                    padding: 1rem;
                    font-size: 1rem;
                }
                
                .article-content blockquote::before {
                    font-size: 3rem;
                    top: -0.25rem;
                }
                
                .article-content table {
                    font-size: 0.8rem;
                }
                
                .article-content th, .article-content td {
                    padding: 0.5rem;
                }
            }
        </style>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <!-- Background Pattern -->
        <div class="fixed inset-0 -z-10">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 dark:from-gray-900 dark:via-blue-900/20 dark:to-indigo-900/20"></div>
            <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%236366f1" fill-opacity="0.05"%3E%3Ccircle cx="30" cy="30" r="2"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-40"></div>
        </div>

        <div class="min-h-screen">
            @include('layouts.navigation')

            <!-- Header -->
            @if (isset($header))
                <header class="bg-white/95 dark:bg-gray-900/95 backdrop-blur-lg shadow-lg border-b border-gray-200 dark:border-gray-700 sticky top-0 z-40">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Newsletter Flash Messages (Global) -->
            @if (session('newsletter_success'))
                <div class="bg-green-500 text-white text-center py-3 px-4" 
                     x-data="{ show: true }" 
                     x-show="show" 
                     x-init="setTimeout(() => show = false, 5000)">
                    <div class="max-w-7xl mx-auto flex items-center justify-between">
                        <span>{{ session('newsletter_success') }}</span>
                        <button @click="show = false" class="text-white hover:text-gray-200">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            @if (session('newsletter_error'))
                <div class="bg-red-500 text-white text-center py-3 px-4" 
                     x-data="{ show: true }" 
                     x-show="show" 
                     x-init="setTimeout(() => show = false, 5000)">
                    <div class="max-w-7xl mx-auto flex items-center justify-between">
                        <span>{{ session('newsletter_error') }}</span>
                        <button @click="show = false" class="text-white hover:text-gray-200">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            @if (session('newsletter_status'))
                <div class="bg-blue-500 text-white text-center py-3 px-4" 
                     x-data="{ show: true }" 
                     x-show="show" 
                     x-init="setTimeout(() => show = false, 5000)">
                    <div class="max-w-7xl mx-auto flex items-center justify-between">
                        <span>{{ session('newsletter_status') }}</span>
                        <button @click="show = false" class="text-white hover:text-gray-200">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            <!-- Main Content -->
            <main class="relative">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="mt-20 bg-white/95 dark:bg-gray-900/95 backdrop-blur-lg border-t border-gray-200 dark:border-gray-700">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                        <!-- Logo and Description -->
                        <div class="md:col-span-2">
                            <div class="flex items-center space-x-3 mb-4">
                                <x-application-logo class="w-8 h-8 text-blue-600 dark:text-blue-400" />
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ config('app.name') }}</h3>
                            </div>
                            <p class="text-gray-600 dark:text-gray-400 max-w-md leading-relaxed">
                                Your trusted source for the latest news, insights, and stories that matter. Stay informed with our comprehensive coverage.
                            </p>
                            
                            <!-- Social Links -->
                            <div class="flex space-x-4 mt-6">
                                <a href="#" class="p-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                                </a>
                                <a href="#" class="p-2 bg-blue-800 hover:bg-blue-900 text-white rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/></svg>
                                </a>
                                <a href="#" class="p-2 bg-gray-800 hover:bg-gray-900 text-white rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.754-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24.009c6.624 0 11.99-5.367 11.99-11.987C24.007 5.367 18.641.001 12.017.001z"/></svg>
                                </a>
                            </div>
                        </div>
                        
                        <!-- Quick Links -->
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Links</h4>
                            <ul class="space-y-2 text-gray-600 dark:text-gray-400">
                                <li><a href="{{ route('home') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Latest News</a></li>
                                <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Categories</a></li>
                                <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">About Us</a></li>
                                <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Contact</a></li>
                                <li><a href="{{ route('newsletter.unsubscribe.form') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Unsubscribe</a></li>
                            </ul>
                        </div>
                        
                        <!-- Newsletter Subscription -->
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Stay Updated</h4>
                            <p class="text-gray-600 dark:text-gray-400 mb-4 text-sm">Subscribe to our newsletter for the latest updates.</p>
                            
                            <!-- Newsletter Form -->
                            <form action="{{ route('newsletter.subscribe') }}" method="POST" 
                                  x-data="{ 
                                      loading: false, 
                                      email: '',
                                      submit() {
                                          this.loading = true;
                                          this.$el.submit();
                                      }
                                  }" 
                                  @submit="submit()" 
                                  class="space-y-3">
                                @csrf
                                <input type="hidden" name="source" value="footer">
                                
                                <div class="relative">
                                    <input type="email" 
                                           name="email" 
                                           x-model="email"
                                           placeholder="Enter your email" 
                                           required
                                           class="w-full px-3 py-2 bg-gray-100 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent text-sm text-gray-900 dark:text-gray-100 pr-10">
                                    
                                    <!-- Loading Spinner -->
                                    <div x-show="loading" 
                                         x-transition
                                         class="absolute right-3 top-1/2 transform -translate-y-1/2">
                                        <svg class="w-4 h-4 text-blue-600 animate-spin" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </div>
                                </div>
                                
                                <button type="submit" 
                                        :disabled="loading || !email"
                                        :class="{ 'opacity-50 cursor-not-allowed': loading || !email }"
                                        class="w-full bg-blue-600 hover:bg-blue-700 disabled:hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg transition-colors text-sm flex items-center justify-center">
                                    <span x-show="!loading">Subscribe</span>
                                    <span x-show="loading" class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 animate-spin" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Subscribing...
                                    </span>
                                </button>
                                
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </form>
                            
                            <!-- Privacy Notice -->
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-3">
                                We respect your privacy. Unsubscribe at any time.
                            </p>
                        </div>
                    </div>
                    
                    <!-- Bottom Bar -->
                    <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700 flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                        <p class="text-gray-600 dark:text-gray-400 text-sm">
                            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                        </p>
                        <div class="flex items-center space-x-6 text-sm text-gray-600 dark:text-gray-400">
                            <a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Privacy Policy</a>
                            <a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Terms of Service</a>
                            <a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Cookie Policy</a>
                        </div>
                    </div>
                </div>
            </footer>

            <!-- Scroll to Top Button -->
            <button x-data="{ 
                        show: false, 
                        init() { 
                            window.addEventListener('scroll', () => { 
                                this.show = window.pageYOffset > 500 
                            }) 
                        } 
                    }"
                    x-show="show"
                    x-transition
                    @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
                    class="fixed bottom-8 right-8 p-3 bg-blue-600 hover:bg-blue-700 text-white rounded-full shadow-lg hover:shadow-xl transform hover:scale-110 transition-all duration-200 z-50">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                </svg>
            </button>
        </div>

        <!-- Loading Overlay -->
        <div x-data="{ loading: false }" 
             x-show="loading"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-white/80 dark:bg-gray-900/80 backdrop-blur-sm z-50 flex items-center justify-center"
             style="display: none;">
            <div class="text-center">
                <div class="w-16 h-16 border-4 border-blue-200 border-t-blue-600 rounded-full animate-spin mx-auto mb-4"></div>
                <p class="text-gray-600 dark:text-gray-400">Loading...</p>
            </div>
        </div>
    </body>
</html>