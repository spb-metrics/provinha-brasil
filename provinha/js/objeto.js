/**
 * biblioteca basica de objetos 
 * * @author dpie
 */

/*insere um objeto no html
 * pai:id de indentificação do objeto onde você vai servir de pono  
 * de inserção do objeto.
 * id: id de indentificação do objeto que vai ser criado
 * tipo: nome da tag que vai identificar o tipo do objeto
 */
function cria_objeto(pai,id,tipo){
  	var obj = document.getElementById(pai);
	var objselect = document.createElement(tipo);
	obj.appendChild(objselect);
	objselect.setAttribute('id',id);
    //objselect.setAttribute("onblur","selectlinha(this.id)");	
}

/*elimina um objeto do html
 * pai:id de indentificação do objeto onde você vai servir de pono de referencia 
 * para definir o objeto a ser eliminado
 * id: id de indentificação do objeto que vai ser eliminado
 */
function destruir_obj(idpai,idfilho){
 var pai = document.getElementById(idpai);
 var filho = document.getElementById(idfilho);
 pai.removeChild(filho);
}

/*verificao se o objeto esta vazio
 * id : define o objeto a ser verificado.
 */
function vazio(id){
	var qtd = document.getElementsByName(id).length;
	var texto = document.getElementById(id).value;
	if (texto == '' && qtd == 1) {
		return true;
	}
	else {
		return false;
	}
}

/*recupera um elemeto de um arquivo xml
 * doc_xml: vai ser um frgmento ou um docomento inteiro xml
 * tag: tag onde se encontra o texto
 * indice: indice para deinir qual dos elementos das tags vai ser selcionado
 */
function valor_xml(doc_xml,tag_name, indice){
	var tag = doc_xml.getElementsByTagName(tag_name);
	try {
		return tag[indice].childNodes[0].data;
	}
	catch (e){
		return "";
	}	
}

// coloca todo texto em maiusculo
function maiuscula(texto){
  var mudar = new String(texto);
  return mudar.toUpperCase();	
}

// coloca todo texto em minusculo
function minuscula(texto){
  var mudar = new String(texto);
  return mudar.toLowerCase;	
}

/* define numero de caracter maximo
 * id: defifine o objeto
 * maximo: numero maximo de caracter.
 */
function limite(id, maximo){
	var texto = new String(document.getElementById(id).value);
	var tamanho = parseInt(texto.length);
	document.getElementById(id).value;
	if (tamanho > maximo) {
		texto = texto.substr(0,maximo);
		document.getElementById(id).value = texto;
	}
}

/* define cor de fundo de um objeto
 * id: defifine o objeto
 * cor_nome: cor pelo nome da cor
 * cor_hexa: cor pelo valor hexadecimal caso o broser não suporte 
 * o a cor pelo nome da cor
 */
function def_cor_fundo(id, cor_nome, cor_hexa){
	try {
		document.getElementById(id).style.backgroundColor = cor_nome;
	} 
	catch (e) {
		document.getElementById(id).style.backgroundColor = cor_hexa;
	}
}

/* define cor da fonte
 * id: defifine o objeto
 * cor_nome: cor pelo nome da cor
 * cor_hexa: cor pelo valor hexadecimal caso o broser não suporte 
 * o a cor pelo nome da cor
 */
function def_cor_fonte(id, cor_nome,cor_hexa){
	try {
		document.getElementById(id).style.color = cor_nome;
	} 
	catch (e) {
		document.getElementById(id).style.color = cor_hexa;
	}
}

function muda_cor(nome, cor){
    switch (cor) {
        case 1:
            cor_nome = 'white';
            cor_hexa = 'ffffff';
            break;
        case 2:
            cor_nome = 'LightGray';
            cor_hexa = 'D3D3D3';
            break;
        case 3:
            cor_nome = 'LightSalmon';
            cor_hexa = 'FFA07A';
            break;
    }
    def_cor_fundo(nome, cor_nome, cor_hexa);
}