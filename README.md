# Pukaar

Pukaar is a localized child-safety support platform for **Track 2 (Bal Suraksha)** that combines:

- **Anonymous/non-anonymous reporting**
- **Verified aid dispatch to vetted NGOs**
- **Physical-digital escalation for real-world intervention**

## Core Architecture

### 1) Reporting Channel (Point 02)
- Users can create reports as:
  - **Anonymous**
  - **Identified (non-anonymous)**
- The reporting flow is trauma-informed and does not force identity disclosure.

### 2) Verification Pipeline (Point 02)
- Only **verified NGOs** can receive and accept cases.
- A **superadmin verification workflow** onboards and whitelists NGOs before activation.

### 3) Dispatch + Physical-Digital Link (Point 03)
- New alerts are dispatched to nearby verified NGOs.
- NGO identity/details remain hidden from the reporting side until acceptance.
- Once accepted, the case is routed for on-ground intervention.

### 4) Localized Goa Rollout
- Initial deployment scope is Goa to ensure realistic operational fit.
- UI and support flows are designed for local institutions and response patterns.

## Critical Safeguards (Must-Have)

### A) Remove Superadmin God-Mode Risk
- Enforce strict **RBAC + least privilege**:
  - NGO verification admins can manage NGO onboarding only.
  - Case responders can access only assigned cases.
  - Audit admins can view logs, not raw case content.
- Sensitive report content should be encrypted and compartmentalized to prevent universal plaintext access.

### B) Prevent Unaccepted Ticket Blackholes
- Add an **automated escalation matrix**:
  - If no NGO accepts within 5 minutes, auto-escalate to backup responders.
  - If still unaccepted, escalate to 24/7 helpline / nearest police control workflow.
- Reporter receives status feedback at each escalation stage.

### C) Preserve Anonymity While Reducing Spam
- Apply anti-abuse controls that do not require identity disclosure:
  - Device/session fingerprinting
  - Behavioral and per-device rate limiting
  - NLP-assisted spam/risk scoring before NGO dispatch
  - Priority queueing for high-risk language indicators

### D) Goa-First Accessibility
- Provide multilingual UI with **Konkani (Devanagari)** and English from day one.
- Keep reporting flow readable with low-text, guided prompts for distressed users.