# Textbook Trove - Second Hand Textbook Store

## Overview

Textbook Trove is a second-hand textbook store developed as a project for a web development course (WEDE6021). The project is built using Bootstrap (HTML+CSS), PHP, and MySQL.

## Requirements

- [WampServer](https://www.wampserver.com/en/) (with MySQL and phpMyAdmin included)


## Setup

1. **Install WampServer:**
   - Download and install WampServer from the [official website](https://www.wampserver.com/en/).
   - During installation, make sure to include the latest version of MySQL.
   - Select phpMyAdmin as one of the components to be installed.

2. **Move Project to www Directory:**
   - After downloading the project zip file, unzip it.
   - Move the project folder to the `www` directory in the WampServer installation directory (e.g., `C:\wamp64\www\textbook_trove`).

3. **Start WampServer:**
   - Launch WampServer and ensure it is running. Check the status from the system tray icon.

4. **Access phpMyAdmin:**
   - Left-click the WampServer icon in the system tray.
   - Navigate to the "phpMyAdmin" option and click to access the phpMyAdmin login page.

5. **Database Setup:**
   - Log in to phpMyAdmin with the default credentials (usually, username: `root` and no password).
   - Create a new database called `textbook_trove_group39`.
   - Click on the SQL tab and execute the SQL commands from the file `myBookStore.sql` to create the database schema.

6. **Import Sample Data(Optional):**
   - In phpMyAdmin, click on the `textbook_trove_group39` database.
   - Click on the table you want to import data into.
   - Go to the Import tab.
   - Upload the corresponding CSV file from the `project_sample_data` directory.
   - Change the format to 'CSV using LOAD Data.'
   - Ensure "Columns escaped with" is blank.
   - Set "Columns separated with" to a comma `,`.
   - Fill in the respective names of the columns under "Column names."

7. **Run the Project:**
   - Open your web browser and navigate to `http://localhost/textbook_trove/`.
   - Alternatively, left-click on the WampServer icon in the system tray.
   - Select the "localhost" option to be taken to the WampServer homepage.
   - Under "Your Projects," find and select your project.

## Troubleshooting

- Check WampServer logs and error messages for any issues.
- Make sure the project folder is located in the `www` directory.
- Ensure the correct database connection details in the project's configuration file (DBConn.php).

