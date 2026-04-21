<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submission Assignment</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar{
            background-color: #4c0f0f !important;
        }

        .main-card { 
            max-width: 600px; 
            margin: auto; 
            margin-top: 50px; 
            border-radius: 15px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            font-weight: bold;
            color: #fafafa !important;
        }

        .content {
            flex: 1;
            padding-bottom: 30px;
        }

        footer {
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 15px 0;
            margin-top: auto;
        }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">

        <!-- dynamic link ikut role -->
        <a class="navbar-brand" href="
        <?php
            if(isset($_SESSION['role'])){
                echo ($_SESSION['role'] == 'admin') ? '../admin/dashboard.php' : '../student/dashboard.php';
            } else {
                echo 'login.php';
            }
        ?>">
        📝 Submission Assignment
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav ms-auto">

                <?php if(isset($_SESSION['role'])): ?>

                    <!-- ADMIN MENU -->
                    <?php if($_SESSION['role'] == 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="../admin/dashboard.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../admin/create_assignment.php">Create Assignment</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../admin/view_submission.php">View Submissions</a>
                        </li>

                    <!-- STUDENT MENU -->
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="../student/dashboard.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../student/submit_assignment.php">Submit Assignment</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../student/my_submissions.php">My Submissions</a>
                        </li>
                    <?php endif; ?>

                    <!-- logout -->
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="../logout.php">Logout</a>
                    </li>

                <?php else: ?>

                    <!-- before login -->
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Register</a>
                    </li>

                <?php endif; ?>

            </ul>

        </div>
    </div>
</nav>

<div class="content">