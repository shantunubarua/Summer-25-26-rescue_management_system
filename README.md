# Rescue Management System (PHP + MySQL, MVC)

A role-based web application for coordinating rescue operations between **admin, volunteer, witness, and help seeker** users.

The project is built with plain **PHP**, **MySQL/MariaDB**, **HTML**, **CSS**, and **JavaScript**. It follows an MVC-style separation using `models/`, `controllers/`, and `views/`, with `index.php` acting as the main front controller/router. The database layer uses procedural `mysqli`, with prepared statements for parameterized database operations.

---

## 1. Install (XAMPP)

1. Copy the project folder into:

   ```text
   C:\xampp\htdocs\
   ```

   Example:

   ```text
   C:\xampp\htdocs\Summer-25-26-rescue_management_system\
   ```

2. Start **Apache** and **MySQL** from the XAMPP Control Panel.

3. Open phpMyAdmin:

   ```text
   http://localhost/phpmyadmin
   ```

4. Create a database named:

   ```text
   rescue_management_system
   ```

5. Select that database and import:

   ```text
   database/rescue_management_system (4).sql
   ```

6. Open the application in the browser:

   ```text
   http://localhost/Summer-25-26-rescue_management_system/
   ```

7. The default database configuration is in `config/database.php`:

   ```php
   $host = "localhost";
   $username = "root";
   $password = "";
   $database = "rescue_management_system";
   ```

   If your MySQL installation uses a different username or password, update this file.

> Public registration is available for **Volunteer**, **Witness**, and **Help Seeker** accounts. Admin registration is intentionally blocked by the registration controller.

---

## 2. Repository layout

This project follows the **MVC (Model-View-Controller)** pattern:

```text
Summer-25-26-rescue_management_system/
├── index.php                              front controller and application router
├── README.md                              project documentation
│
├── config/
│   └── database.php                       MySQL database connection
│
├── helpers/
│   └── auth.php                           session, role guards, CSRF and logout helpers
│
├── middleware/                            reserved middleware directory
│
├── controllers/                           request handling, validation and application flow
│   ├── AdminController.php                admin dashboard and witness report review
│   ├── AuthController.php                 login, registration and password management
│   ├── DonationController.php             donation creation, payment and admin viewing
│   ├── FeedbackController.php             help-seeker feedback and admin management
│   ├── HelpSeekerController.php           rescue requests, profile and nearby volunteers
│   ├── NotificationController.php         admin notification CRUD and search
│   ├── RescueReportController.php         rescue report CRUD and status handling
│   ├── ResourceRequestController.php       volunteer resource requests and admin review
│   └── WitnessController.php              witness reports, evidence upload and profile
│
├── models/                                database access and business data operations
│   ├── AdminDashboardModel.php            dashboard statistics
│   ├── DonationModel.php                  donation data
│   ├── FeedbackModel.php                  feedback data
│   ├── HelpSeekerModel.php                emergency request and help-seeker data
│   ├── NotificationModel.php              notification data
│   ├── RescueReportModel.php              rescue report data
│   ├── ResourceRequestModel.php            resource request data
│   ├── VolunteerModel.php                 volunteer activity, profile and availability
│   ├── WitnessDashboardModel.php           witness dashboard summary data
│   └── WitnessModel.php                   witness report and profile data
│
├── views/                                 presentation templates / user interface
│   ├── auth/
│   │   ├── login.php
│   │   ├── register.php
│   │   ├── forgot_password.php
│   │   ├── reset_password.php
│   │   └── change_password.php
│   │
│   ├── admin/
│   │   ├── dashboard.php
│   │   ├── donations/
│   │   ├── feedback/
│   │   ├── notifications/
│   │   ├── rescue_reports/
│   │   ├── resource_requests/
│   │   └── witness_reports/
│   │
│   ├── witness/
│   │   ├── dashboard.php
│   │   ├── create_report.php
│   │   ├── reports.php
│   │   ├── view_report.php
│   │   ├── edit_report.php
│   │   ├── create_donation.php
│   │   ├── donation_payment.php
│   │   ├── donations.php
│   │   └── profile.php
│   │
│   ├── volunteer/
│   │   ├── dashboard.php
│   │   ├── emergency_requests.php
│   │   ├── accept_request.php
│   │   ├── activities.php
│   │   ├── availability.php
│   │   ├── resource_request.php
│   │   ├── resource_request_edit.php
│   │   └── profile.php
│   │
│   ├── helpseeker/
│   │   ├── dashboard.php
│   │   ├── create_request.php
│   │   ├── requests.php
│   │   ├── view_request.php
│   │   ├── edit_request.php
│   │   ├── nearby_volunteers.php
│   │   ├── feedback.php
│   │   └── profile.php
│   │
│   ├── donation/
│   │   ├── create.php
│   │   └── index.php
│   │
│   └── partials/
│       ├── header.php
│       ├── sidebar.php
│       └── footer.php
│
├── assets/
│   ├── css/
│   │   └── style.css                      application styling and responsive layout
│   ├── images/                            image assets
│   └── js/
│       ├── admin.js                       admin UI, validation and AJAX search
│       ├── helpseeker.js                  help-seeker UI, validation and AJAX search
│       ├── volunteer.js                   volunteer UI, actions and AJAX search
│       └── witness.js                     witness UI, validation and AJAX search
│
├── database/
│   └── rescue_management_system (4).sql   database schema and sample data
│
└── uploads/
    ├── evidence/                          uploaded evidence storage
    └── witness/                           witness report evidence files
```

