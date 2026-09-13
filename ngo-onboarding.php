<?php 
ob_start(); 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Security: Require the user to be logged in to access the onboarding form
require_once 'Session/ActiveSession.php';
require_login(); 

$error_message = "";

// --- PROCESS THE NGO ONBOARDING SUBMISSION ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'config/db.php'; 
    
    $user_id = $_SESSION['user_id'];
    
    // Collect all form data
    $ngo_name = trim($_POST['ngo_name']);
    $registration_number = trim($_POST['registration_number']);
    $primary_focus = $_POST['primary_focus'];
    $establishment_date = trim($_POST['establishment_date']); 
    $website_url = trim($_POST['website_url']);
    $registered_address = trim($_POST['registered_address']);
    
    $rep_name = trim($_POST['representative_name']);
    $rep_designation = trim($_POST['representative_designation']);
    $official_email = trim($_POST['official_email']);
    $contact_phone = trim($_POST['contact_phone']);
    $district = $_POST['district'];
    $operating_region = $_POST['operating_region']; 
    $ngo_size = $_POST['ngo_size'];
    $mission_statement = trim($_POST['mission_statement']);

    try {
        $pdo->beginTransaction();

        // Safely combine fields so no data is lost and it matches your SQL schema exactly
        $combined_city = $operating_region . ', ' . $district; // e.g. "Tiswadi, North Goa"
        $combined_mission = $mission_statement . "\n\nEst. Date: " . $establishment_date . "\nWebsite: " . ($website_url ? $website_url : 'N/A');

        // 1. Insert into ngo_profiles 
        $stmt = $pdo->prepare("
            INSERT INTO ngo_profiles 
            (user_id, ngo_name, registration_number, primary_focus, contact_phone, operating_city, address, representative_name, representative_designation, contact_email, size, mission_statement) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        $stmt->execute([
            $user_id, $ngo_name, $registration_number, $primary_focus, $contact_phone,     
            $combined_city, $registered_address, $rep_name, $rep_designation, 
            $official_email, $ngo_size, $combined_mission   
        ]);

        // 2. Upgrade user role to 'ngo'
        $roleStmt = $pdo->prepare("UPDATE users SET role = 'ngo' WHERE id = ?");
        $roleStmt->execute([$user_id]);
        
        // Update session instantly
        $_SESSION['role'] = 'ngo'; 

        $pdo->commit();

        // 3. Send them to their new Responder Dashboard
        $_SESSION['success_message'] = "Application submitted successfully! Awaiting email verification.";
        
        // Clear buffers and redirect securely
        while (ob_get_level()) { ob_end_clean(); }
        header("Location: Responder/index.php"); 
        exit();

    } catch (PDOException $e) {
        $pdo->rollBack(); 
        // AGGRESSIVE DEBUGGER: If it fails, print a huge error and stop the page entirely.
        die("<div style='padding:40px; background:#fff0f0; border:3px solid red; font-family:sans-serif;'>
                <h1 style='color:red;'>DATABASE ERROR TRIPPED!</h1>
                <p><strong>Error Details:</strong> " . $e->getMessage() . "</p>
                <p>Please copy this error and send it back to me!</p>
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
    .custom-dropdown { position: relative; }
    .dropdown-menu { position: absolute; top: calc(100% + 6px); left: 0; right: 0; background: #FFFFFF; border-radius: 20px; box-shadow: 0 15px 35px rgba(9, 44, 94, 0.15); border: 1px solid rgba(9, 44, 94, 0.08); padding: 6px; z-index: 50; opacity: 0; visibility: hidden; transform: translateY(-8px); transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1); }
    .custom-dropdown.open .dropdown-menu { opacity: 1; visibility: visible; transform: translateY(0); }
    .custom-dropdown.open .arrow-icon { transform: rotate(180deg); color: #092C5E; }
    .dropdown-option { padding: 10px 16px; border-radius: 12px; font-size: 14px; font-weight: 500; color: #334155; cursor: pointer; transition: all 0.15s ease; }
    .dropdown-option:hover { background-color: #F4F6F9; color: #092C5E; font-weight: 600; }
    .dropdown-option.selected { background-color: #092C5E; color: #FFFFFF; font-weight: 600; }
    .flatpickr-calendar { border-radius: 24px !important; box-shadow: 0 20px 40px rgba(9, 44, 94, 0.18) !important; border: 1px solid rgba(9, 44, 94, 0.08) !important; padding: 12px !important; font-family: inherit !important; width: 325px !important; max-width: 90vw !important; box-sizing: border-box !important; }
    .flatpickr-days { width: 100% !important; }
    .dayContainer { width: 100% !important; min-width: 100% !important; max-width: 100% !important; justify-content: space-around !important; }
    .flatpickr-day { border-radius: 10px !important; max-width: 38px !important; height: 38px !important; line-height: 38px !important; }
    .flatpickr-day.selected, .flatpickr-day.selected:hover { background: #092C5E !important; border-color: #092C5E !important; }
    .form-step { display: none; }
    .form-step.active { display: block; animation: fadeIn 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
</style>

<!-- Mobile Blocker -->
<div class="flex lg:hidden flex-col items-center justify-center w-full min-h-[calc(100vh-80px)] p-8 text-center bg-[#fbfbfd] z-[100] fixed inset-0">
    <div class="w-24 h-24 bg-blue-50 rounded-[2rem] flex items-center justify-center mb-8 border border-blue-100 shadow-sm">
        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#092C5E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line>
        </svg>
    </div>
    <h1 class="text-3xl font-black text-[#092C5E] tracking-tight mb-4">Desktop Required</h1>
    <p class="text-slate-500 font-medium text-base leading-relaxed max-w-sm">Please access this page from a computer.</p>
</div>

<!-- Desktop Form -->
<div class="hidden lg:block">
    <section class="relative min-h-[calc(100vh-140px)] flex items-center justify-center py-12 px-4 overflow-hidden">
        <div class="absolute w-[600px] h-[600px] rounded-full bg-gradient-to-tr from-slate-200/50 to-blue-100/40 pointer-events-none -z-10 blur-2xl"></div>
        <div class="w-full max-w-2xl app-card p-6 sm:p-10 relative">

            <div class="mb-6 text-center">
                <h1 class="text-2xl sm:text-3xl font-extrabold text-[#092C5E] tracking-tight">NGO Partner Onboarding</h1>
                <p class="text-slate-400 text-xs sm:text-sm font-semibold mt-1">Register your organization to collaborate and expand your impact.</p>
            </div>

            <div class="mb-8">
                <div class="flex justify-between items-center mb-2 px-1">
                    <span id="step-label" class="text-xs font-bold text-[#092C5E] uppercase tracking-wider">Step 1 of 3: Organization Details</span>
                    <span id="step-percent" class="text-xs font-extrabold text-[#092C5E]">33%</span>
                </div>
                <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden p-0.5 border border-slate-200/60">
                    <div id="progress-bar" class="bg-[#092C5E] h-full rounded-full transition-all duration-500 ease-out" style="width: 33.33%;"></div>
                </div>
            </div>

            <!-- ADDED NOVALIDATE TO BYPASS THE SILENT HTML5 BROWSER BUG -->
            <form id="ngoForm" action="" method="POST" novalidate>
                
                <!-- STEP 1 -->
                <div class="form-step active" id="step-1">
                    <div class="space-y-4">
                        <div class="flex items-center gap-2 border-b border-slate-100 pb-2"><h2 class="text-xs font-bold text-[#092C5E] uppercase tracking-wider">1. Organization Details</h2></div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 mb-1 ml-1">NGO Legal Name *</label>
                                <div class="pill-input px-4 py-3 rounded-2xl"><input type="text" name="ngo_name" required placeholder="e.g., Hope Foundation" class="w-full bg-transparent text-sm font-medium text-slate-800 focus:outline-none"></div>
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 mb-1 ml-1">Registration / DARPAN ID *</label>
                                <div class="pill-input px-4 py-3 rounded-2xl"><input type="text" name="registration_number" required placeholder="e.g., GA/2023/012345" class="w-full bg-transparent text-sm font-medium text-slate-800 focus:outline-none"></div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 mb-1 ml-1">Primary Focus Area *</label>
                                <div class="custom-dropdown">
                                    <input type="hidden" name="primary_focus" value="Education & Child Welfare">
                                    <div class="pill-input px-4 py-3 rounded-2xl flex items-center justify-between cursor-pointer dropdown-trigger"><span class="selected-text text-sm font-medium text-slate-800">Education & Child Welfare</span></div>
                                    <div class="dropdown-menu">
                                        <div class="dropdown-option selected" data-value="Education & Child Welfare">Education & Child Welfare</div>
                                        <div class="dropdown-option" data-value="Healthcare & Medical Relief">Healthcare & Medical Relief</div>
                                        <div class="dropdown-option" data-value="Women Empowerment">Women Empowerment</div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 mb-1 ml-1">Date of Establishment *</label>
                                <div class="pill-input px-4 py-3 rounded-2xl flex items-center justify-between"><input type="text" id="establishment_date" name="establishment_date" required placeholder="Select Date" class="w-full bg-transparent text-sm font-medium text-slate-800 focus:outline-none cursor-pointer"></div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 mb-1 ml-1">Official Website / Portfolio Link</label>
                            <div class="pill-input px-4 py-3 rounded-2xl"><input type="url" name="website_url" placeholder="https://www.example.org" class="w-full bg-transparent text-sm font-medium text-slate-800 focus:outline-none"></div>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 mb-1 ml-1">Registered Address *</label>
                            <div class="pill-input px-4 py-3 rounded-2xl"><input type="text" name="registered_address" required placeholder="Full Head Office Address" class="w-full bg-transparent text-sm font-medium text-slate-800 focus:outline-none"></div>
                        </div>
                    </div>
                </div>

                <!-- STEP 2 -->
                <div class="form-step" id="step-2">
                    <div class="space-y-4">
                        <div class="flex items-center gap-2 border-b border-slate-100 pb-2"><h2 class="text-xs font-bold text-[#092C5E] uppercase tracking-wider">2. Representative & Location Info</h2></div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 mb-1 ml-1">Representative Name *</label>
                                <div class="pill-input px-4 py-3 rounded-2xl"><input type="text" name="representative_name" required placeholder="e.g., John Doe" class="w-full bg-transparent text-sm font-medium text-slate-800 focus:outline-none"></div>
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 mb-1 ml-1">Designation / Role *</label>
                                <div class="pill-input px-4 py-3 rounded-2xl"><input type="text" name="representative_designation" required placeholder="e.g., Director" class="w-full bg-transparent text-sm font-medium text-slate-800 focus:outline-none"></div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 mb-1 ml-1">Official Email Address *</label>
                                <div class="pill-input px-4 py-3 rounded-2xl"><input type="email" name="official_email" required placeholder="contact@example.org" class="w-full bg-transparent text-sm font-medium text-slate-800 focus:outline-none"></div>
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 mb-1 ml-1">Phone / Mobile Number *</label>
                                <div class="pill-input px-4 py-3 rounded-2xl"><input type="tel" name="contact_phone" required placeholder="9876543210" class="w-full bg-transparent text-sm font-medium text-slate-800 focus:outline-none"></div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 mb-1 ml-1">District *</label>
                                <div class="custom-dropdown" id="districtDropdown">
                                    <input type="hidden" name="district" value="North Goa">
                                    <div class="pill-input px-4 py-3 rounded-2xl flex items-center justify-between cursor-pointer dropdown-trigger"><span class="selected-text text-sm font-medium text-slate-800">North Goa</span></div>
                                    <div class="dropdown-menu">
                                        <div class="dropdown-option selected" data-value="North Goa">North Goa</div>
                                        <div class="dropdown-option" data-value="South Goa">South Goa</div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 mb-1 ml-1">Taluka *</label>
                                <div class="custom-dropdown" id="talukaDropdown">
                                    <input type="hidden" name="operating_region" value="Tiswadi">
                                    <div class="pill-input px-4 py-3 rounded-2xl flex items-center justify-between cursor-pointer dropdown-trigger"><span class="selected-text text-sm font-medium text-slate-800">Tiswadi (Panaji)</span></div>
                                    <div class="dropdown-menu max-h-56 overflow-y-auto" id="talukaOptionsContainer"></div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 mb-1 ml-1">Organization Size</label>
                            <div class="custom-dropdown">
                                <input type="hidden" name="ngo_size" value="10-50 Members">
                                <div class="pill-input px-4 py-3 rounded-2xl flex items-center justify-between cursor-pointer dropdown-trigger"><span class="selected-text text-sm font-medium text-slate-800">10-50 Members</span></div>
                                <div class="dropdown-menu">
                                    <div class="dropdown-option" data-value="1-10 Members">1-10 Members</div>
                                    <div class="dropdown-option selected" data-value="10-50 Members">10-50 Members</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 3 (No Uploads) -->
                <div class="form-step" id="step-3">
                    <div class="space-y-4">
                        <div class="flex items-center gap-2 border-b border-slate-100 pb-2"><h2 class="text-xs font-bold text-[#092C5E] uppercase tracking-wider">3. Mission & Submit</h2></div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 mb-1 ml-1">Mission Statement & Overview *</label>
                            <div class="pill-input p-4 rounded-2xl"><textarea name="mission_statement" rows="4" required placeholder="Briefly summarize your key programs and goals..." class="w-full bg-transparent text-sm font-medium text-slate-800 focus:outline-none resize-none"></textarea></div>
                        </div>
                        
                        <!-- Email Notice -->
                        <div class="bg-blue-50/50 p-4 rounded-2xl border border-blue-100 flex items-start gap-3 mt-4">
                            <div class="mt-0.5 text-blue-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg></div>
                            <div>
                                <p class="text-sm font-bold text-[#092C5E]">Email Verification Required</p>
                                <p class="text-xs text-slate-500 mt-1 font-medium leading-relaxed">Our administration team will send a secure verification link to your official email to collect your Registration Certificate.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-2 pt-2 px-1 mt-4">
                            <input type="checkbox" id="declaration" name="declaration" required class="mt-0.5 w-4 h-4 text-[#092C5E] rounded focus:ring-[#092C5E] cursor-pointer">
                            <label for="declaration" class="text-[11px] font-semibold text-slate-500 leading-tight cursor-pointer">I confirm that I am an authorized representative of this NGO.</label>
                        </div>
                    </div>
                </div>

                <!-- NAVIGATION BUTTONS -->
                <div class="flex items-center justify-between gap-4 mt-8 pt-4 border-t border-slate-100">
                    <button type="button" id="prevBtn" class="py-3.5 px-6 border border-slate-200 hover:bg-slate-50 text-slate-600 font-bold text-sm rounded-2xl transition-all hidden">Back</button>
                    <div class="flex-1"></div>
                    <button type="button" id="nextBtn" class="py-3.5 px-8 bg-[#092C5E] hover:bg-blue-900 text-white font-bold text-sm rounded-2xl shadow-lg transition-all active:scale-[0.98]">Next</button>
                    <!-- Type changed to button to allow custom JS submission safely -->
                    <button type="button" id="submitBtn" class="py-3.5 px-8 bg-[#092C5E] hover:bg-blue-900 text-white font-bold text-sm rounded-2xl shadow-lg transition-all active:scale-[0.98] hidden">Complete Onboarding</button>
                </div>

            </form>
        </div>
    </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {

    flatpickr("#establishment_date", { dateFormat: "d-m-Y", disableMobile: "true" });

    const talukasByDistrict = {
        "North Goa": [{ value: "Tiswadi", label: "Tiswadi (Panaji)" }, { value: "Bardez", label: "Bardez (Mapusa)" }],
        "South Goa": [{ value: "Salcete", label: "Salcete (Margao)" }, { value: "Ponda", label: "Ponda" }]
    };

    const talukaContainer = document.getElementById('talukaOptionsContainer');
    const talukaDropdown = document.getElementById('talukaDropdown');
    const talukaHiddenInput = talukaDropdown.querySelector('input[type="hidden"]');
    const talukaSelectedText = talukaDropdown.querySelector('.selected-text');

    function renderTalukas(district) {
        const list = talukasByDistrict[district] || [];
        talukaContainer.innerHTML = '';
        list.forEach((item, index) => {
            const opt = document.createElement('div');
            opt.className = `dropdown-option ${index === 0 ? 'selected' : ''}`;
            opt.setAttribute('data-value', item.value);
            opt.textContent = item.label;
            if (index === 0) { talukaHiddenInput.value = item.value; talukaSelectedText.textContent = item.label; }
            opt.addEventListener('click', () => {
                talukaHiddenInput.value = item.value; talukaSelectedText.textContent = item.label;
                talukaContainer.querySelectorAll('.dropdown-option').forEach(o => o.classList.remove('selected'));
                opt.classList.add('selected'); talukaDropdown.classList.remove('open');
            });
            talukaContainer.appendChild(opt);
        });
    }
    renderTalukas("North Goa");

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
                const val = option.getAttribute('data-value');
                hiddenInput.value = val; selectedText.textContent = option.textContent;
                dropdown.querySelectorAll('.dropdown-option').forEach(opt => opt.classList.remove('selected'));
                option.classList.add('selected'); dropdown.classList.remove('open');
                if (dropdown.id === 'districtDropdown') renderTalukas(val);
            });
        });
    });
    document.addEventListener('click', () => dropdowns.forEach(d => d.classList.remove('open')));

    let currentStep = 1; const totalSteps = 3;
    const nextBtn = document.getElementById('nextBtn'), prevBtn = document.getElementById('prevBtn'), submitBtn = document.getElementById('submitBtn'), progressBar = document.getElementById('progress-bar'), stepLabel = document.getElementById('step-label'), stepPercent = document.getElementById('step-percent');
    const stepTitles = ["Step 1 of 3: Organization Details", "Step 2 of 3: Contact Person Details", "Step 3 of 3: Submit"];

    function updateStepUI() {
        document.querySelectorAll('.form-step').forEach((step, idx) => step.classList.toggle('active', idx + 1 === currentStep));
        const percentage = (currentStep / totalSteps) * 100;
        progressBar.style.width = percentage + '%'; stepLabel.textContent = stepTitles[currentStep - 1]; stepPercent.textContent = Math.round(percentage) + '%';
        prevBtn.classList.toggle('hidden', currentStep === 1);
        if (currentStep === totalSteps) { nextBtn.classList.add('hidden'); submitBtn.classList.remove('hidden'); } 
        else { nextBtn.classList.remove('hidden'); submitBtn.classList.add('hidden'); }
    }

    function validateCurrentStep() {
        const currentFormStep = document.getElementById(`step-${currentStep}`);
        const requiredInputs = currentFormStep.querySelectorAll('[required]');
        let isValid = true;
        requiredInputs.forEach(input => {
            if (!input.checkValidity() || (input.type === 'checkbox' && !input.checked)) {
                isValid = false; input.closest('.pill-input')?.classList.add('border-red-400'); input.reportValidity();
            } else { input.closest('.pill-input')?.classList.remove('border-red-400'); }
        });
        return isValid;
    }

    nextBtn.addEventListener('click', () => { if (validateCurrentStep() && currentStep < totalSteps) { currentStep++; updateStepUI(); } });
    prevBtn.addEventListener('click', () => { if (currentStep > 1) { currentStep--; updateStepUI(); } });
    
    // CUSTOM SUBMIT LISTENER to bypass browser bugs
    submitBtn.addEventListener('click', (e) => {
        e.preventDefault();
        if (validateCurrentStep()) {
            document.getElementById('ngoForm').submit();
        }
    });
});
</script>

<?php include 'footer.php'; ?>