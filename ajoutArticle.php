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
    $servername = "localhost:3306";
    $username = "fhcn0606";
    $password = "fMeE-5GqV-k3k@";
    $dbname = "fhcn0606_blog";

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





