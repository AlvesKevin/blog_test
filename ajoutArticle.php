<?php


// Vérifier si le formulaire a été soumis
if (isset($_POST['submit'])) {

    // Récupérer les données du formulaire
    $titre = $_POST['titre'];
    $contenu = $_POST['contenu'];
    $auteur = $_POST['auteur'];

    // Vérifier si une image a été soumise
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['image'];
        $image_name = $image['name'];
        $image_tmp_name = $image['tmp_name'];
        $image_size = $image['size'];
        $image_error = $image['error'];
        $image_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
        $allowed_ext = array('jpg', 'jpeg', 'png', 'gif');

        // Vérifier si l'extension de l'image est valide
        if (in_array($image_ext, $allowed_ext)) {
            // Déplacer l'image téléchargée vers le dossier images
            $image_dest = 'images/' . $image_name;
            move_uploaded_file($image_tmp_name, $image_dest);
        } else {
            echo "Erreur lors du téléchargement de l'image: l'extension de l'image n'est pas autorisée.";
            exit();
        }
    } else {
        // Utiliser une image par défaut si aucune image n'a été soumise
        $image_dest = 'images/default.jpg';
    }

    // Connexion à la base de données
    $servername = "localhost";
    $username = "nom_utilisateur";
    $password = "mot_de_passe";
    $dbname = "nom_de_la_base_de_données";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Préparer la requête SQL pour insérer les données dans la base de données
    $sql = "INSERT INTO articles (titre, contenu, auteur, image) VALUES ('$titre', '$contenu', '$auteur', '$image_dest')";

    // Exécuter la requête SQL
    if ($conn->query($sql) === TRUE) {
        echo "L'article a été ajouté avec succès.";
    } else {
        echo "Erreur lors de l'ajout de l'article: " . $conn->error;
    }

    // Fermer la connexion à la base de données
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Créer un nouvel article</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-6fiPvvA+ouTk6wL64Gvusb0VQTaQeO1u6KgU6vXuTkB6R0UoPh2Y0Y1iKjx5r5q3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/ajoutArticle.css">

</head>
<body>
<h1>Créer un nouvel article</h1>
<form id="article-form">
    <div>
        <label for="title">Titre :</label>
        <input type="text" id="title" name="title" required>
    </div>
    <div>
        <label for="author">Auteur :</label>
        <input type="text" id="author" name="author" required>
    </div>
    <div>
        <label for="content">Contenu :</label>
        <textarea id="content" name="content" required></textarea>
    </div>
    <div>
        <label for="image">Image :</label>
        <input type="file" id="image" name="image">
    </div>
    <button type="submit">Publier</button>
</form>
</body>
</html>



