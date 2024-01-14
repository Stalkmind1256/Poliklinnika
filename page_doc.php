<?php
// код для подключения к базе данных
$host = "localhost";
$port = "5432";
$dbname = "postgres";
$user = "postgres";
$password = "12345678";

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("Ошибка: Не удалось подключиться к базе данных (pg_connect)!");
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Вывод данных из таблицы</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }
        select {
        width: 100%;
    }
    </style>
</head>
<body>

<h2>Данные из таблицы</h2>

<table>
    <tr>
        <th>ID</th>
        <th>ID доктора</th>
        <th>ID пациента</th>
        <th>Дата</th>
        <th>Время</th>
        <th>ID диагноза</th>
    </tr>

    <?php
    $query = "SELECT * FROM appointment";
    $result = pg_query($conn, $query);

    if (!$result) {
        die("Ошибка: Не удалось выполнить запрос!");
    }

    while ($row = pg_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['id_patients'] . "</td>";
        echo "<td>" . $row['id_doctors'] . "</td>";
        echo "<td>" . $row['date'] . "</td>";
        echo "<td>" . $row['time'] . "</td>";
        
        // получить список диагнозов из другой таблицы
        $diagnos_query = "SELECT * FROM diagnosis"; // замените "diagnoses" на имя вашей таблицы с диагнозами
        $diagnos_result = pg_query($conn, $diagnos_query);
        
        if (!$diagnos_result) {
            die("Ошибка: Не удалось выполнить запрос для диагнозов!");
        }
        
        // создать выпадающий список с диагнозами
        echo "<td>";
        echo "<select name='diagnos'>";
        
        while ($diagnos_row = pg_fetch_assoc($diagnos_result)) {
            echo "<option value='" . $diagnos_row['id'] . "'";
            echo ">" . $diagnos_row['id']. " ".$diagnos_row['name'] . "</option>";
        }
        
        echo "</select>";
        echo "</td>";
        
        echo "</tr>";
    }
    echo "<td>";
    echo "<button onclick='addDiagnos()'>Добавить диагноз</button>";
    echo "</td>";

    pg_free_result($result);
    pg_close($conn);
    ?>

</table>

</body>
</html>