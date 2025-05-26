g<?php
session_start();
include_once("includes/dbconn.php");

if (!isset($_SESSION['admin_id']) && !isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['admin_login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Note: Update this to use password_verify() for security
        $query = "SELECT id FROM users WHERE is_admin = 1 AND username = ? AND password = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ss', $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $admin = $result->fetch_assoc();
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['is_admin'] = 1;
        } else {
            $login_error = "<p class='message error'>Invalid username or password!</p>";
        }
        $stmt->close();
    }
    if (!isset($_SESSION['admin_id'])) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Admin Login</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
            <link href='//fonts.googleapis.com/css?family=Oswald:300,400,700' rel='stylesheet' type='text/css'>
            <link href='//fonts.googleapis.com/css?family=Ubuntu:300,400,500,700' rel='stylesheet' type='text/css'>
            <style>
                body {
                    margin: 0;
                    font-family: 'Ubuntu', sans-serif;
                    background: linear-gradient(45deg, #c32143, #f1b458, #c32143, #f1b458);
                    background-size: 400% 400%;
                    animation: gradient 15s ease infinite;
                    color: #333;
                    background-image: url('images/pic1.avif');
                    background-repeat: no-repeat;
                    background-size: cover;
                    background-position: center center;
                }
                @keyframes gradient {
                    0% { background-position: 0% 50%; }
                    50% { background-position: 100% 50%; }
                    100% { background-position: 0% 50%; }
                }
                .navbar {
                    background-color: rgba(0, 0, 0, 0.7);
                    font-family: 'Ubuntu', sans-serif;
                }
                .navbar-brand {
                    font-family: 'Oswald', sans-serif;
                    font-size: 1.8em;
                    color: rgb(240, 63, 23) !important;
                    transition: color 0.3s ease;
                }
                .navbar-brand:hover {
                    color: #c32143 !important;
                }
                .navbar-nav .nav-link {
                    color: #fff !important;
                    font-size: 1.1em;
                    margin-left: 1em;
                    transition: color 0.3s ease;
                }
                .navbar-nav .nav-link:hover {
                    color: #f1b458 !important;
                }
                .navbar-toggler {
                    border-color: #f1b458;
                }
                .navbar-toggler-icon {
                    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(241, 180, 88, 1)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
                }
                .dropdown-menu {
                    background-color: #333;
                    border: none;
                    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
                }
                .dropdown-menu li a {
                    color: #fff;
                    padding: 10px 20px;
                    font-size: 1em;
                }
                .dropdown-menu li a:hover {
                    background-color: #f1b458;
                    color: #333;
                }
                .login-section {
                    padding: 3em 0;
                    background-color: rgba(255, 255, 255, 0.9);
                    text-align: center;
                }
                .login-section h1 {
                    color: #c32143;
                    font-size: 2.5em;
                    margin-bottom: 1em;
                    font-family: 'Oswald', sans-serif;
                }
                .login-form {
                    max-width: 500px;
                    margin: 0 auto;
                }
                .form-control {
                    border-radius: 5px;
                    border: 1px solid #ccc;
                    padding: 0.8em;
                    font-size: 1em;
                    background-color: #f9f9f9;
                }
                .form-control:focus {
                    border-color: #f1b458;
                    box-shadow: 0 0 5px rgba(241, 180, 88, 0.5);
                }
                .btn-submit {
                    background-color: #c32143;
                    color: #fff;
                    padding: 0.8em 1.5em;
                    border: none;
                    border-radius: 5px;
                    font-size: 1em;
                    cursor: pointer;
                    transition: background-color 0.3s ease;
                }
                .btn-submit:hover {
                    background-color: #f1b458;
                    color: #333;
                }
                .message.error {
                    color: red;
                    background-color: #ffe0e0;
                    padding: 10px;
                    border-radius: 5px;
                    margin-bottom: 1em;
                }
                .footer {
                    background-color: #333;
                    color: #fff;
                    padding: 2em 0;
                    font-size: 0.9em;
                }
                .footer .container {
                    max-width: 1200px;
                    margin: 0 auto;
                    padding: 0 15px;
                }
                .footer h4 {
                    color: #f1b458;
                    font-size: 1.2em;
                    margin-bottom: 1em;
                    font-family: 'Oswald', sans-serif;
                }
                .footer p {
                    font-size: 0.9em;
                    line-height: 1.6;
                    color: #ccc;
                }
                .footer_links, .footer_social {
                    list-style: none;
                    padding: 0;
                }
                .footer_links li, .footer_social li {
                    margin-bottom: 0.5em;
                }
                .footer_links li a, .footer_social li a {
                    color: #fff;
                    text-decoration: none;
                    font-size: 0.9em;
                    transition: color 0.3s ease;
                }
                .footer_links li a:hover, .footer_social li a:hover {
                    color: #f1b458;
                }
                .footer_social .fa {
                    font-size: 1.2em;
                    margin-right: 0.5em;
                }
                .copy {
                    text-align: center;
                    margin-top: 2em;
                    padding-top: 1em;
                    border-top: 1px solid #555;
                }
                .copy p {
                    margin: 0;
                    color: #ccc;
                }
                .copy a {
                    color: #f1b458;
                    text-decoration: none;
                }
                .copy a:hover {
                    color: #c32143;
                }
                .clearfix {
                    clear: both;
                }
                @media (max-width: 768px) {
                    .login-section { padding: 2em 0; }
                    .login-section h1 { font-size: 2em; }
                    .login-form { padding: 0 1em; }
                    .navbar-nav { text-align: center; }
                    .navbar-nav .nav-link { margin: 0.5em 0; }
                    .dropdown-menu { text-align: center; }
                    .footer .col-md-4, .footer .col-md-2 { margin-bottom: 1.5em; text-align: center; }
                    .footer_social { display: flex; justify-content: center; gap: 1em; }
                }
            </style>
        </head>
        <body>
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <a class="navbar-brand" href="index.php">MatchMingle</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                        <ul class="nav navbar-nav">
                            <li class="nav-item"><a class="nav-link" href="index.php"><i class="fa fa-home"></i> Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="about.php"><i class="fa fa-info-circle"></i> About</a></li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-search"></i> Search
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="search.php">Regular Search</a></li>
                                    <li><a class="dropdown-item" href="search-id.php">Search By Profile ID</a></li>
                                    <li><a class="dropdown-item" href="faq.php">Faq</a></li>
                                </ul>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="contact.php"><i class="fa fa-envelope"></i> Contacts</a></li>
                            <?php if (isset($_SESSION['id'])) {
                                echo "<li class='nav-item'><a class='nav-link' href='userhome.php?id=" . $_SESSION['id'] . "'><i class='fa fa-user'></i> Profile</a></li>";
                                echo "<li class='nav-item'><a class='nav-link' href='logout.php'><i class='fa fa-sign-out'></i> Logout</a></li>";
                            } else {
                                echo "<li class='nav-item'><a class='nav-link' href='login.php'><i class='fa fa-sign-in'></i> Login</a></li>";
                                echo "<li class='nav-item'><a class='nav-link' href='register.php'><i class='fa fa-user-plus'></i> Register</a></li>";
                            } ?>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="login-section">
                <h1>Admin Login</h1>
                <?php if (isset($login_error)) echo $login_error; ?>
                <div class="login-form">
                    <form method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                            <input type="text" id="username" name="username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" name="admin_login" class="btn-submit">Login</button>
                    </form>
                </div>
            </div>
            <div class="footer">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 col_2">
                            <h4>About Us</h4>
                            <p>MatchMingle is a trusted matrimony platform helping individuals find meaningful and lasting relationships. We connect verified profiles from diverse backgrounds to make partner search easy, safe, and efficient. Our goal is to simplify matchmaking using smart tools and a secure environment. Whether you're looking for love or a life partner, we're here to support your journey. Join MatchMingle — where meaningful connections begin.</p>
                        </div>
                        <div class="col-md-2 col_2">
                            <h4>Help & Support</h4>
                            <ul class="footer_links">
                                <li><a href="#">24x7 Live help</a></li>
                                <li><a href="contact.php">Contact us</a></li>
                                <li><a href="#">Feedback</a></li>
                                <li><a href="faq.php">FAQs</a></li>
                            </ul>
                        </div>
                        <div class="col-md-2 col_2">
                            <h4>Quick Links</h4>
                            <ul class="footer_links">
                                <li><a href="privacy.php">Privacy Policy</a></li>
                                <li><a href="terms.php">Terms and Conditions</a></li>
                                <li><a href="services.php">Services</a></li>
                            </ul>
                        </div>
                        <div class="col-md-2 col_2">
                            <h4>Social</h4>
                            <ul class="footer_social">
                                <li><a href="#"><i class="fa fa-facebook fa1"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter fa1"></i></a></li>
                                <li><a href="#"><i class="fa fa-google-plus fa1"></i></a></li>
                                <li><a href="#"><i class="fa fa-youtube fa1"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="copy">
                        <p>Copyright © 2025 Marital. All Rights Reserved | Design by <a href="#">Team NBP</a></p>
                    </div>
                </div>
            </div>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        </body>
        </html>
        <?php
        exit();
    }
}

