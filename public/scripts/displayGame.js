//document.getElementById('fill-me-too').innerText = 'filled again';
function displayGame(parameters) {
  //const obj = JSON.parse(parameters);
  //document.getElementById('fill-me-too').innerText = parameters['message'] + 'stuff';
  //alert('function loaded')
  
   const game = {};
    
    /*let parameters = JSON.parse(parameters);*/
    
    chosenGame = parameters['chosen-game'];
    document.getElementById('fill-me-too').innerText = chosenGame; 
    switch (chosenGame) {
        case "letters-to-symbols":
            document.getElementById('fill-me-too').innerText = parameters; 
            game = new LettersToSymbols(parameters);
            break;

        case "flags":
            game = new Flags(parameters);
            break;

        case "scroll-images":
            game = new ScrollImages(parameters);
            break;

        case "memory":
            game = new Memory(parameters);
            break;
    }
    
    game.createGame();
}
//displayGame('pop');
//document.getElementById('fill-me-too').innerText = 'filled once again';