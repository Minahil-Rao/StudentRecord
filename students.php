<?php
$students = file_exists("students.txt") ? file("students.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];

// DELETE
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    unset($students[$id]);
    $students = array_values($students);
    file_put_contents("students.txt", implode("\n", $students) . (count($students) ? "\n" : ""));
    header("Location: students.php?status=deleted");
    exit();
}

// UPDATE
if(isset($_POST['update'])){
    $id = $_POST['id'];
    $students[$id] =
        trim($_POST['name']).",".
        trim($_POST['regno']).",".
        trim($_POST['email']).",".
        trim($_POST['course']);
    file_put_contents("students.txt", implode("\n", $students) . "\n");
    header("Location: students.php?status=updated");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Directory</title>
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
    --danger: #e05555;
    --teal: #3ab8c4;
    --white: #ffffff;
  }

  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  body {
    font-family: 'DM Sans', sans-serif;
    background: var(--navy);
    color: var(--white);
    min-height: 100vh;
    position: relative;
    overflow-x: hidden;
  }

  body::before {
    content: '';
    position: fixed;
    inset: 0;
    background-image:
      linear-gradient(rgba(201,168,76,0.03) 1px, transparent 1px),
      linear-gradient(90deg, rgba(201,168,76,0.03) 1px, transparent 1px);
    background-size: 60px 60px;
    pointer-events: none;
    z-index: 0;
  }

  body::after {
    content: '';
    position: fixed;
    bottom: -200px;
    left: -200px;
    width: 600px;
    height: 600px;
    background: radial-gradient(circle, rgba(58,184,196,0.07) 0%, transparent 65%);
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
    border-bottom: 1px solid rgba(201,168,76,0.18);
    background: rgba(11,22,40,0.85);
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
  }
  .logo-text span { color: var(--gold); }

  .header-right {
    display: flex;
    align-items: center;
    gap: 14px;
  }

  .header-badge {
    font-size: 12px;
    color: var(--text-muted);
    background: rgba(201,168,76,0.08);
    border: 1px solid rgba(201,168,76,0.15);
    padding: 6px 14px;
    border-radius: 50px;
  }

  .btn-back {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 8px 18px;
    background: rgba(201,168,76,0.1);
    border: 1px solid rgba(201,168,76,0.25);
    border-radius: 8px;
    color: var(--gold-light);
    font-size: 13px;
    font-family: 'DM Sans', sans-serif;
    cursor: pointer;
    text-decoration: none;
    transition: background 0.2s, box-shadow 0.2s;
  }
  .btn-back:hover {
    background: rgba(201,168,76,0.18);
    box-shadow: 0 4px 14px rgba(201,168,76,0.15);
  }

  /* ── PAGE CONTENT ── */
  .page-content {
    position: relative;
    z-index: 10;
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 24px 60px;
  }

  /* ── PAGE TITLE ── */
  .page-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    margin-bottom: 32px;
    animation: fadeSlideUp 0.6s ease both;
  }

  @keyframes fadeSlideUp {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  .page-title {
    font-family: 'Playfair Display', serif;
    font-size: 32px;
    color: var(--white);
  }

  .page-title span { color: var(--gold); }

  .page-subtitle {
    font-size: 13px;
    color: var(--text-muted);
    margin-top: 4px;
  }

  .count-badge {
    background: rgba(201,168,76,0.1);
    border: 1px solid rgba(201,168,76,0.2);
    border-radius: 50px;
    padding: 8px 20px;
    font-size: 13px;
    color: var(--gold);
  }

  /* ── ALERT TOAST ── */
  .toast {
    position: fixed;
    top: 80px;
    right: 24px;
    z-index: 999;
    padding: 14px 22px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 500;
    border: 1px solid;
    animation: toastIn 0.4s ease both, toastOut 0.4s ease 3s both;
    display: flex;
    align-items: center;
    gap: 10px;
    box-shadow: 0 8px 28px rgba(0,0,0,0.4);
  }
  .toast.success { background: rgba(58,184,100,0.12); border-color: rgba(58,184,100,0.3); color: #6ee8a0; }
  .toast.info    { background: rgba(58,184,196,0.12); border-color: rgba(58,184,196,0.3); color: #7de6ef; }
  .toast.danger  { background: rgba(224,85,85,0.12);  border-color: rgba(224,85,85,0.3);  color: #f79a9a; }

  @keyframes toastIn  { from { opacity:0; transform:translateX(20px); } to { opacity:1; transform:translateX(0); } }
  @keyframes toastOut { from { opacity:1; } to { opacity:0; } }

  /* ── EDIT FORM ── */
  .edit-panel {
    background: var(--navy-mid);
    border: 1px solid rgba(201,168,76,0.25);
    border-radius: 16px;
    padding: 28px 32px;
    margin-bottom: 28px;
    animation: fadeSlideUp 0.5s ease both;
  }

  .edit-panel h4 {
    font-family: 'Playfair Display', serif;
    font-size: 17px;
    color: var(--gold);
    margin-bottom: 20px;
    padding-bottom: 12px;
    border-bottom: 1px solid rgba(201,168,76,0.12);
  }

  .edit-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 14px;
    align-items: end;
  }

  .edit-field label {
    display: block;
    font-size: 10px;
    letter-spacing: 1.2px;
    text-transform: uppercase;
    color: var(--gold);
    margin-bottom: 7px;
  }

  .edit-field input,
  .edit-field select {
    width: 100%;
    padding: 10px 13px;
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(201,168,76,0.2);
    border-radius: 8px;
    color: var(--white);
    font-family: 'DM Sans', sans-serif;
    font-size: 13px;
    outline: none;
    transition: border-color 0.2s;
    -webkit-appearance: none;
  }

  .edit-field input:focus,
  .edit-field select:focus {
    border-color: var(--gold);
    background: rgba(201,168,76,0.05);
  }

  .edit-field select option { background: var(--navy-mid); }

  .btn-update {
    padding: 10px 22px;
    background: linear-gradient(135deg, var(--gold), #a8762a);
    color: var(--navy);
    border: none;
    border-radius: 8px;
    font-family: 'DM Sans', sans-serif;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    white-space: nowrap;
    transition: transform 0.15s, box-shadow 0.15s;
    height: 40px;
  }
  .btn-update:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(201,168,76,0.3);
  }

  /* ── TABLE ── */
  .table-wrapper {
    background: var(--navy-mid);
    border: 1px solid rgba(201,168,76,0.12);
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0,0,0,0.4);
    animation: fadeSlideUp 0.6s ease 0.1s both;
  }

  table {
    width: 100%;
    border-collapse: collapse;
  }

  thead th {
    padding: 16px 20px;
    text-align: left;
    font-size: 10px;
    letter-spacing: 1.4px;
    text-transform: uppercase;
    color: var(--gold);
    background: rgba(201,168,76,0.07);
    border-bottom: 1px solid rgba(201,168,76,0.15);
    font-weight: 500;
  }

  tbody tr {
    border-bottom: 1px solid rgba(255,255,255,0.04);
    transition: background 0.2s;
  }

  tbody tr:last-child { border-bottom: none; }
  tbody tr:hover { background: rgba(201,168,76,0.04); }

  tbody td {
    padding: 15px 20px;
    font-size: 14px;
    color: #c8d5e8;
    vertical-align: middle;
  }

  .td-index {
    font-family: 'Playfair Display', serif;
    color: rgba(201,168,76,0.5);
    font-size: 13px;
    width: 50px;
  }

  .td-name { font-weight: 500; color: var(--white); }

  .td-regno {
    font-size: 12px;
    color: var(--text-muted);
    font-family: monospace;
    letter-spacing: 0.5px;
  }

  .course-pill {
    display: inline-block;
    padding: 4px 11px;
    background: rgba(58,184,196,0.1);
    border: 1px solid rgba(58,184,196,0.2);
    border-radius: 50px;
    font-size: 11px;
    color: var(--teal);
    letter-spacing: 0.3px;
  }

  .action-btns {
    display: flex;
    gap: 8px;
  }

  .btn-edit, .btn-delete {
    padding: 7px 16px;
    border-radius: 7px;
    font-size: 12px;
    font-family: 'DM Sans', sans-serif;
    font-weight: 500;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    transition: transform 0.15s, box-shadow 0.15s;
    cursor: pointer;
    border: none;
  }
  .btn-edit {
    background: rgba(58,184,196,0.12);
    border: 1px solid rgba(58,184,196,0.3);
    color: var(--teal);
  }
  .btn-edit:hover {
    background: rgba(58,184,196,0.22);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(58,184,196,0.2);
  }
  .btn-delete {
    background: rgba(224,85,85,0.1);
    border: 1px solid rgba(224,85,85,0.25);
    color: var(--danger);
  }
  .btn-delete:hover {
    background: rgba(224,85,85,0.2);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(224,85,85,0.2);
  }

  /* Empty state */
  .empty-state {
    text-align: center;
    padding: 70px 20px;
    color: var(--text-muted);
  }
  .empty-state .icon { font-size: 40px; margin-bottom: 14px; opacity: 0.4; }
  .empty-state p { font-size: 14px; }

  @media (max-width: 768px) {
    header { padding: 14px 18px; }
    .header-badge { display: none; }
    .page-header { flex-direction: column; align-items: flex-start; gap: 12px; }
    .edit-grid { grid-template-columns: 1fr 1fr; }
  }
</style>
</head>
<body>

<header>
  <div class="logo">
    <div class="logo-icon">✦</div>
    <div class="logo-text">Edu<span>Portal</span></div>
  </div>
  <div class="header-right">
    <div class="header-badge">Academic Year 2024 – 25</div>
    <a href="form.php" class="btn-back">← Registration</a>
  </div>
</header>

<?php
// Toast alerts
if(isset($_GET['status'])){
    $s = $_GET['status'];
    if($s === 'added')   echo '<div class="toast success">✦ Student registered successfully</div>';
    if($s === 'updated') echo '<div class="toast info">✎ Student record updated</div>';
    if($s === 'deleted') echo '<div class="toast danger">✕ Student removed from records</div>';
}
?>

<div class="page-content">

  <div class="page-header">
    <div>
      <div class="page-title">Student <span>Directory</span></div>
      <div class="page-subtitle">Enrolled student records for the current session</div>
    </div>
    <div class="count-badge"><?php echo count($students); ?> Enrolled</div>
  </div>

  <!-- EDIT PANEL -->
  <?php if(isset($_GET['edit'])): 
    $id = $_GET['edit'];
    if(isset($students[$id])):
      $d = explode(",", $students[$id]);
  ?>
  <div class="edit-panel">
    <h4>✎ Edit Student Record</h4>
    <form method="POST">
      <input type="hidden" name="id" value="<?php echo $id; ?>">
      <div class="edit-grid">
        <div class="edit-field">
          <label>Full Name</label>
          <input type="text" name="name" value="<?php echo htmlspecialchars($d[0]); ?>">
        </div>
        <div class="edit-field">
          <label>Registration No.</label>
          <input type="text" name="regno" value="<?php echo htmlspecialchars($d[1]); ?>">
        </div>
        <div class="edit-field">
          <label>Email</label>
          <input type="email" name="email" value="<?php echo htmlspecialchars($d[2]); ?>">
        </div>
        <div class="edit-field">
          <label>Program</label>
          <select name="course">
            <?php
              $courses = ['Computer Science','Software Engineering','Information Technology','Artificial Intelligence'];
              foreach($courses as $c){
                $sel = (trim($d[3])==$c) ? 'selected' : '';
                echo "<option $sel>$c</option>";
              }
            ?>
          </select>
        </div>
        <div class="edit-field">
          <label>&nbsp;</label>
          <button name="update" class="btn-update">Save Changes</button>
        </div>
      </div>
    </form>
  </div>
  <?php endif; endif; ?>

  <!-- TABLE -->
  <div class="table-wrapper">
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Reg No.</th>
          <th>Email</th>
          <th>Program</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
      <?php if(empty($students)): ?>
        <tr><td colspan="6">
          <div class="empty-state">
            <div class="icon">✦</div>
            <p>No students registered yet. <a href="form.php" style="color:var(--gold);text-decoration:none;">Register the first student →</a></p>
          </div>
        </td></tr>
      <?php else: ?>
        <?php foreach($students as $index => $line):
          $d = explode(",", $line);
        ?>
        <tr>
          <td class="td-index"><?php echo $index+1; ?></td>
          <td class="td-name"><?php echo htmlspecialchars($d[0]); ?></td>
          <td class="td-regno"><?php echo htmlspecialchars($d[1]); ?></td>
          <td><?php echo htmlspecialchars($d[2]); ?></td>
          <td><span class="course-pill"><?php echo htmlspecialchars($d[3]); ?></span></td>
          <td>
            <div class="action-btns">
              <a class="btn-edit" href="students.php?edit=<?php echo $index; ?>">✎ Edit</a>
              <a class="btn-delete"
                 href="students.php?delete=<?php echo $index; ?>"
                 onclick="return confirm('Remove this student from records?')">✕ Delete</a>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
      <?php endif; ?>
      </tbody>
    </table>
  </div>

</div>

</body>
</html>