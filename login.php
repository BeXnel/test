<?php
//dane do zalogowania
$servername = "localhost";
$username = "id16032200_admin";
$password = "Y^!bKXEgpV[1izcJ";

//połączenie z bazą danych 
$link=mysqli_connect("localhost", "id16032200_admin", "Y^!bKXEgpV[1izcJ", "id16032200_tickets");

session_start();

$login = $_POST['login'];
$pass = $_POST['password']; 

$sql_login = mysqli_query($link, "SELECT login FROM accounts WHERE login='$login'");
$sql_pass = mysqli_query($link, "SELECT pass FROM accounts WHERE login='$login'");

// Przeszukanie DB pod względem loginów
while ($row = $sql_login->fetch_assoc()) 
{   // Sprawdzenie czy $login znajduje się w DB
    $db_login = $row['login'];
    if ($db_login == $login)
    {   // Przeszukanie DB pod względem haseł
        while ($row_pass = $sql_pass->fetch_assoc())
        {   // Sprawdzenie czy $pass zgadza się z hasłem w DB
            $db_pass = $row_pass['pass'];
            if (password_verify($pass, $db_pass))
            {   if($_POST['login'] == "admin")
                {
                    header("location: losowanie.php");
                    exit;
                }
                $_SESSION['user'] = htmlspecialchars($_POST['login']);
            }else{
                $_SESSION['login_temp'] = 'Błędne hasło!';
            }
        }
    }else{
        $_SESSION['login_temp'] = 'Błędny login!';
    }
}$_SESSION['login_temp'] = 'Błędne hasło!';
header("location: index.php")
?>
