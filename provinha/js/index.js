/**
 * @author antoniomc
 */
function iniciar(){
	var xml = chamar_ajax('php/filtros/define.php', null, true, null, null);
	document.getElementById('txt_nome').focus()
}

function testar(){
	if (vazio('txt_nome')) {
		window.alert('Preencha o campo Login:');
		document.getElementById('txt_nome').focus();
	}
	else {
		var usuario = document.getElementById('txt_nome').value;
		var senha = document.getElementById('txt_senha').value;
		var xml = chamar_ajax('php/index.php', 'txt_nome='+usuario+'&txt_senha='+ senha, false, 'xml', null);
		if ( valor_xml(xml,'men', 0) != 'ok') {
			window.alert(valor_xml(xml,'men', 0));
		}
		else{
			window.location.href="inicial.html";
		}
	}
}
function Fechar()
{
window.close();
}
