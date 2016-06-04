/**
 * biblioteca com funçoes pra manipular objeto select do javascript
 * 
 * @author antoniomc
 */

function criar_option(Id, indice, texto, valor){
	document.getElementById(Id)[indice] = new Option(texto, valor);
}

function recupera_por_id(Id, indice, tipo){
	if (tipo == 'text') {
		return document.getElementById(Id)[indice].text;
	}
	if (tipo == 'value') {
		return document.getElementById(Id)[indice].value;
	}
}	
	
function recupera_por_text(Id, valor, tipo){
	var x = document.getElementById(Id).length;
	for (var indice = 0; indice < x; indice++) {
		if (document.getElementById(Id)[indice].text == valor) {
			if (tipo == 'indice') {
				return indice;
			}
			if (tipo == 'value') {
				return document.getElementById(Id)[indice].value;
			}
		}
	}
}

function recupera_por_value(Id, valor, tipo){
	var x = document.getElementById(Id).length;
	for (var indice = 0; indice < x; indice++) {
		if (document.getElementById(Id)[indice].value == valor) {
			if (tipo == 'indice') {
				return indice;
			}
			if (tipo == 'text') {
				return document.getElementById(Id)[indice].text;
			}
		}
	}
}

function n_option(Id){
	return document.getElementById(Id).length;
}

function option_selecionado(Id){
  return document.getElementById(Id).selectedIndex;
}

function selcionar_option(Id, tipo,valor){
	if (tipo == 'indice') {
		var a = document.getElementById(Id).length;
		if (a>0){
			document.getElementById(Id)[valor].selected = true;
		}
	}
	else {
		var x = document.getElementById(Id).length;
		for (var indice = 0; indice < x; indice++) {
			if (tipo == 'text') {
				var teste = document.getElementById(Id)[indice].text;
			}
			if (tipo == 'value') {
				var teste = document.getElementById(Id)[indice].value;
			}
			if (teste == valor) {
				document.getElementById(Id)[indice].selected = true;
			}
		}
		
	}
}
function remover_option(Id, tipo,valor){
	if (tipo == 'indice') {
		document.getElementById(Id).remove(valor);
	}
	else {
		var x = document.getElementById(Id).length;
		for (var indice = 0; indice < x; indice++) {
			if (tipo == 'text') {
				var teste = document.getElementById(Id)[indice].text;
			}
			if (tipo == 'value') {
				var teste = document.getElementById(Id)[indice].value;
			}
			if (teste == valor) {
				document.getElementById(Id).remove(indice);
				break;
			}
		}
		
	}
}

function limpar_Id(Id){
	document.getElementById(Id).length = 0;
}

function aumetar_list(Id){
	document.getElementById(Id).size=document.getElementById(Id).size++;
}

function diminuir_list(Id){
	document.getElementById(Id).size=document.getElementById(Id).size--;
}

function definir_size(Id ,valor){
	document.getElementById(Id).size= valor;
}

function carregar_combo(doc_xml, combo, texto, valor){
	var indice = 1
	document.getElementById(combo).style.fontSize = "1em";
	document.getElementById(combo).length=0;
	var x=parseInt(valor_xml(doc_xml, 'nreg', 0));
	for (var i = 0; i < x ; i++) {
		// window.alert(String(valor_xml(doc_xml, texto, i)));
		if (valor == null) {
		criar_option(combo, indice, valor_xml(doc_xml, texto, i), valor_xml(doc_xml, texto, i)+i);
		}
		else {
			criar_option(combo, indice, valor_xml(doc_xml, texto, i), valor_xml(doc_xml, valor, i));
		}
		indice++;
	}
}
