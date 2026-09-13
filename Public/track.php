<?php 
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/db.php'; 

$ticket_status = null;
$ticket_error = null;

// --- PROCESS TICKET TRACKING ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'track_ticket') {
    $tracking_id = trim($_POST['tracking_id']);
    $passcode = trim($_POST['passcode']);

    try {
        $stmt = $pdo->prepare("
            SELECT status, incident_category, created_at, specific_data->>'passcode' AS saved_passcode 
            FROM reports 
            WHERE tracking_id = ?
        ");
        $stmt->execute([$tracking_id]);
        $report = $stmt->fetch();

        if ($report) {
            if ($report['saved_passcode'] === $passcode) {
                $ticket_status = $report; 
            } else {
                $ticket_error = "Incorrect passcode for this Tracking ID.";
            }
        } else {
            $ticket_error = "Tracking ID not found.";
        }
    } catch (PDOException $e) {
        $ticket_error = "System error verifying ticket.";
    }
}

include __DIR__ . '/./header.php'; 
?>

<style>
    .app-card { background: #FFFFFF; border-radius: 36px; box-shadow: 0 20px 60px -15px rgba(9, 44, 94, 0.12); border: 1px solid rgba(255, 255, 255, 0.8); }
    .pill-input { background-color: #F4F6F9; border: 1.5px solid transparent; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    .pill-input:focus-within { background-color: #FFFFFF; border-color: #092C5E; box-shadow: 0 10px 25px -5px rgba(9, 44, 94, 0.1); }
</style>

<main class="min-h-[calc(100vh-80px)] p-4 md:p-8 flex items-center justify-center relative overflow-hidden">
    <div class="absolute w-[800px] h-[800px] rounded-full bg-gradient-to-tr from-emerald-100/50 to-slate-100/40 pointer-events-none -z-10 blur-3xl"></div>

    <div class="w-full max-w-lg app-card p-8 flex flex-col">
        <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mb-4 border border-emerald-100">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
        </div>
        <h2 class="text-2xl font-black text-[#092C5E] mb-2">Track Your Report</h2>
        <p class="text-sm font-medium text-slate-500 mb-8">Enter your secure Tracking ID and 4-digit passcode to check the status of your case.</p>

        <form method="POST" action="" class="space-y-4 mb-8">
            <input type="hidden" name="action" value="track_ticket">
            
            <div>
                <label class="block text-xs font-bold text-slate-500 mb-1 ml-1">Tracking ID</label>
                <div class="pill-input px-4 py-3 rounded-2xl">
                    <input type="text" name="tracking_id" required placeholder="e.g. PKR-A1B2-C3D4" class="w-full bg-transparent text-sm font-bold text-slate-800 uppercase focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 mb-1 ml-1">4-Digit Passcode</label>
                <div class="pill-input px-4 py-3 rounded-2xl">
                    <input type="password" name="passcode" required pattern="[0-9]{4}" maxlength="4" placeholder="Enter PIN" class="w-full bg-transparent text-sm font-bold tracking-widest text-slate-800 focus:outline-none">
                </div>
            </div>

            <button type="submit" class="w-full py-4 bg-[#092C5E] hover:bg-blue-900 text-white font-bold text-sm rounded-2xl shadow-lg transition-all active:scale-[0.98]">
                Check Status
            </button>

            <?php if ($ticket_error): ?>
                <div class="mt-4 p-3 bg-red-50 text-red-600 text-xs font-bold rounded-xl text-center border border-red-100">
                    <?php echo $ticket_error; ?>
                </div>
            <?php endif; ?>
        </form>

        <?php if ($ticket_status): ?>
            <div class="mt-2 p-6 bg-slate-50 rounded-3xl border border-slate-200">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Current Status</p>
                        <?php if ($ticket_status['status'] === 'open'): ?>
                            <span class="inline-block mt-1 px-3 py-1 bg-amber-100 text-amber-700 text-xs font-bold rounded-full border border-amber-200">Open / Awaiting NGO</span>
                        <?php elseif ($ticket_status['status'] === 'assigned'): ?>
                            <span class="inline-block mt-1 px-3 py-1 bg-blue-100 text-blue-700 text-xs font-bold rounded-full border border-blue-200">NGO Assigned & Active</span>
                        <?php else: ?>
                            <span class="inline-block mt-1 px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold rounded-full border border-emerald-200">Case Closed</span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="font-bold text-slate-500">Category:</span>
                        <span class="font-bold text-slate-800"><?php echo htmlspecialchars($ticket_status['incident_category']); ?></span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="font-bold text-slate-500">Filed On:</span>
                        <span class="font-bold text-slate-800"><?php echo date('M d, Y', strtotime($ticket_status['created_at'])); ?></span>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php include __DIR__ . '/../footer.php'; ?>