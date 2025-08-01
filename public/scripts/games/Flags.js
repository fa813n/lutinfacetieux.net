class Flags {
	constructor(parameters) {
		this.message = parameters['message'].toLowerCase();
		const flagImagePaths = {}
		for (let i in flagList) {
			flagImagePaths[i] = [];
			for (let j in flagList[i]) {
				let imagePath = '<img src="../images/flags/' + flagList[i][j] + '.png">';
				flagImagePaths[i].push(imagePath);
			}
		}
		this.code = new Map(Object.entries(flagImagePaths));
	}
	createGame() {

		const messageObject = new EncodeMessage(this.message, this.code);
		const encodedMessage = messageObject.encode();
		const displaySymbols = messageObject.displaySymbols(encodedMessage, demoZone, 'flags');
	}
}