### MVC responsibility

- **Model** — handles database queries and data operations.
- **View** — displays HTML forms, tables, dashboards, and user-facing content.
- **Controller** — validates requests, calls the model, makes decisions, and loads the correct view.
- **`index.php`** — acts as the central router and sends each request to the correct controller/view.

---

## 3. How the router works

The application uses `index.php` as the main entry point. Most URLs follow this pattern:

```text
index.php?page=<route>
```

Routes that work with a particular record can also use an `id` query parameter:

```text
index.php?page=<route>&id=<record_id>
```

Examples:

| URL | What happens |
| --- | --- |
| `index.php?page=login` | Login page |
| `index.php?page=register` | Registration page |
| `index.php?page=admin-dashboard` | Admin dashboard |
| `index.php?page=notifications` | Admin notification list |
| `index.php?page=witness-reports` | Witness's own incident reports |
| `index.php?page=witness-report-view&id=1` | View one witness report |
| `index.php?page=volunteer-emergency-requests` | Volunteer emergency request list |
| `index.php?page=helpseeker-requests` | Help seeker's rescue requests |
| `index.php?page=helpseeker-request-view&id=1` | View one rescue request |
| `index.php?page=change-password` | Change password page |

`index.php` loads the database configuration and authentication helpers first. Protected routes then call role guards such as `requireAdmin()`, `requireWitness()`, `requireVolunteer()`, or `requireHelpSeeker()` before loading role-specific functionality.

Logout is performed through a **POST** request with CSRF protection rather than a normal GET link.

---

## 4. The four roles

| Role | Main responsibility | Feature 1 | Feature 2 | Feature 3 |
| --- | --- | --- | --- | --- |
| **Admin** | Supervise the whole rescue system | Create, edit, search and delete notifications | Create/manage rescue reports and review witness reports | Review feedback, donations and volunteer resource requests |
| **Volunteer** | Respond to rescue requests | View and accept emergency requests | Track rescue activities and update rescue status | Set availability and create/manage resource requests |
| **Witness** | Report incidents and support rescue operations | Create, view, edit, delete and search witness reports | Upload evidence with incident reports | Make donations and view donation history |
| **Help Seeker** | Request emergency assistance | Create, view, edit, delete and search rescue requests | Find nearby available volunteers | Submit feedback after rescue assistance |

All logged-in non-admin roles also have profile/account pages, and all authenticated users can change their password.

### How the roles connect

1. A **Help Seeker** creates an emergency rescue request.
2. A **Volunteer** can see available emergency requests and accept one.
3. The accepted request becomes part of the volunteer's rescue activity workflow.
4. The volunteer can update rescue activity status and manage their availability.
5. An **Admin** can monitor the system and create/manage rescue reports related to emergency requests.
6. A **Help Seeker** can submit feedback related to a rescue request.
7. A **Witness** can submit an incident report with optional evidence.
8. The **Admin** can review witness reports and update their status.
9. A **Witness** can also make a donation, which is visible from the admin donation section.
10. A **Volunteer** can request resources, and the **Admin** can review and update those requests.

