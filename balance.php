<?php
session_start();

$user = $_SESSION['user'];

$servername = "localhost";
$username = "id16032200_admin";
$password = "Y^!bKXEgpV[1izcJ";

$conn = new mysqli($servername, $username, $password, "id16032200_tickets");

$link=mysqli_connect("localhost", "id16032200_admin", "Y^!bKXEgpV[1izcJ", "id16032200_tickets");

$balance = $_POST['balance'];

if(!empty($balance) && $balance>0)
{
    $sql = "UPDATE accounts SET balance = balance + $balance WHERE login='$user'";
}else{
    header("location: index.php");
    echo "<a href='index.php'>powrot</a>";
}


if(isset($sql))
{
    if ($link->query(($sql)) === true) 
    {
        $last_id = $conn->insert_id;
        $_SESSION["balance"] = "Pomyślnie doładowano konto!";
        header("location: index.php");
        exit;
    } else{
        echo"error<br>";
        echo "<a href='index.php'>powrot</a>";
        exit;
    }
}
?>