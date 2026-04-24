// Загаданное слово
const word = "ШЛЁПА".toUpperCase();
let guessedLetters = [];
let score = 0;

// Инициализация игры
function initGame() {
    updateWordDisplay();
}

// Обновление отображения слова
function updateWordDisplay() {
    const wordDisplay = document.getElementById('wordDisplay');
    wordDisplay.innerHTML = '';
    
    for (let letter of word) {
        const letterElement = document.createElement('span');
        letterElement.className = 'letter';
        
        if (guessedLetters.includes(letter)) {
            letterElement.textContent = letter;
        } else {
            letterElement.textContent = '';
        }
        
        wordDisplay.appendChild(letterElement);
    }
}

// Проверка буквы
function checkLetter() {
    const input = document.getElementById('letterInput');
    const letter = input.value.toUpperCase();
    
    if (letter && !guessedLetters.includes(letter)) {
        guessedLetters.push(letter);
        
        if (word.includes(letter)) {
            // Начисляем очки за правильную букву
            const points = getRandomPoints();
            score += points;
            document.getElementById('score').textContent = score;
            showMessage(`Правильно! +${points} очков!`);
        } else {
            showMessage('Такой буквы нет!');
        }
        
        updateWordDisplay();
        checkGameOver();
    }
    
    input.value = '';
}

// Угадывание слова целиком
function guessWord() {
    const guess = prompt('Введите загаданное слово:').toUpperCase();
    
    if (guess === word) {
        score += 2500;
        document.getElementById('score').textContent = score;
        alert('Поздравляем! Вы угадали слово целиком! +5000 очков!');
        endGame();
    } else {
        alert('Неверно! Попробуйте ещё раз.');
    }
}

// Вращение барабана
function spinWheel() {
    const wheel = document.getElementById('wheel');
    const rotation = Math.floor(Math.random() * 3600) + 360; // 10–11 полных оборотов
    wheel.style.transform = `rotate(${rotation}deg)`;
    
    // Через 3 секунды определяем результат
    setTimeout(() => {
        const result = getWheelResult();
        processWheelResult(result);
    }, 3000);
}

// Получение результата вращения
function getWheelResult() {
    const sectors = ['0', '500', '1000', '1500', '2000', 'БАНКРОТ', 'ПРИЗ', '5000'];
    return sectors[Math.floor(Math.random() * sectors.length)];
}

// Обработка результата вращения
function processWheelResult(result) {
    switch(result) {
        case 'БАНКРОТ':
            score = 0;
            document.getElementById('score').textContent = '0';
            showMessage('БАНКРОТ! Все очки сгорели!');
            break;
        case 'ПРИЗ':
            alert('Вы выиграли приз! Выберите: автомобиль или ключи от квартиры?');
            break;
        default:
            const points = parseInt(result);
            score += points;
            document.getElementById('score').textContent
