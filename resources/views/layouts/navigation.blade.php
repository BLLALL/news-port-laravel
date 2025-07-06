<nav x-data="{ open: false }" class="bg-white/95 dark:bg-gray-900/95 backdrop-blur-lg border-b border-gray-200 dark:border-gray-700 sticky top-0 z-50 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                        <div class="relative">
                            <!-- Use the new custom news portal logo -->
                            <svg class="block h-10 w-10 group-hover:scale-110 transition-transform duration-200" viewBox="0 0 120 120" xmlns="http://www.w3.org/2000/svg">
                                <!-- Background Circle with Gradient -->
                                <defs>
                                    <linearGradient id="logoGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" style="stop-color:#3B82F6;stop-opacity:1" />
                                        <stop offset="50%" style="stop-color:#6366F1;stop-opacity:1" />
                                        <stop offset="100%" style="stop-color:#8B5CF6;stop-opacity:1" />
                                    </linearGradient>
                                    <linearGradient id="paperGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" style="stop-color:#FFFFFF;stop-opacity:1" />
                                        <stop offset="100%" style="stop-color:#F8FAFC;stop-opacity:1" />
                                    </linearGradient>
                                    <filter id="shadow" x="-20%" y="-20%" width="140%" height="140%">
                                        <feDropShadow dx="0" dy="2" stdDeviation="3" flood-color="#1F2937" flood-opacity="0.1"/>
                                    </filter>
                                </defs>
                                
                                <!-- Main Circle Background -->
                                <circle cx="60" cy="60" r="56" fill="url(#logoGradient)" filter="url(#shadow)"/>
                                
                                <!-- Inner highlight circle -->
                                <circle cx="60" cy="60" r="52" fill="none" stroke="rgba(255,255,255,0.2)" stroke-width="1"/>
                                
                                <!-- Newspaper/Document Shape -->
                                <rect x="25" y="30" width="70" height="60" rx="4" ry="4" fill="url(#paperGradient)" filter="url(#shadow)"/>
                                
                                <!-- Header line (main headline) -->
                                <rect x="30" y="38" width="60" height="4" rx="2" fill="#1F2937"/>
                                
                                <!-- Subheader lines -->
                                <rect x="30" y="46" width="45" height="2" rx="1" fill="#6B7280"/>
                                <rect x="30" y="50" width="35" height="2" rx="1" fill="#6B7280"/>
                                
                                <!-- Article columns -->
                                <rect x="30" y="58" width="25" height="2" rx="1" fill="#9CA3AF"/>
                                <rect x="30" y="62" width="28" height="2" rx="1" fill="#9CA3AF"/>
                                <rect x="30" y="66" width="22" height="2" rx="1" fill="#9CA3AF"/>
                                <rect x="30" y="70" width="26" height="2" rx="1" fill="#9CA3AF"/>
                                
                                <rect x="62" y="58" width="25" height="2" rx="1" fill="#9CA3AF"/>
                                <rect x="62" y="62" width="23" height="2" rx="1" fill="#9CA3AF"/>
                                <rect x="62" y="66" width="28" height="2" rx="1" fill="#9CA3AF"/>
                                <rect x="62" y="70" width="20" height="2" rx="1" fill="#9CA3AF"/>
                                
                                <!-- Breaking news badge -->
                                <rect x="78" y="75" width="12" height="8" rx="2" fill="#EF4444"/>
                                <text x="84" y="80.5" font-family="Arial, sans-serif" font-size="5" font-weight="bold" text-anchor="middle" fill="white">N</text>
                                
                                <!-- Notification dot -->
                                <circle cx="85" cy="35" r="3" fill="#10B981"/>
                                <circle cx="85" cy="35" r="2" fill="#34D399" opacity="0.8"/>
                                
                                <!-- Border highlight -->
                                <rect x="25" y="30" width="70" height="60" rx="4" ry="4" fill="none" stroke="rgba(255,255,255,0.3)" stroke-width="1"/>
                            </svg>
                            <div class="absolute inset-0 bg-blue-600/20 rounded-full blur-xl group-hover:blur-2xl transition-all duration-200"></div>
                        </div>
                        <div class="hidden sm:block">
                            <h1 class="text-xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                                News Portal
                            </h1>
                            <p class="text-xs text-gray-500 dark:text-gray-400 -mt-1">Latest News & Stories</p>
                        </div>
                    </a>
                </div>

                @auth
                    <!-- Navigation Links -->
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <x-nav-link :href="route('home')" :active="request()->routeIs('home')" 
                                    class="relative group">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v3H8V5z"></path>
                            </svg>
                            {{ __('Home') }}
                            <div class="absolute inset-x-0 -bottom-px h-0.5 bg-gradient-to-r from-blue-500 to-purple-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-200"></div>
                        </x-nav-link>
                        
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                                    class="relative group">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            {{ __('Dashboard') }}
                            <div class="absolute inset-x-0 -bottom-px h-0.5 bg-gradient-to-r from-blue-500 to-purple-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-200"></div>
                        </x-nav-link>

                       @if (auth()->user()->is_admin)
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.*')" class="relative group">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            {{ __('Admin Panel') }}
                            <div class="absolute inset-x-0 -bottom-px h-0.5 bg-gradient-to-r from-blue-500 to-purple-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-200"></div>
                        </x-nav-link>
                        @endif
                    </div>
                @endauth
            </div>

            @auth
                <!-- Settings Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <!-- Quick Actions -->
                    <div class="flex items-center space-x-2 mr-4">
                        <!-- Search -->
                        <button class="p-2 rounded-lg bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100 transition-all duration-200 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                        
                        <!-- Notifications -->
                        <button class="relative p-2 rounded-lg bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100 transition-all duration-200 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM12 8v8m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="absolute -top-1 -right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>
                    </div>

                    <x-dropdown align="right" width="64">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm leading-4 font-medium rounded-xl text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none transition-all duration-200 shadow-sm">
                                <!-- User Avatar -->
                                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white text-sm font-semibold mr-3">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                
                                <div class="text-left">
                                    <div class="font-medium text-gray-900 dark:text-white">{{ Auth::user()->name }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</div>
                                </div>

                                <div class="ms-3">
                                    <svg class="fill-current h-4 w-4 transform transition-transform duration-200 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ Auth::user()->name }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</p>
                            </div>

                            <x-dropdown-link :href="route('profile.edit')" class="flex items-center">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <x-dropdown-link href="#" class="flex items-center">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ __('Settings') }}
                            </x-dropdown-link>

                            <x-dropdown-link href="#" class="flex items-center">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ __('Help & Support') }}
                            </x-dropdown-link>

                            <div class="border-t border-gray-100 dark:border-gray-700"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();"
                                        class="flex items-center text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>

                <!-- Hamburger -->
                <div class="-me-2 flex items-center sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 focus:text-gray-800 dark:focus:text-gray-200 transition-all duration-200">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @else
                <!-- Guest Navigation -->
                <div class="hidden sm:flex sm:items-center sm:space-x-4">
                    <a href="{{ route('login') }}" 
                       class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200 px-4 py-2 rounded-lg transition-colors">
                        {{ __('Login') }}
                    </a>
                    <a href="{{ route('register') }}" 
                       class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold px-6 py-2 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                        {{ __('Register') }}
                    </a>
                </div>
            @endauth
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1 bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700">
            @auth
                <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')" class="flex items-center">
                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v3H8V5z"></path>
                    </svg>
                    {{ __('Home') }}
                </x-responsive-nav-link>
                
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="flex items-center">
                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
            @endauth
        </div>

        @auth
            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900">
                <div class="px-4 flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div>
                        <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')" class="flex items-center">
                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="flex items-center text-red-600 dark:text-red-400">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            <!-- Guest Mobile Navigation -->
            <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900">
                <div class="space-y-1 px-4">
                    <a href="{{ route('login') }}" 
                       class="block w-full text-left px-4 py-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                        {{ __('Login') }}
                    </a>
                    <a href="{{ route('register') }}" 
                       class="block w-full text-left px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-lg shadow-lg">
                        {{ __('Register') }}
                    </a>
                </div>
            </div>
        @endauth
    </div>
</nav>