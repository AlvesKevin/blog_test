<?php
session_start(); // Ajouter cette ligne pour démarrer la session

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header("Location: create_article.php"); // Modifié pour utiliser pageLogin.php
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Connectez-vous à la base de données
    $servername = "localhost:3306";
    $username = "root";
    $password = "root";
    $dbname = "articles";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insérez l'article dans la base de données
    $title = $_POST['title'];
    $author = $_POST['author'];
    $content = $_POST['content'];
    $date = date('Y-m-d H:i:s');
    $image_data = file_get_contents($_FILES['image_data']['tmp_name']);

    // Utilisation de requêtes préparées pour insérer des données
    $sql = "INSERT INTO articles (title, author, content, date, image_data) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssb", $title, $author, $content, $date, $image_data);

    // Envoi des données binaires
    $stmt->send_long_data(4, $image_data);

    if ($stmt->execute()) {
        header("Location: index.php"); // Redirigez vers la page d'accueil
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
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
    <link rel="stylesheet" href="css/ajoutArticle.css">

    <!-- TinyMCE JavaScript -->
    <script src="https://cdn.tiny.cloud/1/l834ijkh4m2g0ovd871y9oaaek612vh9s1nvmb2q8q0kb1re/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Mon Blog</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Articles</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">À propos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container">
    <h1 class="my-4">Créer un nouvel article</h1>
    <form id="article-form" action="create_article.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Titre :</label>
            <input type="text" id="title" name="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="author">Auteur :</label>
            <input type="text" id="author" name="author" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="content">Contenu :</label>
            <!-- Utilisez un nouvel identifiant pour le textarea -->
            <textarea id="content-editor" name="content" class="form-control" required></textarea>
            <script>
                tinymce.init({
                    selector: '#content-editor', // Sélectionnez le textarea par son identifiant
                    plugins: 'lists link image charmap print preview hr anchor pagebreak spellchecker',
                    toolbar: 'styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                    // Ajoutez d'autres options si nécessaire
                    setup: function (editor) {
                        editor.on('change', function () {
                            editor.save();
                        });
                    },
                });
            </script>
        </div>
        <div class="form-group">
            <label for="image_data">Image :</label>
            <input type="file" id="image_data" name="image_data" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Publier</button>
    </form>

</div>
</body>
</html>
