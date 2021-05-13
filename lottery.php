<?php

session_start();

//dane do zalogowania
$servername = "localhost";
$username = "id16032200_admin";
$password = "Y^!bKXEgpV[1izcJ";

//połączenie z bazą danych #1
$conn = new mysqli($servername, $username, $password, "id16032200_tickets");

//połączenie z bazą danych #2
$link=mysqli_connect("localhost", "id16032200_admin", "Y^!bKXEgpV[1izcJ", "id16032200_tickets");

//sprawdzenie czy połączenie zostało nawiązane
if ($conn->connect_error) {
    die("Nie udało się połączyć z bazą danych: " . $conn->connect_error);
}//sprawdzenie czy dane zostały poprawnie przesłane z index.html
if (isset($_POST["N1"]) &&
    isset($_POST["N2"]) &&
    isset($_POST["N3"]) &&
    isset($_POST["N4"]) &&
    isset($_POST["N5"]) &&
    isset($_POST["N6"])
    )
{
    $N1 = $_POST["N1"];
    $N2 = $_POST["N2"];
    $N3 = $_POST["N3"];
    $N4 = $_POST["N4"];
    $N5 = $_POST["N5"];
    $N6 = $_POST["N6"];

    $user = $_SESSION['user'];

    $data = array($N1,$N2,$N3,$N4,$N5,$N6 );
    $unique = array_unique($data);

    $sql_balance_search = mysqli_query($link, "SELECT balance FROM accounts WHERE login='$user'");

    while ($row = $sql_balance_search->fetch_assoc()) 
    {
        $balance = $row['balance'];
    }

//sprawdzenie czy formularz został w pełni wypełniony
    if(!empty($N1) && !empty($N2) && !empty($N3) && !empty($N4) && !empty($N5) && !empty($N6))
    {   //sprawdzenie czy żadna wartość nie jest większa niż 49
        if($N1 < 50 && $N2 < 50 && $N3 < 50 && $N4 < 50 && $N5 < 50 && $N6 < 50)
        {   //sprawdzenie czy żadna wartość nie jest mniejsza niż 1
            if($N1 > 0 && $N2 > 0  && $N3 > 0  && $N4 > 0  && $N5 > 0  && $N6 > 0)
            {  //sprawdzenie czy liczby są unikalne
              if(count($data) == count($unique))
              {     //sprawdzenie czy stan konta pozawala na zakup losu
                  if($balance >= 5)
                  {
                    $sql = mysqli_query($link, "INSERT INTO lottery_tickets VALUES(NULL, $N1, $N2, $N3, $N4, $N5, $N6, '$user')");// "INSERT INTO lottery_tickets VALUES(NULL, $N1, $N2, $N3, $N4, $N5, $N6, '$user')";
                    $sql_balance = mysqli_query($link, "UPDATE accounts SET balance = balance - 5 WHERE login='$user'");
                    $_SESSION["lottery"] = "Pomyślnie przesłano los!";
                    header("location: index.php");
                    exit;
                  }else{
                      $_SESSION["lottery"] = "Brak środków na koncie!";
                      header("location: index.php");
                  }
              }else{
                  $_SESSION["lottery"] = "Liczby powtórzyły się!";
                  header("location: index.php");
              }
            }else{
                $_SESSION["lottery"] = "Minimalna wartość to 1!";
                header("location: index.php");
            }
        }else{
            $_SESSION["lottery"] = "Maksymalna wartość to 49!";
            header("location: index.php");
        }
       
    }else{
        $_SESSION["lottery"] = "Wypełnij wszystkie pola!";
        header("location: index.php");
    }
}

if(isset($sql_balance))
{
    if ($link->query(($sql_balance)) === true) 
    {
        
    } else{
        echo"za mało środków<br>";
        echo "<a href='index.php'>powrot</a>";
        exit;
    }
}
?>