<?php
error_reporting(E_ALL);
session_start();

 // Подключение к базе данных
 $host = "localhost";
 $port = "5432";
 $dbname = "postgres";
 $user = "postgres";
 $password = "123456789";

 $connect = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");
 if (!$connect) {
     die("Не удалось подключиться к базе данных: " . pg_last_error());
 }

// Проверка метода запроса
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Получение данных из формы
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $birthdate = $_POST['birthdate'];
    $passport = trim($_POST['passport']);
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];

   

    // Проверки на совпадение
    /*$query = "SELECT COUNT(*) FROM public.patients WHERE passport = '$passport'";
    $res = pg_query($connect, $query);
    if (pg_num_rows($res) > 0) {
        die("Паспортные данные уже существуют");
    }

    $query = "SELECT COUNT(*) FROM public.patients WHERE phone = '$phone'";
    $res = pg_query($connect, $query);
    if (pg_fetch_result($res, 0) > 0) {
        die("Номер телефона уже существует");
    }

    $query = "SELECT COUNT(*) FROM public.patients WHERE password = '$password'";
    $res = pg_query($connect, $query);
    if (pg_fetch_result($res, 0) > 0) {
        die("Пароль уже существует");
    }
*/
    // Выполнение запроса на добавление данных в базу данных
    $query = "INSERT INTO public.patients(lastname, firstname, middlename, birthdate, passport, phone, email, password) 
            VALUES ('$lastname', '$firstname', '$middlename', '$birthdate', '$passport', '$phone', '$email', '$password')";

    $result = pg_query($connect, $query);
    if ($result) {
        if (pg_affected_rows($result) > 0) {
            echo "<script>alert('Успешно зарегистрирован')</script>";
            header('Location: index.php');
            exit;
        } else {
            echo "<script>alert('Ошибка')</script>";
        }
    } else {
        echo "<script>alert('Ошибка при выполнении запроса')</script>";
    }

    // Закрытие соединения с базой данных
    pg_close($connect);
}