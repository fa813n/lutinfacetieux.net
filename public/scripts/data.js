const inputZone = document.getElementById('input-zone');
//const gameZone = document.getElementById('game');
const answerZone = document.getElementById('answer');
const instructionsZone = document.getElementById('instructions');
const gameZone = document.getElementById('game-zone');
//const solutionZone= document.getElementById('solution-zone');
const imageFolder = '../../images/';

let urlParams =  new URLSearchParams(document.location.search);
let cellNumber = urlParams.get("cellNumber");

const alphabet = ["a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z"];

const gameConstructor = `{
	"letters-to-symbols" : {"object" : "LettersToSymbols", "parameters" : ["message", "graphic-theme"]},
	"flags" : {"object" : "Flags", "parameters" : ["message"]},
	"scroll-images" : {"object" : "ScrollImages", "parameters" : ["message", "graphic-theme", "difficulty"]},
	"memory" : {"object" : "Memory", "parameters" : ["message", "graphic-theme", "difficulty"]},
	"dobble" : {"object" : "Dobble", "parameters" : ["message", "graphic-theme", "difficulty"]}
}`;
/*
const flagList = {
	a: ['Albanie', 'Algerie', 'Allemagne', 'Arabie-saoudite', 'Argentine', 'Armenie', 'Australie', 'Autriche'], 
	b:['Belgique', 'Benin', 'Bresil', 'Burkina-fasso'], c:['Cambodge', 'Cameroun',  'Canada', 'Chili', 'Chine', 'Comores', 'Congo', 'Coree-du-sud', 'Croatie'], 
	d:['Danemark', 'Djibouti'], e:['Egypte', 'Espagne'], f:['Finlande', 'France'], 
	g:['Gabon', 'Grece'], h:['Haiti', 'Hongrie'], i:['Inde', 'Irlande', 'Islande', 'Israel', 'Italie'], j:['Jamaique', 'Japon'], k:['Kazakhstan', 'Kenya', 'Koweit'], l:['Laos', 'Liban', 'Luxembourg'], 
	m:['Mali', 'Maroc', 'Mauritanie', 'Mexique'], n:['Nepal', 'Nicaragua', 'Nicaragua', 'Nigeria', 'Norvege'], o:['Ouganda', 'Ouzbekistan'], p:['Pakistan', 'Palestine', 'Pays-bas', 'Philippines', 'Pologne', 'Portugal'], 
	q:['Qatar'], r:['Rwanda', 'Roumanie', 'Russie'], s:['Senegal', 'Singapour', 'Suede', 'Suisse'], t:['Thailande', 'Togo', 'Tunisie', 'Turquie'], u:['Ukraine', 'Usa'], v:['Vatican', 'Venezuela', 'Vietnam'], 
	y:['Yemen'], z:['Zambie', 'Zimbabwe']
	};
*/	
	
// tableau qui stocke les Id créés la fonction setInterval, pour avoir un scope global et pouvoir tout réinitialiser, et éviter une accelération à chaque clic, c'est dégueu mais j'ai pas trouvé mieux
const IntervallIds = [];



