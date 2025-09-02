function validateInput(keyPhrase, answer) {
    inputZone.addEventListener("keyup", function () {
        if (inputZone.value.toLowerCase() == keyPhrase) {
            const winMessage = document.createElement("div");
            winMessage.innerHTML = "<h2>Bravo !</h2><p>" + answer + "<p>";
            console.log(winMessage);
            answerZone.appendChild(winMessage);
        }
    });
}

// mélange un array
function mixArray(ar) {
    for (let i = ar.length - 1; i > 0; i--) {
        j = Math.floor(Math.random() * i);
        [ar[i], ar[j]] = [ar[j], ar[i]];
    }
    return ar;
}

// crée une map associative clé => valeur (lettre => symbole)

function associate(array1, array2) {
    let associated = new Map();
    for (let i = 0; i < array1.length; i++) {
        let key = array1[i];
        let value = [array2[i]];
        associated.set(key, value);
    }
    console.log(associated.values());
    return associated;
}
// découpe un message en plusieurs parties

function cutMessage(message, nbMessageParts) {
    console.log(message);
    const messageParts = [];
    let subMessageLength = Math.round(message.length / nbMessageParts);
    for (let i = 0; i < nbMessageParts - 1; i++) {
        messageParts[i] = message.slice(
            subMessageLength * i,
            subMessageLength * (i + 1)
        );
    }
    messageParts[nbMessageParts - 1] = message.slice(
        (nbMessageParts - 1) * subMessageLength
    );
    console.log(messageParts);
    return messageParts;
}

function displayCellGame(gameName) {
    window[gameName](order);
}

function displayCellContent(game, keyPhrase, answer) {
    switch (game) {
        case "mixLetters":
            console.log("mixLetters");
            mixLetters(keyPhrase, answer);
            break;

        case "mixLetters2":
            console.log("mixLetters2");
            mixLetters2(keyPhrase, answer);
            break;

        case "lettersToSymbols":
            console.log("Symbols");
            lettersToSymbols(keyPhrase, answer);
            break;

        case "mirror":
            mirror(order);
            break;

        case "slidingMessage":
            slidingMessage(keyPhrase, 9);
            break;

        case "simpleMessage":
            simpleMessage(keyPhrase);
            break;

        case "messageWithInput":
            messageWithInput(order);
            break;

        case "switchImages":
            switchImages(order);
            break;

        case "colorBoxes":
            colorBoxes(order);
            break;

        case "morse":
            morse(order);
            break;

        case "flags":
            flags(order);
            break;

        case "crossWords":
            crossWords();
            break;
    }
    validateInput(keyPhrase, answer);
}

function displayCell() {
    //console.log(cellDate);
    const currentCellDate = new Date(cellDate);
    //console.log(currentCellDate);
    const today = new Date();
    //console.log(today);
    if (currentCellDate > today) {
        window.alert(
            "Tu es bien pressé! Cette case révelera son contenu en temps et en heure..."
        );
        gameZone.setAttribute("class", "no-display");
        answerZone.innerHTML =
            "<h1>Rien à voir içi!</h1><h2>en tout cas... pour le moment...</h2>";
    } else if (currentCellDate <= today) {
        //console.log('date ok');
        displayCellContent(cellGame, keyPhrase, answer);
    } else {
        window.alert("il y a un truc qui cloche");
    }
}
function displayAdditionalForm() {
    const additionalFormDiv = document.getElementById("additional-form");
    additionalFormDiv.innerHTML = "";

    const chosenGame = document.getElementById("chosen-game").value;

    const gameConstructorObject = JSON.parse(gameConstructor);
    const parameters = gameConstructorObject[chosenGame]["parameters"];

    //recherche des concordances entre le tableau de paramètres et les templates de formulaires complémentaires
    //en excluant le paramètre 'message', utilisé dans le premier input
    for (let parameter of parameters) {
        let template = document.getElementById(parameter);

        if (template && parameter != "message") {
            clone = template.content.cloneNode(true);
            additionalFormDiv.appendChild(clone);
        }
    }
}


function displayGame(params) {
  let game = {};
  chosenGame = params['chosen-game'];
    //document.getElementById('demo').innerHTML = '<h2>game ' + chosenGame + '</h2>';
    
    
    switch (chosenGame) {
        case "letters-to-symbols":
            game = new LettersToSymbols(params);
            break;

        case "flags":
            game = new Flags(params);
            document.getElementById('demo').innerHTML = '<h2>game ' + chosenGame + '</h2>';
            break;

        case "scroll-images":
            game = new ScrollImages(params);
            break;

        case "memory":
            game = new Memory(params);
            break;
    }
    
    game.createGame();
    
}


function displayPreview() {
    demoZone.innerHTML = "";
    const mainForm = document.getElementById("main-form");
    const inputList = mainForm.getElementsByTagName("input");
    const parameters = {};

    for (let inputItem of inputList) {
        inputValue = inputItem.value;

        if (
            (inputItem.type === "checkbox" || inputItem.type === "radio") &&
            inputItem.checked === true
        ) {
            parameters[inputItem.name] = inputItem.value;
        } else if (inputItem.type != "checkbox" && inputItem.type != "radio") {
            parameters[inputItem.name] = inputItem.value;
        }
    }

    const chosenGame = document.getElementById("chosen-game").value;

    const message = document.getElementById("message").value;

    let game = {};

    switch (chosenGame) {
        case "letters-to-symbols":
            game = new LettersToSymbols(parameters);
            break;

        case "flags":
            game = new Flags(parameters);
            break;

        case "scroll-images":
            game = new ScrollImages(parameters);
            break;

        case "memory":
            game = new Memory(parameters);
            break;
    }

    game.createGame();
}
function sayHello() {
  document.getElementById('hello').innerHTML = '<h2>Hello!</h2>';
}
