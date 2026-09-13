<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in (Do NOT kick them out if they aren't, because this is the public area)
$is_logged_in = isset($_SESSION['user_id']);
$user_name = $is_logged_in && isset($_SESSION['full_name']) ? explode(' ', trim($_SESSION['full_name']))[0] : '';
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PUKAAR — Public Portal</title>
    
    <!-- Favicon (Pointing up one folder to Assets) -->
    <link rel="icon" type="image/png" href="../Assets/favicon.png">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

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

        /* --- Hamburger Icon Animation --- */
        .hamburger-line {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            transform-origin: center;
        }
        .is-active .line-1 { transform: translateY(6.5px) rotate(45deg); }
        .is-active .line-2 { opacity: 0; transform: scaleX(0); }
        .is-active .line-3 { transform: translateY(-6.5px) rotate(-45deg); }
    </style>
</head>
<body class="text-[#1d1d1f] overflow-x-hidden relative">

    <!-- Floating Navigation Bar -->
    <nav class="fixed top-0 w-full z-50 px-4 md:px-6 py-3 md:py-4">
        <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center justify-between ios-glass rounded-[2rem] px-6 py-3 border border-white/60 shadow-[0_4px_24px_rgba(0,0,0,0.04)] relative transition-all duration-300">
            
            <!-- Top Row: Logo & Mobile Hamburger -->
            <div class="w-full md:w-auto flex items-center justify-between z-20 relative bg-transparent">
                <a href="index.php" class="flex items-center active:scale-95 transition-transform duration-200">
                    <img src="../Assets/logo.png" alt="PUKAAR" class="h-9 w-auto object-contain transition-transform duration-300 hover:scale-105">
                </a>
                
                <!-- Animated Hamburger Button -->
                <button id="mobile-menu-btn" class="md:hidden p-2 text-[#092C5E] hover:text-blue-500 focus:outline-none active:scale-90 transition-all duration-200" aria-label="Toggle navigation menu">
                    <div class="w-6 h-[16px] flex flex-col justify-between relative">
                        <span class="hamburger-line line-1 w-full h-[2.5px] bg-current rounded-full"></span>
                        <span class="hamburger-line line-2 w-full h-[2.5px] bg-current rounded-full"></span>
                        <span class="hamburger-line line-3 w-full h-[2.5px] bg-current rounded-full"></span>
                    </div>
                </button>
            </div>
            
            <!-- Desktop Navigation Links -->
            <div class="hidden md:flex items-center gap-1">
                <a href="index.php" class="px-3.5 py-2 text-sm font-semibold text-slate-600 hover:text-[#092C5E] active:scale-95 transition-all">Home</a>
                <a href="track.php" class="px-3.5 py-2 text-sm font-semibold text-slate-600 hover:text-[#092C5E] active:scale-95 transition-all">Track Ticket</a>
                <a href="chat.php" class="px-3.5 py-2 text-sm font-semibold text-slate-600 hover:text-[#092C5E] active:scale-95 transition-all">Live Chat</a>
                <a href="report-incident.php" class="px-3.5 py-2 text-sm font-bold text-rose-600 bg-rose-50 rounded-xl hover:bg-rose-100 active:scale-95 transition-all">Report Incident</a>
                
                <div class="h-4 w-px bg-gray-200 mx-2"></div>
                
                <!-- Smart Login / Logout Logic -->
                <?php if ($is_logged_in): ?>
                    <span class="px-2 text-sm font-bold text-[#092C5E]">Hi, <?php echo htmlspecialchars($user_name); ?></span>
                    <a href="../Session/logout.php" class="ml-2 px-5 py-2 text-sm font-semibold bg-slate-100 text-slate-600 rounded-full hover:bg-slate-200 active:scale-95 transition-all">Log out</a>
                <?php else: ?>
                    <a href="../login.php" class="px-5 py-2 text-sm font-bold text-[#092C5E] hover:text-blue-700 active:scale-95 transition-all">Login</a>
                <?php endif; ?>
            </div>

            <!-- Mobile Menu Dropdown -->
            <div id="mobile-menu" class="w-full md:hidden transition-all duration-300 ease-in-out max-h-0 opacity-0 overflow-hidden">
                <div class="flex flex-col items-center gap-2 pt-5 pb-3 mt-2 border-t border-gray-200/60 text-center">
                    
                    <?php if ($is_logged_in): ?>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Welcome, <?php echo htmlspecialchars($user_name); ?></span>
                    <?php endif; ?>
                    
                    <a href="index.php" class="w-full py-2.5 text-sm font-semibold text-slate-700 active:scale-95 rounded-xl transition-all">Home</a>
                    <a href="track.php" class="w-full py-2.5 text-sm font-semibold text-slate-700 active:scale-95 rounded-xl transition-all">Track Ticket</a>
                    <a href="chat.php" class="w-full py-2.5 text-sm font-semibold text-slate-700 active:scale-95 rounded-xl transition-all">Live Chat</a>
                    <a href="report-incident.php" class="w-full py-2.5 text-sm font-bold text-rose-600 bg-rose-50 active:scale-95 rounded-xl transition-all">Report Incident</a>
                    
                    <div class="w-full pt-4 mt-2 border-t border-gray-200/60 flex flex-col items-center gap-3">
                        <?php if ($is_logged_in): ?>
                            <a href="../Session/logout.php" class="w-full max-w-[200px] text-center px-4 py-2.5 text-sm font-bold bg-slate-100 text-slate-600 rounded-xl active:scale-95 transition-all">Log out</a>
                        <?php else: ?>
                            <a href="../login.php" class="w-full max-w-[200px] text-center px-4 py-2.5 text-sm font-bold bg-[#092C5E] text-white rounded-xl active:scale-95 transition-all">Login</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>
    </nav>

    <!-- Header Spacer for Fixed Navigation -->
    <div class="h-24 md:h-32"></div>

    <!-- Mobile Navigation Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');

            if (menuBtn && mobileMenu) {
                menuBtn.addEventListener('click', function() {
                    menuBtn.classList.toggle('is-active');
                    if (mobileMenu.style.maxHeight) {
                        mobileMenu.style.maxHeight = null;
                        mobileMenu.classList.remove('opacity-100');
                        mobileMenu.classList.add('opacity-0');
                    } else {
                        mobileMenu.style.maxHeight = mobileMenu.scrollHeight + "px";
                        mobileMenu.classList.remove('opacity-0');
                        mobileMenu.classList.add('opacity-100');
                    }
                });

                mobileMenu.querySelectorAll('a').forEach(function(link) {
                    link.addEventListener('click', function() {
                        menuBtn.classList.remove('is-active');
                        mobileMenu.style.maxHeight = null;
                        mobileMenu.classList.remove('opacity-100');
                        mobileMenu.classList.add('opacity-0');
                    });
                });
            }
        });
    </script>