---

## 5. Main features

### Authentication and account management

- Login using **username or email**.
- Registration for Volunteer, Witness, and Help Seeker roles.
- Role-based redirect after successful login.
- Forgot-password and reset-password flow.
- Change-password feature for logged-in users.
- Remembered login email cookie.
- Automatic session timeout after 30 minutes of inactivity.

### Admin features

- Dashboard statistics.
- Notification CRUD and live search.
- View and manage feedback.
- Review witness reports and update their status.
- Rescue report CRUD and status management.
- Review volunteer resource requests and update their status.
- View donation records and donation details.

### Volunteer features

- View emergency requests.
- Accept a rescue request.
- View rescue activity history.
- Update rescue activity status.
- Set availability as available, unavailable, or currently rescuing.
- Create, edit, cancel and search resource requests.
- Update volunteer profile information.

### Witness features

- Dashboard summary and recent activity.
- Create incident/witness reports.
- Upload JPG, JPEG, PNG, or PDF evidence.
- View, edit, delete and search own reports.
- Make donations and confirm donation information.
- View personal donation history.
- Update witness profile.

### Help Seeker features

- Dashboard and rescue request overview.
- Create emergency requests with emergency type, location, priority and victim information.
- View, edit, delete and search own requests.
- Find nearby available volunteers.
- Submit rescue feedback.
- Update help-seeker profile.

---

## 6. Requirement checklist

| Requirement | Where to look |
| --- | --- |
| **MVC structure** | `models/`, `controllers/`, `views/`, routed through `index.php` |
| **Database (MySQL/MariaDB)** | `config/database.php`, `database/rescue_management_system (4).sql` |
| **Procedural MySQLi** | model and controller database operations |
| **Authentication** | `controllers/AuthController.php`, `helpers/auth.php` |
| **Role-based authorization** | `requireAdmin()`, `requireWitness()`, `requireVolunteer()`, `requireHelpSeeker()` |
| **PHP validation** | controller functions before database actions |
| **Client-side JavaScript** | `assets/js/admin.js`, `helpseeker.js`, `volunteer.js`, `witness.js` |
| **AJAX / JSON search** | notification, witness report, help-seeker request and resource-request search handlers |
| **CRUD operations** | notifications, reports, rescue requests, resource requests and related role modules |
| **File upload** | witness evidence upload in `controllers/WitnessController.php` |
| **Responsive UI** | `assets/css/style.css` and responsive CSS used by role pages |
| **Web security** | CSRF, session security, password hashing, output escaping and role guards |

---

## 7. Security and validation

| Risk | Protection used | Main location |
| --- | --- | --- |
| SQL injection | Prepared statements are used for parameterized/user-input queries | `models/`, `controllers/AuthController.php` |
| Stolen/plain-text passwords | `password_hash()` when saving passwords and `password_verify()` during login | `controllers/AuthController.php` |
| Cross-site scripting (XSS) | User-controlled output is escaped with `htmlspecialchars()` in views | `views/` |
| Cross-site request forgery (CSRF) | Session CSRF token is added to protected forms and validated on POST actions | `helpers/auth.php`, `index.php`, views |
| Session fixation | Session ID is regenerated after successful login | `controllers/AuthController.php` |
| Session-cookie theft | Session cookie uses `httponly` and `SameSite=Lax`; secure flag is enabled under HTTPS | `helpers/auth.php` |
| Inactive logged-in sessions | Automatic logout after **1800 seconds / 30 minutes** | `helpers/auth.php` |
| Wrong-role access | Every protected route checks the logged-in user's role | `helpers/auth.php`, `index.php` |
| Unauthorized record access | Role models scope personal records using the logged-in user's ID | role models/controllers |
| Unsafe evidence upload | Extension, real MIME type, maximum 5 MB size and unique filename checks | `controllers/WitnessController.php` |
| Weak password reset token | Random reset token, SHA-256 token hash and a 10-minute expiration | `controllers/AuthController.php` |

