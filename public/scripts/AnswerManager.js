class AnswerManager {
	constructor(answer, nbParts) {
		this.answer = answer;
		this.nbParts = nbParts;
		
		this.answerArray = [];
		let partLength = Math.round(this.answer.length / this.nbParts);
		for (let i = 0; i < (nbParts - 1); i++) {
			this.answerArray[i] = this.answer.slice(partLength * i, partLength * (i+1));
		}
		this.answerArray[(this.nbParts - 1)] = this.answer.slice((nbParts - 1)*partLength);
		
		this.revealedParts = [];
	}
	
	transferArrayElement(arraySource, arrayTarget, sourceIndex, position = 'end') {
		let removed = arraySource.splice(sourceIndex, 1);
		if (position === 'end') {
			arrayTarget.push(removed[0]);
		}
		else if (position === 'start') {
				arrayTarget.unshift(removed[0]);
		}
	}
	
	addAnswerPart() {
		const answerStep = {
			revealedString : '',
			finished : false
		};
		//let revealedString = '';
		if (this.answerArray.length > 0) {
			this.transferArrayElement(this.answerArray, this.revealedParts, 0);
			this.revealedParts.forEach((revealedPart) => {answerStep.revealedString += revealedPart});
		}
		if (this.answerArray.length === 0){
			answerStep.finished = true;
		}
		return answerStep;
	}
	removeAnswerPart() {
		const answerStep = {
			revealedString : '',
		}
		//let revealedString = '';
		if (this.revealedParts.length > 0) {
			this.transferArrayElement(this.revealedParts, this.answerArray, this.revealedParts.length - 1, 'start');
			this.revealedParts.forEach((revealedPart) => {answerStep.revealedString += revealedPart});
		}
		return answerStep;
	}	
}