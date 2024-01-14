<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet"type="text/css" href="CSS/regpat.css">
    <title>Добавить пациента</title>
</head>
    <body>
        <div class="header"><h1>Поликлинника</h1></div>

        <div class="wrapper">
            <h1>Регистрация</h1>
            <form id="reg-box" class="register-form" method="POST" action="register_patients.php">
            <h5>
                <span>Личные данные</span>
            </h5>
            <input type="text" name="lastname" placeholder="Фамилия*" required>
            <input type="text" name="firstname" placeholder="Имя*" required>
            <input type="text" name="middlename" placeholder="Отчество*" required>
            <input type="date" name="birthdate" placeholder="Дата рождения*" required>
            <input type="text" name="passport" placeholder="Паспорт*" required>
            <input type="tel" name="phone" placeholder="Номер телефона" required>
            <h5>
                <span>Данные для идентификации</span>
            </h5>
            <input type="email" name="email" placeholder="Электронная почта*" required>
            <input type="password" name="password" placeholder="Пароль*" required>
            <input type="password" name="confirm_password" placeholder="Повторить пароль*" required>
            <button class="bt1" type="submit" name="register">Зарегистрироваться</button>
            </form>
            <button onclick="location.href='index.php'">На главную страницу</button>
        </div>


    <div class="footer"> 
        <div class="copyright">
        <p></p>  
        </div>
    </div>

    </body>

</html> 
