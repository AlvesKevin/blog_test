<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
</head>
<body>
<h1>Connexion</h1>

<?php
if (isset($error_message)) {
    echo "<p>" . $error_message . "</p>";
}
?>

<form action="login.php" method="post">
    <label for="username">Nom d'utilisateur :</label>
    <input type="text" id="username" name="username" required><br>
    <label for="password">Mot de passe :</label>
    <input type="password" id="password" name="password" required><br>
    <button type="submit">Se connecter</button>
</form>

</body>
</html>