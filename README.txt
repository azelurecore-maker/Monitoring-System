DILG PROJECT MONITORING & PUBLIC VIEW SYSTEM
Sapian, Capiz

RUN ON XAMPP
1. Copy the dilg_pms folder to C:\xampp\htdocs\
2. Start Apache and MySQL in XAMPP.
3. Open phpMyAdmin: http://localhost/phpmyadmin
4. Import schema.sql.
5. Open: http://localhost/dilg_pms/

DEFAULT LOGINS
Admin: AdminSapianDILG / adminDILG
Majanlud Rep: Hon. Sec. Majanlud / user
Poblacion Rep: Officer Poblacion Base / pob

BACKEND
- PHP 8+
- MySQL / MariaDB
- PHP sessions for login
- API endpoint: api/api.php
- Data is stored in MySQL, not browser localStorage.
- The supplied PMS_DILG.html interface is integrated into index.php.
- Expense-list data from the Barangay Rep project form is stored in the projects.expense_items field.

UPDATING AN EXISTING DATABASE (v2: new project fields, Completed / Not Yet Started, Confirm / Reject)
If you already imported the old schema.sql, do NOT re-import (that wipes your data).
Open phpMyAdmin > dilg_pms > SQL tab and run the contents of migrate_v2.sql once.
Migrated projects keep their data; Location and Mode of Implementation start empty
and are filled in the next time each project is edited.

WHAT CHANGED IN v2
- Project status is Completed / Ongoing / Not Yet Started (was Accomplished / Ongoing / Delayed).
- Review status (Pending / Confirmed / Rejected) is separate from project status and is set by the admin.
  Only Confirmed projects appear on the admin dashboard and the public view. A rep's edit sends the project back to Pending.
- Full screen: the folder modal, the status modal (dashboard cards) and the project details (receipt) window.
- Printing a project: the Print button in the project details window prints ONE page. The text size is fitted so the content fills
  the page and photos stretch into any leftover space. Pick A4 / Letter / Legal next to the button. Works for Admin, Rep and Public.
- Photos: a project can have up to 10 photos (resized in the browser before upload).
- API: projects are saved one at a time (save_project, delete_project, set_review). The old save_projects "replace everything" action was removed.
- If photo uploads fail, raise post_max_size / upload_max_filesize in php.ini and max_allowed_packet in MySQL (my.ini).

WHAT CHANGED IN v3 (accounts + Barangay Files)
- Barangay Files (Admin) no longer has the fixed 10 folders. A folder is created automatically for each barangay typed in
  Manage Accounts > Add New User > Assigned Barangay (typing the same name again, in any capitalisation, reuses the folder).
  Folders are stored in the barangay_folders table, which api.php creates by itself if it is missing.
- Assigned Barangay is now a free text input (existing folders show as typing suggestions).
- Deactivate / Activate / Remove use dedicated API actions (set_account_status, delete_account, add_account, list_accounts);
  the old save_accounts "delete everything and re-insert" action was removed.
- A deactivated or removed account is signed out immediately (the session is re-checked on every request).
- Removing an account keeps its barangay folder and projects. The accounts list no longer sends passwords to the browser.

IMPORTANT
This is a working local/XAMPP implementation based on the uploaded frontend. For production deployment, passwords should be migrated to password_hash()/password_verify(), CSRF protection should be added, uploads should be stored as files instead of base64, and stricter server-side authorization/audit logging should be implemented.
