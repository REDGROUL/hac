<?
$css = $_SERVER['SERVER_NAME'].'/src/views/css/style.css';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?=$css?>">
    <link rel="stylesheet" href="../src/views/css/bootstrap.css">
    <link rel="stylesheet" href="../src/views/css/style.css">
    <script src="../src/views/js/login.js"></script>
    <script src="../src/views/js/bootstrap.js"></script>
    <script src="../src/views/js/bootstrap.bundle.js"></script>
    <script src="../src/views/js/scrept.js"></script>
    <title><?php echo e($title); ?></title>
</head>
<body>

<?if(@$navbar_show != false){?>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Features</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Pricing</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Dropdown link
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<?}?>
<?php /**PATH C:\OSPanel\domains\hac2\src\views/header.blade.php ENDPATH**/ ?>