
let snake = document.getElementById('snake-head');
let apple = document.getElementById('apple');
let container = document.getElementById('container-jeu');
let scoreDisplay = document.getElementById('score-display');
let positionSnakeX = 300;
let positionSnakeY = 200;
let snakeSizePosition = [];


//FONCTIONS MOUVEMENT SNAKE
function moveSnakeDown() {
        positionSnakeY += 10;
        if (positionSnakeY >= 590) {
                positionSnakeY = 10;
                snake.style.top = positionSnakeY + 'px';
        } else {
                snake.style.top = positionSnakeY + 'px';
        }
}
function moveSnakeUp() {
        positionSnakeY -= 10;
        if (positionSnakeY <= 4) {
                positionSnakeY = 599;
                snake.style.top = positionSnakeY + 'px';
        } else {
                snake.style.top = positionSnakeY + 'px';
        }
}
function moveSnakeRight() {
        positionSnakeX += 10;
        if (positionSnakeX >= 590) {
                positionSnakeX = 0;
                snake.style.left = positionSnakeX + 'px';
        } else {
                snake.style.left = positionSnakeX + 'px';
        }
}
function moveSnakeLeft() {
        positionSnakeX -= 10;
        if (positionSnakeX <= 5) {
                positionSnakeX = 599;
                snake.style.left = positionSnakeX + 'px';
        } else {
                snake.style.left = positionSnakeX + 'px';
        }
}



//GESTION D'EVENEMENTS
//Listener pour touches + renvoi des positions
let lastkeyDownSave = '';
let interval = setInterval(() =>
        snakeEvent(lastkeyDownSave), 100);

document.addEventListener('keydown', function (event) {
        lastkeyDownSave = event.key;
        interval;
});

//Fonction reaction gestion evenement
function snakeEvent(keydown) {
        if (keydown === 'ArrowRight') {
                moveSnakeRight();
        }
        if (keydown === 'ArrowLeft') {
                moveSnakeLeft();
        }
        if (keydown === 'ArrowDown') {
                moveSnakeDown();
        }
        if (keydown === 'ArrowUp') {
                moveSnakeUp();
        }
}


let score = 0;
//CHANGEMENT POSITION APPLE
function AppleMove() {
        apple.style.top = Math.floor(Math.random() * 100);
        apple.style.left = Math.floor(Math.random() * 100);
}


//POSITIONS DES ELEMENTS en continu 
let intervalPositions = setInterval(() =>
        Positions(), 100);
function Positions() {
        let snakePositionDatas = snake.getBoundingClientRect()
        //console.log(snakePositionDatas);
        let applePositionDatas = apple.getBoundingClientRect();
        //console.log(applePositionDatas);
        let snakeValorsArray = [snakePositionDatas.x, snakePositionDatas.y];
        //console.log(snakeValorsArray);

        //POMME MANGEE avec tolérance +- 10px
        if (Math.abs(snakePositionDatas.x - applePositionDatas.x) <= 16 &&
                Math.abs(snakePositionDatas.y - applePositionDatas.y) <= 15) {
                AppleMove();
                score++;
                alert('SCORE:  ' + score);
                scoreDisplay.innerHTML = 'SCORE: ' + score; // REVOIR 

                //Tableau coordonnées
                let snakeSizePositionDats = [];

                //Coordonnées dernier élement du tableau 

                //FONCTION AJOUT SNAKE
                addSnakeSize(snakePositionDatas);
                //Ajout au tableau des coordonnées du snakeSize au dernier index
        }
}


//AJOUT SNAKE
function addSnakeSize(snakePositionDatas) {
        //test positions 
        let positionElementX = 0;
        let positionElementY = 0;

        //Snake grossit
        let snakeSize = document.createElement('div');
        snakeSize.className = 'snake-size';
        snakeSize.style.top = (snakePositionDatas.X + 20) + 'px';
        snakeSize.style.left = snakePositionDatas.Y + 'px';
        container.appendChild(snakeSize);
        // snakeSize.style.top = snakePositionDatas.Y + 'px';
        // snakeSize.style.left = snakePositionDatas.X + 'px';
}