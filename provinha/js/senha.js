/**
 * @author antoniomc
 */
function iniciar(){
	testar_login();
}
 
function alterar(){
	var txt_atual = document.getElementById('txt_atual').value;
	var txt_nova = document.getElementById('txt_nova').value;
	var txt_confirma = document.getElementById('txt_confirma').value;
	if (txt_nova != '' && txt_atual != '' && txt_confirma != '') {
		if (txt_nova != txt_atual) {
			if (txt_nova == txt_confirma) {
				var dados = 'txt_atual=' + txt_atual;
				dados += '&txt_nova=' + txt_nova;
				var xml  = chamar_ajax('php/alterar.php', dados, false, 'xml', null);
				var men = valor_xml(xml,'men', 0);
				if (men == 'ok') {
					window.alert('Senha alterada com sucesso!');
				}
				else {
					window.alert(men);
				}
			}
			else {
				window.alert("A senha nova não é a mesma que a de confirmação!");
			}
		}
		else {
			window.alert("A senha atual não pode ser a mesma que a nova!");
		}
	}
	else {
		window.alert('Todos os campos são de preenchimento obrigatório!')
	}
}
