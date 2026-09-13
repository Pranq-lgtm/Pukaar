<?php include 'header.php'; ?>

<section class="px-4 md:px-6 py-12 md:py-20 bg-gray-50/50 min-h-screen">
    <!-- Hero / Mission Statement -->
    <div class="max-w-5xl mx-auto ios-card-white p-8 md:p-16 relative overflow-hidden shadow-2xl border border-white mb-12">
        <!-- Soft glowing orbs for the light theme -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-blue-100/60 blur-[100px] rounded-full pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-cyan-100/60 blur-[100px] rounded-full pointer-events-none"></div>
        
        <div class="relative z-10 text-center">
            <div class="inline-flex items-center gap-2 mb-6 bg-blue-50 px-5 py-2 rounded-full border border-blue-100 shadow-sm">
                <span class="font-bold uppercase text-xs tracking-widest text-blue-600">Track 2: Bal Suraksha</span>
            </div>
            
            <h1 class="text-4xl md:text-6xl font-black tracking-tight leading-tight mb-8 text-[#092C5E]">
                Bridging the gap between a silent cry and a <span class="text-blue-500">safe rescue.</span>
            </h1>
            
            <p class="text-slate-600 text-lg md:text-xl font-medium leading-relaxed mb-6 max-w-3xl mx-auto">
                Pukaar is an end-to-end child protection pipeline. It was engineered to solve the critical challenges of building localized support systems and secure digital-to-physical rescue links for vulnerable youth.
            </p>
            <p class="text-slate-600 text-lg md:text-xl font-medium leading-relaxed max-w-3xl mx-auto">
                In India, the necessity for robust reporting mechanisms against cyberbullying and online exploitation is at an all-time high. Our platform ensures that no call for help goes unanswered by connecting digital alerts directly to ground-level intervention.
            </p>
        </div>
    </div>

    <!-- Features & Problem Statement Mapping -->
    <div class="max-w-6xl mx-auto">
        <div class="mb-12 text-center">
            <h2 class="text-3xl md:text-5xl font-black tracking-tight text-[#092C5E]">How Pukaar Solves <span class="text-purple-500">The Core Problems</span></h2>
            <p class="text-slate-500 text-lg mt-4 font-medium max-w-2xl mx-auto">Our architecture is mapped directly to the critical needs of trauma-informed care and verified intervention.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <!-- Feature 1: Support Ecosystems -->
            <div class="ios-card-white p-8 group hover:-translate-y-1 transition-transform border-teal-100">
                <div class="w-14 h-14 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center text-2xl mb-6 shadow-sm group-hover:scale-110 transition-transform">🗣️</div>
                <div class="mb-2 flex items-center justify-between">
                    <h3 class="text-2xl font-bold text-[#092C5E]">Trauma-Informed Reporting</h3>
                    <span class="text-[10px] font-black tracking-widest uppercase text-teal-600 bg-teal-50 px-3 py-1 rounded-full border border-teal-100">Support Ecosystems</span>
                </div>
                <p class="text-slate-500 font-medium leading-relaxed mt-4">
                    Traditional forms are clinical and intimidating. Pukaar utilizes a multilingual, conversational interface (supporting regional languages like Konkani) to gently guide the child. By allowing free-text input and strictly optional contact details, it removes friction for youth seeking anonymous help.
                </p>
            </div>

            <!-- Feature 2: Stealth Mode -->
            <div class="ios-card-white p-8 group hover:-translate-y-1 transition-transform border-purple-100">
                <div class="w-14 h-14 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-2xl mb-6 shadow-sm group-hover:scale-110 transition-transform">🕵️</div>
                <div class="mb-2 flex items-center justify-between">
                    <h3 class="text-2xl font-bold text-[#092C5E]">Camouflage UI (Stealth Mode)</h3>
                    <span class="text-[10px] font-black tracking-widest uppercase text-purple-600 bg-purple-50 px-3 py-1 rounded-full border border-purple-100">Digital Guardrails</span>
                </div>
                <p class="text-slate-500 font-medium leading-relaxed mt-4">
                    Children facing domestic abuse are often monitored by their abusers. Pukaar's entry point masquerades as a standard student utility (like a spelling practice app). The actual rescue dashboard is only unlocked via a hidden steganographic gesture, keeping the victim safe from immediate physical retaliation.
                </p>
            </div>

            <!-- Feature 3: AI Triage -->
            <div class="ios-card-white p-8 group hover:-translate-y-1 transition-transform border-blue-100">
                <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl mb-6 shadow-sm group-hover:scale-110 transition-transform">🧠</div>
                <div class="mb-2 flex items-center justify-between">
                    <h3 class="text-2xl font-bold text-[#092C5E]">AI-Powered Severity Triage</h3>
                    <span class="text-[10px] font-black tracking-widest uppercase text-blue-600 bg-blue-50 px-3 py-1 rounded-full border border-blue-100">Backend Logic</span>
                </div>
                <p class="text-slate-500 font-medium leading-relaxed mt-4">
                    To prevent ground-level organizations from suffering alert fatigue, Pukaar runs the child's text through a lightweight K-Nearest Neighbors (KNN) classification model. It automatically color-codes active alerts (Red/Yellow/Green) based on natural language urgency markers, prioritizing immediate physical threats.
                </p>
            </div>

            <!-- Feature 4: Physical-Digital Link -->
            <div class="ios-card-white p-8 group hover:-translate-y-1 transition-transform border-rose-100">
                <div class="w-14 h-14 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-2xl mb-6 shadow-sm group-hover:scale-110 transition-transform">🚨</div>
                <div class="mb-2 flex items-center justify-between">
                    <h3 class="text-2xl font-bold text-[#092C5E]">Fail-Safe Physical Dispatch</h3>
                    <span class="text-[10px] font-black tracking-widest uppercase text-rose-600 bg-rose-50 px-3 py-1 rounded-full border border-rose-100">Physical-Digital Link</span>
                </div>
                <p class="text-slate-500 font-medium leading-relaxed mt-4">
                    When an urgent alert is processed, it is routed via an "Uber-style" dispatch to verified local NGOs, much like the national Childline 1098 network. It includes a "Safe-Word Handshake"—a single-use cryptographic token shared between the child's screen and the responder's device, ensuring the child knows the person arriving is a verified rescuer.
                </p>
            </div>

        </div>
    </div>
</section>

<?php include 'footer.php'; ?>