if (isset($_GET['action']) && isset($_GET['request_id'])) {
    $requestId = intval($_GET['request_id']);
    $action = $_GET['action'];

    if ($action === 'approve') {
        $query = "SELECT user_id, plan_type FROM payment_requests WHERE id = ? AND status = 'pending'";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $requestId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $request = $result->fetch_assoc();
            $expiryDate = date('Y-m-d', strtotime('+1 month'));
            $updateQuery = "UPDATE payment_requests SET status = 'approved' WHERE id = ?";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param('i', $requestId);
            $updateStmt->execute();

            $userUpdateQuery = "UPDATE users SET plan_type = ?, subscription_status = 'active', subscription_expiry = ? WHERE id = ?";
            $userStmt = $conn->prepare($userUpdateQuery);
            $userStmt->bind_param('ssi', $request['plan_type'], $expiryDate, $request['user_id']);
            $userStmt->execute();

            $success = "<p class='message error' style='background-color: #d4edda; color: #155724;'>Payment request approved successfully!</p>";
        }
        $stmt->close();
    } elseif ($action === 'reject') {
        $query = "UPDATE payment_requests SET status = 'rejected' WHERE id = ? AND status = 'pending'";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $requestId);
        $stmt->execute();
        $success = "<p class='message error' style='background-color: #ffe0e0; color: red;'>Payment request rejected.</p>";
        $stmt->close();
    }
}

