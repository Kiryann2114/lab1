<?php
$servername = "localhost";
$username = "root";
$password = "";
$bdname = "Lab1";

$conn = new mysqli($servername, $username, $password, $bdname);

if(!$conn->connect_error){
    if(isset($_POST['ID'])){
        $sql = "UPDATE inform SET nighttem = '" . $_COOKIE["nighttem"] . "' WHERE id = '" . $_POST['ID'] . "'";
        if($conn->query($sql)){
            echo '<script>window.location.href = "index.html";</script>';
        }
    }
    elseif(isset($_POST['loginEntrance'])){
        $sql = "SELECT * FROM Akk WHERE login = '" . $_POST['loginEntrance'] . "' and pass = '" . md5($_POST['passwordEntrance']) . "'";
        if($result = $conn->query($sql)){
            if($result->num_rows == 0){
                echo file_get_contents("index.html");
                echo "<script>alert('Неверные данные для входа')</script>";
            }
            else{
                $NAME = "";
                $TEM = "";
                $ID = "";
                foreach($result as $row){
                    $ID = $row["id"];
                    $result2 = $conn->query("SELECT * FROM inform WHERE id = '" . $ID . "'");
                    foreach($result2 as $row2){
                        $NAME = $row2["name"];
                        $TEM = $row2["nighttem"];
                        setcookie("nighttem",$TEM);
                    }
                }
                echo
                    "<head>
                        <title>Приветствие</title>
                        <link rel='stylesheet' type='text/css' href='light.css'  id='style'>
                        <script src='main.js' defer></script>
                    </head>
                    <body class='bodyPriv'>
                        <div class='Priv'>
                            <lable class='LbPriv'> Здравствуйте, " . $NAME . "</lable>
                            <input type='button' name='tem' value='Тёмная тема' class='inpButton'/>
                            <form action='lab1.php' method='POST' id='exitForm'>
                                <input type='hidden' name='ID' value=" . $ID . " />
                            </form>
                            <input type='button' name='exit' value='ВЫЙТИ' class='inpButton'/>
                        </div>
                    </body>";
            }
        }
    }
    else{
        $sql = "SELECT * FROM Akk WHERE login = '" . $_POST['login'] . "'";
        if($result = $conn->query($sql)){
            $url = 'https://www.google.com/recaptcha/api/siteverify?secret=6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe&response='.(array_key_exists('g-recaptcha-response', $_POST) ? $_POST["g-recaptcha-response"] : '').'&remoteip='.$_SERVER['REMOTE_ADDR'];
            $resp = json_decode(file_get_contents($url), true);
            if (!$resp['success']) {
                echo "<script>alert('Вы не прошли проверку на робота')</script>";
            }
            else {
                if($result->num_rows != 0){
                    echo file_get_contents("index.html");
                    echo "<script>alert('Пользователь с таким логином уже зарегистрирован')</script>";
                }
                else{
                    if (isset($_COOKIE["nighttem"])){
                        $TEM = $_COOKIE["nighttem"];
                    }
                    $ID = $conn->query("SELECT * FROM Akk")->num_rows + 1;
                    $NAME = $_POST['name'];
                    $PASS = md5($_POST['password']);
                    $sql = "INSERT INTO Akk (login,pass,id) VALUES ('" . $_POST['login'] . "','" . $PASS . "','" . $ID . "')";
                    if($conn->query($sql)){
                        $sql = "INSERT INTO inform (name,surname,id,nighttem,man,inform.18,email) VALUES ('" . $_POST['name'] . "','" . $_POST['surname'] . "','" . $ID . "','" . $TEM . "','" . $_POST['gender'] . "','" . $_POST['vozr'] . "','" . $_POST['mail'] . "')";
                        if($conn->query($sql)){
                            echo
                                "<head>
                                <title>Приветствие</title>
                                <link rel='stylesheet' type='text/css' href='light.css'  id='style'>
                                <script src='main.js' defer></script>
                            </head>
                            <body class='bodyPriv'>
                                <div class='Priv'>
                                    <lable class='LbPriv'> Здравствуйте, " . $NAME . "</lable>
                                    <input type='button' name='tem' value='Тёмная тема' class='inpButton'/>
                                    <form action='lab1.php' method='POST' id='exitForm'>
                                        <input type='hidden' name='ID' value=" . $ID . " />
                                    </form>
                                    <input type='button' name='exit' value='ВЫЙТИ' class='inpButton'/>
                                </div>
                            </body>";
                        }
                    }
                }
            }
        }
    }
}