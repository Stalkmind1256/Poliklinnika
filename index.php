<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="CSS/index.css">
    <title>Поликлиника</title>
</head>
<body>
<div class="header"><h1>Поликлиника</h1></div>
<div class="menu">
    <button onclick="location.href='patient.php'">Регистрация</button>
    <button onclick="location.href='login_patients.php'">Вход</button>
    <button onclick="location.href='login_admin.php'">Вход для администратора</button>
    <button onclick="location.href='login_doc.php'">Вход для врача</button>
</div>


<div class="footer"> 
    <div class="copyright">
      <p>&copy; 2024 Поликлиника. Все права защищены.</p>  
    </div>
</div>

</body>
</html>