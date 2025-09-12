class Symbol {
	constructor(symbolNumber, graphicTheme) {
		this.graphicTheme = graphicTheme;
		this.symbolNumber = symbolNumber;
		
		this.extensions = {
			img: 'png',
			input: 'png'
			
		}
	}
	
	folderPath () {
		return('../../images/' + this.graphicTheme);
	}
	
	fileName(extension) {
		return(this.graphicTheme + ' ('+ this.symbolNumber + ').' + extension);
	}
	/*
	imagePath() {
		const folderPath = this.folderPath();;
		const imageName = this.imageName();
		const imagePath = folderPath + '/' + imageName;
		return imagePath;
	}
	*/
	filePath(extension) {
		const folderPath = this.folderPath();
		const fileName = this.fileName(extension);
		const filePath = folderPath + '/' + fileName;
		return filePath;
	}
	imagePath() {
		return this.filePath('png');
	}
	
	toImage(attributes) {
		const imagePath = this.imagePath();
		const img = document.createElement('img');
		img.setAttribute('src', imagePath);
		for (let  attribute in attributes) {
			img.setAttribute(attribute, attributes[attribute]);
		}
		return img;
	}
	/*
	toElement(typeOfElement, attributes) {
		const extension = this.extension[typeOfElement];
		const filePath = this.filePath(extension);
		const elmt = document.createElement(typeOfElement);
		elmt.setAttribute('src', filePath);
		for (let  attribute in attributes) {
			elmt.setAttribute(attribute, attributes[attribute]);
		}
		return elmt;
	}
	*/
	/*
	toImage(attributes) {
		return this.toElement('img', attributes);
	}
	*/
	toInput(attributes) {
		const imagePath = this.imagePath();
		const inp = document.createElement('input');
		inp.setAttribute('type', 'image');
		inp.setAttribute('src', imagePath);
		for (let  attribute in attributes) {
			inp.setAttribute(attribute, attributes[attribute]);
		}
		return inp;
	}
}