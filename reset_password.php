<?php
session_start();
error_reporting(E_ERROR | E_PARSE);
$link=mysqli_connect("localhost", "id16032200_admin", "Y^!bKXEgpV[1izcJ", "id16032200_tickets");
$login = $_POST['login'];
$reset = $_SESSION['reset'];

switch(true)
{
    case isset($_POST['reset_key']):
        $login = $_SESSION['login'];
        $result = mysqli_query($link, "SELECT reset_id FROM reset_pass WHERE login='$login'");
        $reset_key = $_POST['reset_key'];
        $result_key = mysqli_fetch_assoc($result); 
        if($reset_key == $result_key['reset_id'])
        {
            echo '
            <form action="reset_password.php" method="POST">
                <input type="text" name="new_pass" placeholder="Podaj nowe hasło">
                <input type="submit" value="Prześlij">
            </form>';
            $sql_del = mysqli_query($link, "DELETE FROM reset_pass WHERE login='$login'");
        }else{
            echo $reset_key;
            echo 'Błędny kod!';
            echo $result_key['reset_id'];  
            echo $_SESSION['user'];
        }break;
    
    case isset($_POST['new_pass']): //sprawdź czy konto w ogóle istnieje
        $login = $_SESSION['login'];
        $new_pass = $_POST['new_pass'];
        $new_hpass = password_hash($new_pass, PASSWORD_DEFAULT);
        $sql_reset = mysqli_query($link, "UPDATE accounts SET pass='$new_hpass' WHERE login='$login'");
        echo 'Pomyślnie zresetowano hasło!<br>Powrót na stronę główną <a href=index.php>KLIK</a>';
        break;

    case isset($_SESSION['reset']):
        $result = mysqli_query($link, "SELECT reset_id FROM reset_pass WHERE login='$login'");
        $result_exist = mysqli_query($link, "SELECT login FROM accounts WHERE login='$login'");
        if(!mysqli_num_rows($result_exist))
        {
            echo 'Konto z danym loginem nie istnieje<br>Powrót na stronę główną<a href="index.php">KLIK</a>';
        }else if(mysqli_num_rows($result)){
            echo 'Kod już został wysłany!<br>
            <form action="reset_password.php" method="POST">
                <input type="text" name="reset_key" placeholder="Podaj kod">
                <input type="submit" value="Prześlij">
            </form>';
        }else{
            echo 'Wysłano kod!<br>
                    <form action="reset_password.php" method="POST">
                        <input type="text" name="reset_key" placeholder="Podaj kod">
                        <input type="submit" value="Prześlij">
                    </form>';
            $sql = mysqli_query($link, "INSERT INTO reset_pass VALUES($reset, '$login')");
            $_SESSION['login'] = $_POST['login'];
        }break; 
}
?>