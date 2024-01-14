<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['login'];
    $password = $_POST['password'];

    // Проверка логина и пароля администратора
    if ($login === 'admin' && $password === 'password') {
        // Данные верны, устанавливаем сессию для администратора
        $_SESSION['admin'] = true;

        // Перенаправляем на страницу администратора
        header("Location: admin_page.php");
        exit;
    } else {
        // Данные неверны, выдаем сообщение об ошибке или перенаправляем на страницу с ошибкой
        echo "Неверный логин или пароль";
        // Или перенаправление на страницу с ошибкой:
        // header("Location: login_admin.php?error=1");
        // exit;
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet"type="text/css" href="CSS/regpat.css">
    <title>Вход для администратора</title>
</head>
<body>
<div class="header"><h1>Поликлинника</h1></div>

<div class="wrapper">
    <h1>Вход для администратора</h1>
    <form id="login-box" class="login-form" method="POST" action="login_admin.php">
        <input type="text" name="login" placeholder="Логин" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit">Войти</button>
    </form>
</div>

<div class="footer">
    <div class="copyright">
        <p></p>
    </div>
</div>

</body>
</html>
