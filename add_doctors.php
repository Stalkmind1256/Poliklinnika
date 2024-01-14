<?php
print "<html>";
print "<head>";
print "<meta charset='UTF-8'>";
print "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
print "<link rel='stylesheet' type='text/css' href='CSS/tabledoc.css'>";
print "<title>Управление персоналом</title>";
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

$query = "SELECT * FROM public.doctors";

$res = pg_query($connect, $query);

if (!$res) {
    die("Ошибка: Не удалось выполнить запрос (pg_query)!");
}

echo "<table>";
echo "<tr>
        <th>№</th>
        <th>Фимилия</th>
        <th>имя</th>
        <th>Отчество</th>
        <th>Специализация</th>
        <th>Телефон</th>
        <th>Номер кабинета</th>
        <th>пароль</th>
        <th>Удалить</th>
    </tr>";
while ($row = pg_fetch_assoc($res)) {
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
    <td>
        <form action='add_doctors.php' method='POST'>
        <input type='hidden' name='delete' value='" . $id . "'>
        <input type='submit' value='Удалить'>
        </form>
    </td>
    </tr>";
}
echo "</table>";

if (isset($_POST['submit'])) {
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $specializations = $_POST['specializations'];
    $phone = $_POST['phone'];
    $number_of_cabinet = $_POST['number_of_cabinet'];
    $password = $_POST['password'];

    $query = "INSERT INTO public.doctors (lastname, firstname, middlename, specializations, phone, number_of_cabinet, password) VALUES ('$lastname', '$firstname','$middlename','$specializations','$phone','$number_of_cabinet','$password')";
    $result = pg_query($connect, $query);

    if (!$result) {
        die("Ошибка: Не удалось выполнить запрос (pg_query)!");
    } else {
        header("Location: add_doctors.php");
        exit();
    }
}
if(isset($_POST['delete'])) {
    $deleteId = $_POST['delete'];

    $query = "DELETE FROM public.doctors WHERE id = $deleteId";
    $deleteResult = pg_query($connect, $query);

    if(!$deleteResult) {
        die("Ошибка: Не удалось выполнить запрос (pg_query)!");
    }
    else {
        header("Location: add_doctors.php");
        exit();
    }
}



?>

<form action="add_doctors.php" method="POST">
    <label>Фамилия:</label>
    <input type="text" name="lastname" required>
    <label>Имя:</label>
    <input type="text" name="firstname" required>
    <label>Отчество:</label>
    <input type="text" name="middlename" required>
    <label>Специализации:</label>
    <input type="text" name="specializations" required>
    <label>Телефон:</label>
    <input type="phone" name="phone" required>
    <label>Номер кабинета:</label>
    <input type="text" name="number_of_cabinet" required>
    <label>Пароль:</label>
    <input type="password" name="password" required>
    <input type="submit" name="submit" value="Добавить врача">
</form>

<?php
pg_close($connect);
print "</body>";
print "</html>";
?>