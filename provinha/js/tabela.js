/**
 * @author antoniomc
 */
function adiciona_linha(id, qtd_linha, id_linha, qtd_cell, id_celula, inicio){
	var inicio = inicio;
	for (L = inicio; L <= qtd_linha; L++) {
		var texto = id_linha + L;
		var linha = document.getElementById(id).insertRow(L);
		linha.setAttribute('id', texto);
		if (qtd_cell > 0) {
			var texto1 = texto + id_celula;
			adiciona_celula(texto, qtd_cell, texto1,linha);
		}
	}
}


function adiciona_celula(id, qtd, id_celula,linha){
	var celula = new Array(qtd);
	for (var i = 0; i < celula.length; i++) {
		celula[i] = linha.insertCell(i);
		celula[i].setAttribute('id', id_celula + i);
	}
}