<?php include("header.php"); ?>

<div class="game">

    <?php
    $servername = "127.0.0.1"; // Nom du serveur MySQL
    $username = "root";
    $password = "";
    $dbname = "test"; // Nom de la base de données

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $data = file_get_contents('php://input');

    $remote = $_SERVER['REMOTE_ADDR'];

    $selectRemote = $conn->prepare("SELECT * FROM note_game WHERE remote_addr = :remote_addr");
    $selectRemote->bindParam(':remote_addr', $remote);
    $selectRemote->execute();

    if ($selectRemote->rowCount() > 0) {
        $actualNote = $selectRemote->fetch()['note'];
    ?>
        <div id="alreadynoted" style="visibility:hidden;">
            <p> Vous avez déjà noté le jeu <br> Vous avez donnée la note de <?php echo $actualNote ?> /5 </p>
        </div>
    <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $note = json_decode($data, true)['rating'];

            if ($actualNote < 5 && $note > $actualNote && $actualNote) {
                $updateNote = $conn->prepare("UPDATE note_game SET note = :note WHERE remote_addr = :remote_addr");
                $updateNote->bindParam(':remote_addr', $remote);
                $updateNote->bindParam(':note', $note);
                $updateNote->execute();
            }
        }
    } else {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $note = json_decode($data, true)['rating'];
        if (!empty($note) && $note !== null) {
            $insertNote = $conn->prepare("INSERT INTO note_game (remote_addr, note) VALUES (:remote_addr, :note)");
            $insertNote->bindParam(':remote_addr', $remote);
            $insertNote->bindParam(':note', $note);
            $insertNote->execute();
        }
    }
    }

    ?>

    <div id="message">
        <p> Le jeu sera fait plus tard </p>
    </div>
</div>

<?php include("footer.php") ?>