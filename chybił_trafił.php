<?php
session_start();

$link = mysqli_connect("localhost", "id16032200_admin", "Y^!bKXEgpV[1izcJ", "id16032200_tickets");

// Grupy losowych liczb
    $N1 = rand(1,8);   //1,2,3,4,5,6,7,8
    $N2 = rand(9,16);  //9,10,11,12,13,14,15,16
    $N3 = rand(17,24); //17,18,19,20,21,22,23,24
    $N4 = rand(25,32); //25,26,27,28,29,30,31,32
    $N5 = rand(33,40); //33,34,35,36,37,38,39,40
    $N6 = rand(41,49); //41,42,43,44,45,46,47,48

// Zbiór grup liczb
    $input = array($N1,$N2,$N3,$N4,$N5,$N6); 
    $user = $_SESSION['user'];

// Przemieszanie wartości w $input i wypisanie ich
    shuffle($input);

// Uzyskanie stanu konta użytkownika
    $sql_balance_search = mysqli_query($link, "SELECT balance FROM accounts WHERE login='$user'");
        while ($row = $sql_balance_search->fetch_assoc()) 
        {
            $balance = $row['balance'];
        }

 //sprawdzenie czy stan konta pozawala na zakup losu
    if($balance >= 5)
    {
        $sql = mysqli_query($link, "INSERT into lottery_tickets VALUES('',$input[0],$input[1],$input[2],$input[3],$input[4],$input[5],'$user')");
        $sql_balance = mysqli_query($link, "UPDATE accounts SET balance = balance - 5 WHERE login='$user'");
        $_SESSION["random"] = "Pomyślnie przesłano los!<br>Twoje szczęśliwe liczby to: <br>".$input[0]." ".$input[1]." ".$input[2]." ".$input[3]." ".$input[4]." ".$input[5];
        header("location: index.php");
        exit;
    }else{
        $_SESSION["lottery"] = "Brak środków na koncie!";
        header("location: index.php");
    }
?>