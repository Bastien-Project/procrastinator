<?php include("header.php"); ?>

<div class="game" id="message">
    <p> Le jeu sera fait plus tard </p>
</div>

<?php
$note = (json_decode(file_get_contents('php://input'), true)['rating']);
$remote = $_SERVER['REMOTE_ADDR'];

$servername = "127.0.0.1"; // Nom du serveur MySQL
$username = "root";
$password = "";
$dbname = "test"; // Nom de la base de données

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$selectRemote = $conn->prepare("SELECT * FROM note_game WHERE remote_addr = :remote_addr");
$selectRemote->bindParam(':remote_addr', $remote);
$selectRemote->execute();
if ($selectRemote->rowCount() > 0) {
    echo "Vous avez déjà noté le jeu";
    exit();
}

if (!empty($note) && $note !== null) {
    try {
        $stmt = $conn->prepare("INSERT INTO note_game (remote_addr, note) VALUES (:remote_addr, :note)");
        $stmt->bindParam(':remote_addr', $remote);
        $stmt->bindParam(':note', $note);
        $stmt->execute();
    } catch (PDOException $e) {
        // Gestion des erreurs PDO
        echo "Erreur de connexion à la base de données : " . $e->getMessage();
    }
}
?>

<?php include("footer.php") ?>
