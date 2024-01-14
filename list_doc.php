<?php

print "<html>";
print "<head>";
print '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
print "<title>";
print "Лист пациентов";
print "</title>";
print '<link rel="stylesheet" type="text/css" href="CSS/showdiagn.css">';
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

$perPage = 5; // Количество строк на странице
$page = isset($_GET['page']) ? intval($_GET['page']) : 1; // Текущая страница

$query = "SELECT * FROM public.doctors";
$result = pg_query($connect, $query);

if (!$result) {
    die("Ошибка: Не удалось выполнить запрос (pg_query)!");
}

$totalRows = pg_num_rows($result); // Общее количество строк
$totalPages = ceil($totalRows / $perPage); // Общее количество страниц

// Рассчитываем ограничения для текущей страницы
$offset = ($page - 1) * $perPage;

$query .= " LIMIT $perPage OFFSET $offset";
$result = pg_query($connect, $query);

// вывод данных о диагнозах в браузер списком
print "<table>";
print "<tr>
        <th>№</th>
        <th>Фимилия</th>
        <th>имя</th>
        <th>Отчество</th>
        <th>Специализация</th>
        <th>Телефон</th>
        <th>Номер кабинета</th>
        <th>пароль</th>
    </tr>";

    while ($row = pg_fetch_assoc($result)) {
        $id = $row['id'];
        $lastname = $row['lastname'];
        $firstname = $row['firstname'];
        $middlename = $row['middlename'];
        $specializations = $row['specializations'];
        $phone = $row['phone'];
        $number_of_cabinet = $row['number_of_cabinet'];
        $password = $row['password'];
    
        echo "<tr>
        <td>" . $id . "</td>
        <td>" . $lastname . "</td>
        <td>" . $firstname . "</td>
        <td>" . $middlename . "</td>
        <td>" . $specializations . "</td>
        <td>" . $phone . "</td>
        <td>" . $number_of_cabinet . "</td>
        <td>" . $password . "</td>
        </tr>";
    }
    echo "</table>";

// Вывод пагинации
print "<ul>";
for ($i = 1; $i <= $totalPages; $i++) {
    echo "<li><a href='?page=$i'>$i</a></li>";
}
print "</ul>";

pg_close($connect);

print "</body>";
print "</html>";