<!DOCTYPE html>

<head>
	<meta charset="UTF-8" />
	<title>Game</title>
	<link rel="stylesheet" media="screen" href="./stylesheets/style.css" type="text/css" />
	<script src="https://kit.fontawesome.com/3cff230019.js" crossorigin="anonymous"></script>
	<script src="./script.js"></script>
</head>

<?php if ($_SERVER['PHP_SELF'] == "/game/game.php") { ?>

	<body id="contenu" style="overflow: hidden" ;>
	<?php } else { ?>

		<body id="contenu">
		<?php } ?>
		<nav>
			<h1><a href="index.php">The Procrastinator</a></h1>
			<div class="onglets">
				<p class="link"><a href="index.php">Accueil</a></p>
				<p class="link"><a href="game.php">Jeu</a></p>
			</div>
		</nav>