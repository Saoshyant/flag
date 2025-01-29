let attemptsLeft = 6;

const words = [
	"Amigo",
	"Presente",
	"Portugal",
	"Algarve",
	"Portalegre",
	"Chinchila",
	"Australopiteco",
	"Espirituosocaturiscadamente",
	"Efectivamente",
	"Otorrinolaringologista",
	"Pneumoultramicroscopicossilicovulcanoconiose"
];

const chosenWord = words[  Math.floor(Math.random() * words.length) ];

console.log(chosenWord);

/*
preencher o numero de SPANs com underscores _ na pagina depois de escolhida a palavra aleatoria
o número de SPANs depende do numero de letras que a palavra tenha
por cada letra, criar um SPAN, ou seja, executar um ciclo
*/

const gameArea = document.getElementById("gameArea");

for(let i = 0; i < chosenWord.length; i++) {

	gameArea.appendChild( document.createElement("span") );

	gameArea.lastElementChild.textContent = "_";
}

/* 
criar código para gerir formulário, obter a letra escolhida pelo utilizador dentro de uma variavel
*/

const form = document.querySelector("form");
const attemptsDisplay = document.getElementById("attemptsDisplay");

form.addEventListener("submit", function(event) {
	
	event.preventDefault();

	const letterPicked = form.letter.value.toUpperCase();

	form.letter.value = "";

	console.log("letra do formulario", letterPicked);
	
	let isCorrect = false;

	for(let i = 0; i < chosenWord.length; i++) {

		let currentLetter = chosenWord[i].toUpperCase();

		if(letterPicked === currentLetter) {
			/*
			   obtendo acesso aos SPANs que estão na página em forma de array 
			   vamos colocar na posição correcta a letra encontrada (textContent do SPAN em causa)
			*/
			isCorrect = true;
			gameArea.children[i].textContent = currentLetter;
		}
	}

	/*
	cada vez que o utilizador não acertar em nenhum letra,
	perde uma tentativa.
	*/
	if(isCorrect === false) {
		attemptsLeft--;

		attemptsDisplay.lastElementChild.textContent = attemptsLeft;

		if(attemptsLeft === 0) {
			alert("GAME OVER");
			window.location.reload();
		}
	}

});
