
let champ = document.getElementById("champ");
let champWidth = champ.clientWidth;
let champHeight = champ.clientHeight;
let difficulty = 300; // Vitesse du serpent en millisecondes

let snake = document.getElementById("snake");
let snakeBodies = [];

let direction = "";
let intervalID = null;

function init () {
    initSnake();
    positionApple();
    moveSnake();
}

function initSnake() {
    let snake = document.getElementById("snake");

    let snakeX = Math.floor(Math.random() * (champWidth / 20)) * 20;
    let snakeY = Math.floor(Math.random() * (champHeight / 20)) * 20;

    snake.style.left = snakeX + "px";
    snake.style.top = snakeY + "px";

    snakeBodies.push(snake); // Ajoute le serpent à la liste des corps du serpent
}

function positionApple() {
    let apple = document.getElementById("apple");
    let champWidth = champ.clientWidth;
    let champHeight = champ.clientHeight;

    let appleX = Math.floor(Math.random() * (champWidth / 20)) * 20;
    let appleY = Math.floor(Math.random() * (champHeight / 20)) * 20;

    apple.style.left = appleX + "px";
    apple.style.top = appleY + "px";
}

function moveSnake() {
  // Empêche les doubles timers
  if (intervalID) clearInterval(intervalID);

  const champWidth  = champ.clientWidth;
  const champHeight = champ.clientHeight;

  // Position actuelle de la tête (fallback à 0)
  let snakeLeftPosition = parseInt(snakeBodies[0].style.left, 10) || 0;
  let snakeTopPosition  = parseInt(snakeBodies[0].style.top , 10) || 0;

  intervalID = setInterval(() => {
    if (!direction) return;      // Pas de direction → pas de déplacement

    //Traduction de la direction en vecteur (dx, dy)
    let dx = 0, dy = 0;
    switch (direction) {
      case "ArrowRight": dx =  20; break;
      case "ArrowLeft":  dx = -20; break;
      case "ArrowUp":    dy = -20; break;
      case "ArrowDown":  dy =  20; break;
    }

    //Nouvelle position de la tête
    const nextLeft = snakeLeftPosition + dx;
    const nextTop  = snakeTopPosition + dy;

    //Collision bordure ?
    if (
      nextLeft < 0 ||
      nextTop  < 0 ||
      nextLeft >= champWidth ||
      nextTop  >= champHeight
    ) {
      return gameOver();
    }

    //Collision avec le corps si le corps fait + de 2 parties ?
    if (snakeBodies.length > 2) {
        // Position normalisée de la tête
        const headLeft = parseInt(snakeBodies[0].style.left, 10) || 0;
        const headTop  = parseInt(snakeBodies[0].style.top , 10) || 0;

        // On part du 2ᵉ élément (index 1)
        for (let i = 1; i < snakeBodies.length; i++) {
            const partLeft = parseInt(snakeBodies[i].style.left, 10) || 0;
            const partTop  = parseInt(snakeBodies[i].style.top , 10) || 0;

            if (partLeft === headLeft && partTop === headTop) {
            gameOver();
            return;              // Inutile de continuer
            }
        }
    }


    //Déplace tout le corps (tête incluse)
    moveSnakeBodies(dx, dy);

    //Met à jour les références pour le tick suivant
    snakeLeftPosition = nextLeft;
    snakeTopPosition  = nextTop;

    //Pomme ?
    snakeEatsApple();
  }, difficulty);
}

function moveSnakeBodies(dx, dy) {
  // Position initiale de la tête
  let prevLeft = parseInt(snakeBodies[0].style.left, 10) || 0;
  let prevTop  = parseInt(snakeBodies[0].style.top , 10) || 0;

  // Avance la tête
  snakeBodies[0].style.left = (prevLeft + dx) + "px";
  snakeBodies[0].style.top  = (prevTop  + dy) + "px";

  // Chaque segment prend la position du précédent
  for (let i = 1; i < snakeBodies.length; i++) {
    const currentLeft = parseInt(snakeBodies[i].style.left, 10) || 0;
    const currentTop  = parseInt(snakeBodies[i].style.top , 10) || 0;

    snakeBodies[i].style.left = prevLeft + "px";
    snakeBodies[i].style.top  = prevTop  + "px";

    prevLeft = currentLeft;
    prevTop  = currentTop;
  }
}

function gameOver() {
  clearInterval(intervalID);
  alert("GAME OVER");
  document.getElementById("restart").style.display = "block"; // Affiche le bouton de redémarrage
}


function snakeEatsApple() {
    let apple = document.getElementById("apple");
    let snake = document.getElementById("snake");
    if(snake.style.top == apple.style.top && snake.style.left == apple.style.left) {
        positionApple(); // Repositionne la pomme
        enlargeYourSnake(); // Agrandit le serpent
        manageScore(); // Gère le score
    }

    manageDifficulty(); // Gère la difficulté
}

function manageDifficulty() {
    //on va gérer la difficulté en fonction de la taille du serpent parce qu'on est des fous
    if (snakeBodies.length > 9 && difficulty == 300) {
        clearInterval(intervalID); // Stoppe l'ancien intervalle        
        difficulty = 200; // Augmente la vitesse du serpent
        moveSnake(); // Redémarre le mouvement du serpent avec la nouvelle difficulté
        document.getElementById("difficulty").textContent = "Vipère";
    }
    if (snakeBodies.length > 19 && difficulty == 200) {
        clearInterval(intervalID); // Stoppe l'ancien intervalle        
        difficulty = 100; // Augmente la vitesse du serpent
        moveSnake(); // Redémarre le mouvement du serpent avec la nouvelle difficulté
        document.getElementById("difficulty").textContent = "Anaconda";
    }
    if (snakeBodies.length > 29 && difficulty == 100) {
        clearInterval(intervalID); // Stoppe l'ancien intervalle        
        difficulty = 50; // Augmente la vitesse du serpent
        moveSnake(); // Redémarre le mouvement du serpent avec la nouvelle difficulté
        document.getElementById("difficulty").textContent = "Mamba Noir";
    } 
}

function enlargeYourSnake() {
  //Création du nouveau maillon
  const lastPart    = snakeBodies[snakeBodies.length - 1];
  const newPart     = document.createElement("div");
  newPart.classList.add("snake-body");

  //Position identique à celle du dernier maillon
  newPart.style.left = lastPart.style.left;
  newPart.style.top  = lastPart.style.top;

  //Injection dans le terrain de jeu (remplace 'champ' par ton conteneur réel)
  champ.appendChild(newPart);

  //Référence stockée dans le tableau
  snakeBodies.push(newPart);
}


function manageScore() {
    let score = document.getElementById("score");
    let currentScore = parseInt(score.textContent);
    let points = snakeBodies.length;
    currentScore += points; // Augmente le score du nombre de bodies de snake gagnés
    score.textContent = currentScore; // Met à jour l'affichage du score
}

function restart() {
    window.location.reload(); // Recharge la page pour redémarrer le jeu
}

// Gère les touches du clavier
document.addEventListener("keydown", function(event) {
    direction = event.key;
});

// Gère lebouton restart
document.getElementById("restart").addEventListener("click", restart);

init(); // Initialisation du jeu