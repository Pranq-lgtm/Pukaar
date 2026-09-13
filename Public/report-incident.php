<?php 
ob_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$error_message = "";
$success_message = "";

// Generate a secure Tracking ID for this session
$tracking_id = 'PKR-' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 4)) . '-' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 4, 4));

// --- PROCESS THE INCIDENT REPORT ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/../config/db.php';
    
    // Check if user is logged in, otherwise leave as NULL for public victims
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    
    // Core Report Data
    $submitted_tracking_id = $_POST['tracking_id'];
    $form_source = $_POST['form_source']; 
    $incident_category = $_POST['incident_category'];
    $urgency_level = $_POST['urgency_level'];
    $location_address = trim($_POST['location_address']);
    $incident_summary = trim($_POST['incident_summary']);
    
    // Reporter Identity
    $reporter_name = trim($_POST['reporter_name']);
    
    // STRICT POSTGRESQL BOOLEAN HANDLING (1 = true, 0 = false)
    $is_anonymous = empty($reporter_name) ? 1 : 0;
    $victim_name = empty($reporter_name) ? 'Anonymous User' : $reporter_name;

    // Specific Data (JSON mapping for extra fields)
    $specific_data = json_encode([
        'contact_phone' => trim($_POST['contact_phone'] ?? ''),
        'incident_datetime' => trim($_POST['incident_datetime'] ?? ''),
        'support_needed' => trim($_POST['support_needed'] ?? ''),
        'passcode' => trim($_POST['lookup_passcode'] ?? '')
    ]);

    try {
        $pdo->beginTransaction();

        // 1. Insert into reports table
        $stmt = $pdo->prepare("
            INSERT INTO reports 
            (tracking_id, user_id, is_anonymous, victim_name, form_source, incident_category, urgency_level, location_address, incident_summary, specific_data) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            RETURNING id
        ");
        
        $stmt->execute([
            $submitted_tracking_id, 
            $user_id, 
            $is_anonymous, 
            $victim_name, 
            $form_source, 
            $incident_category, 
            $urgency_level, 
            $location_address, 
            $incident_summary, 
            $specific_data
        ]);
        
        $report = $stmt->fetch();
        $report_id = $report['id'];

        // 2. Handle Evidence Uploads
        if (isset($_FILES['evidence']) && !empty($_FILES['evidence']['name'][0])) {
            $upload_dir = 'Assets/uploads/evidence/';
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

            $file_count = count($_FILES['evidence']['name']);
            for ($i = 0; $i < $file_count; $i++) {
                if ($_FILES['evidence']['error'][$i] === UPLOAD_ERR_OK) {
                    $tmp_name = $_FILES['evidence']['tmp_name'][$i];
                    $file_ext = strtolower(pathinfo($_FILES['evidence']['name'][$i], PATHINFO_EXTENSION));
                    $file_type = $_FILES['evidence']['type'][$i];
                    
                    $new_filename = 'evd_' . uniqid() . '_' . time() . '.' . $file_ext;
                    $destination = $upload_dir . $new_filename;

                    if (move_uploaded_file($tmp_name, $destination)) {
                        $fileStmt = $pdo->prepare("INSERT INTO attachments (entity_type, entity_id, file_path, file_type) VALUES ('report_evidence', ?, ?, ?)");
                        $fileStmt->execute([$report_id, $destination, $file_type]);
                    }
                }
            }
        }

        $pdo->commit();
        $success_message = "Your report has been securely submitted. Please save your Tracking ID: <strong>" . $submitted_tracking_id . "</strong>";

    } catch (PDOException $e) {
        $pdo->rollBack(); 
        die("<div style='padding:40px; background:#fff0f0; border:3px solid red; font-family:sans-serif;'>
                <h1 style='color:red;'>DATABASE ERROR TRIPPED!</h1>
                <p><strong>Error Details:</strong> " . $e->getMessage() . "</p>
             </div>");
    }
}

include 'header.php'; 
?>

<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<style>
    .app-card { background: #FFFFFF; border-radius: 40px; box-shadow: 0 20px 60px -15px rgba(9, 44, 94, 0.12); border: 1px solid rgba(255, 255, 255, 0.8); }
    .pill-input { background-color: #F4F6F9; border: 1.5px solid transparent; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    .pill-input:hover { background-color: #EEF2F7; }
    .pill-input:focus-within, .pill-input.active { background-color: #FFFFFF; border-color: #092C5E; box-shadow: 0 10px 25px -5px rgba(9, 44, 94, 0.1); }
    .pill-input.error-border { border-color: #EF4444 !important; background-color: #FEF2F2 !important; }
    .custom-dropdown { position: relative; }
    .dropdown-menu { position: absolute; top: calc(100% + 6px); left: 0; right: 0; background: #FFFFFF; border-radius: 20px; box-shadow: 0 15px 35px rgba(9, 44, 94, 0.15); border: 1px solid rgba(9, 44, 94, 0.08); padding: 6px; z-index: 50; opacity: 0; visibility: hidden; transform: translateY(-8px); transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1); }
    .custom-dropdown.open .dropdown-menu { opacity: 1; visibility: visible; transform: translateY(0); }
    .custom-dropdown.open .arrow-icon { transform: rotate(180deg); color: #092C5E; }
    .dropdown-option { padding: 10px 16px; border-radius: 12px; font-size: 14px; font-weight: 500; color: #334155; cursor: pointer; transition: all 0.15s ease; }
    .dropdown-option:hover { background-color: #F4F6F9; color: #092C5E; font-weight: 600; }
    .dropdown-option.selected { background-color: #092C5E; color: #FFFFFF; font-weight: 600; }
    .flatpickr-calendar { border-radius: 24px !important; box-shadow: 0 20px 40px rgba(9, 44, 94, 0.18) !important; border: 1px solid rgba(9, 44, 94, 0.08) !important; padding: 12px !important; font-family: inherit !important; box-sizing: border-box !important; }
    .form-step { display: none; }
    .form-step.active { display: block; animation: fadeIn 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    
    /* Dynamic Theme Colors based on Form Selection */
    .theme-bg-anonymous { background: linear-gradient(to top right, rgba(147, 51, 234, 0.2), rgba(59, 130, 246, 0.2)); }
    .theme-bg-helpline { background: linear-gradient(to top right, rgba(244, 63, 94, 0.2), rgba(59, 130, 246, 0.2)); }
    .theme-bg-national { background: linear-gradient(to top right, rgba(16, 185, 129, 0.2), rgba(59, 130, 246, 0.2)); }
</style>

<section class="relative min-h-[calc(100vh-140px)] flex items-center justify-center py-12 px-4 overflow-hidden">
    
    <!-- Dynamic Ambient Background -->
    <div id="ambient-bg" class="absolute w-[600px] h-[600px] rounded-full theme-bg-anonymous pointer-events-none -z-10 blur-2xl transition-all duration-700"></div>
    
    <div class="w-full max-w-2xl app-card p-6 sm:p-10 relative">

        <?php if(!empty($success_message)): ?>
            <div class="bg-green-50 text-green-700 p-6 rounded-2xl text-center border border-green-200 shadow-sm">
                <svg class="w-12 h-12 text-green-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-lg"><?php echo $success_message; ?></p>
                <a href="index.php" class="inline-block mt-4 px-6 py-2 bg-green-600 text-white font-bold rounded-full hover:bg-green-700">Return to Home</a>
            </div>
        <?php else: ?>

        <!-- Dynamic Header UI -->
        <div class="w-full flex justify-center mb-4 pt-1">
            <div class="relative w-44 h-32 flex items-center justify-center">
                <div class="absolute inset-0 bg-white/50 rounded-full blur-md -z-10"></div>
                <img id="form-mascot" src="Assets/incognito.png" alt="Reporting Mascot" class="h-full w-auto object-contain drop-shadow-md transition-all duration-500">
            </div>
        </div>

        <div class="mb-6 text-center">
            <h1 id="form-title" class="text-2xl sm:text-3xl font-extrabold text-[#092C5E] tracking-tight transition-all">Anonymous Incident Report</h1>
            <p id="form-subtitle" class="text-slate-400 text-xs sm:text-sm font-semibold mt-1 transition-all">Your identity is never tracked. Save your unique Reference ID.</p>
        </div>

        <!-- PROGRESS BAR -->
        <div class="mb-8">
            <div class="flex justify-between items-center mb-2 px-1">
                <span id="step-label" class="text-xs font-bold text-[#092C5E] uppercase tracking-wider">Step 1 of 3: Report Type & Info</span>
                <span id="step-percent" class="text-xs font-extrabold text-[#092C5E]">33%</span>
            </div>
            <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden p-0.5 border border-slate-200/60">
                <div id="progress-bar" class="bg-[#092C5E] h-full rounded-full transition-all duration-500 ease-out" style="width: 33.33%;"></div>
            </div>
        </div>

        <form id="incidentForm" action="" method="POST" enctype="multipart/form-data" novalidate>
            <input type="hidden" name="tracking_id" value="<?php echo $tracking_id; ?>">
            
            <!-- STEP 1: REPORT TYPE -->
            <div class="form-step active" id="step-1">
                <div class="space-y-4">
                    
                    <!-- Auto-Generated Tracking Code Notice -->
                    <div class="p-4 bg-slate-50 border border-slate-200/80 rounded-2xl flex items-center justify-between mb-2">
                        <div>
                            <span class="block text-[10px] font-extrabold uppercase text-slate-400 tracking-wider">Your Secure Tracking ID</span>
                            <span class="text-base font-extrabold text-[#092C5E] font-mono tracking-wide"><?php echo $tracking_id; ?></span>
                        </div>
                        <div class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-bold rounded-full">Save This Pin</div>
                    </div>

                    <!-- What kind of report is this? -->
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 mb-1 ml-1">What kind of report are you filing? *</label>
                        <div class="custom-dropdown" id="reportTypeDropdown">
                            <input type="hidden" name="form_source" id="form_source_input" value="anonymous">
                            <div class="pill-input px-4 py-3 rounded-2xl flex items-center justify-between cursor-pointer dropdown-trigger">
                                <span class="selected-text text-sm font-bold text-slate-800">Anonymous General Concern</span>
                                <svg class="w-4 h-4 text-slate-400 arrow-icon transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                            </div>
                            <div class="dropdown-menu">
                                <div class="dropdown-option selected" data-value="anonymous" data-title="Anonymous Incident Report" data-sub="Your identity is completely protected." data-img="Assets/incognito.png" data-theme="theme-bg-anonymous">Anonymous General Concern</div>
                                <div class="dropdown-option" data-value="helpline" data-title="Women's Safety & Helpline" data-sub="Reach out safely for direct assistance and protection." data-img="Assets/woman.png" data-theme="theme-bg-helpline">Women's Safety & Helpline</div>
                                <div class="dropdown-option" data-value="national" data-title="National Emergency Report" data-sub="Report disasters, infrastructure collapse, or critical threats." data-img="Assets/NIR.png" data-theme="theme-bg-national">National Emergency / Disaster</div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 mb-1 ml-1">Your Name <span class="text-indigo-400">(Optional for Anonymity)</span></label>
                            <div class="pill-input px-4 py-3 rounded-2xl">
                                <input type="text" name="reporter_name" placeholder="Leave blank to remain anonymous" class="w-full bg-transparent text-sm font-medium text-slate-800 focus:outline-none">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 mb-1 ml-1">Contact Phone <span class="text-indigo-400">(Optional)</span></label>
                            <div class="pill-input px-4 py-3 rounded-2xl">
                                <input type="tel" name="contact_phone" data-type="phone-only" placeholder="For updates from responders" class="w-full bg-transparent text-sm font-medium text-slate-800 focus:outline-none">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- STEP 2: INCIDENT DETAILS -->
            <div class="form-step" id="step-2">
                <div class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 mb-1 ml-1">Category of Incident *</label>
                            <div class="custom-dropdown">
                                <input type="hidden" name="incident_category" value="public_nuisance">
                                <div class="pill-input px-4 py-3 rounded-2xl flex items-center justify-between cursor-pointer dropdown-trigger">
                                    <span class="selected-text text-sm font-medium text-slate-800">Public Nuisance / Harassment</span>
                                    <svg class="w-4 h-4 text-slate-400 arrow-icon transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                                <div class="dropdown-menu max-h-48 overflow-y-auto">
                                    <div class="dropdown-option selected" data-value="public_nuisance">Public Nuisance / Harassment</div>
                                    <div class="dropdown-option" data-value="domestic_violence">Domestic Violence / Abuse</div>
                                    <div class="dropdown-option" data-value="natural_disaster">Natural Disaster (Flood, Quake)</div>
                                    <div class="dropdown-option" data-value="infrastructure">Infrastructure Damage (Bridge, Road)</div>
                                    <div class="dropdown-option" data-value="medical_emergency">Medical Emergency / Accident</div>
                                    <div class="dropdown-option" data-value="other">Other Concern</div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 mb-1 ml-1">Threat Level / Urgency *</label>
                            <div class="custom-dropdown">
                                <input type="hidden" name="urgency_level" value="moderate">
                                <div class="pill-input px-4 py-3 rounded-2xl flex items-center justify-between cursor-pointer dropdown-trigger">
                                    <span class="selected-text text-sm font-medium text-slate-800">Moderate (Monitor)</span>
                                    <svg class="w-4 h-4 text-slate-400 arrow-icon transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                                <div class="dropdown-menu">
                                    <div class="dropdown-option" data-value="critical">Critical (Immediate Danger to Life)</div>
                                    <div class="dropdown-option" data-value="high">High (Requires NGO Follow-up)</div>
                                    <div class="dropdown-option selected" data-value="moderate">Moderate (Monitor Situation)</div>
                                    <div class="dropdown-option" data-value="low">Low (Informational Only)</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 mb-1 ml-1">Date & Time of Occurrence *</label>
                            <div class="pill-input px-4 py-3 rounded-2xl flex items-center justify-between">
                                <input type="text" id="incident_datetime_picker" name="incident_datetime" required placeholder="Select Date & Time" class="w-full bg-transparent text-sm font-medium text-slate-800 focus:outline-none cursor-pointer">
                                <svg class="w-4 h-4 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 mb-1 ml-1">Exact Location / Address *</label>
                            <div class="pill-input px-4 py-3 rounded-2xl">
                                <input type="text" name="location_address" required placeholder="City, Landmark, or Street" class="w-full bg-transparent text-sm font-medium text-slate-800 focus:outline-none">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- STEP 3: NARRATIVE & SUBMIT -->
            <div class="form-step" id="step-3">
                <div class="space-y-4">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 mb-1 ml-1">Detailed Incident Description *</label>
                        <div class="pill-input p-4 rounded-2xl">
                            <textarea name="incident_summary" rows="3" required placeholder="Describe what happened, who is involved, and what help is needed..." minlength="10" class="w-full bg-transparent text-sm font-medium text-slate-800 focus:outline-none resize-none"></textarea>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 mb-1 ml-1">Support Needed</label>
                            <div class="custom-dropdown">
                                <input type="hidden" name="support_needed" value="none">
                                <div class="pill-input px-4 py-3 rounded-2xl flex items-center justify-between cursor-pointer dropdown-trigger">
                                    <span class="selected-text text-sm font-medium text-slate-800">None / Just Reporting</span>
                                    <svg class="w-4 h-4 text-slate-400 arrow-icon transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                                <div class="dropdown-menu">
                                    <div class="dropdown-option selected" data-value="none">None / Just Reporting</div>
                                    <div class="dropdown-option" data-value="medical">Medical / First Aid</div>
                                    <div class="dropdown-option" data-value="police">Police Intervention</div>
                                    <div class="dropdown-option" data-value="counseling">Psychological / NGO Counseling</div>
                                    <div class="dropdown-option" data-value="rescue">Search & Rescue</div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 mb-1 ml-1">Attach Evidence <span class="text-indigo-400">(Optional)</span></label>
                            <div class="pill-input p-2.5 rounded-2xl border-dashed border-2 border-slate-200 text-center hover:border-[#092C5E] transition-all">
                                <input type="file" name="evidence[]" multiple id="evidenceUpload" accept="image/*,.pdf" class="hidden">
                                <label for="evidenceUpload" class="cursor-pointer flex flex-col items-center justify-center">
                                    <span class="text-xs font-bold text-[#092C5E]">Click to attach images/docs</span>
                                    <span class="text-[10px] text-slate-400">Metadata is scrubbed automatically</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="col-span-1 sm:col-span-2">
                            <label class="block text-[11px] font-bold text-slate-500 mb-1 ml-1">Create a 4-Digit Passcode (To check responses later) *</label>
                            <div class="pill-input px-4 py-3 rounded-2xl">
                                <input type="password" name="lookup_passcode" required placeholder="e.g. 4921" pattern="[0-9]{4}" maxlength="4" onkeypress="return /[0-9]/i.test(event.key)" class="w-full bg-transparent text-sm font-medium text-slate-800 focus:outline-none">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- BUTTONS -->
            <div class="flex items-center justify-between gap-4 mt-8 pt-4 border-t border-slate-100">
                <button type="button" id="prevBtn" class="py-3.5 px-6 border border-slate-200 hover:bg-slate-50 text-slate-600 font-bold text-sm rounded-2xl transition-all hidden">Back</button>
                <div class="flex-1"></div>
                <button type="button" id="nextBtn" class="py-3.5 px-8 bg-[#092C5E] hover:bg-blue-900 text-white font-bold text-sm rounded-2xl shadow-lg transition-all active:scale-[0.98] flex items-center gap-2"><span>Next</span><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></button>
                <button type="submit" id="submitBtn" class="py-3.5 px-8 bg-[#092C5E] hover:bg-blue-900 text-white font-bold text-sm rounded-2xl shadow-lg transition-all active:scale-[0.98] flex items-center gap-2 hidden"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg><span>Submit Secure Report</span></button>
            </div>
        </form>
        
        <?php endif; ?>

    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {

    flatpickr("#incident_datetime_picker", { enableTime: true, dateFormat: "Y-m-d H:i", disableMobile: "true" });

    // Custom Dropdown & Dynamic Theme Logic
    const dropdowns = document.querySelectorAll('.custom-dropdown');
    dropdowns.forEach(dropdown => {
        const trigger = dropdown.querySelector('.dropdown-trigger');
        const hiddenInput = dropdown.querySelector('input[type="hidden"]');
        const selectedText = dropdown.querySelector('.selected-text');
        
        trigger.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdowns.forEach(d => d !== dropdown && d.classList.remove('open'));
            dropdown.classList.toggle('open');
        });

        dropdown.querySelectorAll('.dropdown-option').forEach(option => {
            option.addEventListener('click', () => {
                hiddenInput.value = option.getAttribute('data-value');
                selectedText.innerHTML = option.innerHTML; 
                dropdown.querySelectorAll('.dropdown-option').forEach(opt => opt.classList.remove('selected'));
                option.classList.add('selected');
                dropdown.classList.remove('open');

                if (dropdown.id === 'reportTypeDropdown') {
                    document.getElementById('form-title').textContent = option.getAttribute('data-title');
                    document.getElementById('form-subtitle').textContent = option.getAttribute('data-sub');
                    document.getElementById('form-mascot').src = option.getAttribute('data-img');
                    
                    const bg = document.getElementById('ambient-bg');
                    bg.className = `absolute w-[600px] h-[600px] rounded-full pointer-events-none -z-10 blur-2xl transition-all duration-700 ${option.getAttribute('data-theme')}`;
                }
            });
        });
    });
    document.addEventListener('click', () => dropdowns.forEach(d => d.classList.remove('open')));

    document.querySelectorAll('input[data-type="phone-only"]').forEach(input => {
        input.addEventListener('input', (e) => e.target.value = e.target.value.replace(/[^0-9\+\-\s\(\)]/g, ''));
    });

    let currentStep = 1; const totalSteps = 3;
    const nextBtn = document.getElementById('nextBtn'), prevBtn = document.getElementById('prevBtn'), submitBtn = document.getElementById('submitBtn'), progressBar = document.getElementById('progress-bar');
    const stepTitles = ["Step 1 of 3: Report Type & Info", "Step 2 of 3: Incident Details", "Step 3 of 3: Narrative & Submit"];

    function updateStepUI() {
        document.querySelectorAll('.form-step').forEach((step, idx) => step.classList.toggle('active', idx + 1 === currentStep));
        progressBar.style.width = ((currentStep / totalSteps) * 100) + '%'; 
        document.getElementById('step-label').textContent = stepTitles[currentStep - 1]; 
        document.getElementById('step-percent').textContent = Math.round((currentStep / totalSteps) * 100) + '%';
        prevBtn.classList.toggle('hidden', currentStep === 1);
        if (currentStep === totalSteps) { nextBtn.classList.add('hidden'); submitBtn.classList.remove('hidden'); } 
        else { nextBtn.classList.remove('hidden'); submitBtn.classList.add('hidden'); }
    }

    function validateCurrentStep() {
        const currentFormStep = document.getElementById(`step-${currentStep}`);
        const inputs = currentFormStep.querySelectorAll('[required]');
        let isValid = true;
        inputs.forEach(input => {
            if (!input.checkValidity()) {
                isValid = false; input.closest('.pill-input')?.classList.add('error-border'); input.reportValidity();
            } else { input.closest('.pill-input')?.classList.remove('error-border'); }
        });
        return isValid;
    }

    nextBtn.addEventListener('click', () => { if (validateCurrentStep() && currentStep < totalSteps) { currentStep++; updateStepUI(); } });
    prevBtn.addEventListener('click', () => { if (currentStep > 1) { currentStep--; updateStepUI(); } });
    
    document.getElementById('incidentForm').addEventListener('submit', (e) => {
        if (!validateCurrentStep()) e.preventDefault();
    });
});
</script>

<?php include 'footer.php'; ?>