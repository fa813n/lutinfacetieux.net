class ScrollImages {
	constructor (parameters) {
		this.instructions = 'Déchiffrez le message codé ci dessous!';
		this.message = parameters['message'];
		this.graphicTheme = parameters['graphic-theme'];
		this.difficulty = parameters['difficulty'];
	}
	
	#alternateImages(graphicTheme, letter, nbChanges, divId) {
		let letterDivContent = '';
		
		
		if (letter === ' ') {
			letterDivContent = '<span class="scroll-image"></span>';
			/*
			letterDivContent = document.createElement('span');
			letterDivContent.setAttribute('class', 'scroll-image');
			*/
		}
		else {
			let i = Math.floor(Math.random()*nbChanges);
			if (i === 1) {
				letterDivContent = '<span class="scroll-images">' + letter.toUpperCase() + '</span>';
			}
			else {
				const j = Math.floor(Math.random()*31) + 1;
				const symbol = new Symbol(j, graphicTheme);
				letterDivContent = '<img src="' + symbol.imagePath() + '" class="scroll-image-sample">';
				
			}
		}
		let letterDiv = document.getElementById(divId);
	
		letterDiv.innerHTML = letterDivContent;
	
	}
	
	createGame() {
		let IntervallId = '';
	
		//remise à 0 des timers
		if (IntervallIds.length > 0) {
			for (let i = 0; i < IntervallIds.length; i++) {
				clearInterval(IntervallIds[i]);
			}
			IntervallIds.length = 0;
			
		}

		const gameContainer = document.createElement('div');
		gameContainer.setAttribute('id', 'game-container');
		gameZone.appendChild(gameContainer);
		gameContainer.innerHtmlm = '';
		
		let speed;
		let nbChanges;
		
		
		for (let i = 0; i < this.message.length; i++) {
			
			let letter = this.message[i];
			let letterDiv = document.createElement('div');
			letterDiv.setAttribute('id', i);
			letterDiv.setAttribute('class', 'sample-symbol');
			gameContainer.appendChild(letterDiv);
			
			// modulation de la vitesse et du nombre d'images en fonction de la difficulté choisie
			switch (this.difficulty) {
			
				case 'easy' : 
				speed = Math.floor(Math.random()*400) + 200;
				nbChanges = 4;
				break;
				
				case 'medium' : 
				speed = Math.floor(Math.random()*200) + 150;
				nbChanges = 8;
				break;
				
				case 'hard' : 
				speed = Math.floor(Math.random()*100) + 100;
				nbChanges = 16;
				break;
			}
			IntervallId = setInterval(this.#alternateImages, speed, this.graphicTheme, letter, nbChanges, i);
			IntervallIds.push(IntervallId);


		}
	}	
	
}