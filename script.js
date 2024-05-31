document.addEventListener("keydown", function (event) {
  if (event.keyCode === 13) {
    window.location.href = "./game.php";
  }
});

setTimeout(function () {
  var messageElement = document.getElementById("message");
  messageElement.innerHTML = '<img src="./images/after-10-seconds.gif">';

  setTimeout(function () {
    messageElement.innerHTML = "";
    var alreadyNotedElement = document.getElementById('alreadynoted');
    if (alreadyNotedElement) {
      alreadyNotedElement.style.visibility = 'visible';
    }


    var ratingElement = document.createElement("div");
    ratingElement.textContent = "Veuillez noter le jeu :";

    for (var i = 1; i <= 5; i++) {
      var star = document.createElement("span");
      star.innerHTML = "&#9734;"; // Etoile vide
      star.style.cursor = "pointer";
      star.dataset.ratingValue = i;

      star.addEventListener("mouseover", function () {
        var stars = ratingElement.querySelectorAll("span");
        var rating = parseInt(this.dataset.ratingValue);
        for (var k = 0; k < rating; k++) {
          stars[k].innerHTML = "&#9733;"; // Etoile pleine
        }
      });

      star.addEventListener("mouseout", function () {
        var stars = ratingElement.querySelectorAll("span");
        for (var j = 0; j < stars.length; j++) {
          stars[j].innerHTML = "&#9734;"; // Etoile vide
        }
      });

      star.addEventListener("click", function () {
        var stars = ratingElement.querySelectorAll("span");
        for (var j = 0; j < stars.length; j++) {
          stars[j].innerHTML = "&#9734;"; // Etoile vide
        }
        var rating = parseInt(this.dataset.ratingValue);
        for (var k = 0; k < rating; k++) {
          stars[k].innerHTML = "&#9733;"; // Etoile pleine
        }

        if (rating === 1 || rating === 2) {
          rating = 6 - rating;
        }

        sendDataToDatabase(rating);
        alert("Merci pour la note de " + rating + " étoiles !");
      });

      ratingElement.appendChild(star);
    }

    messageElement.appendChild(ratingElement);
  }, 10000);
}, 5000);

function sendDataToDatabase(rating) {
  var data = {
    rating: rating
  };

  fetch('game.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(data)
  })
    .then(response => {
      if (!response.ok) {
        throw new Error('Erreur lors de l\'envoi des données à la base de données');
      }
    })
    .catch(error => {
      console.error('Erreur :', error);
    });
}