<?php include 'header.php'; ?>

<section class="px-4 md:px-6 py-16">
    <div class="max-w-5xl mx-auto">
        <div class="mb-16 text-center">
            <h1 class="text-4xl md:text-5xl font-black tracking-tight text-[#092C5E]">Upcoming <span class="text-purple-500">Workshops</span></h1>
            <p class="text-slate-500 text-lg mt-4 font-medium max-w-2xl mx-auto">Join the community movement. Education is the first line of defense against bullying and exploitation.</p>
        </div>

        <div class="space-y-6">
            <?php 
            $campaigns = [
                ["date" => "Oct 20", "title" => "Cyber Safety Workshop", "desc" => "Learn how to secure digital profiles, spot online grooming, and block cyberbullies safely.", "color" => "blue"],
                ["date" => "Nov 05", "title" => "Mental Health Summit", "desc" => "Open talks with certified counselors on handling student stress and trauma.", "color" => "teal"],
                ["date" => "Nov 15", "title" => "Youth Legal Rights", "desc" => "Know your legal rights against harassment, with guest speakers from local law enforcement.", "color" => "purple"]
            ];
            
            foreach ($campaigns as $camp): 
            ?>
            <div class="ios-card-white p-6 md:p-8 flex flex-col md:flex-row items-start md:items-center gap-6 border-l-[6px] border-<?php echo $camp['color']; ?>-400 hover:bg-gray-50/50">
                <div class="flex-shrink-0 bg-<?php echo $camp['color']; ?>-50 text-<?php echo $camp['color']; ?>-700 font-black p-4 rounded-2xl text-center w-24 shadow-sm">
                    <div class="text-sm uppercase tracking-widest opacity-80"><?php echo explode(' ', $camp['date'])[0]; ?></div>
                    <div class="text-3xl leading-none mt-1"><?php echo explode(' ', $camp['date'])[1]; ?></div>
                </div>
                <div class="flex-grow">
                    <h3 class="text-2xl font-bold text-[#092C5E]"><?php echo $camp['title']; ?></h3>
                    <p class="text-slate-500 font-medium mt-2 leading-relaxed"><?php echo $camp['desc']; ?></p>
                </div>
                <div class="flex-shrink-0 w-full md:w-auto mt-4 md:mt-0">
                    <button class="w-full px-8 py-3 bg-[#092C5E] text-white rounded-xl font-bold shadow-md hover:bg-blue-900 transition-colors">
                        Register
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>