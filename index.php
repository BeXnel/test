<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giga Totek</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!--Sprawdzenie czy użytkownik jest zalogowany-->
<?php if (empty($_SESSION['user'])) : ?>

  <form action="register.php" method="POST">
        <input class="i_login" type="text" name="login" placeholder="Login" required><br>
        <input class="i_login" type="email" name="email" placeholder="Email" required><br>
        <input class="i_login" type="password" name="pass" placeholder="hasło" minlength="6" required><br>
        <input type="submit" value="zarejestruj">
    <?php
     if ((isset($_SESSION["register"]))) 
     {
       echo '<br>'.$_SESSION["register"];
     } // Usuwanie wartości dla $_SESSION['balance']
     if ((isset($_SESSION["register"]))) 
     {
       unset($_SESSION["register"]);
     }
    ?>
  </form>
   <div class="lottery_ticket">
    <h1 style="color: black">Zaloguj aby przesłać los</h1>
   </div>

  <form action="login.php" method="post"> 
    <input class="i_login" type="text" name="login" placeholder="login"/>     <br/>
    <input class="i_login" type="password" name="password" placeholder="haslo"/>     <br/>
    <button type="submit">Zaloguj</button>
    <?php
     if ((isset($_SESSION["login_temp"]))) 
     {
       echo '<br>'.$_SESSION["login_temp"];
     } // Usuwanie wartości dla $_SESSION['login_temp']
     if ((isset($_SESSION["login_temp"]))) 
     {
       unset($_SESSION['login_temp']);
     }
    ?>
  </form>
  <form action="reset.php">
     <input type="submit" value="Zresetuj hasło">
  </form>
  <?php else : ?>

    <?php   
      //połączenie z bazą danych 
      $link=mysqli_connect("localhost", "id16032200_admin", "Y^!bKXEgpV[1izcJ", "id16032200_tickets");

      $user = $_SESSION['user'];

      $sql = mysqli_query($link, "SELECT balance FROM accounts WHERE login='$user'");

      //przeszukiwanie DB w celu wyświetlenia stanu konta
      while ($row = $sql->fetch_assoc()) 
      {
        $balance = $row['balance'];
      }
    ?>

    <div>
      <h2>Stan konta: &nbsp<?=$balance?>zł</h2>
      <form action="balance.php" method="POST">
        <input style="width: 5vw" type='number' min="1" step='1' name='balance' placeholder="Doładuj konto " required><br>
        <input type="submit" value="Doładuj!">
      </form>
      <?php // Otrzymanie $_SESSION['balance']
      if ((isset($_SESSION['balance']))) 
      {
        echo $_SESSION['balance'];
      } // Usuwanie wartości dla $_SESSION['balance']
      if ((isset($_SESSION['balance']))) 
      {
        unset($_SESSION['balance']);
      }
      ?>
    </div>

    <div class="lottery_ticket">
    <h3 style="text-align: center;">Wybierz swoje 6 liczb! (1-49)</h3>
    <p>Liczby nie mogą się powtarzać</p>
    <form class="form" action="lottery.php" method="POST">
        1: <input type="number" min="1" max="49" step="1" name="N1"><br>
        2: <input type="number" min="1" max="49" step="1" name="N2"><br>
        3: <input type="number" min="1" max="49" step="1" name="N3"><br>
        4: <input type="number" min="1" max="49" step="1" name="N4"><br>
        5: <input type="number" min="1" max="49" step="1" name="N5"><br>
        6: <input type="number" min="1" max="49" step="1" name="N6"><br><br>
          <input type="submit" value="Prześlij los!">
     </form>
     <br>
     <p>Koszt jednego losu wynosi 5zł</p>
     <form action="chybił_trafił.php">
      <input type="submit" value="Chybił trafił!">
     </form>
     <?php
     // Selektor otrzymanych danych z $_SESSION
     switch(TRUE)
      {
          case isset($_SESSION["lottery"]):
              echo '<br>'.$_SESSION["lottery"];
          // Usuwanie wartości dla $_SESSION['lottery']
              if ((isset($_SESSION["lottery"]))) 
              {
                  unset($_SESSION["lottery"]);
              }
          
          case isset($_SESSION["random"]):
              echo '<br>'.$_SESSION["random"];
          // Usuwanie wartości dla $_SESSION['random']
              if ((isset($_SESSION["random"]))) 
              {
                  unset($_SESSION["random"]);
              }
      }
    ?>
</div>

<div class="login_panel">
        <h2>Witaj, &nbsp<?=$_SESSION['user']?>!</h2>
        <a class="logout" href="logout.php">logout</a>
        <?php endif; ?>
  </div>

</body>
</html>