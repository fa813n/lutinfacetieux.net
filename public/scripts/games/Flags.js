class Flags {
	constructor(parameters) {
		this.instructions = 'Vous êtes bon en géographie? Remplacez chaque drapeau par l\'initiale du pays qu\'il représente.';
		this.flagList = {
		a: ['Albanie', 'Algerie', 'Allemagne', 'Arabie-saoudite', 'Argentine', 'Armenie', 'Australie', 'Autriche'], 
		b:['Belgique', 'Benin', 'Bresil', 'Burkina-fasso'], c:['Cambodge', 'Cameroun',  'Canada', 'Chili', 'Chine', 'Comores', 'Congo', 'Coree-du-sud', 'Croatie'], 
		d:['Danemark', 'Djibouti'], e:['Egypte', 'Espagne'], f:['Finlande', 'France'], 
		g:['Gabon', 'Grece'], h:['Haiti', 'Hongrie'], i:['Inde', 'Irlande', 'Islande', 'Israel', 'Italie'], j:['Jamaique', 'Japon'], k:['Kazakhstan', 'Kenya', 'Koweit'], l:['Laos', 'Liban', 'Luxembourg'], 
		m:['Mali', 'Maroc', 'Mauritanie', 'Mexique'], n:['Nepal', 'Nicaragua', 'Nicaragua', 'Nigeria', 'Norvege'], o:['Ouganda', 'Ouzbekistan'], p:['Pakistan', 'Palestine', 'Pays-bas', 'Philippines', 'Pologne', 'Portugal'], 
		q:['Qatar'], r:['Rwanda', 'Roumanie', 'Russie'], s:['Senegal', 'Singapour', 'Suede', 'Suisse'], t:['Thailande', 'Togo', 'Tunisie', 'Turquie'], u:['Ukraine', 'Usa'], v:['Vatican', 'Venezuela', 'Vietnam'], 
		y:['Yemen'], z:['Zambie', 'Zimbabwe']
		};

		this.message = parameters['message'].toLowerCase();
		const flagImagePaths = {}
		for (let i in this.flagList) {
			flagImagePaths[i] = [];
			for (let j in this.flagList[i]) {
				let imagePath = '<img src="' + imageFolder + 'flags/' + this.flagList[i][j] + '.png">';
				flagImagePaths[i].push(imagePath);
			}
		}
		this.code = new Map(Object.entries(flagImagePaths));
	}
	createGame() {

		const messageObject = new EncodeMessage(this.message, this.code);
		const encodedMessage = messageObject.encode();
		const displaySymbols = messageObject.displaySymbols(encodedMessage, gameZone, 'flags');
	}
}