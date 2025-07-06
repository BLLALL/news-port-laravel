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

        <title>{{ isset($title) ? $title . ' - ' : '' }}Admin Panel - {{ config('app.name', 'Laravel') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 120 120'%3E%3Cdefs%3E%3ClinearGradient id='logoGradient' x1='0%25' y1='0%25' x2='100%25' y2='100%25'%3E%3Cstop offset='0%25' style='stop-color:%233B82F6;stop-opacity:1' /%3E%3Cstop offset='50%25' style='stop-color:%236366F1;stop-opacity:1' /%3E%3Cstop offset='100%25' style='stop-color:%238B5CF6;stop-opacity:1' /%3E%3C/linearGradient%3E%3ClinearGradient id='paperGradient' x1='0%25' y1='0%25' x2='100%25' y2='100%25'%3E%3Cstop offset='0%25' style='stop-color:%23FFFFFF;stop-opacity:1' /%3E%3Cstop offset='100%25' style='stop-color:%23F8FAFC;stop-opacity:1' /%3E%3C/linearGradient%3E%3C/defs%3E%3Ccircle cx='60' cy='60' r='56' fill='url(%23logoGradient)'/%3E%3Ccircle cx='60' cy='60' r='52' fill='none' stroke='rgba(255,255,255,0.2)' stroke-width='1'/%3E%3Crect x='25' y='30' width='70' height='60' rx='4' ry='4' fill='url(%23paperGradient)'/%3E%3Crect x='30' y='38' width='60' height='4' rx='2' fill='%231F2937'/%3E%3Crect x='30' y='46' width='45' height='2' rx='1' fill='%236B7280'/%3E%3Crect x='30' y='50' width='35' height='2' rx='1' fill='%236B7280'/%3E%3Crect x='30' y='58' width='25' height='2' rx='1' fill='%239CA3AF'/%3E%3Crect x='30' y='62' width='28' height='2' rx='1' fill='%239CA3AF'/%3E%3Crect x='30' y='66' width='22' height='2' rx='1' fill='%239CA3AF'/%3E%3Crect x='30' y='70' width='26' height='2' rx='1' fill='%239CA3AF'/%3E%3Crect x='62' y='58' width='25' height='2' rx='1' fill='%239CA3AF'/%3E%3Crect x='62' y='62' width='23' height='2' rx='1' fill='%239CA3AF'/%3E%3Crect x='62' y='66' width='28' height='2' rx='1' fill='%239CA3AF'/%3E%3Crect x='62' y='70' width='20' height='2' rx='1' fill='%239CA3AF'/%3E%3Crect x='78' y='75' width='12' height='8' rx='2' fill='%23EF4444'/%3E%3Ctext x='84' y='80.5' font-family='Arial, sans-serif' font-size='5' font-weight='bold' text-anchor='middle' fill='white'%3EN%3C/text%3E%3Ccircle cx='85' cy='35' r='3' fill='%2310B981'/%3E%3Ccircle cx='85' cy='35' r='2' fill='%2334D399' opacity='0.8'/%3E%3Crect x='25' y='30' width='70' height='60' rx='4' ry='4' fill='none' stroke='rgba(255,255,255,0.3)' stroke-width='1'/%3E%3C/svg%3E">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')
    </head>
    <body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
        <div class="min-h-screen flex">
            <!-- Sidebar -->
            <div class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-gray-800 shadow-lg transform transition-transform duration-300 ease-in-out lg:translate-x-0"
                 :class="{ '-translate-x-full': !sidebarOpen, 'translate-x-0': sidebarOpen }">
                
                <!-- Logo -->
                <div class="flex items-center justify-center h-16 px-4 bg-gradient-to-r from-blue-600 to-indigo-600">
                    <h1 class="text-xl font-bold text-white">Admin Panel</h1>
                </div>

                <!-- Navigation -->
                <nav class="mt-8">
                    <div class="px-4 space-y-2">
                        <!-- Dashboard -->
                        <a href="{{ route('admin.dashboard') }}" 
                           class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v3H8V5z"></path>
                            </svg>
                            Dashboard
                        </a>

                      <!-- resources/views/layouts/admin.blade.php - Update the Articles navigation section -->

                <!-- Articles -->
                <div x-data="{ open: {{ request()->routeIs('admin.articles.*') ? 'true' : 'false' }} }">
                    <button @click="open = !open" 
                            class="flex items-center justify-between w-full px-4 py-3 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors {{ request()->routeIs('admin.articles.*') ? 'bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300' : '' }}">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Articles
                        </div>
                        <svg class="w-4 h-4 transform transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" x-transition class="ml-8 mt-2 space-y-2">
                        <a href="{{ route('admin.articles.index') }}" 
                        class="block px-4 py-2 text-sm text-gray-600 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('admin.articles.index') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                            All Articles
                        </a>
                        <a href="{{ route('admin.articles.create') }}" 
                        class="block px-4 py-2 text-sm text-gray-600 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('admin.articles.create') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                            Create Article
                        </a>
                    </div>
                </div>

                        <!-- Categories -->
                        <div x-data="{ open: {{ request()->routeIs('admin.categories.*') ? 'true' : 'false' }} }">
                            <button @click="open = !open" 
                                    class="flex items-center justify-between w-full px-4 py-3 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors {{ request()->routeIs('admin.categories.*') ? 'bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300' : '' }}">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    Categories
                                </div>
                                <svg class="w-4 h-4 transform transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="open" x-transition class="ml-8 mt-2 space-y-2">
                                <a href="{{ route('admin.categories.index') }}" 
                                   class="block px-4 py-2 text-sm text-gray-600 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('admin.categories.index') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                                    All Categories
                                </a>
                                <a href="{{ route('admin.categories.create') }}" 
                                   class="block px-4 py-2 text-sm text-gray-600 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('admin.categories.create') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                                    Create Category
                                </a>
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="border-t border-gray-200 dark:border-gray-700 my-4"></div>

                        <!-- Site Link -->
                        <a href="{{ route('home') }}" 
                           class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                            View Site
                        </a>

                        <!-- Settings -->
                        <a href="#" 
                           class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Settings
                        </a>
                    </div>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="flex-1 lg:ml-64">
                <!-- Top Bar -->
                <header class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between px-6 py-4">
                        <!-- Mobile menu button -->
                        <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>

                        <!-- Header Content -->
                        @if (isset($header))
                            <div class="flex-1 lg:flex-none">
                                {{ $header }}
                            </div>
                        @endif

                        <!-- Right Side -->
                        <div class="flex items-center space-x-4">
                            <!-- User Dropdown -->
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="flex items-center text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition duration-150 ease-in-out">
                                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white text-sm font-semibold mr-2">
                                            {{ substr(Auth::user()->name, 0, 1) }}
                                        </div>
                                        <div>{{ Auth::user()->name }}</div>
                                        <div class="ml-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <x-dropdown-link :href="route('profile.edit')">
                                        {{ __('Profile') }}
                                    </x-dropdown-link>

                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <x-dropdown-link :href="route('logout')"
                                                onclick="event.preventDefault(); this.closest('form').submit();">
                                            {{ __('Log Out') }}
                                        </x-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="p-6">
                    <!-- Flash Messages -->
                    @if (session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    {{ $slot }}
                </main>
            </div>
        </div>

        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-40 bg-gray-600 bg-opacity-75 lg:hidden"
             @click="sidebarOpen = false"></div>

        @stack('scripts')
    </body>
</html>