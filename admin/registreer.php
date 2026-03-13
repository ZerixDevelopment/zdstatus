<?php
include('../db.php'); // Controleer of dit pad klopt naar je db.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT); // De veilige hash

    $sql = "INSERT INTO users (gebruikersnaam, wachtwoord) VALUES ('$user', '$pass')";
    
    if (mysqli_query($conn, $sql)) {
        echo "<div style='color:green; font-weight:bold;'>Gebruiker $user succesvol aangemaakt! <a href='login.php'>Klik hier om in te loggen.</a></div>";
    } else {
        echo "<div style='color:red;'>Fout bij aanmaken: " . mysqli_error($conn) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Admin Aanmaken</title></head>
<body style="font-family:sans-serif; padding:50px;">
    <h2>Nieuwe Beheerder Aanmaken</h2>
    <form method="POST">
        <label>Gebruikersnaam:</label><br>
        <input type="text" name="username" required style="padding:10px; width:300px; margin-bottom:10px;"><br>
        <label>Wachtwoord:</label><br>
        <input type="password" name="password" required style="padding:10px; width:300px; margin-bottom:10px;"><br>
        <button type="submit" style="padding:10px 20px; background:blue; color:white; border:none; cursor:pointer;">Gebruiker Opslaan</button>
    </form>
</body>
</html>