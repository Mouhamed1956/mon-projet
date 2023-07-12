<?php
session_start();
require_once 'config.php';
if (!isset($_SESSION['nom'])) {
    header('Location: login.php');
    exit();
}
$nom = $_SESSION['nom'];
$sql = "SELECT * FROM utilisateur WHERE nom = '$nom'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom_et_prenom = $_POST['nom_et_prenom'];
    $email = $_POST['email'];
    $sql = "UPDATE utilisateur SET nom_et_prenom = '$nom_et_prenom', email = '$email' WHERE nom = '$nom'";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['nom_et_prenom'] = $nom_et_prenom;
        $_SESSION['email'] = $email;

        $success = 'Informations mises à jour avec succès.';
    } else {
        $error = 'Une erreur est survenue lors de la mise à jour des informations.';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mon compte</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.php">Réseau social</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">File d'actualité</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Déconnexion</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mt-5">
        <h2>Mon compte</h2>
        <?php if (isset($error)) : ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        <?php if (isset($success)) : ?>
            <div class="alert alert-success" role="alert">
                <?php echo $success; ?>
            </div>
        <?php endif; ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="mb-3">
                <label for="nom_et_prenom" class="form-label">Nom et prénom</label>
                <input type="text" class="form-control" id="nom_et_prenom" name="nom_et_prenom" value="<?php echo $user['nom_et_prenom']; ?>">
            </div>
            <div class="mb-3">
                <label for="nom" class="form-label">Nom d'Utilisateur</label>
                <input type="text" class="form-control" id="nom" name="nom" value="<?php echo $user['nom']; ?>">
            </div>
            <div class="mb-3">
                <label for="mot_de_passe" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe" value="<?php echo $user['mot_de_passe']; ?>">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Adresse e-mail</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
