<?php 
require_once 'Session/ActiveSession.php';
redirect_if_logged_in(); // Skips page if already logged in

$error_message = ""; // Variable to hold any errors

// --- PROCESS THE LOGIN SUBMISSION ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'config/db.php'; 

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    try {
        // Fetch user from DB
        $stmt = $pdo->prepare("SELECT id, full_name, password_hash, role FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        // Verify Password
        if ($user && password_verify($password, $user['password_hash'])) {
            
            // Update last login timestamp
            $updateStmt = $pdo->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
            $updateStmt->execute([$user['id']]);

            // Create Active Session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['role'] = $user['role'];

            // ROUTE BASED ON ROLE (Exactly as requested)
            if ($user['role'] === 'ngo' || $user['role'] === 'admin') {
                header("Location: Responder/index.php");
            } else {
                header("Location: Public/index.php");
            }
            exit();

        } else {
            $error_message = "Invalid email or password.";
        }

    } catch (PDOException $e) {
        $error_message = "Login failed: " . $e->getMessage();
    }
}

include 'header.php'; 
?>

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
    <!-- Background Circle Accents -->
    <div class="absolute w-[500px] h-[500px] rounded-full bg-gradient-to-tr from-slate-200/60 to-blue-100/50 pointer-events-none -z-10 blur-xl"></div>
    <div class="absolute top-12 left-10 w-12 h-12 rounded-full bg-[#092C5E]/20 pointer-events-none hidden sm:block"></div>
    <div class="absolute bottom-16 right-12 w-8 h-8 rounded-full bg-blue-200 pointer-events-none hidden sm:block"></div>

    <div class="w-full max-w-[400px] app-card p-8 sm:p-10 relative">

        <!-- Error Message Display -->
        <?php if(!empty($error_message)): ?>
            <div class="bg-red-50 text-red-600 p-3 rounded-xl text-xs font-bold text-center mb-4 border border-red-100 shadow-sm">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <div class="w-full flex justify-center mb-6 pt-2">
            <div class="relative w-48 h-40 flex items-center justify-center">
                <div class="absolute inset-0 bg-gradient-to-b from-slate-100 to-blue-50/50 rounded-full blur-md -z-10"></div>
                <img src="Assets/login_mascot.png" alt="Mascot" class="h-full w-auto object-contain drop-shadow-md transition-transform duration-300 hover:scale-105" onerror="this.src='Assets/mascot.png'">
            </div>
        </div>

        <div class="mb-6 text-center">
            <h1 class="text-3xl font-extrabold text-[#092C5E] tracking-tight">Login</h1>
            <p class="text-slate-400 text-xs font-semibold mt-1">Please Sign in to continue.</p>
        </div>

        <!-- Divider -->
        <div class="relative flex py-1 items-center mb-5">
            <div class="flex-grow border-t border-slate-200"></div>
            <span class="flex-shrink mx-3 text-slate-400 text-[10px] font-bold uppercase tracking-wider">Or email</span>
            <div class="flex-grow border-t border-slate-200"></div>
        </div>

        <!-- Login Form posts to itself securely -->
        <form action="" method="POST" class="space-y-4">
            
            <div class="pill-input flex items-center px-4 py-3.5 rounded-2xl">
                <svg class="w-5 h-5 text-slate-400 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <input type="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" placeholder="Email Address" required class="w-full bg-transparent text-sm font-medium text-slate-800 placeholder-slate-400 focus:outline-none">
            </div>

            <div class="pill-input flex items-center px-4 py-3.5 rounded-2xl relative">
                <svg class="w-5 h-5 text-slate-400 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                <input type="password" id="passwordInput" name="password" placeholder="••••••••••••" required class="w-full bg-transparent text-sm font-medium text-slate-800 placeholder-slate-400 focus:outline-none pr-6">
                <button type="button" onclick="togglePassword()" class="absolute right-4 text-slate-400 hover:text-slate-600 focus:outline-none">
                    <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </button>
            </div>

            <div class="flex items-center justify-end pt-1 pb-1">
                <a href="Session/forgot-password.php" class="text-xs font-bold text-[#092C5E] hover:underline">Forgot Password?</a>
            </div>

            <button type="submit" class="w-full py-3.5 px-4 bg-[#092C5E] hover:bg-blue-900 text-white font-bold text-sm rounded-full shadow-lg transition-all active:scale-[0.98] mt-2">
                Sign In
            </button>
        </form>

        <div class="text-center mt-6">
            <p class="text-xs font-semibold text-slate-400">
                Don't have an account? 
                <a href="signup.php" class="text-[#092C5E] font-bold hover:underline">Sign Up</a>
            </p>
        </div>

    </div>
</section>

<script>
    function togglePassword() {
        const input = document.getElementById('passwordInput');
        if (input.type === "password") {
            input.type = "text";
        } else {
            input.type = "password";
        }
    }
</script>

<?php include 'footer.php'; ?>