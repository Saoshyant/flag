// js24-randomrgb.js
console.log("funca");

//const body = document.getElementsByTagName("body")[0];
const body = document.querySelector("body");

console.log(body);

/*
	a cada 5 segundos que passam, a cor de fundo do BODY
	vai mudar aleatoriamente
	
	isso implica calcular três números aleatórios
	(R)ed (G)reen (B)lue
	que vão cada um deles de 0 a 255
	
	como revisão, em CSS, mudar o background-color do body poderia ser feito desta forma como exemplo:
	
	body { background-color: rgb(21, 120, 200); }

	em JS para fazer isto tenho que usar a propriedade "style"
	sobre o meu elemento de HTML "body" mais a regra de 
	"backgroundColor"
*/

function randomLight() {
	/* quando uma função tem que passar algo para fora dela,
	   usa-se a keyword "return" para passar o valor pretendido
	   a keyword "return" força sempre o termino da função (é assumido que todo o trabalho já foi feito)
	*/
	return Math.floor(Math.random() * 256);

	console.log("ele já não executa isto"); // unreachable
}

setInterval(function() {

	const r = randomLight(); // recebeu o resultado da função
	const g = randomLight();
	const b = randomLight();

	body.style.backgroundColor = "rgb(" + r + ", " + g + ", " + b + ")";

	
}, 5000);






