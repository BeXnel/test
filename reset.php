<?php session_start();?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lottery Ticket</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="reset_password.php" method="POST">
    <input type="text" name="login" placeholder="Podaj swój login">
    <input type="submit" value="Zresetuj hasło">
    <?php $_SESSION['reset'] = rand(100000,999999); ?>
</form>
</body>