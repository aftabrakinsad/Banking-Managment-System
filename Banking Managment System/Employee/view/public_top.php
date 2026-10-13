<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars(isset($pageTitle) ? $pageTitle : 'Employee', ENT_QUOTES, 'UTF-8'); ?> · Banking Management System</title>
    <link rel="stylesheet" href="/assets/theme.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
<header class="topbar">
    <a class="brand" href="/Admin/View/Home.php"><img src="/Admin/Image/banklogo.png" alt="">Banking Management System</a>
    <nav><a href="/Admin/View/Home.php">Home</a></nav>
</header>
<main class="page">
