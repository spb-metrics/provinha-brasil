/**
 * @author antoniomc
 */
 function testar_login(){
 	var xml = chamar_ajax('php/filtros/filtro_xml.php', null, false, 'xml', null);
 	var existe = valor_xml(xml,'existe', 0);
 	if (existe != "sim") {
     	window.location.href="index.html";
 		window.alert('Acesso negado!!! erro de permissão!!');
 	}
 }