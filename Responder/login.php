<?php 
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect if already logged in as NGO/Admin
if (isset($_SESSION['user_id']) && isset($_SESSION['role']) && ($_SESSION['role'] === 'ngo' || $_SESSION['role'] === 'admin')) {
    header("Location: index.php");
    exit();
}

$error_message = "";

// Process NGO Login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../config/db.php'; 

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    try {
        $stmt = $pdo->prepare("SELECT id, full_name, password_hash, role FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            
            // SECURITY CHECK: Strictly ensure the database role is 'ngo' or 'admin'
            if ($user['role'] === 'ngo' || $user['role'] === 'admin') {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['email'] = $email;
                $_SESSION['role'] = $user['role'];
                
                header("Location: index.php");
                exit();
            } else {
                // Block general users attempting to access the responder portal
                $error_message = "Access Denied. This portal is strictly for authorized NGO partners and Administrators.";
            }

        } else {
            $error_message = "Invalid credentials. Please try again.";
        }

    } catch (PDOException $e) {
        $error_message = "Login failed: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responder Portal Login — PUKAAR</title>
    <link rel="icon" type="image/png" href="../Assets/favicon.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #fbfbfd; }
        .ios-card {
            background: #FFFFFF;
            border-radius: 32px;
            box-shadow: 0 20px 60px -15px rgba(9, 44, 94, 0.15);
            border: 1px solid rgba(0, 0, 0, 0.05);
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
</head>
<body class="min-h-screen flex items-center justify-center p-4">

    <!-- Admin aesthetic background -->
    <div class="fixed inset-0 z-0 bg-[#092C5E]">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
        <div class="absolute w-[800px] h-[800px] bg-blue-500/20 blur-[120px] rounded-full top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2"></div>
    </div>

    <div class="ios-card w-full max-w-md p-10 relative z-10">
        
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-blue-50 border border-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <img src="../Assets/logo.png" alt="Logo" class="w-10 h-10 object-contain" onerror="this.style.display='none'">
                <span class="text-2xl font-black text-[#092C5E]" style="display: <?php echo file_exists('../Assets/logo.png') ? 'none' : 'block'; ?>">P</span>
            </div>
            <h1 class="text-2xl font-black text-[#092C5E] tracking-tight">Responder Portal</h1>
            <p class="text-xs font-bold text-slate-400 mt-2 uppercase tracking-widest">Authorized Personnel Only</p>
        </div>

        <?php if(!empty($error_message)): ?>
            <div class="bg-red-50 text-red-600 p-4 rounded-xl text-xs font-bold text-center mb-6 border border-red-100">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" class="space-y-4">
            
            <div>
                <label class="block text-[11px] font-bold text-slate-500 mb-1 ml-1">Official Email</label>
                <div class="pill-input flex items-center px-4 py-3.5 rounded-2xl">
                    <svg class="w-5 h-5 text-slate-400 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <input type="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" placeholder="name@ngo.org" required class="w-full bg-transparent text-sm font-medium text-slate-800 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-[11px] font-bold text-slate-500 mb-1 ml-1">Password</label>
                <div class="pill-input flex items-center px-4 py-3.5 rounded-2xl">
                    <svg class="w-5 h-5 text-slate-400 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    <input type="password" name="password" placeholder="••••••••••••" required class="w-full bg-transparent text-sm font-medium text-slate-800 focus:outline-none">
                </div>
            </div>

            <button type="submit" class="w-full py-4 bg-[#092C5E] hover:bg-blue-900 text-white font-bold text-sm rounded-2xl shadow-lg transition-all active:scale-[0.98] mt-4">
                Access Dashboard
            </button>
        </form>

        <div class="text-center mt-6 pt-6 border-t border-slate-100">
            <p class="text-xs font-semibold text-slate-400">
                New NGO Partner? 
                <a href="../ngo-onboarding.php" class="text-[#092C5E] font-bold hover:underline">Apply Here</a>
            </p>
            <p class="text-[10px] font-semibold text-slate-400 mt-2">
                <a href="../index.php" class="hover:underline text-slate-500">&larr; Back to Public Site</a>
            </p>
        </div>

    </div>
</body>
</html>