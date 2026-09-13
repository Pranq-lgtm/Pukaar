<?php include 'header.php'; ?>

<!-- Custom Styles for Consistency & Marquee -->
<style>
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
        transform: translateY(-5px);
        box-shadow: 0 20px 40px -15px rgba(9, 44, 94, 0.15);
    }
    
    .ios-card-dark {
        background: #092C5E;
        border-radius: 36px;
        box-shadow: 0 20px 50px -10px rgba(9, 44, 94, 0.4);
    }

    /* Marquee Scroll Animation */
    @keyframes scroll {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }
    .animate-scroll {
        display: flex;
        width: max-content;
        animation: scroll 35s linear infinite;
    }
    .animate-scroll:hover {
        animation-play-state: paused;
    }
</style>

<!-- Hero Section -->
<section class="max-w-7xl mx-auto px-4 pt-6 md:pt-10 pb-16">
    <div class="relative w-full rounded-[3rem] overflow-hidden shadow-[0_20px_50px_-10px_rgba(9,44,94,0.15)] bg-blue-50/50 border border-white/60 p-8 md:p-16 flex flex-col-reverse lg:flex-row items-center justify-between gap-12">
        
        <!-- Text Content -->
        <div class="lg:w-1/2 text-center lg:text-left z-10">
            <span class="inline-block bg-white text-[#092C5E] text-xs font-black uppercase px-4 py-1.5 rounded-full tracking-wider mb-6 shadow-sm border border-blue-100">
                Partner Network Onboarding
            </span>
            
            <!-- Typewriter Heading Target -->
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-black tracking-tight text-[#092C5E] leading-[1.1] mb-6 min-h-[2.2em]">
                <span id="typewriter-line1"></span><br>
                <span class="text-blue-500" id="typewriter-line2"></span><span id="cursor" class="animate-pulse text-blue-500">|</span>
            </h1>

            <p class="text-slate-600 text-lg font-medium max-w-xl mx-auto lg:mx-0 mb-8 leading-relaxed">
                Pukaar provides NGOs and certified social workers with a unified platform to locate local needs, communicate securely, and collaborate to resolve distress cases efficiently.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                <a href="login.php" class="px-8 py-4 rounded-full bg-[#092C5E] text-white font-bold text-sm shadow-xl hover:bg-blue-900 transition-all active:scale-95 text-center">
                    Apply for Verification
                </a>
            </div>
        </div>

        <!-- Mascot Image -->
        <div class="lg:w-1/2 flex justify-center items-center relative z-10">
            <div class="absolute w-72 h-72 bg-blue-400/20 rounded-full blur-3xl"></div>
            <img src="Assets/learn_more.png" alt="Pukaar NGO Mascot" class="max-h-[300px] lg:max-h-[450px] w-auto object-contain drop-shadow-2xl relative z-10" onerror="this.src='https://placehold.co/500x500/092C5E/FFFFFF?text=NGO+Mascot'">
        </div>
    </div>
</section>

<!-- Powerful Tools Suite (Features) -->
<section class="max-w-7xl mx-auto px-4 py-16">
    <div class="text-center max-w-3xl mx-auto mb-16">
        <h2 class="text-3xl md:text-5xl font-black tracking-tight text-[#092C5E] mb-6">Everything you need to <span class="text-blue-500">intervene faster.</span></h2>
        <p class="text-slate-500 text-lg font-medium">We equip our verified partners with a complete suite of digital tools designed for rapid response and secure collaboration.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <!-- Verification -->
        <div class="ios-card-white p-8 flex flex-col items-center text-center border-blue-50/50 relative overflow-hidden group bg-white">
            <div class="h-20 mb-4 flex justify-center transition-transform duration-500 group-hover:scale-110 group-hover:-translate-y-2">
                <img src="Assets/security.png" alt="Trust & Verification Mascot" class="h-full object-contain drop-shadow-md" onerror="this.src='https://placehold.co/100x100/092C5E/FFFFFF?text=Trust'">
            </div>
            <h3 class="text-xl font-bold text-[#092C5E] mb-3">Trust & Verification</h3>
            <p class="text-slate-500 text-sm font-medium leading-relaxed">
                To protect victims, every partner undergoes a strict verification process. Once verified, you gain full access to the platform's secure ecosystem.
            </p>
        </div>

        <!-- Local Complaint Routing -->
        <div class="ios-card-white p-8 flex flex-col items-center text-center border-blue-50/50 relative overflow-hidden group bg-white">
            <div class="h-20 mb-4 flex justify-center transition-transform duration-500 group-hover:scale-110 group-hover:-translate-y-2">
                <img src="Assets/routing.png" alt="Smart Complaint Routing Mascot" class="h-full object-contain drop-shadow-md" onerror="this.src='https://placehold.co/100x100/092C5E/FFFFFF?text=Routing'">
            </div>
            <h3 class="text-xl font-bold text-[#092C5E] mb-3">Smart Complaint Routing</h3>
            <p class="text-slate-500 text-sm font-medium leading-relaxed">
                Our complaint system automatically filters and routes localized distress calls directly to you, helping you locate and serve immediate needs in your specific region.
            </p>
        </div>

        <!-- Communication Tools -->
        <div class="ios-card-white p-8 flex flex-col items-center text-center border-blue-50/50 relative overflow-hidden group bg-white">
            <div class="h-20 mb-4 flex justify-center transition-transform duration-500 group-hover:scale-110 group-hover:-translate-y-2">
                <img src="Assets/cutomer_care.png" alt="Video, Call & Chat Mascot" class="h-full object-contain drop-shadow-md" onerror="this.src='https://placehold.co/100x100/092C5E/FFFFFF?text=Chat'">
            </div>
            <h3 class="text-xl font-bold text-[#092C5E] mb-3">Video, Call & Chat</h3>
            <p class="text-slate-500 text-sm font-medium leading-relaxed">
                Provide real-time support without leaving the dashboard. Utilize built-in, secure, and anonymous chat, voice calling, and video conferencing.
            </p>
        </div>

        <!-- Team Collaboration -->
        <div class="ios-card-white p-8 flex flex-col items-center text-center border-blue-50/50 relative overflow-hidden group bg-white">
            <div class="h-20 mb-4 flex justify-center transition-transform duration-500 group-hover:scale-110 group-hover:-translate-y-2">
                <img src="Assets/team.png" alt="Team Collaboration Mascot" class="h-full object-contain drop-shadow-md" onerror="this.src='https://placehold.co/100x100/092C5E/FFFFFF?text=Team'">
            </div>
            <h3 class="text-xl font-bold text-[#092C5E] mb-3">Team Collaboration</h3>
            <p class="text-slate-500 text-sm font-medium leading-relaxed">
                Cases are rarely solved alone. Add internal team members, share case files securely, and collaborate with other specialized NGOs to resolve complex issues.
            </p>
        </div>

    </div>
</section>

<!-- Our Core Missions (Marquee with Unique Mascots matched to actual Public folder files) -->
<section id="missions" class="py-20 bg-gradient-to-b from-transparent to-gray-50 border-t border-gray-100 overflow-hidden">
    <div class="max-w-6xl mx-auto px-6 mb-12 text-center">
        <h2 class="text-3xl md:text-5xl font-black tracking-tight text-[#092C5E]">Our Core Missions</h2>
        <p class="text-lg text-slate-500 mt-2 font-medium">Quick access to all our reporting tools, registrations, and support forms.</p>
    </div>

    <!-- Marquee Container -->
    <div class="relative w-full overflow-hidden">
        <div class="absolute left-0 top-0 bottom-0 w-16 md:w-32 bg-gradient-to-r from-gray-50 to-transparent z-10 pointer-events-none"></div>
        <div class="absolute right-0 top-0 bottom-0 w-16 md:w-32 bg-gradient-to-l from-gray-50 to-transparent z-10 pointer-events-none"></div>

        <div class="animate-scroll flex space-x-6 px-6">
            <?php 
            $missions = [
                [
                    "tag" => "Report", 
                    "title" => "Anonymous Report", 
                    "desc" => "File a report securely without revealing your identity.", 
                    "link" => "Public/anonymous.php", 
                    "mascot" => "Assets/incognito.png"
                ],
                [
                    "tag" => "Helpline", 
                    "title" => "Child Protection", 
                    "desc" => "Immediate assistance and protection services for children.", 
                    "link" => "Public/child.php", 
                    "mascot" => "Assets/child.png"
                ],
                [
                    "tag" => "Urgent", 
                    "title" => "Emergency SOS Alert", 
                    "desc" => "Trigger a rapid response for immediate life-threatening situations.", 
                    "link" => "Public/Emergency.php", 
                    "mascot" => "Assets/emergency.png"
                ],
                [
                    "tag" => "Feedback", 
                    "title" => "Resolution Feedback", 
                    "desc" => "Share your feedback on how we handled your previous case.", 
                    "link" => "Public/feedback.php", 
                    "mascot" => "Assets/feedback.png"
                ],
                [
                    "tag" => "Crisis", 
                    "title" => "General Emergency", 
                    "desc" => "Broad disaster or multi-agency emergency response coordination.", 
                    "link" => "Public/general emergency.php", 
                    "mascot" => "Assets/NIR.png"
                ],
                [
                    "tag" => "Partner", 
                    "title" => "NGO Registration", 
                    "desc" => "Register your organization to partner with our safety network.", 
                    "link" => "Public/ngo.php", 
                    "mascot" => "Assets/ngo_onboarding.png"
                ],
                [
                    "tag" => "Support", 
                    "title" => "Victim Assistance", 
                    "desc" => "Comprehensive case management and direct support resources for victims.", 
                    "link" => "Public/victim.php", 
                    "mascot" => "Assets/Cyberbullying.png"
                ],
                [
                    "tag" => "Safety", 
                    "title" => "Women's Safety", 
                    "desc" => "Dedicated reporting channels and rapid response teams for women's security.", 
                    "link" => "Public/women.php", 
                    "mascot" => "Assets/security.png"
                ]
            ];
            
            // Duplicate array to make the infinite scroll continuous without jumping
            $missions_loop = array_merge($missions, $missions);
            
            foreach ($missions_loop as $mission): 
            ?>
                <div class="w-80 shrink-0 ios-card-white p-8 flex flex-col justify-between border-blue-50/50 text-center relative overflow-hidden group bg-white">
                    <div>
                        <!-- Unique Mascot Image Added Here -->
                        <div class="h-20 mb-4 flex justify-center transition-transform duration-500 group-hover:scale-110 group-hover:-translate-y-2">
                            <img src="<?php echo $mission['mascot']; ?>" alt="<?php echo $mission['title']; ?> Mascot" class="h-full object-contain drop-shadow-md" onerror="this.src='https://placehold.co/100x100/092C5E/FFFFFF?text=<?php echo urlencode($mission['tag']); ?>'">
                        </div>
                        <span class="text-[10px] font-black tracking-widest text-blue-600 bg-blue-50 px-3 py-1.5 rounded-full uppercase border border-blue-100"><?php echo $mission['tag']; ?></span>
                        <h3 class="text-xl font-bold text-[#092C5E] mt-4"><?php echo $mission['title']; ?></h3>
                        <p class="text-sm font-medium text-slate-500 mt-2 leading-relaxed"><?php echo $mission['desc']; ?></p>
                    </div>
                    <button onclick="window.location.href='<?php echo $mission['link']; ?>'" class="mt-8 w-full bg-gray-50 hover:bg-[#092C5E] hover:text-white text-slate-700 text-sm font-bold py-3 rounded-xl transition-colors border border-gray-100 shadow-sm">
                        Open Form
                    </button>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- How to Join Process (Full-Width Clean Stepped Flow) -->
<section class="py-20 bg-gradient-to-b from-transparent via-blue-50/40 to-transparent">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="inline-block bg-blue-100/70 text-[#092C5E] text-xs font-black uppercase px-4 py-1.5 rounded-full tracking-wider mb-4 border border-blue-200">
                Seamless Integration
            </span>
            <h2 class="text-3xl md:text-5xl font-black tracking-tight text-[#092C5E]">How it Works</h2>
            <p class="text-lg text-slate-500 mt-3 font-medium">Follow these simple steps to join our network and start making an impact.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <!-- Step 1 -->
            <div class="ios-card-white p-8 pt-12 flex flex-col items-center text-center border-blue-100/60 relative group bg-white">
                <div class="absolute -top-5 w-12 h-12 rounded-2xl bg-blue-400 text-white flex items-center justify-center text-xl font-black shadow-lg border-2 border-white">1</div>
                <h3 class="text-xl font-bold text-[#092C5E] mb-3 mt-2">Register & Apply</h3>
                <p class="text-slate-500 text-sm font-medium leading-relaxed">
                    Create an organization profile and submit your registration details directly to our panel for review.
                </p>
            </div>

            <!-- Step 2 -->
            <div class="ios-card-white p-8 pt-12 flex flex-col items-center text-center border-blue-100/60 relative group bg-white">
                <div class="absolute -top-5 w-12 h-12 rounded-2xl bg-blue-600 text-white flex items-center justify-center text-xl font-black shadow-lg border-2 border-white">2</div>
                <h3 class="text-xl font-bold text-[#092C5E] mb-3 mt-2">Verification Review</h3>
                <p class="text-slate-500 text-sm font-medium leading-relaxed">
                    Our team manually verifies your credentials to ensure complete ecosystem security and victim protection.
                </p>
            </div>

            <!-- Step 3 -->
            <div class="ios-card-white p-8 pt-12 flex flex-col items-center text-center border-blue-100/60 relative group bg-white">
                <div class="absolute -top-5 w-12 h-12 rounded-2xl bg-[#092C5E] text-white flex items-center justify-center text-xl font-black shadow-lg border-2 border-white">3</div>
                <h3 class="text-xl font-bold text-[#092C5E] mb-3 mt-2">Onboard & Save Lives</h3>
                <p class="text-slate-500 text-sm font-medium leading-relaxed">
                    Get full dashboard access to receive complaints, coordinate teams, and communicate directly with victims.
                </p>
            </div>

        </div>
    </div>
</section>

<!-- Final CTA (Dark Card) -->
<section class="max-w-6xl mx-auto px-4 py-16 mb-10">
    <div class="ios-card-dark p-10 md:p-16 relative overflow-hidden text-center text-white flex flex-col items-center">
        <!-- Abstract Background Elements -->
        <div class="absolute top-0 right-0 w-80 h-80 bg-blue-400/20 blur-[80px] rounded-full pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 bg-cyan-400/20 blur-[80px] rounded-full pointer-events-none"></div>
        
        <h2 class="text-3xl md:text-5xl font-black tracking-tight mb-6 relative z-10">Ready to make a difference?</h2>
        <p class="text-blue-100/90 text-lg md:text-xl font-medium max-w-2xl text-center mb-10 relative z-10">
            Join the verified network today. Setup your NGO profile, invite your social workers, and start utilizing our advanced communication systems to locate and help those in distress.
        </p>
        
        <div class="flex flex-col sm:flex-row gap-4 relative z-10">
            <a href="login.php" class="px-10 py-4 rounded-full bg-white text-[#092C5E] font-bold text-lg shadow-xl hover:bg-gray-50 transition-all active:scale-95 text-center">
                Register Your NGO
            </a>
            <a href="login.php" class="px-10 py-4 rounded-full bg-transparent border-2 border-white/30 text-white font-bold text-lg hover:bg-white/10 transition-all active:scale-95 text-center">
                Partner Login
            </a>
        </div>
    </div>
</section>

<!-- Typewriter Effect JavaScript -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const line1El = document.getElementById("typewriter-line1");
        const line2El = document.getElementById("typewriter-line2");
        
        const phrase1 = "Amplify your impact.";
        const phrase2 = "Join the cause.";
        
        let i = 0;
        let j = 0;

        function typeLine1() {
            if (i < phrase1.length) {
                line1El.textContent += phrase1.charAt(i);
                i++;
                setTimeout(typeLine1, 80);
            } else {
                setTimeout(typeLine2, 300);
            }
        }

        function typeLine2() {
            if (j < phrase2.length) {
                line2El.textContent += phrase2.charAt(j);
                j++;
                setTimeout(typeLine2, 80);
            }
        }

        setTimeout(typeLine1, 500);
    });
</script>

<?php include 'footer.php'; ?>