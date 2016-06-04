/**
 * @author dpie
 */


var HttpReq = null;
var tipo_retorno= null;
var separador=null;
var retorno=null;
 
function chamar_ajax(url, dados, tipo, tretorno, str){
	tipo_retorno = tretorno;
	separador = str;
	ajax(url, dados, tipo);
	return retorno;
}

function ajax(url, dados, tipo){
	if (document.getElementById) //Verifica se o Browser suporta DHTML.
	{
		HttpReq = GetXmlHttpObject();
		HttpReq.open("POST", url, tipo);
		HttpReq.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=ISO-8859-1");
		HttpReq.send(dados);
		try {
			HttpReq.onreadystatechange = XMLHttpRequestChange();
		} 
		catch (e) {
			HttpReq.onreadystatechange = XMLHttpRequestChange;
		}
	}
}


//verifica se o browser suporta o Ajax e cria XMLHttpRequest
 function GetXmlHttpObject(){
 	var xmlHttp = null;
 	try {
 		// Firefox, Opera 8.0+, Safari
			xmlHttp = new XMLHttpRequest();
		} 
		catch (e) {
			// Internet Explorer
			try {
				xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
			} 
			catch (e) {
				xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
		}
		return xmlHttp;
	}

//verifica o status da requisição Ajax e quando e depois chama a função que ira definir que função ira processar o dados retornados  
function XMLHttpRequestChange(){
	if (HttpReq.readyState == 4) {
		if (HttpReq.status == 200) {
			if (tipo_retorno == "xml") {
				retorno = HttpReq.responseXML;
			}
			else {
				if (tipo_retorno == "m") { //se matriz ele carega uma string e despois tratar transfoma ela com uma matriz
					var texto = new String(HttpReq.responseText);
					retorno = texto.split(separador); /* split trabalho o vetor ...	 */
				}
				else {
					retorno = HttpReq.responseText;
					//window.alert(retorno);
				}
			}
		}
		else {
			window.alert("erro ao HttpReq.status");
		}
	}
}

	