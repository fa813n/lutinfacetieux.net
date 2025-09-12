class Memory {
	constructor(parameters) {
		
		this.message = parameters['message'];
		
		this.solutionZone = {};
		
		this.graphicTheme = parameters['graphic-theme'];
		this.difficulty = parameters['difficulty'];
		this.numberOfCards = 0;
		this.duplicates = 0; //nb cartes identiques à retourner
		this.cardValues = [];
		this.memoryCards = {};
		
		this.lastTurnedCard = '';
		this.turnedCardValue;
		
		
		switch (this.difficulty) {
			case 'easy' :
			this.numberOfCards = 10;
			this.duplicates = 2;
			break;
			
			case 'medium' : 
			this.numberOfCards = 16;
			this.duplicates = 3;
			break;
			
			case 'hard' :
			this.numberOfCards = 20;
			this.duplicates = 4;
			break;
		}
		let i = 1;
		while (i <= this.numberOfCards) {
			let j = 1;
			while (j <= this.duplicates) {
				this.cardValues.push(i);
				j++;
			}
			i++;
		}
		this.spreadMessage = cutMessage(this.message, this.numberOfCards);
		this.instructions = 'Retournez ' + this.duplicates + ' cartes identiques pour faire apparaître le message caché';
		//console.log(this.spreadMessage);
	}
	
	
	createGame() {
		
		// à décommenter pour un mélange aléatoire
		//let randomValues = this.cardValues;
		let randomValues = mixArray(this.cardValues);
		
		const cardsZone = document.createElement('div');
		cardsZone.setAttribute('id', 'memory');
		cardsZone.setAttribute('class', this.difficulty);
		
		this.solutionZone = document.createElement('div');
		this.solutionZone.setAttribute('id', 'solution-zone');
		
		gameZone.appendChild(cardsZone);
		gameZone.appendChild(this.solutionZone);
		
		let turnedCardValue;
		let cards = document.getElementsByClassName('memoryCard');
		
		for (let i = 0; i < randomValues.length; i++) {
			if (!this.memoryCards[i]) {
				this.memoryCards[i] = {};
			}
			let j = randomValues[i];
			this.memoryCards[i]['cardValue'] = j;
			//
			this.memoryCards[i]['container'] = document.createElement('div');
			this.memoryCards[i]['container'].setAttribute('class', 'card-container');
			cardsZone.appendChild(this.memoryCards[i]['container']);
			//
			this.memoryCards[i]['htmlElement'] = document.createElement('input');
			this.memoryCards[i]['htmlElement'].setAttribute('type', 'image');
			this.memoryCards[i]['htmlElement'].setAttribute('src', '../../images/question-mark.png');
			this.memoryCards[i]['htmlElement'].setAttribute('class', 'memory-card-back');
			this.memoryCards[i]['hiddenImgSrc'] = '../../images/' + this.graphicTheme + '/' + this.graphicTheme +' ('+ j + ').png';
			this.memoryCards[i]['htmlElement'].setAttribute('value', '?');

			//cardsZone.appendChild(this.memoryCards[i]['htmlElement']);
			this.memoryCards[i]['container'].appendChild(this.memoryCards[i]['htmlElement']);			
			//console.log(this.memoryCards[i]['hiddenImgSrc']);
			this.memoryCards[i]['htmlElement'].addEventListener("click", () => {this.#controlTurnedCards(i)});
		}
	}
	
	#controlTurnedCards(i) {
		// getElementsByClassName renvoie une collection mise à jour en temps réel, c'est pourquoi il faut d'abord passer par un array pour pouvoir boucler dessus
		let turnedCards = Array.from(document.getElementsByClassName('memory-card-front'));

		const card = this.memoryCards[i];
		console.log(this.lastTurnedCard);


		if (card['htmlElement'].value == '?') { // on ne tient pas compte d'un clic sur case déjà tournée
			if ((turnedCards.length == 0) || (card['cardValue'] == this.lastTurnedCard)) {
				console.log('case 1');
				card['htmlElement'].setAttribute('class', 'memory-card-front');
				card['htmlElement'].setAttribute('src', card['hiddenImgSrc']);
				card['htmlElement'].setAttribute('value', card['cardValue']);

				this.lastTurnedCard = card['cardValue'];
				
				if (turnedCards.length == (this.duplicates - 1)) {
					console.log ('you win !');
					this.solutionZone.innerHTML += this.spreadMessage.shift();
					for (let turnedCard of turnedCards) {
						turnedCard.setAttribute('class', 'memory-card-won');
					}
					card['htmlElement'].setAttribute('class', 'memory-card-won');
				}
					
			}
			else {
				
				// Si on a retourné une carte différente de celles déjà retournées, on la laisse voir avant de tout remttre "face contre table"
				card['htmlElement'].setAttribute('value', card['cardValue']);
				card['htmlElement'].setAttribute('src', card['hiddenImgSrc']);
				setTimeout(function() {
					
					card['htmlElement'].setAttribute('value', '?');
					card['htmlElement'].setAttribute('src', '../../images/question-mark.png');

					for (let turnedCard of turnedCards) {

						turnedCard.setAttribute('class', 'memory-card-back');
						turnedCard.setAttribute('src', '../../images/question-mark.png');
						turnedCard.setAttribute('value', '?');
					}
				}, 750);
			}
		}
	}
}