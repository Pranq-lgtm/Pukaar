# Pukaar

Pukaar is a localized child-safety support platform developed for **Track 2: Bal Suraksha**. It is designed to protect vulnerable youth by combining anonymous/non-anonymous reporting, verified aid dispatch to vetted NGOs, and bridging the physical-digital gap for real-world intervention.

## 🏗️ Core Architecture

### 1) Reporting Channel
- Users can create reports as **Anonymous** or **Identified (non-anonymous)**.
- The reporting flow is trauma-informed and does not force identity disclosure.

### 2) Verification Pipeline
- Only **verified NGOs** can receive and accept cases.
- Authorized helpline recipients and authorized police recipients are separate, non-NGO roles provisioned independently of NGO verification for final escalation.
- Escalation transfers contain only the minimum case payload (case ID, risk level, incident location, timing, and safe callback/status metadata); full report content and identity details require an explicit operational need.
- Transfers are restricted by Role-Based Access Control (RBAC) to assigned helpline or police responders, and every access or transfer is recorded in an audit log (audit admins can review logs but not raw case content).
- A **superadmin verification workflow** onboards and whitelists NGOs before activation.

### 3) Dispatch & Physical-Digital Link
- Before acceptance, dispatch only a minimal, compartmentalized summary of new alerts to nearby verified NGOs.
- NGO identity and details remain hidden from the reporting side until a case is formally accepted.
- Report content is released only after explicit assignment and authorization.

### 4) Localized Rollout (Goa)
- Initial deployment scope is focused on Goa to ensure realistic operational fit.
- UI and support flows are tailored for local institutions and response patterns.

---

## 🛡️ Critical Safeguards

### A) Removing Superadmin God-Mode Risk
- Enforces strict **RBAC and least privilege**:
  - NGO verification admins can only manage NGO onboarding.
  - Case responders can access only assigned cases.
  - Audit admins can view logs, but not raw case content.
- Sensitive report content utilizes per-tenant or per-case key separation, narrowly scoped decryption roles, and audited access paths in addition to encryption at rest, preventing universal plaintext access.

### B) Preventing Unaccepted Ticket Blackholes
- Features an **automated escalation matrix**:
  - If no NGO accepts within 5 minutes, cases auto-escalate to backup responders.
  - If still unaccepted, cases escalate to a 24/7 helpline or the nearest police control workflow.
- The reporter receives status feedback at each escalation stage during the active submission session only (anonymous reporters are not promised post-session updates).

### C) Preserving Anonymity While Reducing Spam
- Applies robust anti-abuse controls without requiring identity disclosure:
  - Device/session fingerprinting and behavioral/per-device rate limiting.
  - NLP-assisted spam/risk scoring prior to NGO dispatch.
  - Priority queueing for high-risk language indicators.

### D) Goa-First Accessibility
- Provides a multilingual UI with **Konkani (Devanagari)** and English from day one.
- Keeps the reporting flow readable with low-text, guided prompts tailored for distressed users.

---

## 🚀 Getting Started & Git Deployment

Follow these instructions to initialize and push this project to the remote GitHub repository.

### Prerequisites
* Check if Git is installed by running `git --version` in your terminal.
* If it is not installed, install it and restart your terminal[cite: 4].

### Repository Setup
1. **Open your project folder:** 
   `cd path/to/your/project`[cite: 4]
2. **Initialize the repository** (if it is not already a Git repo): 
   `git init`[cite: 4]
3. **Add files to staging:** 
   `git add .`[cite: 4]
4. **Create the first commit:** 
   `git commit -m "Initial commit"`[cite: 4]
   *(Note: If Git asks for your name/email, run `git config --global user.name "Your Name"` and `git config --global user.email "you@example.com"`, then run the commit again[cite: 4].)*

### Connecting to Remote & Pushing
5. **Connect the local repository to the remote Pukaar repository:** 
   `git remote add origin https://github.com/Pranq-lgtm/Pukaar`[cite: 4]
6. **Rename the default branch to main:** 
   `git branch -M main`[cite: 4]
7. **Push the project to GitHub:** 
   `git push -u origin main`[cite: 4]

*(Note: If prompted for a GitHub login, use a Personal Access Token instead of a password for HTTPS, or configure SSH and use the SSH remote URL instead[cite: 4].)*

### Future Updates
To push updates in the future, use the following commands[cite: 4]:
```bash
git add .
git commit -m "Describe your changes"
git push
