# StudentRecord

# ✦ EduPortal — Student Registration System

> A professional web-based student enrollment and management system built with PHP and flat-file storage.


## 📽 Demo Video

**▶ Watch Demo:** [Click Here to View](https://www.loom.com/share/994ee7ff0b5f4120a7cbd0ed425ded6d)

## 📌 Project Overview

EduPortal is a Student Registration System developed as part of a university project. It allows administrators to register new students, view all enrolled students in a directory, and perform edit and delete operations — all without a database, using a simple text file for storage.

## 🛠 Technologies Used

- **PHP** — Backend logic (form handling, file read/write, redirects)
- **HTML5 & CSS3** — Structure and styling
- **Google Fonts** — Playfair Display + DM Sans typography
- **Flat File Storage** — `students.txt` used as a lightweight database
- **JavaScript** — Delete confirmation dialogs and toast-style alerts


## 📁 Project Structure

```
project/
│
├── form.php          # Student registration form (input page)
├── students.php      # Student directory (view, edit, delete)
├── students.txt      # Auto-generated data file (do not delete)
└── README.md         # Project documentation
```

## ⚙️ Features

- **Register Students** — Add name, registration number, email, and course
- **View Directory** — See all enrolled students in a clean table
- **Edit Records** — Update any student's details inline
- **Delete Records** — Remove a student with confirmation prompt
- **Toast Notifications** — Slide-in alerts for add, update, and delete actions
- **Empty State Handling** — Friendly message when no students are registered
- **Responsive Design** — Works on desktop and mobile screens


## 🖥 Pages

### `form.php` — Registration Page
- Split-layout design with a step guide on the left and form on the right
- Fields: Full Name, Registration No., Email, Programme (dropdown)
- Validates that all fields are filled before saving
- Appends new student data to `students.txt`

### `students.php` — Student Directory
- Displays all registered students in a styled dark table
- Each row has **Edit** and **Delete** action buttons
- Edit opens an inline form panel above the table
- Delete requires confirmation before removing the record
- Shows total enrolled count in the header

