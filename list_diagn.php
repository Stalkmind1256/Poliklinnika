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

$perPage = isset($_GET['perPage']) ? intval($_GET['perPage']) : 5; // Количество строк на странице, значение по умолчанию - 5
$page = isset($_GET['page']) ? intval($_GET['page']) : 1; // Текущая страница

$query = "SELECT * FROM public.diagnosis ORDER BY name ASC";
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
print "<tr><th>№</th><th>Название</th><th>Описание</th></tr>";

while ($row = pg_fetch_assoc($result)) {
    $id = $row['id'];
    $name = $row['name'];
    $discription = $row['discription'];
    print "<tr><td>$id</td><td>$name</td><td>$discription</td></tr>";
}
echo "</table>";

// Вывод пагинации
print "<ul>";
for ($i = 1; $i <= $totalPages; $i++) {
    echo "<li><a href='?page=$i&perPage=$perPage'>$i</a></li>";
}
print "</ul>";

// Форма для выбора количества строк на странице
print '<form action="" method="get">';
print '<label for="perPage">Количество строк на странице: </label>';
print '<input type="number" id="perPage" name="perPage" value="' . $perPage . '"/>';
print '<input type="submit" value="Применить"/>';
print '</form>';

pg_close($connect);

print "</body>";
print "</html>";