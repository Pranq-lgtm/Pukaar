<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Security: Check if user session exists directly without external helper files
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'ngo' && $_SESSION['role'] !== 'admin')) {
    header("Location: ../login.php");
    exit();
}

// Fetch user info for the header
$responder_name = isset($_SESSION['full_name']) ? $_SESSION['full_name'] : 'Responder';
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PUKAAR — Responder Portal</title>
    
    <link rel="icon" type="image/png" href="../Assets/favicon.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        body { 
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; 
            background-color: #fbfbfd;
            -webkit-font-smoothing: antialiased;
        }
        .ios-glass {
            background: rgba(255, 255, 255, 0.82);
            backdrop-filter: saturate(180%) blur(20px);
            -webkit-backdrop-filter: saturate(180%) blur(20px);
        }
        .ios-card-white {
            background: rgba(255, 255, 255, 1);
            border-radius: 24px;
            border: 1px solid rgba(0,0,0,0.04);
            box-shadow: 0 10px 30px -10px rgba(9, 44, 94, 0.05);
            transition: all 0.3s ease;
        }
        .ios-card-white:hover {
            box-shadow: 0 15px 35px -10px rgba(9, 44, 94, 0.1);
        }
        
        /* Dropdown CSS */
        .profile-dropdown { display: none; }
        .profile-wrapper:hover .profile-dropdown { display: block; }
    </style>
</head>
<body class="text-[#1d1d1f] overflow-x-hidden relative bg-[#fbfbfd]">

    <!-- MOBILE BLOCKER -->
    <div class="flex lg:hidden flex-col items-center justify-center w-full min-h-screen p-8 text-center bg-white z-[100] fixed inset-0">
        <div class="w-24 h-24 bg-blue-50 rounded-[2rem] flex items-center justify-center mb-8 border border-blue-100 shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#092C5E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                <line x1="8" y1="21" x2="16" y2="21"></line>
                <line x1="12" y1="17" x2="12" y2="21"></line>
            </svg>
        </div>
        <h1 class="text-3xl font-black text-[#092C5E] tracking-tight mb-4">Desktop Required</h1>
        <p class="text-slate-500 font-medium text-base leading-relaxed max-w-sm">
            The PUKAAR Responder Portal contains highly sensitive case management tools and live chat routing that require a full desktop environment for secure handling. 
        </p>
        <div class="mt-8 px-6 py-3 bg-[#092C5E]/5 text-[#092C5E] font-bold rounded-xl text-sm border border-[#092C5E]/10">
            Please access this portal from a computer.
        </div>
    </div>

    <!-- DESKTOP ENCLOSURE -->
    <div class="hidden lg:flex flex-col min-h-screen">
        <nav class="fixed top-0 w-full z-50 px-6 py-4">
            <div class="max-w-7xl mx-auto flex items-center justify-between ios-glass rounded-3xl px-6 py-3 border border-white/60 shadow-[0_4px_24px_rgba(0,0,0,0.04)]">
                
                <!-- Left: Logo & Portal Tag -->
                <div class="flex items-center gap-4">
                    <a href="index.php" class="flex items-center active:scale-95 transition-transform duration-200">
                        <img src="../Assets/logo.png" alt="PUKAAR" class="h-8 w-auto object-contain" onerror="this.src='https://placehold.co/40x40/092C5E/FFFFFF?text=P'">
                    </a>
                    <div class="h-5 w-px bg-gray-300"></div>
                    <span class="text-xs font-black uppercase tracking-widest text-[#092C5E] bg-blue-50 px-3 py-1 rounded-lg border border-blue-100">
                        Responder Portal
                    </span>
                </div>
                
                <!-- Center: Admin Navigation Links -->
                <div class="flex items-center gap-2">
                    <a href="index.php" class="px-4 py-2 text-sm font-bold bg-[#092C5E] text-white rounded-xl shadow-sm transition-all">Dashboard</a>
                    <a href="#" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:text-[#092C5E] hover:bg-blue-50 rounded-xl transition-all">Active Chats <span class="ml-1 bg-rose-500 text-white text-[10px] px-2 py-0.5 rounded-full">3</span></a>
                    <a href="#" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:text-[#092C5E] hover:bg-blue-50 rounded-xl transition-all">Complaints</a>
                    <a href="#" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:text-[#092C5E] hover:bg-blue-50 rounded-xl transition-all">Reports</a>
                </div>

                <!-- Right: Profile & Action -->
                <div class="flex items-center gap-4 relative profile-wrapper">
                    
                    <span class="text-xs font-bold text-slate-500">Hi, <?php echo htmlspecialchars(explode(' ', $responder_name)[0]); ?></span>

                    <!-- Profile Avatar -->
                    <button class="flex items-center gap-2 hover:opacity-80 transition-opacity">
                        <div class="w-10 h-10 bg-slate-200 rounded-full border-2 border-white shadow-sm overflow-hidden">
                            <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($responder_name); ?>&background=092C5E&color=fff" alt="Profile" class="w-full h-full object-cover">
                        </div>
                    </button>

                    <!-- Dropdown Menu -->
                    <div class="profile-dropdown absolute top-12 right-0 w-48 bg-white border border-gray-100 rounded-2xl shadow-xl py-2 z-50">
                        <div class="px-4 py-2 border-b border-gray-50 mb-1">
                            <p class="text-xs font-bold text-[#092C5E]">NGO Account</p>
                            <p class="text-[10px] font-medium text-slate-400 truncate"><?php echo htmlspecialchars($_SESSION['email'] ?? 'Responder'); ?></p>
                        </div>
                        <a href="#" class="block px-4 py-2 text-sm font-medium text-slate-600 hover:bg-blue-50 hover:text-[#092C5E]">Profile Settings</a>
                        <a href="../Session/logout.php" class="block px-4 py-2 text-sm font-bold text-rose-600 hover:bg-rose-50">Log Out</a>
                    </div>
                </div>
            </div>
        </nav>

        <div class="h-28"></div>