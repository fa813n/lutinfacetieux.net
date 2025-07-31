class LettersToSymbols 
{
	constructor(parameters) {
		this.message = parameters['message'].toLowerCase();
		this.graphicTheme = parameters['graphic-theme'];
	}
	
	
	
	createGame() {
		
		// Création du tableau asociatif alphabet => symboles
		const numberOfSymbols = 31; // à définir en fonction du nombre d'images dans le dossier du theme choisi
		const graphicTheme = this.graphicTheme;
		const arrayOfValues = [];
		const imagePaths = [];
		for (let i = 1; i<= numberOfSymbols; i++) {
			arrayOfValues.push(i);
		}
		
		const mixedValues = mixArray(arrayOfValues);
		mixedValues.forEach(setImagePath);
		function setImagePath(value) {
			imagePaths.push('<img src="./data/images/' + graphicTheme + '/' + graphicTheme +' ('+ value + ').png">');
		}

		const encodedAlphabet = associate(alphabet, imagePaths);

		const messageObject = new EncodeMessage(this.message, encodedAlphabet);
		const encodedMessage = messageObject.encode();

		const displaySymbols = messageObject.displaySymbols(encodedMessage, demoZone, 'letters-to-symbol');
	}
}