<?php include 'header.php'; ?>

<section class="px-4 md:px-6 py-16 bg-gray-50/50 min-h-screen">
    <div class="max-w-6xl mx-auto">
        <div class="mb-12 border-b border-gray-200/60 pb-8 flex flex-col md:flex-row justify-between items-end gap-6">
            <div>
                <h1 class="text-4xl md:text-5xl font-black tracking-tight text-[#092C5E]">Verified <span class="text-blue-500">Partners</span></h1>
                <p class="text-slate-500 text-lg mt-3 font-medium">Certified, real-world organizations actively resolving cases on the ground.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php 
            $ngos = [
                ["name" => "Sangath", "role" => "Mental Health", "desc" => "Award-winning NGO improving health across the lifespan by empowering community workers.", "image" => "ngo-sangath.jpeg", "color" => "green"],
                ["name" => "Goa Foundation", "role" => "Environmental Protection", "desc" => "Works to protect Goa's natural environment and promote sustainable development.", "image" => "ngo-goa-foundation.png", "color" => "blue"],
                ["name" => "Human Touch Foundation", "role" => "Community Support", "desc" => "Supports vulnerable communities through practical social development initiatives.", "image" => "ngo-human-touch-foundation.jpg", "color" => "purple"],
                ["name" => "Child's Play India Foundation", "role" => "Child Development", "desc" => "Uses sport and play to help children build confidence, wellbeing, and opportunity.", "image" => "ngo-childs-play-india-foundation.jpg", "color" => "rose"]
            ];
            
            foreach ($ngos as $ngo): 
            ?>
            <div class="ios-card-white p-8 flex flex-col hover:border-<?php echo $ngo['color']; ?>-200 group">
                <div class="w-16 h-16 rounded-2xl bg-<?php echo $ngo['color']; ?>-50 flex items-center justify-center mb-6 shadow-inner group-hover:scale-110 transition-transform overflow-hidden">
                    <img src="Assets/<?php echo htmlspecialchars($ngo['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($ngo['name'], ENT_QUOTES, 'UTF-8'); ?> logo" class="w-full h-full object-cover">
                </div>
                <h3 class="text-2xl font-bold text-[#092C5E] mb-2"><?php echo $ngo['name']; ?></h3>
                <span class="text-[10px] font-black tracking-widest uppercase text-<?php echo $ngo['color']; ?>-600 bg-<?php echo $ngo['color']; ?>-50 px-3 py-1 rounded-full self-start mb-4">
                    <?php echo $ngo['role']; ?>
                </span>
                <p class="text-slate-500 text-sm font-medium leading-relaxed"><?php echo $ngo['desc']; ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>