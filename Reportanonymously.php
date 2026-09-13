<?php include 'header.php'; ?>

<section class="px-4 md:px-6 py-12 bg-gray-50/50">
    <div class="max-w-4xl mx-auto">
        
        <!-- Reassurance Banner -->
        <div class="ios-card-dark p-8 md:p-12 mb-8 text-white relative overflow-hidden shadow-2xl">
            <div class="absolute top-0 right-0 w-64 h-64 bg-blue-400/20 blur-[80px] rounded-full pointer-events-none"></div>
            <div class="relative z-10">
                <h2 class="text-3xl font-black mb-4 flex items-center gap-3">
                    <span class="text-4xl">🛡️</span> Your Identity is Safe
                </h2>
                <p class="text-blue-100 text-lg font-medium leading-relaxed">
                    We understand that speaking up can be terrifying. <strong class="text-white">You are in control.</strong> When you file an anonymous report, we do not track your IP, and your data is heavily encrypted. Your distress call is routed only to verified professionals.
                </p>
            </div>
        </div>

        <!-- The Report Form inside iOS Glass Card -->
        <div class="ios-card-white p-8 md:p-12">
            <form action="api.php" method="POST" class="space-y-8">
                
                <div>
                    <label class="block text-xl font-bold text-[#092C5E] mb-2">What are you experiencing?</label>
                    <p class="text-sm text-slate-400 font-medium mb-4">Describe the situation in your own words. Take your time.</p>
                    <textarea name="description" rows="5" required
                        class="w-full p-5 bg-gray-50/50 border border-gray-200 rounded-3xl focus:ring-4 focus:ring-blue-100 focus:border-blue-400 outline-none resize-none transition-all text-slate-700 font-medium shadow-inner"
                        placeholder="I am facing..."></textarea>
                </div>

                <div>
                    <label class="block text-xl font-bold text-[#092C5E] mb-4">What kind of support do you need?</label>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <label class="cursor-pointer">
                            <input type="radio" name="category" value="cyber" class="peer sr-only">
                            <div class="p-5 border-2 border-gray-100 rounded-2xl text-center peer-checked:bg-blue-50 peer-checked:border-blue-400 peer-checked:text-blue-700 hover:bg-gray-50 transition-all font-bold text-slate-500 shadow-sm">
                                💻 Cyber Bullying
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="category" value="mental" class="peer sr-only">
                            <div class="p-5 border-2 border-gray-100 rounded-2xl text-center peer-checked:bg-teal-50 peer-checked:border-teal-400 peer-checked:text-teal-700 hover:bg-gray-50 transition-all font-bold text-slate-500 shadow-sm">
                                🧠 Mental Health
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="category" value="physical" class="peer sr-only">
                            <div class="p-5 border-2 border-gray-100 rounded-2xl text-center peer-checked:bg-rose-50 peer-checked:border-rose-400 peer-checked:text-rose-700 hover:bg-gray-50 transition-all font-bold text-slate-500 shadow-sm">
                                🛑 Physical Danger
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Forced Anonymous Block -->
                <div class="bg-blue-50/50 p-6 rounded-3xl border border-blue-100 flex items-start space-x-4">
                    <div class="bg-blue-500 text-white rounded-full p-1 mt-1 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    </div>
                    <input type="hidden" name="is_anonymous" value="true">
                    <div>
                        <label class="font-bold text-[#092C5E] text-lg">Kept 100% Anonymous</label>
                        <p class="text-sm font-medium text-blue-600 mt-1">This is locked on for this page. Your safety is guaranteed.</p>
                    </div>
                </div>

                <button type="submit" class="w-full bg-[#092C5E] hover:bg-blue-900 text-white font-black tracking-wide py-5 rounded-full shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all text-lg mt-4 active:scale-95">
                    Submit Anonymous Report
                </button>
            </form>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>