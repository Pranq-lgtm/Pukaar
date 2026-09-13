<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Check if user session exists
$is_logged_in = isset($_SESSION['user_id']) || isset($_SESSION['firebase_uid']); 

// Detect current page filename
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PUKAAR — Report Bullying. Be Heard.</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Fonts -->
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="Assets/favicon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { 
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; 
            background-color: #fbfbfd;
            -webkit-font-smoothing: antialiased;
        }

        /* Apple-style Liquid Glass */
        .ios-glass {
            background: rgba(255, 255, 255, 0.82);
            backdrop-filter: saturate(180%) blur(20px);
            -webkit-backdrop-filter: saturate(180%) blur(20px);
        }

        /* Marquee Animation for Campaigns */
        @keyframes scroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        .animate-scroll {
            display: flex;
            width: calc(200% + 2rem);
            animation: scroll 25s linear infinite;
        }
        .animate-scroll:hover {
            animation-play-state: paused;
        }
    </style>
</head>
<body class="text-[#1d1d1f] overflow-x-hidden relative">

    <!-- Floating Navigation Bar -->
    <nav class="fixed top-0 w-full z-50 px-4 md:px-6 py-3 md:py-4">
        <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center justify-between ios-glass rounded-[2rem] px-6 py-2.5 border border-white/60 shadow-[0_4px_24px_rgba(0,0,0,0.04)] relative">
            
            <!-- Top Row: Logo & Mobile Hamburger -->
            <div class="w-full md:w-auto flex items-center justify-between">
                <a href="index.php" class="flex items-center">
                    <img src="Assets/logo.png" alt="PUKAAR" class="h-9 w-auto object-contain transition-transform duration-300 hover:scale-105">
                </a>
                
                <button id="mobile-menu-btn" class="md:hidden p-2 text-slate-700 hover:text-blue-600 focus:outline-none transition-colors" aria-label="Toggle navigation menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Desktop Navigation Links -->
            <div class="hidden md:flex items-center gap-1">
                <a href="index.php#services" class="px-3.5 py-2 text-sm font-semibold text-slate-600 hover:text-slate-900 transition-colors">Services</a>
                <a href="index.php#about" class="px-3.5 py-2 text-sm font-semibold text-slate-600 hover:text-slate-900 transition-colors">About</a>
                <a href="index.php#ngos" class="px-3.5 py-2 text-sm font-semibold text-slate-600 hover:text-slate-900 transition-colors">Partnered NGOs</a>
                <a href="index.php#campaigns" class="px-3.5 py-2 text-sm font-semibold text-slate-600 hover:text-slate-900 transition-colors">Campaigns</a>
                <a href="Public/report-incident.php" class="px-3.5 py-2 text-sm font-bold text-blue-600 hover:text-blue-700 transition-colors">Report Anonymously</a>
                
                <div class="h-4 w-px bg-gray-200 mx-2"></div>
                
                <!-- Auth State Buttons -->
                <?php if($is_logged_in): ?>
                    <!-- Added Dashboard Button so logged in users can reach their panels! -->
                    <a href="<?php echo (isset($_SESSION['role']) && ($_SESSION['role'] === 'ngo' || $_SESSION['role'] === 'admin')) ? 'Responder/index.php' : 'Public/index.php'; ?>" class="px-5 py-2 text-sm font-semibold bg-[#092C5E] text-white rounded-full hover:bg-blue-900 transition-all shadow-sm">Dashboard</a>
                    <a href="Session/logout.php" class="px-5 py-2 text-sm font-semibold bg-rose-50 text-rose-600 rounded-full hover:bg-rose-100 transition-all">Log out</a>
                <?php else: ?>
                    <?php if($current_page == 'login.php'): ?>
                        <a href="login.php" class="px-5 py-2 text-sm font-semibold bg-[#092C5E] text-white rounded-full hover:bg-blue-900 transition-all shadow-sm">Log in</a>
                        <a href="signup.php" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:text-slate-900 transition-colors">Sign up</a>
                    <?php elseif($current_page == 'signup.php'): ?>
                        <a href="login.php" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:text-slate-900 transition-colors">Log in</a>
                        <a href="signup.php" class="px-5 py-2 text-sm font-semibold bg-[#092C5E] text-white rounded-full hover:bg-blue-900 transition-all shadow-sm">Sign up</a>
                    <?php else: ?>
                        <a href="login.php" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:text-slate-900 transition-colors">Log in</a>
                        <a href="signup.php" class="px-5 py-2 text-sm font-semibold bg-[#092C5E] text-white rounded-full hover:bg-blue-900 transition-all shadow-sm">Sign up</a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <!-- Mobile Menu Dropdown -->
            <div id="mobile-menu" class="hidden w-full md:hidden flex flex-col gap-3 pt-4 pb-2 border-t border-gray-100 mt-3">
                <center>
                <a href="index.php#services" class="px-2 py-1.5 text-sm font-semibold text-slate-700 hover:text-blue-600 block">Services</a>
                <a href="index.php#about" class="px-2 py-1.5 text-sm font-semibold text-slate-700 hover:text-blue-600 block">About</a>
                <a href="index.php#ngos" class="px-2 py-1.5 text-sm font-semibold text-slate-700 hover:text-blue-600 block">Partnered NGOs</a>
                <a href="index.php#campaigns" class="px-2 py-1.5 text-sm font-semibold text-slate-700 hover:text-blue-600 block">Campaigns</a>
                <a href="Public/report-incident.php" class="px-2 py-1.5 text-sm font-bold text-blue-600 block">Report Anonymously</a>
                
                <div class="pt-3 border-t border-gray-100 flex flex-col gap-2">
                    <?php if($is_logged_in): ?>
                        <a href="<?php echo (isset($_SESSION['role']) && ($_SESSION['role'] === 'ngo' || $_SESSION['role'] === 'admin')) ? 'Responder/index.php' : 'Public/index.php'; ?>" class="w-full text-center px-4 py-2.5 text-sm font-bold bg-[#092C5E] text-white rounded-xl hover:bg-blue-900 transition-all block">Dashboard</a>
                        <a href="Session/logout.php" class="w-full text-center px-4 py-2.5 text-sm font-bold bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-100 transition-all block">Log out</a>
                    <?php else: ?>
                        <?php if($current_page == 'login.php'): ?>
                            <a href="login.php" class="w-full text-center px-4 py-2 text-sm font-semibold bg-[#092C5E] text-white rounded-xl hover:bg-blue-900 transition-all block shadow-sm">Log in</a>
                            <a href="signup.php" class="w-full text-center px-4 py-2 text-sm font-semibold text-slate-700 border border-gray-200 rounded-xl hover:bg-gray-50 transition-all block">Sign up</a>
                        <?php elseif($current_page == 'signup.php'): ?>
                            <a href="login.php" class="w-full text-center px-4 py-2 text-sm font-semibold text-slate-700 border border-gray-200 rounded-xl hover:bg-gray-50 transition-all block">Log in</a>
                            <a href="signup.php" class="w-full text-center px-4 py-2 text-sm font-semibold bg-[#092C5E] text-white rounded-xl hover:bg-blue-900 transition-all block shadow-sm">Sign up</a>
                        <?php else: ?>
                            <a href="login.php" class="w-full text-center px-4 py-2 text-sm font-semibold text-slate-700 border border-gray-200 rounded-xl hover:bg-gray-50 transition-all block">Log in</a>
                            <a href="signup.php" class="w-full text-center px-4 py-2 text-sm font-semibold bg-[#092C5E] text-white rounded-xl hover:bg-blue-900 transition-all block shadow-sm">Sign up</a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                </center>
            </div>

        </div>
    </nav>

    <!-- Header Spacer for Fixed Navigation -->
    <div class="h-20 md:h-24"></div>

    <!-- Script to make your Mobile Menu functional! -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');

            if (menuBtn && mobileMenu) {
                menuBtn.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            }
        });
    </script>