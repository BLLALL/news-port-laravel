<svg {{ $attributes }} viewBox="0 0 120 120" xmlns="http://www.w3.org/2000/svg">
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