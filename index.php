<?php
require_once __DIR__ . '/includes/bootstrap.php';

// Redirect if already logged in
if (Auth::isUserLoggedIn()) {
    header('Location: ' . APP_URL . '/user/dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email']    ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($email === '' || $password === '') {
        $error = 'Please fill in all fields.';
    } else {
        $userModel = new User();
        $user = $userModel->login($email, $password);

        if ($user) {
            Auth::loginUser($user);
            header('Location: ' . APP_URL . '/user/dashboard.php');
            exit;
        } else {
            $error = 'Invalid credentials or account not yet approved.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Login — <?= APP_NAME ?></title>

<link rel="stylesheet" href="<?= APP_URL ?>/assets/css/style.css">

<link rel="stylesheet" 
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">



</head>


<body>


<!-- Admin Login Top Right -->

<div class="top-admin">

<a href="<?= APP_URL ?>/admin/index.php">

<i class="fa-solid fa-user-shield"></i>

Admin Login

</a>

</div>



<div class="auth-wrapper">


<div class="auth-card">


<div class="brand">
    <h1>Faculty Directory</h1>
    <p class="brand-subtitle">University Notice Board System</p>
    <p class="login-subtitle">
        <i class="fas fa-lock"></i> Secure User Login
    </p>
</div>



<?php if ($error): ?>

<div class="alert alert-danger">
<?= htmlspecialchars($error) ?>
</div>

<?php endif; ?>




<form method="POST">


<div class="form-group">

<label>Email Address</label>

<input 
type="email"
name="email"
value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
placeholder="Enter email"
required>

</div>



<div class="form-group">

<label>Password</label>

<input 
type="password"
name="password"
placeholder="Enter password"
required>

</div>



<button class="btn-primary" style="width:100%">

<i class="fa-solid fa-right-to-bracket"></i>

Sign In

</button>


</form>







<!-- Demo Credentials -->

<div class="demo-box">

<div class="demo-title">
<i class="fa-solid fa-flask"></i>
DEMO ACCOUNTS
</div>


<!-- Teacher -->

<div class="demo-card">

<div class="demo-role teacher">
<i class="fa-solid fa-chalkboard-user"></i>
Teacher Account
</div>


<div class="credential">

<span id="teacher-email">
ahmed.raza@university.edu
</span>

<button class="copy-btn"
onclick="copyText('teacher-email',this)">
<i class="fa-regular fa-copy"></i>
</button>

</div>


<div class="credential">

<span id="teacher-pass">
user123
</span>

<button class="copy-btn"
onclick="copyText('teacher-pass',this)">
<i class="fa-regular fa-copy"></i>
</button>

</div>





</div>




<!-- Student -->

<div class="demo-card">


<div class="demo-role student">

<i class="fa-solid fa-user-graduate"></i>

Student Account

</div>


<div class="credential">

<span id="student-email">
ali.hassan@student.edu
</span>

<button class="copy-btn"
onclick="copyText('student-email',this)">
<i class="fa-regular fa-copy"></i>
</button>

</div>


<div class="credential">

<span id="student-pass">
user123
</span>

<button class="copy-btn"
onclick="copyText('student-pass',this)">
<i class="fa-regular fa-copy"></i>
</button>

</div>





</div>


</div>



<div class="auth-footer">

Don't have an account?

<a href="<?= APP_URL ?>/user/register.php">

Register here

</a>


</div>



</div>

</div>

<script src="<?= APP_URL ?>/assets/js/auth.js"></script>

</body>
</html>