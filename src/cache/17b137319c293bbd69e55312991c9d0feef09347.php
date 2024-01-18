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
        <a class="navbar-brand" href="/tasks">Awesome Kanban</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="/tasks" class="nav-link active" aria-current="page" href="#">Канбан</a>
                </li>


                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Личные данные
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" id="userProfileLink">Профиль пользователя</a></li>
                        <li><a class="dropdown-item" href="/logout">Выход</a></li>
                    </ul>
                </li>


                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Админка
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/ref">Редактирование канбана</a></li>
                        <li><a class="dropdown-item" href="/newUser">Регистрация пользователя</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script>
    let elem = document.getElementById("userProfileLink");
    elem.href = '/profile/'+localStorage.getItem("uid");
    </script>
<?}?>
<?php /**PATH C:\OSPanel\domains\hac2\src\views/header.blade.php ENDPATH**/ ?>