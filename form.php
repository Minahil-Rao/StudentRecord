<?php
if(isset($_POST['submit'])){
    $name   = trim($_POST['name']);
    $regno  = trim($_POST['regno']);
    $email  = trim($_POST['email']);
    $course = trim($_POST['course']);
    if($name=="" || $regno=="" || $email=="" || $course==""){
        echo "<script>alert('⚠ Please fill all fields!');</script>";
    } else {
        $data = $name.",".$regno.",".$email.",".$course."\n";
        if(file_put_contents("students.txt",$data,FILE_APPEND)){
            echo "<script>
                    alert('Student Registered Successfully!');
                    window.location.href='students.php?status=added';
                  </script>";
        } else {
            echo "<script>alert('Error saving data. Check file permissions.');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Registration Portal</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<style>
  :root {
    --navy: #0b1628;
    --navy-mid: #132040;
    --navy-light: #1e3160;
    --gold: #c9a84c;
    --gold-light: #e8c97a;
    --cream: #f7f3ec;
    --text-muted: #8a9ab5;
    --white: #ffffff;
  }

  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  body {
    font-family: 'DM Sans', sans-serif;
    background: var(--navy);
    color: var(--white);
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    position: relative;
    overflow-x: hidden;
  }

  /* Decorative background grid */
  body::before {
    content: '';
    position: fixed;
    inset: 0;
    background-image:
      linear-gradient(rgba(201,168,76,0.04) 1px, transparent 1px),
      linear-gradient(90deg, rgba(201,168,76,0.04) 1px, transparent 1px);
    background-size: 60px 60px;
    pointer-events: none;
    z-index: 0;
  }

  /* Glowing orb top right */
  body::after {
    content: '';
    position: fixed;
    top: -150px;
    right: -150px;
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, rgba(201,168,76,0.12) 0%, transparent 70%);
    pointer-events: none;
    z-index: 0;
  }

  /* ── HEADER ── */
  header {
    position: relative;
    z-index: 10;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 18px 48px;
    border-bottom: 1px solid rgba(201,168,76,0.2);
    background: rgba(11,22,40,0.8);
    backdrop-filter: blur(10px);
  }

  .logo {
    display: flex;
    align-items: center;
    gap: 14px;
  }

  .logo-icon {
    width: 42px;
    height: 42px;
    border: 2px solid var(--gold);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    color: var(--gold);
  }

  .logo-text {
    font-family: 'Playfair Display', serif;
    font-size: 20px;
    color: var(--white);
    letter-spacing: 0.5px;
  }

  .logo-text span { color: var(--gold); }

  .header-badge {
    font-size: 12px;
    color: var(--text-muted);
    background: rgba(201,168,76,0.08);
    border: 1px solid rgba(201,168,76,0.15);
    padding: 6px 14px;
    border-radius: 50px;
    letter-spacing: 0.5px;
  }

  /* ── MAIN LAYOUT ── */
  main {
    position: relative;
    z-index: 10;
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 50px 24px;
    gap: 60px;
  }

  /* Left panel: decorative info */
  .side-panel {
    flex: 0 0 300px;
    display: flex;
    flex-direction: column;
    gap: 28px;
    animation: fadeSlideLeft 0.7s ease both;
  }

  @keyframes fadeSlideLeft {
    from { opacity: 0; transform: translateX(-30px); }
    to   { opacity: 1; transform: translateX(0); }
  }

  .side-title {
    font-family: 'Playfair Display', serif;
    font-size: 38px;
    line-height: 1.2;
    color: var(--white);
  }
  .side-title em {
    font-style: normal;
    color: var(--gold);
    display: block;
  }

  .side-divider {
    width: 60px;
    height: 3px;
    background: linear-gradient(90deg, var(--gold), transparent);
    border-radius: 2px;
  }

  .side-desc {
    font-size: 14px;
    color: var(--text-muted);
    line-height: 1.8;
    font-weight: 300;
  }

  .side-steps {
    display: flex;
    flex-direction: column;
    gap: 14px;
  }

  .step {
    display: flex;
    align-items: center;
    gap: 14px;
    font-size: 13px;
    color: #6a7d9b;
  }

  .step-num {
    flex-shrink: 0;
    width: 28px;
    height: 28px;
    border: 1px solid rgba(201,168,76,0.4);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    color: var(--gold);
    font-family: 'Playfair Display', serif;
  }

  /* ── FORM CARD ── */
  .form-card {
    flex: 0 0 440px;
    background: var(--navy-mid);
    border: 1px solid rgba(201,168,76,0.15);
    border-radius: 20px;
    padding: 42px 38px;
    box-shadow: 0 40px 80px rgba(0,0,0,0.5), 0 0 0 1px rgba(255,255,255,0.03);
    animation: fadeSlideUp 0.7s ease 0.1s both;
  }

  @keyframes fadeSlideUp {
    from { opacity: 0; transform: translateY(30px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  .form-card-header {
    margin-bottom: 32px;
  }

  .form-card-header h3 {
    font-family: 'Playfair Display', serif;
    font-size: 22px;
    margin-bottom: 6px;
    color: var(--white);
  }

  .form-card-header p {
    font-size: 13px;
    color: var(--text-muted);
  }

  /* Form fields */
  .field-group {
    margin-bottom: 20px;
  }

  label {
    display: block;
    font-size: 11px;
    letter-spacing: 1.2px;
    text-transform: uppercase;
    color: var(--gold);
    margin-bottom: 8px;
    font-weight: 500;
  }

  input[type=text],
  input[type=email],
  select {
    width: 100%;
    padding: 13px 16px;
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(201,168,76,0.2);
    border-radius: 10px;
    color: var(--white);
    font-family: 'DM Sans', sans-serif;
    font-size: 14px;
    transition: border-color 0.25s, background 0.25s, box-shadow 0.25s;
    outline: none;
    -webkit-appearance: none;
  }

  input::placeholder { color: #3d5070; }

  input:focus, select:focus {
    border-color: var(--gold);
    background: rgba(201,168,76,0.06);
    box-shadow: 0 0 0 4px rgba(201,168,76,0.08);
  }

  select {
    cursor: pointer;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' fill='none'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23c9a84c' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 16px center;
    padding-right: 40px;
  }

  select option {
    background: var(--navy-mid);
    color: var(--white);
  }

  /* Buttons */
  .btn-primary {
    width: 100%;
    padding: 14px;
    background: linear-gradient(135deg, var(--gold), #a8762a);
    color: var(--navy);
    border: none;
    border-radius: 10px;
    font-family: 'DM Sans', sans-serif;
    font-size: 14px;
    font-weight: 600;
    letter-spacing: 0.5px;
    cursor: pointer;
    transition: transform 0.15s, box-shadow 0.15s, filter 0.15s;
    margin-top: 8px;
  }

  .btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(201,168,76,0.35);
    filter: brightness(1.1);
  }

  .btn-primary:active { transform: translateY(0); }

  .btn-ghost {
    width: 100%;
    padding: 12px;
    background: transparent;
    color: var(--text-muted);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 10px;
    font-family: 'DM Sans', sans-serif;
    font-size: 13px;
    cursor: pointer;
    margin-top: 10px;
    transition: border-color 0.2s, color 0.2s, background 0.2s;
  }

  .btn-ghost:hover {
    border-color: rgba(201,168,76,0.3);
    color: var(--gold-light);
    background: rgba(201,168,76,0.05);
  }

  .form-footer {
    margin-top: 24px;
    padding-top: 20px;
    border-top: 1px solid rgba(255,255,255,0.06);
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 11px;
    color: #3d5070;
  }

  @media (max-width: 860px) {
    main { flex-direction: column; gap: 30px; }
    .side-panel { flex: none; text-align: center; align-items: center; }
    .side-divider { margin: auto; }
    .form-card { flex: none; width: 100%; max-width: 440px; }
    header { padding: 16px 20px; }
    .header-badge { display: none; }
  }
</style>
</head>
<body>

<header>
  <div class="logo">
    <div class="logo-icon">✦</div>
    <div class="logo-text">Edu<span>Portal</span></div>
  </div>
  <div class="header-badge">Academic Year 2024 – 25</div>
</header>

<main>
  <div class="side-panel">
    <div class="side-title">
      Student
      <em>Enrollment</em>
      System
    </div>
    <div class="side-divider"></div>
    <p class="side-desc">
      Register new students into the academic records system. All entries are stored securely and can be managed from the students directory.
    </p>
    <div class="side-steps">
      <div class="step"><span class="step-num">1</span> Fill in student details</div>
      <div class="step"><span class="step-num">2</span> Select enrolled course</div>
      <div class="step"><span class="step-num">3</span> Submit for registration</div>
      <div class="step"><span class="step-num">4</span> View in student directory</div>
    </div>
  </div>

  <div class="form-card">
    <div class="form-card-header">
      <h3>New Registration</h3>
      <p>Complete all fields to enroll a student</p>
    </div>

    <form method="POST">
      <div class="field-group">
        <label for="name">Full Name</label>
        <input type="text" id="name" name="name" placeholder="e.g. Minahil Nisar">
      </div>
      <div class="field-group">
        <label for="regno">Registration No.</label>
        <input type="text" id="regno" name="regno" placeholder="e.g. COSC231101036">
      </div>
      <div class="field-group">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" placeholder="e.g. minahil@university.edu">
      </div>
      <div class="field-group">
        <label for="course">Program</label>
        <select id="course" name="course">
          <option value="">— Select Program —</option>
          <option>Computer Science</option>
          <option>Software Engineering</option>
          <option>Information Technology</option>
          <option>Artificial Intelligence</option>
        </select>
      </div>
      <button type="submit" name="submit" class="btn-primary">✦ Register Student</button>
    </form>

    <form action="students.php">
      <button class="btn-ghost">View Student Directory →</button>
    </form>

    <div class="form-footer">
      <span>EduPortal v2.0</span>
      <span>Secure · Academic Records</span>
    </div>
  </div>
</main>

</body>
</html>