<?php include_once("functions.php");?>
<?php
session_start();

include_once("includes/dbconn.php");

$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($email) || empty($password)) {
        $message = "<p style='color: red; text-align: center;'>Username, email, and password are required!</p>";
    } else {
        $sql = "SELECT id, password FROM users WHERE username = ? AND email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $username, $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['id'] = $user['id'];
            error_log("Login successful, session ID set: " . $_SESSION['id']);
            header("Location: userhome.php?id=" . $user['id']);
            exit();
        } else {
            $message = "<p style='color: red; text-align: center;'>Invalid username, email, or password!</p>";
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
}
?>

<!DOCTYPE HTML>
<html>
<head>
<title>Makemy Love</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

<link href="css/bootstrap-3.1.1.min.css" rel='stylesheet' type='text/css' />
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link href='//fonts.googleapis.com/css?family=Oswald:300,400,700' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Ubuntu:300,400,500,700' rel='stylesheet' type='text/css'>
<link href="css/font-awesome.css" rel="stylesheet">
<style>
body {
    background-image: url('images/coverrr.webp');
    background-size: contain;
    background-repeat: no-repeat;
    background-position: center center;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center top;
}

.breadcrumb1 {
    background-color: rgba(247, 246, 250, 0.98);
    padding: 10px;
    border-radius: 2px;
}

.login_left {
    background-color: rgba(228, 156, 156, 0.8);
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 10px;
}

.login_left label {
    color: #333;
}

.login_left input[type="text"],
.login_left input[type="email"],
.login_left input[type="password"] {
    padding: 0.8em;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f9f9f9;
}

.login_left .btn_1 {
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
    cursor: pointer;
    font-size: 1em;
    transition: background-color 0.3s ease;
}

.login_left .btn_1:hover {
    background-color: #0056b3;
}

.sharing {
    background-color: rgba(228, 156, 156, 0.8);
    padding: 20px;
    border-radius: 10px;
}

.sharing li a {
    color: #fff;
}

.message {
    text-align: center;
    margin-bottom: 20px;
    padding: 10px;
    border-radius: 5px;
}
.message.error { color: red; background-color: #ffe0e0; }
</style>

<script>
$(document).ready(function(){
    $(".dropdown").hover(
        function() {
            $('.dropdown-menu', this).stop( true, true ).slideDown("fast");
            $(this).toggleClass('open');
        },
        function() {
            $('.dropdown-menu', this).stop( true, true ).slideUp("fast");
            $(this).toggleClass('open');
        }
    );
});
</script>
</head>
<body>
<?php include_once("includes/navigation.php");?>
<div class="grid_3">
  <div class="container">
   <div class="breadcrumb1">
      <ul>
         <a href="index.php"><i class="fa fa-home home_1"></i></a>
         <span class="divider"> | </span>
         <li class="current-page">Login</li>
      </ul>
   </div>
   <?php if (!empty($message)) echo $message; ?>
   <div class="services">
      <div class="col-sm-6 login_left">
       <form action="" method="post">
        <div class="form-item form-type-textfield form-item-name">
         <label for="edit-name">Username <span class="form-required" title="This field is required.">*</span></label>
         <input type="text" id="edit-name" name="username" value="" size="60" maxlength="60" class="form-text required">
        </div>
        <div class="form-item form-type-textfield form-item-email">
         <label for="edit-email">Email <span class="form-required" title="This field is required.">*</span></label>
         <input type="email" id="edit-email" name="email" value="" size="60" maxlength="255" class="form-text required">
        </div>
        <div class="form-item form-type-password form-item-pass">
         <label for="edit-pass">Password <span class="form-required" title="This field is required.">*</span></label>
         <input type="password" id="edit-pass" name="password" size="60" maxlength="128" class="form-text required">
        </div>
        <div class="form-actions">
          <input type="submit" id="edit-submit" name="op" value="Log in" class="btn_1 submit">
        </div>
       </form>
      </div>
      <div class="col-sm-6">
      <img src="images/images2.jpeg" alt="" style="max-height: 50px; width: auto; margin-right: 5px;">
    <ul class="sharing">
        <li><a href="#" class="facebook" title="Facebook"><i class="fa fa-boxed fa-fw fa-facebook"></i> Share on Facebook</a></li>
        <li><a href="#" class="twitter" title="Twitter"><i class="fa fa-boxed fa-fw fa-twitter"></i> Tweet</a></li>
        <li><a href="#" class="google" title="Google"><i class="fa fa-boxed fa-fw fa-google-plus"></i> Share on Google+</a></li>
        <li><a href="#" class="linkedin" title="Linkedin"><i class="fa fa-boxed fa-fw fa-linkedin"></i> Share on LinkedIn</a></li>
        <li><a href="#" class="mail" title="Email"><i class="fa fa-boxed fa-fw fa-envelope-o"></i> E-mail</a></li>
    </ul>
</div>
      <div class="clearfix"> </div>
   </div>
  </div>
</div>
<?php include_once("footer.php");?>
</body>
</html>
