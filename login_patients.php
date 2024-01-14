<?php
session_start();

$host = "localhost";
$port = "5432";
$dbname = "postgres";
$user = "postgres";
$password = "123456789";

$connect = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");
if (!$connect) {
    die("Не удалось подключиться к базе данных: " . pg_last_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Проверка почты и пароля пациента
    $query = "SELECT * FROM patients WHERE email = $1 AND password = $2";
    $stmt = pg_prepare($connect, "login_patients", $query);
    $result = pg_execute($connect, "login_patients", array($email, $password));
    
    $patient = pg_fetch_assoc($result);

    if ($patient) {
        // Установка сессии для пациента
        $_SESSION['patient'] = true;
        $_SESSION['patient_id'] = $patient['id'];

        // Перенаправление на страницу пациента
        header("Location: patient_page.php");
        exit;
    } else {
        // Данные неверны, выдача сообщения об ошибке или перенаправление на страницу с ошибкой
        echo "Неверная почта или пароль";
        // Или перенаправление на страницу с ошибкой:
        // header("Location: login_patients.php?error=1");
        // exit;
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet"type="text/css" href="CSS/regpat.css">
    <title>Вход для пользователя</title>
</head>
<body>
<div class="header"><h1>Поликлинника</h1></div>

<div class="wrapper">
    <h1>Вход для пользователя</h1>
    <form id="login-box" class="login-form" method="POST" action="login_patients.php">
        <input type="email" name="email" placeholder="Email" required>
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