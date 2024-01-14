<?php
print "<html>";
print "<head>";
print '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
print '<link rel="stylesheet" type="text/css" href="CSS/tablediagn.css">';
print "<title>";
print "Список диагнозов";
print "</title>";
print "</head>";
print "<body>";

$host = "localhost";
$port = "5432";
$dbname = "postgres";
$user = "postgres";
$password = "123456789";

$connect = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$connect) {
    die("Ошибка: Не удалось подключиться к базе данных");
}

// добавление диагнозов
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $discription = $_POST['discription'];

    $query = "INSERT INTO public.diagnosis (name, discription) VALUES ('$name', '$discription')";
    $result = pg_query($connect, $query);

    if (!$result) {
        die("Ошибка: Не удалось выполнить запрос (pg_query)!");
    } else {
        header("Location: diagnosis.php");
        exit();
    }
}

if(isset($_POST['delete'])) {
    $deleteId = $_POST['delete'];

    $query = "DELETE FROM public.diagnosis WHERE id = $deleteId";
    $deleteResult = pg_query($connect, $query);

    if(!$deleteResult) {
        die("Ошибка: Не удалось выполнить запрос (pg_query)!");
    }
    else {
        header("Location: diagnosis.php");
        exit();
    }
}

?>

<form action="diagnosis.php" method="POST">
    <label>Название диагноза:</label>
    <input type="text" name="name" required>

    <label>Информация о диагнозе:</label>
    <textarea name="discription" required></textarea>

    <input type="submit" name="submit" value="Добавить диагноз">
</form>

<?php

$query = "SELECT * FROM public.diagnosis";
$res = pg_query($connect, $query);

if (!$res) {
    die("Ошибка: Не удалось выполнить запрос (pg_query)!");
}

// вывод данных о диагнозах в браузер
echo "<table>";
echo "<tr><th>№</th><th>Название диагноза</th><th>Информация о диагнозе</th><th>Удаление</th></tr>";

while ($row = pg_fetch_assoc($res)) {
    $id = $row['id'];
    $name = $row['name'];
    $discription = $row['discription'];
    echo "<tr>
    <td>$id</td>
    <td>$name</td>
    <td>$discription</td>
    <td><form action='diagnosis.php' method='POST'><input type='hidden' name='delete' value='$id'><input type='submit' value='Удалить'></form></td>
    </tr>";
}

echo "</table>";

pg_close($connect);
print "</body>";
print "</html>";