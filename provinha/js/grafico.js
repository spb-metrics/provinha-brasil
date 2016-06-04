function Iniciar() {
	// Carrega Ano
	var varXML = chamar_ajax("php/filtros/filtro_sql.php", "filtro=16", false,
			"xml", null);
	// Parâmetros: variável XML, id do combo a ser carregado, nome do campo de
	// exibição (texto), nome do campo de ID (valor)
	limpar_Id("cboTurma")
	limpar_Id("cboSerie")
	limpar_Id("cboFase")
	selcionar_option('cboAno', 'indice',0);
	selcionar_option('cboTipo', 'indice',0);
	carregar_combo(varXML, "cboAno", "ano", "ano");

}

function CarregaFase() {
	var ano = recupera_por_id("cboAno", option_selecionado("cboAno"), "text");
	// Carrega Cidade
	var varXML = chamar_ajax("php/filtros/filtro_sql.php", "filtro=17&ano="
			+ ano, false, "xml", null);
	// Parâmetros: variável XML, id do combo a ser carregado, nome do campo de
	// exibição (texto), nome do campo de ID (valor)
	limpar_Id("cboTurma")
	limpar_Id("cboSerie")
	carregar_combo(varXML, "cboFase", "cod_fase", "cod_fase");
}

function CarregaSerie() {
	var ano = recupera_por_id("cboAno", option_selecionado("cboAno"), "text");
	// Carrega Cidade
	var varXML = chamar_ajax("php/filtros/filtro_sql.php", "filtro=18&ano="
			+ ano, false, "xml", null);
	// Parâmetros: variável XML, id do combo a ser carregado, nome do campo de
	// exibição (texto), nome do campo de ID (valor)
	limpar_Id("cboTurma")
	carregar_combo(varXML, "cboSerie", "Serie", "idSerie");
}

function CarregaTurma() {
	// var serie = document.getElementById("cboSerie").value;
	// var fase = document.getElementById("cboFase").value;
	var serie = recupera_por_id("cboSerie", option_selecionado("cboSerie"),
			"value");
	var fase = recupera_por_id("cboFase", option_selecionado("cboFase"),
			"value");
	// Carrega Cidade
	var varXML = chamar_ajax("php/filtros/filtro_sql.php", "filtro=19&serie="
			+ serie + "&fase=" + fase, false, "xml", null);
	// Parâmetros: variável XML, id do combo a ser carregado, nome do campo de
	// exibição (texto), nome do campo de ID (valor)
	carregar_combo(varXML, "cboTurma", "Turma", "idTurma");
}

function DefineVarGrafico() {
	var objFrame = document.getElementById("telaGrafico");
	if (validar()) {
		var xml = chamar_ajax('php/filtros/defineVarGrafico.php',
				'filtro=1&gtipo=' + document.getElementById('cboTipo').value
						+ '&gturma='
						+ document.getElementById('cboTurma').value
						+ '&gserie='
						+ document.getElementById('cboSerie').value + '&gano='
						+ document.getElementById('cboAno').value + '&gfase='
						+ document.getElementById('cboFase').value, false,
				null, null);
		objFrame.src = "gerar_grafico.html"
	}
}

function SelecionaTipo(indice) {
	limpar_Id("cboTurma")
	limpar_Id("cboSerie")
	limpar_Id("cboFase")
	selcionar_option('cboAno', 'indice',0);
	if (indice > 1) {
		document.getElementById('tbTurma').style.display = "inline";
	} else {
		document.getElementById('tbTurma').style.display = "none";
		selcionar_option('cboSerie', 'indice',0);
		selcionar_option('cboTurma', 'indice',0);
	}
}

function validar() {
	i = document.getElementById('cboTipo').value;
	if (option_selecionado('cboAno') == 0) {
		alert("Selecione um ano!");
		return false;
	}
	if (option_selecionado('cboFase') == 0) {
		alert("Selecione uma fase!");
		return false;
	}
	if (i > 1) {
		if (option_selecionado('cboSerie') == 0) {
			alert("Selecione uma série!");
			return false;
		}
		if (option_selecionado('cboTurma') == 0) {
			alert("Selecione uma turma!");
			return false;
		}
	}
	return true;
}