// Fetch pending payment requests
$query = "SELECT pr.id, u.username, pr.plan_type, pr.bkash_number, pr.transaction_id, pr.amount, pr.status, pr.created_at FROM payment_requests pr JOIN users u ON pr.user_id = u.id WHERE pr.status = 'pending'";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Payment Requests</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='//fonts.googleapis.com/css?family=Oswald:300,400,700' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Ubuntu:300,400,500,700' rel='stylesheet' type='text/css'>
    <style>
        body {
            margin: 0;
            font-family: 'Ubuntu', sans-serif;
            background: linear-gradient(45deg, #c32143, #f1b458, #c32143, #f1b458);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
            color: #333;
            background-image: url('images/pic1.avif');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;
        }
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .navbar {
            background-color: rgba(0, 0, 0, 0.7);
            font-family: 'Ubuntu', sans-serif;
        }
        .navbar-brand {
            font-family: 'Oswald', sans-serif;
            font-size: 1.8em;
            color: rgb(240, 63, 23) !important;
            transition: color 0.3s ease;
        }
        .navbar-brand:hover {
            color: #c32143 !important;
        }
        .navbar-nav .nav-link {
            color: #fff !important;
            font-size: 1.1em;
            margin-left: 1em;
            transition: color 0.3s ease;
        }
        .navbar-nav .nav-link:hover {
            color: #f1b458 !important;
        }
        .navbar-toggler {
            border-color: #f1b458;
        }
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(241, 180, 88, 1)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        .dropdown-menu {
            background-color: #333;
            border: none;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
        .dropdown-menu li a {
            color: #fff;
            padding: 10px 20px;
            font-size: 1em;
        }
        .dropdown-menu li a:hover {
            background-color: #f1b458;
            color: #333;
        }
        .admin-section {
            padding: 3em 0;
            background-color: rgba(255, 255, 255, 0.9);
            text-align: center;
        }
        .admin-section h1 {
            color: #c32143;
            font-size: 2.5em;
            margin-bottom: 1.5em;
            font-family: 'Oswald', sans-serif;
        }
        .table-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 0 1em;
        }
        .table {
            width: 100%;
            margin-bottom: 0;
        }
        .table th, .table td {
            text-align: center;
            vertical-align: middle;
            padding: 1em;
        }
        .actions-cell a {
            display: block;
            margin: 0.5em 0;
            width: 80%;
            margin-left: auto;
            margin-right: auto;
        }
        .form-control {
            border-radius: 5px;
            border: 1px solid #ccc;
            padding: 0.8em;
            font-size: 1em;
            background-color: #f9f9f9;
        }
        .btn-submit, .btn-reject {
            background-color: #c32143;
            color: #fff;
            padding: 0.8em 1.5em;
            border: none;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        .btn-reject {
            background-color: #dc3545;
        }
        .btn-submit:hover, .btn-reject:hover {
            background-color: #f1b458;
            color: #333;
        }
        .message.error {
            color: red;
            background-color: #ffe0e0;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 1em;
            display: inline-block;
        }
        .message.success {
            color: #155724;
            background-color: #d4edda;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 1em;
            display: inline-block;
        }
        .footer {
            background-color: #333;
            color: #fff;
            padding: 2em 0;
            font-size: 0.9em;
        }
        .footer .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }
        .footer h4 {
            color: #f1b458;
            font-size: 1.2em;
            margin-bottom: 1em;
            font-family: 'Oswald', sans-serif;
        }
        .footer p {
            font-size: 0.9em;
            line-height: 1.6;
            color: #ccc;
        }
        .footer_links, .footer_social {
            list-style: none;
            padding: 0;
        }
        .footer_links li, .footer_social li {
            margin-bottom: 0.5em;
        }
        .footer_links li a, .footer_social li a {
            color: #fff;
            text-decoration: none;
            font-size: 0.9em;
            transition: color 0.3s ease;
        }
        .footer_links li a:hover, .footer_social li a:hover {
            color: #f1b458;
        }
        .footer_social .fa {
            font-size: 1.2em;
            margin-right: 0.5em;
        }
        .copy {
            text-align: center;
            margin-top: 2em;
            padding-top: 1em;
            border-top: 1px solid #555;
        }
        .copy p {
            margin: 0;
            color: #ccc;
        }
        .copy a {
            color: #f1b458;
            text-decoration: none;
        }
        .copy a:hover {
            color: #c32143;
        }
        .clearfix {
            clear: both;
        }
        @media (max-width: 768px) {
            .admin-section { padding: 2em 0; }
            .admin-section h1 { font-size: 2em; }
            .table-container { padding: 0; }
            .actions-cell a { margin: 0.3em 0; width: 90%; }
            .navbar-nav { text-align: center; }
            .navbar-nav .nav-link { margin: 0.5em 0; }
            .dropdown-menu { text-align: center; }
            .footer .col-md-4, .footer .col-md-2 { margin-bottom: 1.5em; text-align: center; }
            .footer_social { display: flex; justify-content: center; gap: 1em; }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">MatchMingle</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="nav navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="index.php"><i class="fa fa-home"></i> Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php"><i class="fa fa-info-circle"></i> About</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-search"></i> Search
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="search.php">Regular Search</a></li>
                            <li><a class="dropdown-item" href="search-id.php">Search By Profile ID</a></li>
                            <li><a class="dropdown-item" href="faq.php">Faq</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="contact.php"><i class="fa fa-envelope"></i> Contacts</a></li>
                    <?php if (isset($_SESSION['id'])) {
                        echo "<li class='nav-item'><a class='nav-link' href='userhome.php?id=" . $_SESSION['id'] . "'><i class='fa fa-user'></i> Profile</a></li>";
                        echo "<li class='nav-item'><a class='nav-link' href='logout.php'><i class='fa fa-sign-out'></i> Logout</a></li>";
                    } else {
                        echo "<li class='nav-item'><a class='nav-link' href='login.php'><i class='fa fa-sign-in'></i> Login</a></li>";
                        echo "<li class='nav-item'><a class='nav-link' href='register.php'><i class='fa fa-user-plus'></i> Register</a></li>";
                    } ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="admin-section">
        <h1>Admin Panel - Payment Requests</h1>
        <?php if (isset($success)) echo $success; ?>
        <div class="table-container">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Plan</th>
                        <th>bKash Number</th>
                        <th>Transaction ID</th>
                        <th>Amount (BDT)</th>
                        <th>Requested At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['username']; ?></td>
                            <td><?php echo ucfirst($row['plan_type']); ?> Plan</td>
                            <td><?php echo $row['bkash_number']; ?></td>
                            <td><?php echo $row['transaction_id']; ?></td>
                            <td><?php echo $row['amount']; ?></td>
                            <td><?php echo $row['created_at']; ?></td>
                            <td class="actions-cell">
                                <a href="?action=approve&request_id=<?php echo $row['id']; ?>" class="btn-submit">Approve</a>
                                <a href="?action=reject&request_id=<?php echo $row['id']; ?>" class="btn-reject">Reject</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col_2">
                    <h4>About Us</h4>
                    <p>MatchMingle is a trusted matrimony platform helping individuals find meaningful and lasting relationships. We connect verified profiles from diverse backgrounds to make partner search easy, safe, and efficient. Our goal is to simplify matchmaking using smart tools and a secure environment. Whether you're looking for love or a life partner, we're here to support your journey. Join MatchMingle — where meaningful connections begin.</p>
                </div>
                <div class="col-md-2 col_2">
                    <h4>Help & Support</h4>
                    <ul class="footer_links">
                        <li><a href="#">24x7 Live help</a></li>
                        <li><a href="contact.php">Contact us</a></li>
                        <li><a href="#">Feedback</a></li>
                        <li><a href="faq.php">FAQs</a></li>
                    </ul>
                </div>
                <div class="col-md-2 col_2">
                    <h4>Quick Links</h4>
                    <ul class="footer_links">
                        <li><a href="privacy.php">Privacy Policy</a></li>
                        <li><a href="terms.php">Terms and Conditions</a></li>
                        <li><a href="services.php">Services</a></li>
                    </ul>
                </div>
                <div class="col-md-2 col_2">
                    <h4>Social</h4>
                    <ul class="footer_social">
                        <li><a href="#"><i class="fa fa-facebook fa1"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter fa1"></i></a></li>
                        <li><a href="#"><i class="fa fa-google-plus fa1"></i></a></li>
                        <li><a href="#"><i class="fa fa-youtube fa1"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="copy">
                <p>Copyright © 2025 Marital. All Rights Reserved | Design by <a href="#">Team NBP</a></p>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
