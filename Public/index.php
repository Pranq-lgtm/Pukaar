<?php 
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include __DIR__ . '/./header.php'; 
?>

<style>
    .app-card { 
        background: #FFFFFF; 
        border-radius: 36px; 
        box-shadow: 0 20px 60px -15px rgba(9, 44, 94, 0.12); 
        border: 1px solid rgba(255, 255, 255, 0.8); 
    }
    .hover-card { 
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
    }
    .hover-card:hover { 
        transform: translateY(-4px); 
        box-shadow: 0 25px 50px -12px rgba(9, 44, 94, 0.15); 
        border-color: rgba(9, 44, 94, 0.1); 
    }

    /* Floating mascot micro-animation */
    .mascot-bounce {
        animation: subtleFloat 4s ease-in-out infinite;
    }
    @keyframes subtleFloat {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }
</style>

<main class="min-h-[calc(100vh-80px)] p-4 md:p-8 relative overflow-hidden">
    <!-- Calm Ambient Background -->
    <div class="absolute w-[800px] h-[800px] rounded-full bg-gradient-to-tr from-blue-50/80 to-slate-100/60 pointer-events-none -z-10 blur-3xl left-1/2 -translate-x-1/2 top-0"></div>

    <div class="w-full max-w-5xl mx-auto z-10 space-y-10">
        
        <!-- HEADER SECTION -->
        <div class="text-center max-w-3xl mx-auto pt-4">
            <h1 class="text-3xl md:text-5xl font-black text-[#092C5E] tracking-tight mb-4">You are not alone. We are here to help.</h1>
            <p class="text-base md:text-lg font-medium text-slate-500 max-w-2xl mx-auto leading-relaxed">
                This is a safe, secure, and highly confidential space. Read through the step-by-step guidance for each service and get help whenever you are ready.
            </p>
        </div>

        <!-- COMBINED CARDS (ACTION + INSTRUCTIONS + MASCOT) -->
        <div class="space-y-8">
            
            <!-- CARD 1: REPORT AN INCIDENT -->
            <div class="app-card hover-card p-8 sm:p-10 relative">
                <div class="flex flex-col md:flex-row items-center gap-8 md:gap-12">
                    <!-- Prominent Mascot Image -->
                    <div class="flex-shrink-0 mascot-bounce">
                        <img src="Assets/ngo_pc.png" alt="NGO Assistant" class="w-48 h-48 sm:w-56 sm:h-56 md:w-64 md:h-64 object-contain drop-shadow-xl">
                    </div>

                    <!-- Content & Steps -->
                    <div class="flex-1 space-y-5 text-left">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center flex-shrink-0 border border-rose-100">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-black text-[#092C5E]">Report an Incident</h3>
                                <p class="text-sm font-semibold text-rose-600">File a secure, anonymous report to alert local NGOs</p>
                            </div>
                        </div>

                        <p class="text-slate-600 font-medium leading-relaxed text-sm sm:text-base">
                            Fill out our protected reporting form to alert verified emergency response teams. Reports can be submitted completely anonymously with optional file attachments.
                        </p>

                        <!-- Step-by-step breakdown -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-1">
                            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                                <span class="block text-xs font-black text-rose-600 mb-1">Step 1</span>
                                <p class="text-xs text-slate-500 font-medium">Select form category & location.</p>
                            </div>
                            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                                <span class="block text-xs font-black text-rose-600 mb-1">Step 2</span>
                                <p class="text-xs text-slate-500 font-medium">Describe incident & upload proof.</p>
                            </div>
                            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                                <span class="block text-xs font-black text-rose-600 mb-1">Step 3</span>
                                <p class="text-xs text-slate-500 font-medium">Save your secret tracking Passcode.</p>
                            </div>
                        </div>

                        <div class="pt-2">
                            <a href="report-incident.php" class="inline-flex items-center gap-2 px-6 py-3 bg-rose-600 text-white font-bold rounded-2xl text-sm hover:bg-rose-700 transition-colors shadow-md">
                                Start Incident Report <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CARD 2: LIVE SUPPORT / CHAT -->
            <div class="app-card hover-card p-8 sm:p-10 relative">
                <div class="flex flex-col md:flex-row-reverse items-center gap-8 md:gap-12">
                    <!-- Prominent Mascot Image -->
                    <div class="flex-shrink-0 mascot-bounce">
                        <img src="Assets/ngo_pc.png" alt="NGO Assistant" class="w-48 h-48 sm:w-56 sm:h-56 md:w-64 md:h-64 object-contain drop-shadow-xl">
                    </div>

                    <!-- Content & Steps -->
                    <div class="flex-1 space-y-5 text-left">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center flex-shrink-0 border border-blue-100">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-black text-[#092C5E]">Live Support</h3>
                                <p class="text-sm font-semibold text-blue-600">Connect instantly with a verified NGO counselor</p>
                            </div>
                        </div>

                        <p class="text-slate-600 font-medium leading-relaxed text-sm sm:text-base">
                            Start a confidential 1-on-1 real-time session with an active NGO responder for immediate guidance, emotional support, legal assistance, or shelter placement.
                        </p>

                        <!-- Step-by-step breakdown -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-1">
                            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                                <span class="block text-xs font-black text-blue-600 mb-1">Step 1</span>
                                <p class="text-xs text-slate-500 font-medium">Open the Live Support room.</p>
                            </div>
                            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                                <span class="block text-xs font-black text-blue-600 mb-1">Step 2</span>
                                <p class="text-xs text-slate-500 font-medium">Camera & mic remain disabled.</p>
                            </div>
                            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                                <span class="block text-xs font-black text-blue-600 mb-1">Step 3</span>
                                <p class="text-xs text-slate-500 font-medium">Connect & chat with responder.</p>
                            </div>
                        </div>

                        <div class="pt-2">
                            <a href="chat.php" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white font-bold rounded-2xl text-sm hover:bg-blue-700 transition-colors shadow-md">
                                Connect Now <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CARD 3: TRACK TICKET STATUS -->
            <div class="app-card hover-card p-8 sm:p-10 relative">
                <div class="flex flex-col md:flex-row items-center gap-8 md:gap-12">
                    <!-- Prominent Mascot Image -->
                    <div class="flex-shrink-0 mascot-bounce">
                        <img src="Assets/ngo_pc.png" alt="NGO Assistant" class="w-48 h-48 sm:w-56 sm:h-56 md:w-64 md:h-64 object-contain drop-shadow-xl">
                    </div>

                    <!-- Content & Steps -->
                    <div class="flex-1 space-y-5 text-left">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center flex-shrink-0 border border-emerald-100">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-black text-[#092C5E]">Track Status</h3>
                                <p class="text-sm font-semibold text-emerald-600">Check case resolution updates in real time</p>
                            </div>
                        </div>

                        <p class="text-slate-600 font-medium leading-relaxed text-sm sm:text-base">
                            Keep track of your submitted incident progress using your secret Passcode. Access assigned team updates, action status, and officer notes anonymously.
                        </p>

                        <!-- Step-by-step breakdown -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-1">
                            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                                <span class="block text-xs font-black text-emerald-600 mb-1">Step 1</span>
                                <p class="text-xs text-slate-500 font-medium">Go to the Track Status page.</p>
                            </div>
                            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                                <span class="block text-xs font-black text-emerald-600 mb-1">Step 2</span>
                                <p class="text-xs text-slate-500 font-medium">Enter your saved Passcode.</p>
                            </div>
                            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                                <span class="block text-xs font-black text-emerald-600 mb-1">Step 3</span>
                                <p class="text-xs text-slate-500 font-medium">View NGO responses & actions.</p>
                            </div>
                        </div>

                        <div class="pt-2">
                            <a href="track.php" class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-600 text-white font-bold rounded-2xl text-sm hover:bg-emerald-700 transition-colors shadow-md">
                                Track Ticket Status <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</main>

<?php include __DIR__ . '/../footer.php'; ?>