### Important validation rule

Client-side JavaScript validation improves the user experience, but important validation is repeated on the server in PHP because browser-side JavaScript can be bypassed.

---

## 8. Database tables

The SQL dump contains the following main tables:

| Table | Purpose |
| --- | --- |
| `users` | Stores all Admin, Volunteer, Witness and Help Seeker accounts |
| `volunteer_profiles` | Stores volunteer skills, experience, address, blood group and availability |
| `emergency_requests` | Stores rescue requests created by Help Seekers and volunteer assignment information |
| `witness_reports` | Stores witness incident reports and evidence-file paths |
| `rescue_reports` | Stores admin-managed rescue reports linked to emergency requests |
| `resource_requests` | Stores resources requested by volunteers |
| `notifications` | Stores admin announcements/alerts for target audiences |
| `feedback` | Stores Help Seeker feedback related to rescue requests |
| `donations` | Stores Witness donation information and payment/status details |

---

## 9. Search and AJAX features

The application contains live/asynchronous search functionality for several modules. JavaScript sends requests to route-specific PHP handlers, and the controllers return JSON data.

Examples include:

```text
index.php?page=notification-search
index.php?page=witness-report-search
index.php?page=helpseeker-request-search
index.php?page=volunteer-resource-request-search
index.php?page=admin-resource-request-search
```

Relevant JavaScript files:

```text
assets/js/admin.js
assets/js/witness.js
assets/js/helpseeker.js
assets/js/volunteer.js
```

---

## 10. Evidence upload rules

Witnesses can attach evidence when creating an incident report.

Allowed extensions:

```text
.jpg
.jpeg
.png
.pdf
```

Allowed MIME types:

```text
image/jpeg
image/png
application/pdf
```

Maximum file size:

```text
5 MB
```

Uploaded witness evidence is stored under:

```text
uploads/witness/
```

The server generates a unique filename before saving the uploaded file.

---

## 11. Seeded users and registration

The included SQL dump contains sample user records for all four roles.

| Role | Seeded username(s) |
| --- | --- |
| Admin | `admin` |
| Witness | `tanaka`, `nasiba` |
| Help Seeker | `parvej` |
| Volunteer | `suporna` |

Passwords in the SQL file are stored as **password hashes**, not plain text. Use the credentials configured by your project team, use the password-reset flow, or register a new non-admin account for testing.

The public registration page permits only:

```text
volunteer
witness
help_seeker
```

An `admin` account cannot be created from the public registration form.

---

## 12. Suggested project demonstration flow

For a full project demonstration, the system can be shown in this order:

1. Log in as a **Help Seeker** and create a rescue request.
2. Log in as a **Volunteer**, open Emergency Requests and accept the request.
3. Show the volunteer's Rescue Activities and update the rescue status.
4. Log in as **Admin** and show dashboard statistics and rescue-report management.
5. Return to the **Help Seeker** and submit feedback.
6. Log in as a **Witness**, create an incident report and optionally upload evidence.
7. Show Witness report search/edit/view features.
8. Create a Witness donation and show donation history.
9. Log in as **Admin** and review Witness Reports, Donations, Feedback and Resource Requests.
10. Demonstrate Notifications and role-based access restrictions.

---

## 13. Technology stack

```text
Frontend : HTML, CSS, JavaScript
Backend  : PHP
Database : MySQL / MariaDB
DB API   : Procedural MySQLi
Pattern  : MVC-style architecture
Server   : Apache (XAMPP)
```

---

## 14. Project summary

The **Rescue Management System** provides a single role-based platform where emergency requests, volunteer rescue activity, witness incident reports, donations, resource requests, feedback, rescue reports, and administrative notifications can be managed securely through separate dashboards.

The project demonstrates core Web Technology concepts including **PHP**, **MySQL**, **MVC organization**, **CRUD**, **session authentication**, **role-based authorization**, **server-side validation**, **JavaScript**, **AJAX/JSON**, **file upload**, and common web-security practices.


"Copyright (c) 2026 Shantunu Barua, Tanaka Rahman, Israt Jahan Suporna, Md Mahamudul Parvej. All rights reserved."