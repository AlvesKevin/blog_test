<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Article</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>
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
</header><main>
    <div class="container">
        <?php
        if (isset($_GET['id'])) {
            // Récupérez l'ID de l'article à partir de l'URL
            $article_id = intval($_GET['id']);

            // Connectez-vous à la base de données
            $servername = "localhost:3306";
            $username = "root";
            $password = "root";
            $dbname = "articles";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Récupérez les informations de l'article correspondant à l'ID
            $sql = "SELECT title, author, content, date, image_data FROM articles WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $article_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $article = $result->fetch_assoc();

            $stmt->close();
            $conn->close();

            if ($result->num_rows > 0) {
                ?>
                <h2 class="my-4"><?= htmlspecialchars($article['title']) ?></h2>
                <p><strong>Auteur : </strong><?= htmlspecialchars($article['author']) ?></p>
                <p><strong>Date : </strong><?= htmlspecialchars($article['date']) ?></p>
                <?php if (!empty($article['image_data'])): ?>
                    <img src="data:image/png;base64,<?= base64_encode($article['image_data']) ?>" alt="<?= htmlspecialchars($article['title']) ?>" class="img-fluid">
                <?php endif; ?>
                <p class="mt-4"><?= $article['content'] ?></p>
                <?php
            } else {
                echo "<p class='text-danger'>Cet article n'existe pas.</p>";
            }
        } else {
            echo "<p class='text-danger'>Aucun article spécifié.</p>";
        }
        ?>
    </div>
</main>
</body>
</html>