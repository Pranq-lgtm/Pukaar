<?php 
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Security: If not logged in, or NOT an NGO/Admin, kick them immediately to login
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'ngo' && $_SESSION['role'] !== 'admin')) {
    header("Location: ../login.php");
    exit();
}

require_once __DIR__ . '/../config/db.php';

$ngo_status = 'pending';
$ngo_name = "Responder";
$primary_focus = "General";
$incoming_reports = [];
$searched_report = null;
$search_error = "";

try {
    // 1. Fetch NGO Profile Data
    $stmt = $pdo->prepare("SELECT ngo_name, verification_status, primary_focus FROM ngo_profiles WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $profile = $stmt->fetch();

    if ($profile) {
        $ngo_name = $profile['ngo_name'];
        $ngo_status = $profile['verification_status'];
        $primary_focus = $profile['primary_focus'];
    }

    // 2. Fetch Recent Reports matching this NGO's focus or general open reports
    if ($ngo_status === 'verified') {
        $reportsStmt = $pdo->prepare("
            SELECT id, tracking_id, incident_category, urgency_level, location_address, incident_summary, status, created_at, specific_data 
            FROM reports 
            WHERE status = 'open' 
            ORDER BY created_at DESC 
            LIMIT 10
        ");
        $reportsStmt->execute();
        $incoming_reports = $reportsStmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 3. Handle Tracking ID Lookup Form Submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'lookup_ticket') {
        $search_id = trim($_POST['tracking_id']);
        $lookupStmt = $pdo->prepare("SELECT * FROM reports WHERE tracking_id = ?");
        $lookupStmt->execute([$search_id]);
        $searched_report = $lookupStmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$searched_report) {
            $search_error = "No report found with Tracking ID: " . htmlspecialchars($search_id);
        }
    }

} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}

include 'header.php'; 
?>

<main class="flex-grow max-w-6xl mx-auto w-full px-4 py-8">

    <?php if ($ngo_status === 'pending'): ?>
        <!-- PENDING SCREEN -->
        <div class="bg-amber-50 border border-amber-200 rounded-3xl p-8 text-center max-w-2xl mx-auto mt-12">
            <h2 class="text-2xl font-extrabold text-amber-800 mb-2">Verification Pending</h2>
            <p class="text-amber-700 text-sm font-medium">Your profile is awaiting review by Pukaar Administration. Case access will unlock upon approval.</p>
        </div>
    <?php else: ?>

        <!-- DASHBOARD HEADER -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4 pb-6 border-b border-slate-200">
            <div>
                <h1 class="text-2xl font-extrabold text-[#092C5E]">Responder Portal — <?php echo htmlspecialchars($ngo_name); ?></h1>
                <p class="text-xs font-semibold text-slate-500 mt-0.5">Specialization Focus: <span class="text-[#092C5E] uppercase font-bold"><?php echo htmlspecialchars($primary_focus); ?></span></p>
            </div>
            <!-- Quick Link to Chat Hub -->
            <a href="../Public/chat.php" target="_blank" class="px-5 py-2.5 bg-emerald-600 text-white font-bold text-xs rounded-xl hover:bg-emerald-700 transition shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                Open Live Chat Hub
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- LEFT 2 COLUMNS: INCOMING CASE QUEUE -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm">
                    <h2 class="text-lg font-bold text-[#092C5E] mb-4">Recent Incident Queue</h2>
                    
                    <?php if (count($incoming_reports) > 0): ?>
                        <div class="space-y-3">
                            <?php foreach ($incoming_reports as $report): ?>
                                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 flex flex-col gap-2">
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs font-mono font-bold text-[#092C5E]"><?php echo htmlspecialchars($report['tracking_id']); ?></span>
                                        <span class="px-2 py-0.5 text-[10px] font-bold uppercase rounded-full 
                                            <?php echo $report['urgency_level'] === 'critical' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700'; ?>">
                                            <?php echo htmlspecialchars($report['urgency_level']); ?>
                                        </span>
                                    </div>
                                    <p class="text-sm font-semibold text-slate-800"><?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $report['incident_category']))); ?></p>
                                    <p class="text-xs text-slate-500 truncate"><?php echo htmlspecialchars($report['incident_summary']); ?></p>
                                    <div class="flex justify-between items-center pt-2 mt-1 border-t border-slate-200/60 text-[11px] text-slate-400">
                                        <span>Location: <?php echo htmlspecialchars($report['location_address']); ?></span>
                                        <span><?php echo date('M d, H:i', strtotime($report['created_at'])); ?></span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-xs text-slate-400 py-6 text-center">No open cases found in the queue.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- RIGHT 1 COLUMN: TRACKING ID LOOKUP TOOL -->
            <div class="space-y-6">
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm">
                    <h2 class="text-lg font-bold text-[#092C5E] mb-2">Track Case by ID</h2>
                    <p class="text-xs text-slate-500 mb-4">Enter a victim's Tracking ID to view detailed incident notes.</p>
                    
                    <form method="POST" action="" class="space-y-3">
                        <input type="hidden" name="action" value="lookup_ticket">
                        <input type="text" name="tracking_id" required placeholder="e.g. PKR-ABCD-1234" class="w-full bg-slate-100 text-xs font-bold uppercase px-3.5 py-3 rounded-xl border border-transparent focus:bg-white focus:border-[#092C5E] outline-none">
                        <button type="submit" class="w-full py-3 bg-[#092C5E] text-white font-bold text-xs rounded-xl hover:bg-blue-900 transition">
                            Lookup Ticket
                        </button>
                    </form>

                    <?php if (!empty($search_error)): ?>
                        <p class="mt-4 text-xs font-bold text-red-600 bg-red-50 p-3 rounded-xl border border-red-100"><?php echo $search_error; ?></p>
                    <?php endif; ?>

                    <?php if ($searched_report): ?>
                        <div class="mt-4 p-4 bg-blue-50/50 rounded-2xl border border-blue-100 text-xs space-y-2">
                            <p class="font-bold text-[#092C5E]">Ticket Found:</p>
                            <p><strong>ID:</strong> <?php echo htmlspecialchars($searched_report['tracking_id']); ?></p>
                            <p><strong>Category:</strong> <?php echo htmlspecialchars($searched_report['incident_category']); ?></p>
                            <p><strong>Status:</strong> <span class="uppercase font-bold text-emerald-600"><?php echo htmlspecialchars($searched_report['status']); ?></span></p>
                            <p><strong>Summary:</strong> <?php echo htmlspecialchars($searched_report['incident_summary']); ?></p>
                            <p><strong>Address:</strong> <?php echo htmlspecialchars($searched_report['location_address']); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>

    <?php endif; ?>

</main>

<?php include 'footer.php'; ?>