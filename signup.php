<?php 
require_once 'Session/ActiveSession.php';
redirect_if_logged_in(); // Skips page if already logged in

$error_message = ""; // Variable to hold any errors

// --- PROCESS THE FORM SUBMISSION ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Include database connection
    require_once 'config/db.php'; 

    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // 1. Check if passwords match
    if ($password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    } else {
        try {
            // 2. Check if email already exists in Supabase
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                $error_message = "This email is already registered.";
            } else {
                // 3. Hash the password securely
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                // 4. Insert new user into Database
                $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password_hash, role) VALUES (?, ?, ?, 'general') RETURNING id, role");
                $stmt->execute([$full_name, $email, $hashed_password]);
                $new_user = $stmt->fetch();

                // 5. Create Active Session
                $_SESSION['user_id'] = $new_user['id'];
                $_SESSION['full_name'] = $full_name;
                $_SESSION['role'] = $new_user['role'];

                // 6. Redirect to protected public area (Home page)
                header("Location: index.php");
                exit();
            }
        } catch (PDOException $e) {
            $error_message = "Registration failed: " . $e->getMessage(); // Shows exact DB error if it fails
        }
    }
}

// Include header AFTER processing so redirects work properly
include 'header.php'; 
?>

<!-- Styling matching the reference design layout & theme -->
<style>
    .app-card {
        background: #FFFFFF;
        border-radius: 40px;
        box-shadow: 0 20px 60px -15px rgba(9, 44, 94, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.8);
    }
    .pill-input {
        background-color: #F4F6F9;
        border: 1px solid transparent;
        transition: all 0.2s ease-in-out;
    }
    .pill-input:focus-within {
        background-color: #FFFFFF;
        border-color: #092C5E;
        box-shadow: 0 0 0 4px rgba(9, 44, 94, 0.08);
    }
</style>

<section class="relative min-h-[calc(100vh-140px)] flex items-center justify-center py-12 px-4 overflow-hidden">
    <!-- Background Gradient Soft Accents -->
    <div class="absolute w-[500px] h-[500px] rounded-full bg-gradient-to-tr from-slate-200/60 to-blue-100/50 pointer-events-none -z-10 blur-xl"></div>
    <div class="absolute top-12 left-10 w-12 h-12 rounded-full bg-[#092C5E]/20 pointer-events-none hidden sm:block"></div>
    <div class="absolute bottom-16 right-12 w-8 h-8 rounded-full bg-blue-200 pointer-events-none hidden sm:block"></div>

    <div class="w-full max-w-[420px] app-card p-8 sm:p-10 relative">

        <!-- Error Message Display -->
        <?php if(!empty($error_message)): ?>
            <div class="bg-red-50 text-red-600 p-3 rounded-xl text-xs font-bold text-center mb-4 border border-red-100 shadow-sm">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <div class="w-full flex justify-center mb-4 pt-1">
            <div class="relative w-44 h-36 flex items-center justify-center">
                <div class="absolute inset-0 bg-gradient-to-b from-slate-100 to-blue-50/50 rounded-full blur-md -z-10"></div>
                <img src="Assets/onboarding.png" alt="Register Mascot" class="h-full w-auto object-contain drop-shadow-md transition-transform duration-300 hover:scale-105" onerror="this.src='https://placehold.co/200x200/F4F6F9/092C5E?text=Signup'">
            </div>
        </div>

        <div class="mb-6 text-center">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#092C5E] tracking-tight">Create Account</h1>
            <p class="text-slate-400 text-xs font-semibold mt-1">You are Heard. You are Protected.</p>
        </div>

        <!-- Form action is empty so it posts to itself securely -->
        <form action="" method="POST" class="space-y-3.5">
            
            <div>
                <label for="full_name" class="block text-[11px] font-bold text-slate-500 mb-1 ml-1">Full Name</label>
                <div class="pill-input flex items-center px-4 py-3 rounded-2xl">
                    <!-- Retains value if there is an error -->
                    <input type="text" id="full_name" name="full_name" value="<?php echo isset($_POST['full_name']) ? htmlspecialchars($_POST['full_name']) : ''; ?>" placeholder="Full Name" required class="w-full bg-transparent text-sm font-medium text-slate-800 placeholder-slate-300 focus:outline-none">
                </div>
            </div>

            <div>
                <label for="email" class="block text-[11px] font-bold text-slate-500 mb-1 ml-1">Email</label>
                <div class="pill-input flex items-center px-4 py-3 rounded-2xl">
                    <!-- Retains value if there is an error -->
                    <input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" placeholder="Email" required class="w-full bg-transparent text-sm font-medium text-slate-800 placeholder-slate-300 focus:outline-none">
                </div>
            </div>

            <div>
                <label for="password" class="block text-[11px] font-bold text-slate-500 mb-1 ml-1">Password</label>
                <div class="pill-input flex items-center px-4 py-3 rounded-2xl relative">
                    <input type="password" id="passwordInput" name="password" placeholder="Password" required class="w-full bg-transparent text-sm font-medium text-slate-800 placeholder-slate-300 focus:outline-none pr-8">
                    <button type="button" onclick="toggleVisibility('passwordInput', 'eye1')" class="absolute right-4 text-slate-400 hover:text-slate-600 focus:outline-none">
                        <svg id="eye1" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
            </div>

            <div>
                <label for="confirm_password" class="block text-[11px] font-bold text-slate-500 mb-1 ml-1">Confirm Password</label>
                <div class="pill-input flex items-center px-4 py-3 rounded-2xl relative">
                    <input type="password" id="confirmPasswordInput" name="confirm_password" placeholder="Confirm Password" required class="w-full bg-transparent text-sm font-medium text-slate-800 placeholder-slate-300 focus:outline-none pr-8">
                    <button type="button" onclick="toggleVisibility('confirmPasswordInput', 'eye2')" class="absolute right-4 text-slate-400 hover:text-slate-600 focus:outline-none">
                        <svg id="eye2" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
            </div>

            <button type="submit" class="w-full py-3.5 px-4 bg-[#092C5E] hover:bg-blue-900 text-white font-bold text-sm rounded-2xl shadow-lg transition-all active:scale-[0.98] mt-3">
                Sign Up
            </button>
        </form>

        <div class="text-center mt-6">
            <p class="text-xs font-semibold text-slate-400">
                Already have an account? 
                <a href="login.php" class="text-[#092C5E] font-bold hover:underline">Log In</a>
            </p>
        </div>
    </div>
</section>

<script>
    function toggleVisibility(inputId, eyeId) {
        const input = document.getElementById(inputId);
        if (input.type === "password") {
            input.type = "text";
        } else {
            input.type = "password";
        }
    }
</script>

<?php include 'footer.php'; ?>