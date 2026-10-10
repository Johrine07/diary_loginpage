LITTLE DIARY — PHP + MySQL project

FEATURES
- Create an account and log in
- Passwords are stored as secure password hashes
- PHP sessions keep users logged in
- Each user sees only their own diary entries
- Create and delete diary pages
- Responsive pastel diary-style design

HOW TO RUN USING XAMPP
1. Install and open XAMPP.
2. Start Apache and MySQL.
3. Copy the diary_login_project folder into:
   C:\xampp\htdocs\
4. Open http://localhost/phpmyadmin
5. Choose the Import tab and import diary_db.sql.
   (Alternatively, open the SQL tab and run the contents of diary_db.sql.)
6. If your MySQL username/password is different from XAMPP defaults,
   update db.php. Default XAMPP settings are username root and blank password.
7. Open http://localhost/diary_login_project/index.php
8. Select "Create an account", register, and start writing.

IMPORTANT
- This is a classroom starter project. Use it locally for your assignment.
- Do not upload real private diary entries to a public server without additional
  security measures, HTTPS, backups, and careful configuration.
- Never store plain-text passwords; this project uses password_hash() and
  password_verify().
