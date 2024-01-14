<?php
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

// Обработка добавления нового диагноза
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_diagnosis'])) {
    $name = $_POST['name'];
    $discription = $_POST['discription'];

    $query = "INSERT INTO public.diagnosis (name, discription) VALUES ('$name', '$discription')";
    $result = pg_query($connect, $query);

    if ($result) {
        echo "<script>alert('Диагноз успешно добавлен')</script>";
    } else {
        echo "<script>alert('Ошибка при добавлении диагноза')</script>";
    }
}

// Обработка удаления диагноза
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_diagnosis'])) {
    $diagnosis_id = $_POST['diagnosis_id'];

    $query = "DELETE FROM diagnosis WHERE id = $diagnosis_id";
    $result = pg_query($connect, $query);

    if ($result) {
        echo "<script>alert('Диагноз успешно удален')</script>";
    } else {
        echo "<script>alert('Ошибка при удалении диагноза')</script>";
    }
}

// Получение списка диагнозов
$query = "SELECT id, name, discription FROM diagnosis";
$result = pg_query($connect, $query);
$rows = pg_fetch_all($result);
?>
