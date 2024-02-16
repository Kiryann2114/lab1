<?php
$servername = "localhost";
$username = "root";
$password = "";
$bdname = "Lab2";

$conn = new mysqli($servername, $username, $password, $bdname);

if(!$conn->connect_error) {
/////////////////////////////////////////////////////////////////////////////
    echo "<lable>Упражнение 1</lable>";

    $sql = "SELECT * FROM info";
    if($result = $conn->query($sql)) {
        printtable($conn,$sql);
    }
    echo "<br>";
/////////////////////////////////////////////////////////////////////////////
    echo "<lable>Упражнение 2</lable>";

    if($result = $conn->query($sql)) {
        echo "<div> 2.1) " . $result->num_rows . "</div>";
    }

    $date_array = getdate();
    $begin_date = date ("Y-m-d", mktime(0,0,0, $date_array['mon'],1, $date_array['year']));
    $end_date = date ("Y-m-d", mktime(0,0,0, $date_array['mon'] + 1,0, $date_array['year']));

    $sql = "SELECT COUNT(*) AS kol FROM info WHERE date>='$begin_date' AND date<='$end_date'";
    if($result = $conn->query($sql)) {
        foreach($result as $row){
            echo"<div> 2.2) " . $row['kol'] . "</div>";
        }
    }

    $sql = "SELECT * FROM info WHERE date = (SELECT MAX(date) FROM info)";
    echo "<div> 2.3)</div>";
    printtable($conn,$sql);
    echo "<br>";
/////////////////////////////////////////////////////////////////////////////
    echo "<lable>Упражнение 3</lable>";

    echo "<div> 3.1)</div>";
    echo "
        <form  action='lab2.php' method='GET'>
            <input type='text' name='searchSlov' placeholder='поиск по слову'>
            <input type='submit' name='btnsearch' value='ПОИСК'>
        </form>";
    echo "<div> 3.2)</div>";
    echo "
        <form  action='lab2.php' method='GET'>
            <input type='text' name='searchFraz' placeholder='поиск по фразе'>
            <input type='submit' name='btnsearch' value='ПОИСК'>
        </form>";

    if(isset($_GET['searchSlov']))
    {
        $sql = "SELECT * FROM info WHERE name LIKE '%" . $_GET['searchSlov'] . "%' OR surname LIKE '%" . $_GET['searchSlov'] . "%'";
        printtable($conn,$sql);
    }
    if(isset($_GET['searchFraz']))
    {
        $sql = "SELECT * FROM info WHERE name LIKE '%" . $_GET['searchFraz'] . "%'";
        $search = explode( " " , $_GET['searchFraz']);
        foreach ($search as $rez){
            $sql = $sql . " OR name LIKE '%" . $rez . "%' OR surname LIKE '%" . $rez . "%'";
        }
        printtable($conn,$sql);
    }
}

/////////////////////////////////////////////////////////////////////////////
function printtable($conn,$sql)
{
    if($result = $conn->query($sql)) {
        echo
        "<table>
            <tr>
                <th>Имя</th>
                <th>Фамилия</th>
                <th>Дата регистрации</th>
                <th>ID</th>
            </tr>";
        foreach($result as $row){
            echo
                "<tr>
                    <td>" . $row['name'] . "</td>
                    <td>" . $row['surname'] . "</td>
                    <td>" . $row['date'] . "</td>
                    <td>" . $row['id'] . "</td>
                </tr>";
        }
        echo"</table>";
    }
}