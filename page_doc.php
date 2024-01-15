<?php
session_start();
error_reporting(E_ALL);
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
            border-solid:solid;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        th {
            background-color: #333;
            color: white;
        }
        select {
        width: 100%;
    }
    </style>
</head>
<body>

<h2>Данные Приемов</h2>
<table>
    <tr>
        <th>ID</th>
        <th>ID доктора</th>
        <th>ID пациента</th>
        <th>Дата</th>
        <th>Время</th>
        <th>ID диагноза</th>
        <th>ID Добавить диагноз</th>
    </tr>

    <?php

    $query = "SELECT * FROM appointment";
    $result = pg_query($conn, $query);

    if (!$result) {
        die("Ошибка: Не удалось выполнить запрос!");
    }

    if(isset($_POST['diagnos']) && isset($_POST['appointmentId'])) {
        $diagnosIds = $_POST['diagnos'];
        $appointmentId = $_POST['appointmentId'];
        
        foreach($diagnosIds as $diagnosId) {
            $updateQuery = "UPDATE appointment SET id_diagnos = $diagnosId WHERE id = $appointmentId";
            $updateQuery = pg_query($conn, $updateQuery);
            if(!$updateQuery){
                die("Не удалось выполнить запрос");
            } 
        }
    }


    while ($row = pg_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['id_patients'] . "</td>";
        echo "<td>" . $row['id_doctors'] . "</td>";
        echo "<td>" . $row['date'] . "</td>";
        echo "<td>" . $row['time'] . "</td>";
        echo "<td>" . $row['id_diagnos'] . "</td>";
        
        // получить список диагнозов из другой таблицы
        $diagnos_query = "SELECT * FROM diagnosis"; 
        $diagnos_result = pg_query($conn, $diagnos_query);
        
        if (!$diagnos_result) {
            die("Ошибка: Не удалось выполнить запрос для диагнозов!");
        }
        
        // создать выпадающий список с диагнозами
        echo "<td>";
        echo "<form action='' method='POST'>";
        
        // создать множественные выпадающие списки
        echo "<select name='diagnos[]' multiple>";
        
        while ($diagnos_row = pg_fetch_assoc($diagnos_result)) {
            echo "<option value='" . $diagnos_row['id'] . "'";
            if($row['id_diagnos'] == $diagnos_row['id']) {
                echo "selected";
            }
            echo ">" . $diagnos_row['id']. " ".$diagnos_row['name'] . "</option>";
        }
       
        echo "</select>";
        // передать ID приема в качестве скрытого значения
        echo "<input type='hidden' name='appointmentId' value='" . $row['id'] . "'>";
        echo "<input type='submit' value='Добавить диагноз'>";
        echo "</form>";
        echo "</td>";
        
        echo "</tr>";
    }

    pg_free_result($result);
    pg_close($conn);
    ?>

</table>

</body>
</html>
