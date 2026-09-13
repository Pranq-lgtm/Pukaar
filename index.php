<?php include 'header.php'; ?>

<!-- Custom Styles for Apple-like specific components & Slider -->
<style>
    /* Premium Liquid Glass Card */
    .ios-card-white {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: saturate(180%) blur(20px);
        -webkit-backdrop-filter: saturate(180%) blur(20px);
        border-radius: 36px;
        border: 1px solid rgba(255,255,255,0.8);
        box-shadow: 0 10px 40px -10px rgba(9, 44, 94, 0.08);
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .ios-card-white:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px -15px rgba(9, 44, 94, 0.15);
    }

    /* Hero Slider Styles */
    .hero-slide {
        transition: opacity 0.6s ease-in-out, transform 0.6s ease-in-out;
        opacity: 0;
        position: absolute;
        inset: 0;
        z-index: 0;
        pointer-events: none;
        transform: scale(0.98);
    }

    .hero-slide.active {
        opacity: 1;
        z-index: 10;
        pointer-events: auto;
        transform: scale(1);
    }

    .hero-dot {
        transition: all 0.3s ease;
    }

    .hero-dot.active {
        background-color: #092C5E;
        transform: scale(1.3);
        width: 24px;
        border-radius: 99px;
    }

    /* Aira Typewriter Cursor */
    .typewriter-cursor::after {
        content: '|';
        display: inline-block;
        animation: blink 1s infinite;
        color: #092C5E;
        font-weight: 300;
        margin-left: 2px;
    }

    @keyframes blink {
        0%, 100% {
            opacity: 1;
        }

        50% {
            opacity: 0;
        }
    }

    /* Aira Line Transitions */
    .aira-line {
        display: block;
        min-height: 1.15em;
        opacity: 0;
        transform: translateY(12px);
        transition: opacity 0.6s cubic-bezier(0.16, 1, 0.3, 1), transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .aira-line.line-visible {
        opacity: 1;
        transform: translateY(0);
    }

    /* Marquee Animation */
    @keyframes scroll {
        0% {
            transform: translateX(0);
        }

        100% {
            transform: translateX(-50%);
        }
    }

    .animate-scroll {
        display: flex;
        width: max-content;
        animation: scroll 30s linear infinite;
    }

    .animate-scroll:hover {
        animation-play-state: paused;
    }
</style>


<!-- 1. Hero Slideshow Section -->
<section class="max-w-7xl mx-auto px-4 pt-6 md:pt-10 pb-12">

    <!-- Slider Container -->
    <div class="relative w-full h-[650px] md:h-[500px] rounded-[3rem] overflow-hidden shadow-[0_20px_50px_-10px_rgba(9,44,94,0.15)] bg-white border border-white/60">

        <!-- Slide 1: Welcome (Mascot Right) -->
        <div class="hero-slide active bg-blue-50/50 flex flex-col-reverse md:flex-row items-center justify-center md:justify-between p-8 md:p-16 h-full">

            <div class="md:w-1/2 text-center md:text-left z-10 pt-6 md:pt-0">

                <span class="inline-block bg-white text-[#092C5E] text-xs font-black uppercase px-4 py-1.5 rounded-full tracking-wider mb-4 shadow-sm border border-blue-100">
                    Welcome to Pukaar
                </span>

                <h1 class="text-4xl md:text-6xl font-black tracking-tight text-[#092C5E] leading-[1.1] mb-4">
                    You are heard.<br>
                    <span class="text-blue-500">You are protected.</span>
                </h1>

                <p class="text-slate-600 text-base md:text-lg font-medium max-w-md mx-auto md:mx-0 mb-8">
                    A safe space for students and children to speak up, get help, and find support without fear.
                </p>

                <a href="login.php"
                   class="px-8 py-4 rounded-full bg-[#092C5E] text-white font-bold text-sm shadow-xl hover:bg-blue-900 transition-all active:scale-95 inline-block">
                    Explore Support
                </a>
            </div>

            <div class="md:w-1/2 h-1/2 md:h-full flex justify-center items-center relative z-10">
                <div class="absolute w-64 h-64 bg-blue-400/20 rounded-full blur-3xl"></div>

                <img src="Assets/mascot.png"
                     alt="Pukaar Mascot"
                     class="max-h-[200px] md:max-h-[380px] w-auto object-contain drop-shadow-2xl animate-pulse-slow"
                     onerror="this.src='https://placehold.co/400x400/092C5E/FFFFFF?text=Mascot'">
            </div>

        </div>


        <!-- Slide 2: Anonymous (Mascot Left) -->
        <div class="hero-slide bg-blue-50/50 flex flex-col-reverse md:flex-row-reverse items-center justify-center md:justify-between p-8 md:p-16 h-full">

            <div class="md:w-1/2 text-center md:text-left z-10 pt-6 md:pt-0 md:pl-10">

                <span class="inline-block bg-white text-[#092C5E] text-xs font-black uppercase px-4 py-1.5 rounded-full tracking-wider mb-4 shadow-sm border border-blue-100">
                    Privacy Guaranteed
                </span>

                <h1 class="text-3xl md:text-5xl font-black tracking-tight text-[#092C5E] leading-[1.1] mb-4">
                    No need to reveal your identity. <br>
                    <span class="text-blue-500">Stay Anonymous.</span>
                </h1>

                <p class="text-slate-600 text-base md:text-lg font-medium max-w-md mx-auto md:mx-0 mb-8">
                    Don't want to share your name? That's completely fine. Live chat is available 24/7 without exposing who you are.
                </p>

                <a href="login.php"
                   class="px-8 py-4 rounded-full bg-[#092C5E] text-white font-bold text-sm shadow-xl hover:bg-blue-900 transition-all active:scale-95 inline-block">
                    Chat Anonymously
                </a>
            </div>

            <div class="md:w-1/2 h-1/2 md:h-full flex justify-center items-center relative z-10">
                <div class="absolute w-64 h-64 bg-blue-400/20 rounded-full blur-3xl"></div>

                <img src="Assets/incognito.png"
                     alt="Incognito Mode"
                     class="max-h-[200px] md:max-h-[380px] w-auto object-contain drop-shadow-2xl"
                     onerror="this.src='https://placehold.co/400x400/092C5E/FFFFFF?text=Incognito'">
            </div>

        </div>


        <!-- Slide 3: Mental Wellness -->
        <div class="hero-slide bg-blue-50/50 flex flex-col-reverse md:flex-row-reverse items-center justify-center md:justify-between p-8 md:p-16 h-full">

            <div class="md:w-1/2 text-center md:text-left z-10 pt-6 md:pt-0 md:pl-10">

                <span class="inline-block bg-white text-[#092C5E] text-xs font-black uppercase px-4 py-1.5 rounded-full tracking-wider mb-4 shadow-sm border border-blue-100">
                    Mental Health
                </span>

                <h1 class="text-4xl md:text-5xl font-black tracking-tight text-[#092C5E] leading-[1.1] mb-4">
                    Trust us for your <br>
                    <span class="text-blue-500">Mental Wellness.</span>
                </h1>

                <p class="text-slate-600 text-base md:text-lg font-medium max-w-md mx-auto md:mx-0 mb-8">
                    Struggling with anxiety, stress, or dark thoughts? We are here for suicide prevention and guiding you through your problems.
                </p>

                <div class="flex gap-4 justify-center md:justify-start">

                    <a href="login.php"
                       class="px-8 py-4 rounded-full bg-[#092C5E] text-white font-bold text-sm shadow-xl hover:bg-blue-900 transition-all active:scale-95 inline-block">
                        Talk to Someone
                    </a>

                </div>
            </div>

            <div class="md:w-1/2 h-1/2 md:h-full flex justify-center items-center relative z-10">
                <div class="absolute w-64 h-64 bg-blue-400/20 rounded-full blur-3xl"></div>

                <img src="Assets/onboarding.png"
                     alt="Mental Health Support"
                     class="max-h-[200px] md:max-h-[380px] w-auto object-contain drop-shadow-2xl"
                     onerror="this.src='https://placehold.co/400x400/092C5E/FFFFFF?text=Mental+Health'">
            </div>

        </div>


        <!-- Slide 4: Women Safety -->
        <div class="hero-slide bg-gradient-to-br from-rose-50 to-pink-100 flex flex-col-reverse md:flex-row items-center justify-center md:justify-between p-8 md:p-16 h-full">

            <div class="md:w-1/2 text-center md:text-left z-10 pt-6 md:pt-0">

                <span class="inline-block bg-white text-rose-500 text-xs font-black uppercase px-4 py-1.5 rounded-full tracking-wider mb-4 shadow-sm border border-rose-100">
                    Woman Helpline
                </span>

                <h1 class="text-4xl md:text-6xl font-black tracking-tight text-rose-900 leading-[1.1] mb-4">
                    Women Safety <br>
                    <span class="text-rose-500">& Helpline.</span>
                </h1>

                <p class="text-rose-800/80 text-base md:text-lg font-medium max-w-md mx-auto md:mx-0 mb-8">
                    A dedicated, secure channel for women to seek rapid response, legal help, and emotional care immediately.
                </p>

                <div class="flex gap-4 justify-center md:justify-start">

                    <a href="login.php"
                       class="px-8 py-4 rounded-full bg-rose-500 text-white font-bold text-sm shadow-xl hover:bg-rose-600 transition-all active:scale-95 inline-block">
                        Get Help Now
                    </a>

                </div>
            </div>

            <div class="md:w-1/2 h-1/2 md:h-full flex justify-center items-center relative z-10">
                <div class="absolute w-64 h-64 bg-rose-400/20 rounded-full blur-3xl"></div>

                <img src="Assets/woman.png"
                     alt="Women Safety Mascot"
                     class="max-h-[200px] md:max-h-[380px] w-auto object-contain drop-shadow-2xl"
                     onerror="this.src='https://placehold.co/400x400/f43f5e/FFFFFF?text=Woman'">
            </div>

        </div>


        <!-- Left/Right Navigation Arrows -->
        <button onclick="prevSlide()"
                class="absolute left-2 md:left-6 top-1/2 -translate-y-1/2 w-10 h-10 md:w-12 md:h-12 bg-white/80 backdrop-blur-md rounded-full shadow-lg flex items-center justify-center text-[#092C5E] hover:bg-white z-20 transition-transform active:scale-90">

            <svg xmlns="http://www.w3.org/2000/svg"
                 width="24"
                 height="24"
                 viewBox="0 0 24 24"
                 fill="none"
                 stroke="currentColor"
                 stroke-width="2.5"
                 stroke-linecap="round"
                 stroke-linejoin="round">
                <path d="m15 18-6-6 6-6"/>
            </svg>

        </button>


        <button onclick="nextSlide()"
                class="absolute right-2 md:right-6 top-1/2 -translate-y-1/2 w-10 h-10 md:w-12 md:h-12 bg-white/80 backdrop-blur-md rounded-full shadow-lg flex items-center justify-center text-[#092C5E] hover:bg-white z-20 transition-transform active:scale-90">

            <svg xmlns="http://www.w3.org/2000/svg"
                 width="24"
                 height="24"
                 viewBox="0 0 24 24"
                 fill="none"
                 stroke="currentColor"
                 stroke-width="2.5"
                 stroke-linecap="round"
                 stroke-linejoin="round">
                <path d="m9 18 6-6-6-6"/>
            </svg>

        </button>


        <!-- Slider Controls -->
        <div class="absolute bottom-6 left-0 right-0 flex justify-center gap-3 z-20">

            <button class="hero-dot active w-3 h-3 rounded-full bg-slate-300 shadow-sm"
                    onclick="goToSlide(0)"></button>

            <button class="hero-dot w-3 h-3 rounded-full bg-slate-300 shadow-sm"
                    onclick="goToSlide(1)"></button>

            <button class="hero-dot w-3 h-3 rounded-full bg-slate-300 shadow-sm"
                    onclick="goToSlide(2)"></button>

            <button class="hero-dot w-3 h-3 rounded-full bg-slate-300 shadow-sm"
                    onclick="goToSlide(3)"></button>

        </div>

    </div>
</section>


<!-- 2. Dark Blue Impact Metrics -->
<section class="max-w-6xl mx-auto px-6 mb-20 relative z-10">

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 py-8 bg-white/80 backdrop-blur-xl border border-gray-100 rounded-[2.5rem] shadow-[0_10px_30px_-10px_rgba(9,44,94,0.05)]">

        <div class="text-center border-r border-gray-100 last:border-0 md:border-r-0 md:border-b-0">
            <div class="text-3xl md:text-4xl font-black text-[#092C5E] mb-1">
                12K+
            </div>

            <div class="text-slate-500 text-[10px] font-bold uppercase tracking-widest">
                Voices Heard
            </div>
        </div>


        <div class="text-center md:border-r border-gray-100">

            <div class="text-3xl md:text-4xl font-black text-[#092C5E] mb-1">
                98%
            </div>

            <div class="text-slate-500 text-[10px] font-bold uppercase tracking-widest">
                Cases Guided
            </div>

        </div>


        <div class="text-center border-r border-gray-100 last:border-0 md:border-b-0">

            <div class="text-3xl md:text-4xl font-black text-[#092C5E] mb-1">
                50+
            </div>

            <div class="text-slate-500 text-[10px] font-bold uppercase tracking-widest">
                Verified NGOs
            </div>

        </div>


        <div class="text-center flex flex-col items-center justify-center">

            <div class="bg-blue-100 text-[#092C5E] px-4 py-1.5 rounded-full flex items-center gap-1.5 font-bold text-sm mb-1 border border-blue-200">

                <svg xmlns="http://www.w3.org/2000/svg"
                     width="16"
                     height="16"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="3"
                     stroke-linecap="round"
                     stroke-linejoin="round">

                    <polyline points="20 6 9 17 4 12"/>

                </svg>

                Active

            </div>

            <div class="text-slate-500 text-[10px] font-bold uppercase tracking-widest">
                Anonymous Mode
            </div>

        </div>

    </div>
</section>


<!-- 3. Trust & Reporting (Aira Layout) -->
<section id="report" class="px-4 md:px-6 pb-16">

    <div class="max-w-6xl mx-auto ios-card-white p-8 md:p-16 relative overflow-hidden flex flex-col lg:flex-row items-center gap-12 lg:gap-16">

        <div class="absolute top-0 left-0 w-64 h-64 bg-blue-100/50 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>


        <div class="lg:w-1/2 text-center lg:text-left z-10">

            <div class="inline-flex items-center gap-2 mb-6 bg-blue-50 text-[#092C5E] px-4 py-2 rounded-2xl border border-blue-100 shadow-sm">

                <span class="text-xl">👋</span>

                <span class="font-bold uppercase text-[10px] tracking-widest">
                    Meet Aira
                </span>

            </div>


            <!-- Aira Animated Heading -->
            <h2 id="aira-heading"
                class="typewriter-cursor text-4xl md:text-5xl font-black tracking-tight text-[#092C5E] leading-tight mb-6 min-h-[9rem] md:min-h-[10rem]">

                <span class="aira-line">Hey, Aira here.</span>
                <span class="aira-line">Why trust Pukaar?</span>
                <span class="aira-line">Here's why.</span>

            </h2>


            <p class="text-slate-500 text-lg leading-relaxed max-w-md mx-auto lg:mx-0 mb-8 font-medium">

                I make sure that whenever you file a
                <strong class="text-[#092C5E]">General Report</strong>
                or an
                <strong class="text-[#092C5E]">Anonymous Request</strong>,
                your identity is completely hidden. I personally route your distress calls to certified NGO partners so you stay perfectly safe.

            </p>


            <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">

                <a href="login.php"
                   class="px-8 py-4 bg-[#092C5E] text-white rounded-full font-bold shadow-xl hover:bg-blue-900 transition-all active:scale-95 text-sm">
                    File Anonymous Report
                </a>

                <a href="login.php"
                   class="px-8 py-4 bg-white text-[#092C5E] border-2 border-[#092C5E]/10 rounded-full font-bold hover:bg-blue-50 transition-all active:scale-95 text-sm">
                    File General Report
                </a>

            </div>

        </div>


        <!-- Relieved Image -->
        <div class="lg:w-1/2 w-full flex justify-center relative z-10">

            <div class="w-full max-w-md relative">

                <img src="Assets/relived.png"
                     alt="Relieved User"
                     class="w-full h-auto object-contain drop-shadow-xl"
                     onerror="this.src='https://placehold.co/500x500/092C5E/FFFFFF?text=Relived'">

            </div>

        </div>

    </div>

</section>


<!-- 4. Services Grid -->
<section id="services" class="px-4 md:px-6 py-16">

    <div class="max-w-6xl mx-auto">

        <div class="mb-12 md:mb-16 text-center md:text-left">

            <h2 class="text-4xl md:text-5xl font-black tracking-tight text-[#092C5E] mb-4">
                Dedicated <br>
                <span class="text-blue-400">Support Channels</span>
            </h2>

            <p class="text-slate-500 text-lg max-w-2xl mx-auto md:mx-0 font-medium">
                Select the specific help you need right now. We cover all bases of harassment and abuse.
            </p>

        </div>


        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">


            <!-- Cyber Bullying -->
            <div class="ios-card-white overflow-hidden flex flex-col group border-gray-100 hover:border-blue-200">

                <div class="h-48 bg-transparent flex items-center justify-center p-6 relative overflow-hidden">

                    <img src="Assets/security.png"
                         alt="Cyber Bullying"
                         class="h-full object-contain relative z-10 transition-transform duration-500 group-hover:scale-110 drop-shadow-md"
                         onerror="this.src='https://placehold.co/300x200/ffffff/092C5E?text=Cyber'">

                </div>

                <div class="p-8 flex flex-col flex-grow items-start bg-white/50 border-t border-gray-50">

                    <h3 class="text-2xl font-black mb-3 text-[#092C5E]">
                        Cyber Bullying
                    </h3>

                    <p class="text-slate-500 text-sm font-medium leading-relaxed mb-8 flex-grow">
                        Report online harassment, threats, or abuse. Our digital response partners will help secure your footprint.
                    </p>

                    <a href="login.php"
                       class="mt-auto w-full text-center bg-[#092C5E] text-white font-bold py-3.5 rounded-xl hover:bg-blue-900 transition-colors shadow-md">
                        Seek Cyber Help
                    </a>

                </div>
            </div>


            <!-- Mental Health -->
            <div class="ios-card-white overflow-hidden flex flex-col group border-gray-100 hover:border-blue-200">

                <div class="h-48 bg-transparent flex items-center justify-center p-6 relative overflow-hidden">

                    <img src="Assets/onboarding.png"
                         alt="Mental Health"
                         class="h-full object-contain relative z-10 transition-transform duration-500 group-hover:scale-110 drop-shadow-md"
                         onerror="this.src='https://placehold.co/300x200/ffffff/092C5E?text=Mental+Health'">

                </div>

                <div class="p-8 flex flex-col flex-grow items-start bg-white/50 border-t border-gray-50">

                    <h3 class="text-2xl font-black mb-3 text-[#092C5E]">
                        Mental Health
                    </h3>

                    <p class="text-slate-500 text-sm font-medium leading-relaxed mb-8 flex-grow">
                        Connect with friendly therapists and counselors. Do not suffer in silence; get the emotional support you deserve.
                    </p>

                    <a href="login.php"
                       class="mt-auto w-full text-center bg-[#092C5E] text-white font-bold py-3.5 rounded-xl hover:bg-blue-900 transition-colors shadow-md">
                        Talk to a Counselor
                    </a>

                </div>
            </div>


            <!-- Woman Helpline -->
            <div class="ios-card-white overflow-hidden flex flex-col group md:col-span-2 lg:col-span-1 border-gray-100 hover:border-blue-200">

                <div class="h-48 bg-transparent flex items-center justify-center p-6 relative overflow-hidden">

                    <img src="Assets/woman.png"
                         alt="Woman Helpline"
                         class="h-full object-contain relative z-10 transition-transform duration-500 group-hover:scale-110 drop-shadow-md"
                         onerror="this.src='https://placehold.co/300x200/ffffff/092C5E?text=Women'">

                </div>

                <div class="p-8 flex flex-col flex-grow items-start bg-white/50 border-t border-gray-50">

                    <h3 class="text-2xl font-black mb-3 text-[#092C5E]">
                        Woman Helpline
                    </h3>

                    <p class="text-slate-500 text-sm font-medium leading-relaxed mb-8 flex-grow">
                        A dedicated safe space and rapid-response network for women facing abuse, harassment, or feeling unsafe.
                    </p>

                    <a href="login.php"
                       class="mt-auto w-full text-center bg-[#092C5E] text-white font-bold py-3.5 rounded-xl hover:bg-blue-900 transition-colors shadow-md">
                        Reach Women's Desk
                    </a>

                </div>
            </div>


        </div>
    </div>

</section>


<!-- 5. Feel Free / Safe (Modernized Redesign) -->
<section id="about" class="px-4 md:px-6 py-12">

    <div class="max-w-6xl mx-auto bg-gradient-to-br from-[#092C5E] via-[#0B3B7B] to-[#061C3D] rounded-[3rem] p-8 md:p-16 relative overflow-hidden shadow-[0_25px_60px_-15px_rgba(9,44,94,0.35)] border border-white/10">

        <!-- Ambient Background Glows -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-blue-500/20 blur-[120px] rounded-full pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-indigo-500/20 blur-[120px] rounded-full pointer-events-none"></div>

        <!-- Section Header -->
        <div class="text-center max-w-2xl mx-auto mb-12 md:mb-16 relative z-10">
            <span class="inline-block bg-white/10 text-blue-200 text-xs font-bold uppercase tracking-widest px-4 py-1.5 rounded-full backdrop-blur-md mb-4 border border-white/10">
                Safe & Confidential
            </span>
            <h2 class="text-4xl md:text-5xl font-black tracking-tight text-white leading-tight">
                Don't suffer in silence.
            </h2>
            <p class="text-blue-100/80 text-sm md:text-base font-medium mt-3">
                Your safety and peace of mind are built into every level of our platform.
            </p>
        </div>

        <!-- 3 Pillars Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8 relative z-10">

            <!-- Card 1: 100% Anonymous -->
            <div class="group relative bg-white/5 backdrop-blur-xl border border-white/10 rounded-[2.5rem] p-8 flex flex-col items-center text-center transition-all duration-300 hover:bg-white/10 hover:-translate-y-1.5 hover:shadow-2xl">
                <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-blue-400/20 to-blue-600/20 border border-blue-400/30 flex items-center justify-center mb-6 shadow-inner group-hover:scale-105 transition-transform">
                    <span class="text-2xl font-black text-blue-300">100%</span>
                </div>
                <h3 class="font-bold text-xl text-white mb-2">
                    Anonymous Mode
                </h3>
                <p class="text-blue-100/70 text-sm font-medium leading-relaxed">
                    No name, email, or personal details required to request emergency guidance.
                </p>
            </div>

            <!-- Card 2: Very Quick Response -->
            <div class="group relative bg-white/5 backdrop-blur-xl border border-white/10 rounded-[2.5rem] p-8 flex flex-col items-center text-center transition-all duration-300 hover:bg-white/10 hover:-translate-y-1.5 hover:shadow-2xl">
                <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-purple-400/20 to-purple-600/20 border border-purple-400/30 flex items-center justify-center mb-6 shadow-inner group-hover:scale-105 transition-transform text-purple-300">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                </div>
                <h3 class="font-bold text-xl text-white mb-2">
                    Rapid Response
                </h3>
                <p class="text-blue-100/70 text-sm font-medium leading-relaxed">
                    Directly routed distress calls to active emergency partners and verified NGOs.
                </p>
            </div>

            <!-- Card 3: Encrypted & Secure -->
            <div class="group relative bg-white/5 backdrop-blur-xl border border-white/10 rounded-[2.5rem] p-8 flex flex-col items-center text-center transition-all duration-300 hover:bg-white/10 hover:-translate-y-1.5 hover:shadow-2xl">
                <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-cyan-400/20 to-cyan-600/20 border border-cyan-400/30 flex items-center justify-center mb-6 shadow-inner group-hover:scale-105 transition-transform text-cyan-300">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    </svg>
                </div>
                <h3 class="font-bold text-xl text-white mb-2">
                    End-to-End Encrypted
                </h3>
                <p class="text-blue-100/70 text-sm font-medium leading-relaxed">
                    All chat threads and uploaded report data stay completely private and protected.
                </p>
            </div>

        </div>

    </div>

</section>


<!-- 6. Partnered NGOs -->
<section id="ngos" class="max-w-6xl mx-auto px-6 py-16">

    <div class="flex flex-col md:flex-row justify-between items-end mb-10 gap-4">

        <div>

            <h2 class="text-3xl md:text-5xl font-black tracking-tight text-[#092C5E]">
                Partnered NGOs
            </h2>

            <p class="text-lg text-slate-500 mt-2 font-medium">
                Certified, real-world organizations actively resolving cases on the ground.
            </p>

        </div>

        <a href="Partnered.php"
           class="hidden md:inline-flex text-[#092C5E] font-bold items-center gap-2 hover:gap-3 transition-all bg-blue-50 px-5 py-2.5 rounded-full border border-blue-100">
            View All Partners &rarr;
        </a>

    </div>


    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

        <?php

        $ngos = [

            [
                "name" => "Sangath",
                "role" => "Mental Health",
                "desc" => "Award-winning NGO improving health across the lifespan by empowering community workers.",
                "image" => "ngo-sangath.jpeg",
                "color" => "green"
            ],

            [
                "name" => "Goa Foundation",
                "role" => "Environmental Protection",
                "desc" => "Works to protect Goa's natural environment and promote sustainable development.",
                "image" => "ngo-goa-foundation.png",
                "color" => "blue"
            ],

            [
                "name" => "Human Touch Foundation",
                "role" => "Community Support",
                "desc" => "Supports vulnerable communities through practical social development initiatives.",
                "image" => "ngo-human-touch-foundation.jpg",
                "color" => "purple"
            ],

            [
                "name" => "Child's Play India Foundation",
                "role" => "Child Development",
                "desc" => "Uses sport and play to help children build confidence, wellbeing, and opportunity.",
                "image" => "ngo-childs-play-india-foundation.jpg",
                "color" => "rose"
            ]

        ];

        foreach ($ngos as $ngo):

        ?>

            <div class="ios-card-white p-6 text-center flex flex-col items-center justify-between group cursor-pointer hover:border-<?php echo $ngo['color']; ?>-200"
                 onclick="window.location.href='Partnered.php'">

                <div>

                    <div class="w-20 h-20 mx-auto rounded-2xl bg-<?php echo $ngo['color']; ?>-50 flex items-center justify-center mb-5 shadow-inner group-hover:scale-110 transition-transform overflow-hidden p-2">

                        <img src="Assets/<?php echo htmlspecialchars($ngo['image'], ENT_QUOTES, 'UTF-8'); ?>"
                             alt="<?php echo htmlspecialchars($ngo['name'], ENT_QUOTES, 'UTF-8'); ?> logo"
                             class="w-full h-full object-contain">

                    </div>

                    <h3 class="font-bold text-[#092C5E] text-xl mb-2">
                        <?php echo $ngo['name']; ?>
                    </h3>

                    <span class="text-[10px] font-black tracking-widest uppercase text-<?php echo $ngo['color']; ?>-600 bg-<?php echo $ngo['color']; ?>-50 px-3 py-1 rounded-full inline-block mb-3">
                        <?php echo $ngo['role']; ?>
                    </span>

                    <p class="text-slate-500 text-xs font-medium leading-relaxed line-clamp-3">
                        <?php echo $ngo['desc']; ?>
                    </p>

                </div>

            </div>

        <?php endforeach; ?>

    </div>


    <!-- Mobile View All Button -->
    <div class="mt-8 text-center md:hidden">

        <a href="Partnered.php"
           class="inline-flex text-[#092C5E] font-bold items-center gap-2 bg-blue-50 px-6 py-3 rounded-full border border-blue-100 shadow-sm">
            View All Partners &rarr;
        </a>

    </div>

</section>


<!-- 7. Upcoming Campaigns -->
<section id="campaigns"
         class="py-20 bg-gradient-to-b from-transparent to-gray-50 border-t border-gray-100 overflow-hidden">

    <div class="max-w-6xl mx-auto px-6 mb-12 text-center">

        <h2 class="text-3xl md:text-5xl font-black tracking-tight text-[#092C5E]">
            Upcoming Workshops
        </h2>

        <p class="text-lg text-slate-500 mt-2 font-medium">
            Join the community movement and learn together.
        </p>

    </div>


    <div class="relative w-full overflow-hidden">

        <div class="absolute left-0 top-0 bottom-0 w-16 md:w-32 bg-gradient-to-r from-gray-50 to-transparent z-10"></div>

        <div class="absolute right-0 top-0 bottom-0 w-16 md:w-32 bg-gradient-to-l from-gray-50 to-transparent z-10"></div>


        <div class="animate-scroll flex space-x-6 px-6">

            <?php

            $campaigns = [

                [
                    "date" => "Oct 20, 2026",
                    "title" => "Cyber Safety Workshop",
                    "desc" => "Learn how to secure digital profiles."
                ],

                [
                    "date" => "Nov 05, 2026",
                    "title" => "Mental Health Summit",
                    "desc" => "Open talks with certified counselors."
                ],

                [
                    "date" => "Nov 15, 2026",
                    "title" => "Girls Legal Rights",
                    "desc" => "Know your rights against harassment."
                ],

                [
                    "date" => "Dec 01, 2026",
                    "title" => "School Anti-Bullying",
                    "desc" => "Creating safe spaces in education."
                ]

            ];

            $campaign_loop = array_merge($campaigns, $campaigns);

            foreach ($campaign_loop as $camp):

            ?>

                <div class="w-80 shrink-0 ios-card-white p-8 flex flex-col justify-between border-blue-50/50">

                    <div>

                        <span class="text-[10px] font-black tracking-widest text-blue-600 bg-blue-50 px-3 py-1.5 rounded-full uppercase border border-blue-100">
                            <?php echo $camp['date']; ?>
                        </span>

                        <h3 class="text-xl font-bold text-[#092C5E] mt-5">
                            <?php echo $camp['title']; ?>
                        </h3>

                        <p class="text-sm font-medium text-slate-500 mt-2 leading-relaxed">
                            <?php echo $camp['desc']; ?>
                        </p>

                    </div>

                    <button onclick="window.location.href='login.php'"
                            class="mt-8 w-full bg-gray-50 hover:bg-[#092C5E] hover:text-white text-slate-700 text-sm font-bold py-3 rounded-xl transition-colors border border-gray-100">
                        View Details
                    </button>

                </div>

            <?php endforeach; ?>

        </div>

    </div>

</section>


<!-- 8. Responder Onboarding CTA -->
<section class="px-4 md:px-6 py-16 border-t border-gray-100 bg-white">

    <div class="max-w-4xl mx-auto ios-card-white p-10 md:p-16 text-center shadow-[0_20px_50px_-10px_rgba(9,44,94,0.08)] border border-blue-100/50">

        <div class="w-20 h-20 bg-[#092C5E] text-white rounded-3xl flex items-center justify-center mx-auto mb-8 shadow-xl shadow-blue-900/20 transform -rotate-3">

            <svg xmlns="http://www.w3.org/2000/svg"
                 width="36"
                 height="36"
                 viewBox="0 0 24 24"
                 fill="none"
                 stroke="currentColor"
                 stroke-width="2.5"
                 stroke-linecap="round"
                 stroke-linejoin="round">

                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>

                <circle cx="9" cy="7" r="4"/>

                <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>

                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>

            </svg>

        </div>


        <h2 class="text-3xl md:text-4xl font-black text-[#092C5E] mb-4">
            Are you an NGO or Certified Responder?
        </h2>


        <p class="text-slate-500 font-medium text-base max-w-lg mx-auto mb-8">
            Join the Pukaar network to receive routed distress signals and help protect students and children on the ground.
        </p>


        <!-- Dual Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">

            <a href="ngo-onboarding.php"
               class="w-full sm:w-auto px-8 py-4 bg-[#092C5E] text-white rounded-full font-bold shadow-xl hover:bg-blue-900 transition-all active:scale-95 text-sm">
                Join as a Partner
            </a>

            <a href="learn_more.php"
               class="w-full sm:w-auto px-8 py-4 bg-white text-[#092C5E] border-2 border-[#092C5E]/15 rounded-full font-bold hover:bg-blue-50 transition-all active:scale-95 text-sm">
                Learn More
            </a>

        </div>

    </div>

</section>


<script>

    /* =========================================
       HERO SLIDER
    ========================================= */

    let currentSlide = 0;

    const slides = document.querySelectorAll('.hero-slide');
    const dots = document.querySelectorAll('.hero-dot');


    function showSlide(index) {

        slides.forEach((slide, i) => {

            slide.classList.toggle('active', i === index);
            dots[i].classList.toggle('active', i === index);

        });

        currentSlide = index;
    }


    function nextSlide() {

        let next = (currentSlide + 1) % slides.length;

        showSlide(next);
    }


    function prevSlide() {

        let prev = (currentSlide - 1 + slides.length) % slides.length;

        showSlide(prev);
    }


    function goToSlide(index) {

        showSlide(index);
    }


    // Auto-advance slides every 6 seconds
    setInterval(nextSlide, 6000);



    /* =========================================
       AIRA STAGGERED FADE-IN ANIMATION
    ========================================= */

    function animateAiraLines() {
        const lines = document.querySelectorAll('#aira-heading .aira-line');
        lines.forEach((line, index) => {
            setTimeout(() => {
                line.classList.add('line-visible');
            }, index * 400);
        });
    }


    /* Start Aira animation after page loads */
    document.addEventListener('DOMContentLoaded', () => {
        setTimeout(animateAiraLines, 300);
    });

</script>


<?php include 'footer.php'; ?>