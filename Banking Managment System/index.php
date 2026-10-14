<?php
// Public landing page for the project. Peeks at each portal's own session (read-only)
// so signed-in visitors get "Open dashboard" instead of "Sign in".
function portal_active($sessName, $key)
{
    if (empty($_COOKIE[$sessName]) || !preg_match('/^[A-Za-z0-9,-]{1,128}$/', $_COOKIE[$sessName])) { return false; }
    session_name($sessName);
    session_id($_COOKIE[$sessName]);
    @session_start();
    $ok = !empty($_SESSION[$key]);
    session_write_close();
    return $ok;
}

$portals = [
    ['Admin', 'The single master administrator. Reviews join applications, manages staff and customers, assigns work, posts news and oversees every transaction and activity.',
        '/Admin/View/adminlogin.php', '/Admin/View/adminhomepage.php', portal_active('ADMINSESSID', 'admin_id')],
    ['Manager', 'Approved by the admin. Oversees employees, transfers funds and follows the tasks and announcements sent by the admin.',
        '/Manager/view/managerlogin.php', '/Manager/view/managerHomePage.php', portal_active('MANAGERSESSID', 'username')],
    ['Employee', 'Approved by the admin. Serves customers, looks up accounts, handles queries and completes assigned work.',
        '/Employee/view/employelogin.php', '/Employee/view/epage1.php', portal_active('EMPLOYEESESSID', 'username')],
    ['Customer', 'Checks balances, sends money with a PIN, saves payees, downloads statements and gets transfer alerts.',
        '/User/View/login.php', '/User/View/dashboard.php', portal_active('CUSTOMERSESSID', 'cust_id')],
];
$features = [
    ['Role-based access', 'Four separate portals with their own sign-in and session, so one role can never open another role\'s pages.'],
    ['Admin approval workflow', 'Managers and employees apply to join. The admin reads each application in full, approves or rejects it, and leaves a note.'],
    ['Safe money transfers', 'Transfers run in a single database transaction with per-account balances, PIN confirmation and overdraft protection.'],
    ['Full visibility', 'A system dashboard and an activity log show sign-ins, approvals, role changes, transfers and news across the whole bank.'],
    ['Tasks and announcements', 'The admin assigns work to managers and employees and posts news to everyone, or to one audience.'],
    ['Customer self-service', 'Statements with filters and CSV export, saved payees, alerts, and password and PIN changes.'],
];
$stack = ['PHP 8', 'MySQL', 'Apache', 'JavaScript + AJAX', 'Docker', 'Layered architecture'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banking Management System</title>
    <meta name="description" content="A role-based web banking system built with PHP and MySQL: Admin, Manager, Employee and Customer portals.">
    <link rel="stylesheet" href="/assets/theme.css">
</head>
<body>
<header class="topbar">
    <a class="brand" href="/"><img src="/Admin/Image/banklogo.png" alt="">Banking Management System</a>
    <input type="checkbox" id="nav-toggle" class="nav-toggle">
    <label for="nav-toggle" class="hamburger" aria-label="Menu">&#9776;</label>
    <nav>
        <a href="#portals">Portals</a>
        <a href="#features">Features</a>
        <a href="#how">How it works</a>
        <a href="#demo">Demo</a>
        <a href="/Admin/View/News.php">News</a>
    </nav>
</header>

<main class="page">
    <section class="hero landing-hero">
        <p class="eyebrow">Academic course project · AIUB · CSC3215 Web Technologies</p>
        <h1>Banking Management System</h1>
        <p class="lead">A role-based web banking application. An admin governs the system, managers and employees run it, and customers bank online.</p>
        <div class="cta">
            <a class="btn" href="#portals">Choose a portal</a>
            <a class="btn btn-ghost" href="https://github.com/aftabrakinsad/Banking-Managment-System" target="_blank" rel="noopener">View source on GitHub</a>
        </div>
    </section>

    <h2 id="portals" class="section-title">Sign in to your portal</h2>
    <section class="grid portals">
    <?php foreach ($portals as $p) { ?>
        <div class="card portal-card">
            <h3><?php echo htmlspecialchars($p[0]); ?></h3>
            <p class="muted"><?php echo htmlspecialchars($p[1]); ?></p>
            <?php if ($p[4]) { ?>
                <a class="btn" href="<?php echo $p[3]; ?>">Open dashboard</a>
                <span class="muted small">You are signed in</span>
            <?php } else { ?>
                <a class="btn" href="<?php echo $p[2]; ?>">Sign in as <?php echo htmlspecialchars(strtolower($p[0])); ?></a>
            <?php } ?>
        </div>
    <?php } ?>
    </section>

    <h2 id="features" class="section-title">What it does</h2>
    <section class="grid features">
    <?php foreach ($features as $f) { ?>
        <div class="card"><h3><?php echo htmlspecialchars($f[0]); ?></h3><p class="muted"><?php echo htmlspecialchars($f[1]); ?></p></div>
    <?php } ?>
    </section>

    <h2 id="how" class="section-title">How it works</h2>
    <ol class="steps">
        <li><strong>Apply.</strong> Managers and employees register an application with their details and documents.</li>
        <li><strong>Review.</strong> The admin opens each application, reads it in full and approves or rejects it.</li>
        <li><strong>Operate.</strong> Approved staff sign in, receive tasks and news, and serve customers.</li>
        <li><strong>Oversee.</strong> The admin sees every transaction and event in one place.</li>
    </ol>

    <h2 class="section-title">Built with</h2>
    <p class="chips"><?php foreach ($stack as $s) { echo '<span class="chip">' . htmlspecialchars($s) . '</span>'; } ?></p>

    <h2 id="demo" class="section-title">Try the demo</h2>
    <section class="card">
        <p class="muted">This site runs on sample data. Every demo account uses the password <code>Demo@1234</code>.</p>
        <div class="table-wrap"><table>
            <thead><tr><th>Portal</th><th>Username</th><th>Extra</th></tr></thead>
            <tbody>
                <tr><td>Admin</td><td><code>admin</code></td><td>Has pending applications to review</td></tr>
                <tr><td>Manager</td><td><code>manager</code></td><td></td></tr>
                <tr><td>Employee</td><td><code>employee</code></td><td></td></tr>
                <tr><td>Customer</td><td><code>casey</code> or <code>riley</code></td><td>Transfer PINs: 1111 and 2222</td></tr>
            </tbody>
        </table></div>
    </section>
</main>
<footer class="footer">Academic course project · Banking Management System · AIUB, CSC3215 Web Technologies</footer>
</body>
</html>
