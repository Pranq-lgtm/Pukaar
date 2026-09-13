<!-- Simple Footer -->
    <footer class="bg-white border-t border-gray-200 py-10 mt-auto">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-4">
            
            <!-- Brand Logo (Image Only) -->
            <a href="index.php" class="flex items-center">
                <img src="Assets/logo.png" alt="PUKAR Logo" class="h-8 w-auto object-contain">
            </a>

            <div class="flex space-x-6 text-sm font-bold text-gray-500">
                <a href="#" class="hover:text-blue-600 transition">Privacy Policy</a>
                <a href="#" class="hover:text-blue-600 transition">Terms of Service</a>
                <a href="#" class="hover:text-blue-600 transition">Emergency Contacts</a>
            </div>
            
            <div class="text-xs font-semibold text-gray-400">
                &copy; <?php echo date('Y'); ?> PUKAR Platform. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- Mobile Menu Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('mobile-menu-btn');
            const menu = document.getElementById('mobile-menu');

            if (btn && menu) {
                btn.addEventListener('click', () => {
                    menu.classList.toggle('hidden');
                });
            }
        });
    </script>
</body>
</html>