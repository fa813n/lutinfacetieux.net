/*
function validateInput(keyPhrase, answer) {
	inputZone.addEventListener("keyup", function() {
		
		if (inputZone.value.toLowerCase() == keyPhrase) {
			const winMessage = document.createElement('div')
			winMessage.innerHTML = '<h2>Bravo !</h2><p>' + answer + '<p>';
			console.log(winMessage);
			answerZone.appendChild(winMessage);
		}
	});
}
*/

// mélange un array
function mixArray(ar) {
	for (let i = (ar.length - 1); i > 0; i--) {
	j = Math.floor(Math.random()*i);
	[ar[i], ar[j]] = [ar[j], ar[i]];
	}
	return ar;
}
// renvoie l'index d'un élément aléatoire d'un tableau
function randomIndex(ar) {
	return Math.floor(Math.random() * ar.length) - 1
}
//transfére un élément d'un tableau source vers un autre tableau

function transferElement(arraySource, sourceIndex,  arrayTarget) {
	let removed = arraySource.splice(sourceIndex, 1);
	arrayTarget.push(removed[0]);
}
//compte le n'ombre d'itération d'une lettre dans
function countLetters(str) {
	const letters = new Map();
	for (let i = 0; i < str.length; i++) {
		let letter = str.at(i).match(/[a-z]/i);
		//console.log(k);
		if (letter) {
			let key = letter.toString().toLowerCase();
			let value = letters.get(key) || 0;
			letters.set(key, value + 1);
		}
	}
	return letters;
}

function chooseHints(str, percentage) {
	const lettersMap = countLetters(str);
	//console.log(lettersMap);
	let total = 0;
	let numberOfLetters = lettersMap.size;
	console.log(numberOfLetters);
	for (const iters of lettersMap.values()) {
		total += iters;
	}
	console.log(total);
	let numberOfHints = 0;
	let hintValue = 0;
	
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

	const messageParts = [];
	let subMessageLength = Math.round(message.length / nbMessageParts);
	for (let i = 0; i < (nbMessageParts - 1); i++) {
		messageParts[i] = message.slice(subMessageLength * i, subMessageLength * (i+1));
	}
	messageParts[(nbMessageParts - 1)] = message.slice((nbMessageParts - 1)*subMessageLength);

	return messageParts;
}

function displayAdditionalForm() {
	
	const additionalFormDiv = document.getElementById('additional-form');
	additionalFormDiv.innerHTML = '';
	
	const chosenGame = document.getElementById('chosen-game').value;

	const gameConstructorObject = JSON.parse(gameConstructor);
	const parameters = gameConstructorObject[chosenGame]['parameters'];

	//recherche des concordances entre le tableau de paramètres et les templates de formulaires complémentaires
	//en excluant le paramètre 'message', utilisé dans le premier input
	for (let parameter of parameters) {
		let template = document.getElementById(parameter);

		if (template && (parameter != 'message')) {
			clone = template.content.cloneNode(true);
			additionalFormDiv.appendChild(clone);	
		}	
	}
}
function displayPreview() {
  const mainForm = document.getElementById('main-form');
	const inputList = mainForm.getElementsByTagName('input');
	const parameters = {};
	
	for (let inputItem of inputList) {
		inputValue = inputItem.value;
		
		if ((inputItem.type === 'checkbox' || inputItem.type === 'radio') && inputItem.checked === true){
			parameters[inputItem.name] = inputItem.value;
		}
		else if (inputItem.type != 'checkbox' && inputItem.type != 'radio') {
			parameters[inputItem.name] = inputItem.value;
		}
		//console.log(parameters);
		
	  parameters['chosen-game'] = document.getElementById('chosen-game').value;	
	  /*
	  parameters['message'] = document.getElementById('message').value;
	  */
	}
  displayGame(parameters);
}
function displayGame(parameters) {
	console.log(parameters);
	gameZone.innerHTML = '';
	instructionsZone.innerHTML = '';
	// const mainForm = document.getElementById('main-form');
// 	const inputList = mainForm.getElementsByTagName('input');
// 	const parameters = {};
// 	
// 	for (let inputItem of inputList) {
// 		inputValue = inputItem.value;
// 		
// 		if ((inputItem.type === 'checkbox' || inputItem.type === 'radio') && inputItem.checked === true){
// 			parameters[inputItem.name] = inputItem.value;
// 		}
// 		else if (inputItem.type != 'checkbox' && inputItem.type != 'radio') {
// 			parameters[inputItem.name] = inputItem.value;
// 		}
// 			
// 	}
	
	//const chosenGame = document.getElementById('chosen-game').value;
	const chosenGame = parameters['chosen-game'];
	console.log(chosenGame);
	//const message = parameters['message'];

	//const message = document.getElementById('message').value;
	

	let game = {};
	
	switch(chosenGame) {
		case 'letters-to-symbols' :
		game = new LettersToSymbols(parameters);
		break;
		
		case 'flags' : 
		game = new Flags(parameters);
		break;
		
		case 'scroll-images' :
		game = new ScrollImages(parameters);
		break;
		
		case 'memory' :
		game = new Memory(parameters);
		break;
		
		case 'dobble' :
		game = new Dobble(parameters);
		break;
	}
	instructionsZone.innerHTML = game.instructions;
	game.createGame();
	
}
/*
//Il doit y avoir plus élégant...
console.log('test')
let selectedGame = document.getElementById('chosen-game').getElementsByTagName('option');
for (let i = 0; i < selectedGame.length; i++) {
  console.log(selectedGame[i].value;
			  console.log('test');
	if (selectedGame[i].selected === true) {
		displayAdditionalForm();
	}
}
*/
