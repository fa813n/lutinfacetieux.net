class EncodeMessage {
	constructor(message, code) {
		this.message = message;
		this.code = code;
	}
	//crée une liste de symboles à partir d'un message
	encode() {
		let encodedMessage = [];
		for (let i = 0; i < this.message.length; i++) {
			const letter = this.message[i];

			let symbol = '';
			const symbols = this.code.get(letter);

			if (symbols) {  //pour le cas où plusieurs symboles peuvent être associés à la même lettre, on en choisi un aléatoirement
				symbol = symbols[Math.floor(Math.random()*symbols.length)];
			}
			else {
				symbol = letter;
			}
			encodedMessage.push(symbol);
		}
		return encodedMessage;
	}
	
	//crée un div avec un symbole (ex image issue d'un encodage de message) dans une zone d'affichage
	displaySymbol(symbol, displayZone) {
		const sampleSymbol = document.createElement('div');
		sampleSymbol.setAttribute('class', 'sample-symbol');
		sampleSymbol.innerHTML = symbol;
		displayZone.appendChild(sampleSymbol);
	}
	
	//affiche une série de symboles
	displaySymbols(encodedMessage, displayZone, zoneId) {
		displayZone.setAttribute('id', zoneId);
		for (let i = 0; i < encodedMessage.length; i++) {
			let displayedSymbol = this.displaySymbol(encodedMessage[i], displayZone);
		}
	}
}
				