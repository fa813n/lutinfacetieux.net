class LettersToSymbols 
{
	constructor(parameters) {
		this.instructions = 'Déchiffrez le message codé ci dessous! chaque dessin représente une lettre';
		this.message = parameters['message'].toLowerCase();
		this.graphicTheme = parameters['graphic-theme'];
	}
	
	//const instructions = 'Déchiffrez le message codé ci dessous! chaque dessin représente une lettre';
	
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
			const symbol = new Symbol(value, graphicTheme)
			const imagePath = symbol.imagePath();
			imagePaths.push('<img src="' + imagePath + '">');
			//imagePaths.push('<img src="./data/images/' + graphicTheme + '/' + graphicTheme +' ('+ value + ').png">');
		}

		const encodedAlphabet = associate(alphabet, imagePaths);

		const messageObject = new EncodeMessage(this.message, encodedAlphabet);
		const encodedMessage = messageObject.encode();

		const displaySymbols = messageObject.displaySymbols(encodedMessage, gameZone, 'letters-to-symbol');
	}
}