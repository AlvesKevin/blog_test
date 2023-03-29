<?php
// Connectez-vous à la base de données
// Remplacez les valeurs par celles de votre base de données
$servername = "localhost:3306";
$username = "root";
$password = "root";
$dbname = "articles";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

    <!DOCTYPE html>
    <html>
    <head>
        <title>Mon Blog</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-6fiPvvA+ouTk6wL64Gvusb0VQTaQeO1u6KgU6vXuTkB6R0UoPh2Y0Y1iKjx5r5q3" crossorigin="anonymous">
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
    </header>
    <main>
        <div class="container">
            <h2 class="my-4">Derniers articles</h2>
            <div class="row">
<?php
// Récupérez les articles de la base de données
$sql = "SELECT * FROM articles ORDER BY date DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Affichez chaque article
    while ($article = $result->fetch_assoc()) {
        $base64_image = "data:image/jpeg;base64," . base64_encode($article['image_data']);

        echo '
          <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
              <img class="card-img-top" src="' . $base64_image . '" alt="">
              <div class="card-body">
                <h4 class="card-title">' . $article['title'] . '</h4>
              </div>
              <div class="card-footer">
                <a href="article.php?id=' . $article['id'] . '" class="btn btn-primary">Lire la suite</a>
              </div>
            </div>
          </div>
          ';
    }
} else {
    echo '<p class="text-center">Aucun article trouvé.</p>';
}
$conn->close();
?>
            </div>
        </div>
    </main>
    </body>
</html>