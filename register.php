<?php
$servername = "localhost";
$username = "id16032200_admin";
$password = "Y^!bKXEgpV[1izcJ";

session_start();
// połączenie z bazą danych #1 sposób
$conn = new mysqli($servername, $username, $password, "id16032200_tickets");
// połączenie z bazą danych #2 sposób
$link=mysqli_connect("localhost", "id16032200_admin", "Y^!bKXEgpV[1izcJ", "id16032200_tickets");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (isset($_POST["login"]) &&
    isset($_POST["pass"]) &&
    isset($_POST["email"])
    )
{
    $login=$_POST["login"];
    $pass=$_POST["pass"];
    $email=$_POST["email"];

    // Zapytanie pobierające loginy z bazy danych
    $sql_login = mysqli_query($link, "SELECT login FROM accounts WHERE login='$login'");

    // Pobranie zapytania 
	$query = "SELECT login FROM accounts WHERE login = '$login'"; 
	
	// Przechowanie danych z zapytania w zmiennej $result
	$result = mysqli_query($link, $query);  
    
    //sprawdzenie czy formularz nie został przesłany pusty
    if(!empty($login) && !empty($pass))
    {   // wykonanie zapytania
        if ($result) 
        {   // Sprawdzenie czy dany login występuje już w DB
            $row = mysqli_num_rows($result); 
            if ($row) 
            {
                    $_SESSION['register'] = 'Podany login już istnieje!';
                    header("location: index.php");
            } else{ // Przesłanie polecenia do DB, jeśli dany $login jest dostępny
                //$ID = uniqid(); To dodamy jeśli będziemy chcieli robić unikalne ID dla każdego użytkownika
                $h_pass = password_hash($pass, PASSWORD_DEFAULT);
                $sql = "INSERT INTO accounts VALUES(NULL, '$login', '$email', '$h_pass', 0)";
            }
        }
    }else{
        $_SESSION['register'] = "Wypełnij wszystkie pola!";
        header("location: index.php");
    }
        // Sprawdzenie czy polecenie zostało wykonane
    if(isset($sql))
    {
        if ($conn->query(($sql)) === true) 
        {
            $last_id = $conn->update_id;
            $_SESSION['register'] = "Pomyślnie zarejestrowano!";
            header("location: index.php");
            exit;
        } else{
            $_SESSION['register'] = "Wystąpił błąd!";
            header("location: index.php");
            exit;
        }
    }
 
}

?>