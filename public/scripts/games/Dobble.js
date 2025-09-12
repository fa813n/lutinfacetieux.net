class Dobble {
	constructor(parameters) {
		this.instructions = 'Vous avez une carte avec une liste de dessins; quand vous en reconnaissez un parmis ceux présenté à l\'écran, cliquez ou touchez-le pour révéler une partie du message caché.';
		this.message = parameters['message'];
		this.graphicTheme = parameters['graphic-theme'];
		this.difficulty = parameters['difficulty'];
		
		this.numberOfSymbols = 6; //à moduler avec la difficulté
		this.maxDuplicates = 3; //à moduler avec la difficulté
		this.displayTime = 4000; //à moduler avec la difficulté
		this.numberOfMessageParts = 5; //à moduler avec la difficulté
		this.restartGameTimeOut;
		this.fadeOutTimeOut;
		switch (this.difficulty) {
			case 'easy' :
			this.numberOfSymbols = 8;
			this.maxDuplicates = 3;
			this.displayTime = 4000;
			this.numberOfMessageParts = 5;
			break;
			
			case 'medium' : 
			this.numberOfSymbols = 10;
			this.maxDuplicates = 2;
			this.displayTime = 3000;
			this.numberOfMessageParts = 10;
			break;
			
			case 'hard' :
			this.numberOfSymbols = 12;
			this.maxDuplicates = 1;
			this.displayTime = 2000;
			this.numberOfMessageParts = 15;
			break;
		}
		
		this.playerCardValues = []; // la liste des valeurs de la carte du joueur
		this.gameCardValues = []; // la liste des valeurs de la carte à comparer
		
		this.arrayOfSymbols = []; // liste des valeurs possible; à faire varier en fonction du nb de fichiers dans le dossier images

		this.spreadMessage = cutMessage(this.message, this.numberOfMessageParts);
		this.solutionParts = [];
		
		this.displayZone = document.createElement('div');
		this.displayZone.setAttribute('id', 'dobble');
		gameZone.appendChild(this.displayZone);
		
		this.gameMasterZone = document.createElement('div');
		this.gameMasterZone.setAttribute('id', 'game-master');
		this.displayZone.appendChild(this.gameMasterZone);
		
		this.playerZone = document.createElement('div');
		this.playerZone.setAttribute('id', 'player');
		this.displayZone.appendChild(this.playerZone);
	}
	
	/*
	Mode facile: la carte joueur reste la même tant qu'on perd, et c'est la pioche qui la remplace à chaque victoire,
	mode medium: la carte joueur reste la même tant qu'on perd, on change les deux à chaque victoire
	Mode difficile: changement des deux cartes à chaque fois
	*/
	
	createGame() {
		
		this.solutionZone = document.createElement('div');
		this.solutionZone.setAttribute('id', 'solution-zone');

		gameZone.appendChild(this.solutionZone);
		
		clearTimeout(this.restartGameTimeOut);
		clearTimeout(this.fadeOutTimeOut);
		
		this.playerCardValues = [];
		this.gameCardValues = [];
		
		this.#resetArrayOfSymbols();
		this.#setPlayerCard();
		this.#displayPlayerCard();
		this.#createGameCard();
		
		
		
	}

	#drawNewCard(victory) {

		//clearTimeout(this.restartGameTimeOut);
		//clearTimeout(this.fadeOutTimeOut);
		
		if (victory && this.difficulty === 'easy') {
			console.log('easy victory');
			this.#resetArrayOfSymbols();
			this.playerCardValues = [];
			// la pioche remplace la carte joueur
			for (let value of this.gameCardValues) {
				let sourceIndex = this.arrayOfSymbols.indexOf(value);
				transferElement(this.arrayOfSymbols, sourceIndex, this.playerCardValues);
			}
			this.#displayPlayerCard();
			this.gameCardValues = [];
			this.#createGameCard();
		}
		else if ((!victory && this.difficulty === 'easy') || (!victory &&  this.difficulty === 'medium')) {
			console.log('easy or medium loss');
			//on ne change que la pioche; il faut retransférer les éléments dans la liste des valeurs possibles, sinon arrayOfSymbols se vide à chaque tour

			this.#resetArrayOfSymbols();
			for (let value of this.playerCardValues) {
				let sourceIndex = this.arrayOfSymbols.indexOf(value);
				this.arrayOfSymbols.splice(sourceIndex, 1);
			}
			this.gameCardValues = [];
			this.#createGameCard();
		}
		else {
			console.log('anything else');
			this.playerCardValues = [];
			this.gameCardValues = [];
		
			this.#resetArrayOfSymbols();
			this.#setPlayerCard();
			this.#displayPlayerCard();
			this.#createGameCard();
		}
		console.log(this.arrayOfSymbols);
		console.log(this.playerCardValues);
		console.log(this.gameCardValues);
		//this.restartGameTimeOut = setTimeout(this.#drawNewCard.bind(this), this.displayTime, false); //changement automatique de carte après un temps
		//this.fadeOutTimeOut = setTimeout(this.#setClassFadeOut.bind(this), this.displayTime - 1000);
	}
	
	// réinitialise la liste des valeurs possibles
	#resetArrayOfSymbols() {
		this.arrayOfSymbols = [];
		for (let i = 1; i<= 30; i++) {
			this.arrayOfSymbols.push(i);
		}
	}
	
	// associe une image à chaque valeur de la carte
	// retourne la liste des éléments créés (input);
	#displaySymbols(cardValues, cardDisplayZone) {
		
		const cardElements = [];
		const displayZoneClass = cardDisplayZone.getAttribute('id') + '-card';
		for (let symbolNumber of cardValues) {
			const symbol = new Symbol(symbolNumber, this.graphicTheme);
			const cardElement = symbol.toInput({
				class: displayZoneClass,
				value: symbolNumber
			});
			cardDisplayZone.appendChild(cardElement);
			cardElements.push(cardElement);
		}
		return cardElements;
	}
	#setPlayerCard() {
		for (let i = 0; i < this.numberOfSymbols; i++) {
			this.#transfer(this.arrayOfSymbols, this.playerCardValues);	
		}
	}
	//affiche la carte du joueur
	#displayPlayerCard() {
		let cardElements = [];
		this.playerZone.innerHTML = '';

		cardElements = this.#displaySymbols(this.playerCardValues, this.playerZone);

		for (let i = 0; i < cardElements.length; i++) {
			const cardElement = cardElements[i];
			let symbolNumber = cardElement.value;
			cardElement.addEventListener("click", () => this.#controlImg(symbolNumber));
		}	
	}
	
	// crée la carte à comparer, en incluant entre un plusieurs éléments de la carte du joueur, selon la difficulté
	#createGameCard() {

		this.gameMasterZone.innerHTML = '';
		let numberOfDuplicates;
		numberOfDuplicates = Math.floor(Math.random() * this.maxDuplicates) + 1;
		
		//on met entre 1 et maxDuplicates symboles identiques sur la carte du joueur
		let playerCardValuesCopy = [...this.playerCardValues];
		
		for (let i = 0; i < numberOfDuplicates; i++) {
			this.#transfer(playerCardValuesCopy, this.gameCardValues);
		}
		
		//on complete avec les autres symboles disponibles
		for (let i = this.gameCardValues.length; i < this.numberOfSymbols; i++) {
			this.#transfer(this.arrayOfSymbols, this.gameCardValues);

		}
		//et on mélange!
		this.gameCardValues = mixArray(this.gameCardValues);
		
		this.#displaySymbols(this.gameCardValues, this.gameMasterZone);
		
		//ajout d'une classe aléatoire pour faire varier les tailles
		const gameCards = document.getElementsByClassName('game-master-card');
		//const gameCardElements = document.getElementById('game-master').getElementsByTagName('input');
		console.log(gameCards);
		//console.log(gameCardElements)
		
		for (let i = 0; i < gameCards.length; i++) {
			
			let sizeClass = Math.floor(Math.random()*5);
			gameCards[i].classList.add('size-' + sizeClass);
			
		}
		
		clearTimeout(this.restartGameTimeOut);
		clearTimeout(this.fadeOutTimeOut);
		this.restartGameTimeOut = setTimeout(this.#drawNewCard.bind(this), this.displayTime, false); //changement automatique de carte après un temps
		this.fadeOutTimeOut = setTimeout(this.#setClassFadeOut.bind(this), this.displayTime - 1000);
	}
	
	#setClassFadeOut() {
		
		const gameCardElements = document.getElementById('game-master').getElementsByTagName('input');
		for (let i = 0; i < gameCardElements.length; i++){
			gameCardElements[i].classList.add('fade-out');
		}
		
		console.log('time');
	}
	
	// transfère un élément aléatoire d'un array vers un autre, utilise randomIndex et transferElement
	#transfer(arraySource, arrayTarget) {
		const j = randomIndex(arraySource);
		transferElement(arraySource, j, arrayTarget);
	}
	
	// vérifie si l'élément cliqué se retrouve dans la carte à comparer
	#controlImg(symbolNumber) {
		
		const gameCard = document.getElementById('game-master');
		const gameCardElements = gameCard.getElementsByTagName('input');
		const values = [];
		let victory = false;
		for (let i = 0; i < gameCardElements.length; i++){
			values.push(gameCardElements[i].value);
		}
		if (values.includes(symbolNumber)){
			// Victoire
			console.log('gagné');
			transferElement(this.spreadMessage, 0, this.solutionParts);
			this.solutionParts.forEach((solutionPart) => {this.solutionZone.innerHTML += solutionPart});
			victory = true;
		}
		else {
			victory = false;
			// Echec
			console.log('perdu');
		}
		
		this.#drawNewCard(victory);	
	}	
}