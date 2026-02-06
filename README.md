\# SafeCampus System



SafeCampus is a campus safety reporting system developed to assist students

and administrators in managing safety-related incidents within a campus

environment. The system allows users to submit reports, view incident

locations, and manage safety data through both a web-based system and an

Android mobile application.



This project was developed for academic purposes and demonstrates the

integration of a web application with a mobile application using a shared

backend system.



---



\## Objectives



The objectives of this project are:

\- To provide a centralized platform for campus safety reporting.

\- To allow users to submit and manage safety reports efficiently.

\- To integrate a web-based system with an Android mobile application.

\- To demonstrate client-server communication using REST API.



---



\## Technologies Used



\### Backend (Web Application)

\- PHP

\- MySQL

\- XAMPP (Apache \& MySQL)

\- HTML, CSS, JavaScript



\### Mobile Application

\- Android Studio

\- Java / Kotlin

\- Android Emulator / Physical Android Device



\### Database

\- MySQL (phpMyAdmin)



---



\## Project Structure



safecampus/

├── backend/ # PHP web application files

│ ├── login.php

│ ├── add\_report.php

│ ├── manage\_location.php

│ ├── admin.php

│ ├── db.php

│ └── ...

│

├── android/ # Android Studio project

│ └── safecampus-android/

│ ├── app/

│ ├── gradle/

│ ├── build.gradle.kts

│ └── settings.gradle.kts

│

├── database/

│ └── safecampus\_database.sql

│

└── README.md



---



\## Backend Setup (Web System)



1\. Install \*\*XAMPP\*\*.

2\. Place the `safecampus` project folder inside:

C:\\xampp\\htdocs\\

3\. Open \*\*XAMPP Control Panel\*\* and start:

\- Apache

\- MySQL

4\. Open \*\*phpMyAdmin\*\* in a browser.

5\. Create a new database (e.g. `safecampus`).

6\. Import the database file:

database/safecampus\_database.sql

7\. Access the backend system via browser:

http://localhost:8080/safecampus/admin\_login.php

---



\## Android Application Setup



1\. Open \*\*Android Studio\*\*.

2\. Select \*\*Open Existing Project\*\*.

3\. Choose the folder:

android/safecampus-android

4\. Allow Gradle to sync completely.

5\. Run the application using:

\- Android Emulator, or

\- Physical Android device



\### Backend Connection

\- For Android Emulator:

http://10.0.2.2:8080/safecampus/register.php

\- For Physical Device:

http://<PC-IP-Address>:8080/safecampus/backend/



---



\## System Features



\### Web System

\- Admin login and authentication

\- User management

\- Location management

\- View and manage safety reports

\- Dashboard overview



\### Android Application

\- User registration and login

\- Submit safety reports

\- View reported locations

\- Communicate with backend via REST API



---



\## Limitations



\- The system requires XAMPP to be running in order to function properly.

\- The Android application depends on the availability of the backend server.

\- Additional configuration may be required when running the project on a

different machine.



---



\## Conclusion



The SafeCampus System successfully demonstrates the integration of a

web-based application with an Android mobile application using a centralized

backend system. This project fulfills the academic requirements and provides

a practical solution for campus safety reporting.



---



\## Author



NUR ANIS SYAFIKA BINTI ZULHAMIZI(2023406052)

NORSHAMIERA BINTI MAT ZIN (2023213842)

AI’NAA AMANI BINTI HATTA (2023492248)



Academic Project – Not for Commercial Use















