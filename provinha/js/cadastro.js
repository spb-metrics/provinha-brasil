// declarações globais
var n_cadastrados = null;
var dados = null;
var cod_aluno = null;
var gabarito = new Array(23);
var nota = new Array(24);
var nivel = null;
var nivel_aluno = null;

function iniciar() {
	testar_login();
	travar_options();
	document.getElementById('cmb_status').disabled = true;
	var xml = chamar_ajax("php/filtros/filtro_sql.php", "filtro=11", false,
			"xml", null);
	var x = parseInt(valor_xml(xml, 'nreg', 0));
	nivel = new Array(x);
	for (i = 0; i < x; i++) {
		nivel[i] = new Array(3);
		nivel[i][0] = valor_xml(xml, "idnivel", i);
		nivel[i][1] = valor_xml(xml, "menor", i);
		nivel[i][2] = valor_xml(xml, "maior", i);
	}
	var xml = chamar_ajax("php/filtros/filtro_sql.php", "filtro=0", false,
			"xml", null);
	qst_id = 1;
	for (i = 0; i <= 23; i++) {
		gabarito[i] = valor_xml(xml, "Q" + qst_id, 0);
		qst_id++;
	}
	var xml = chamar_ajax("php/filtros/filtro_sql.php", "filtro=9", false,
			"xml", null);
	for (i = 1; i <= 24; i++) {
		carregar_combo(xml, "cmb_q" + i, "resposta", "idresposta");
	}
	var xml = chamar_ajax("php/filtros/filtro_sql.php", "filtro=1", false,
			"xml", null);
	carregar_combo(xml, "cmb_status", "status", "cod_status");
	var xml = chamar_ajax("php/filtros/filtro_sql.php", "filtro=2", false,
			"xml", null);
	document.getElementById('txt_escola').value = valor_xml(xml, "escola", 0);
	var xml = chamar_ajax("php/filtros/filtro_sql.php", "filtro=3", false,
			"xml", null);
	carregar_combo(xml, "cmb_serie", "Serie", "idSerie");
}

function cmb_serie_onchange() {
	carrega_questionario(false, 1);
	travar_options();
	document.getElementById('cmb_status').disabled = true;
	document.getElementById('cmb_aluno').length = 0;
	document.getElementById('lst_aluno').length = 0;
	selcionar_option('cmb_status', 'indice', 0);
	var serie = recupera_por_id("cmb_serie", option_selecionado("cmb_serie"),
			"value");
	var xml = chamar_ajax("php/filtros/filtro_sql.php", "filtro=4&serie="
			+ serie, false, "xml", null);
	carregar_combo(xml, "cmb_turma", "Turma", "idTurma");
}

function cmb_turma_onchange() {
	carrega_questionario(false, 1);
	travar_options();
	document.getElementById('cmb_status').disabled = true;
	var turma = recupera_por_id("cmb_turma", option_selecionado("cmb_turma"),
			"value");
	var xml = chamar_ajax("php/filtros/filtro_sql.php", "&filtro=5&turma="
			+ turma, false, "xml", null);
	document.getElementById('txt_periodo').value = valor_xml(xml, "PERIODO", 0);
	var xml = chamar_ajax("php/filtros/filtro_sql.php",
			"filtro=6&forma=not exists", false, "xml", null);
	carregar_combo(xml, "cmb_aluno", "nome", "id_cidadao");
	var xml = chamar_ajax("php/filtros/filtro_sql.php",
			"filtro=6&forma=exists", false, "xml", null);
	carregar_combo(xml, "lst_aluno", "nome", "id_cidadao");
	document.getElementById('lst_aluno').remove(0);
}

function cmb_aluno_onchange() {
	carrega_questionario(true, 1);
	selcionar_option('cmb_status', 'text', 'Presente');
}

function caregar_nota() {
	for (i = 0; i <= 23; i++) {
		nota[i] = gabarito[i];
	}
	nota[24] = 24;
	x = nivel.length - 1;
	nivel_aluno = nivel[x][0];
}

function zerar_notas() {
	for (i = 0; i <= 24; i++) {
		nota[i] = 0;
	}
	nivel_aluno = nivel[0][0];
}

function carrega_questionario(carregar, cor) {
	document.getElementById('cmb_status').disabled = false;
	destravar_options()
	if (carregar) {
		caregar_nota();
		document.getElementById('txt_nota').value = nota[24];
		modo = 'value'
	} else {
		zerar_notas()
		document.getElementById('txt_nota').value = 0;
		modo = 'indice'
	}
	qst_id = 1;
	for (i = 0; i <= 23; i++) {
		var nome = 'cmb_q' + qst_id;
		muda_cor(nome, cor);
		def_cor_fundo(nome, cor_nome, cor_hexa);
		selcionar_option(nome, modo, nota[i]);
		qst_id++;
	}
}

function resposta(qst_id) {
	var nome = 'cmb_q' + qst_id;
	var rsp_id = qst_id - 1;
	var resposta_atual = parseInt(recupera_por_id(nome,
			option_selecionado(nome), 'value'));
	if (isNaN(resposta_atual)) {
		resposta_atual = 0;
	}
	if (resposta_atual != nota[rsp_id]) {
		if (nota[rsp_id] != gabarito[rsp_id]) {
			if (resposta_atual == gabarito[rsp_id]) {
				var cor = 1
				nota[24]++;
			}
		} else {
			if (resposta_atual != gabarito[rsp_id]) {
				var cor = 3
				nota[24]--;
			}
		}
		muda_cor(nome, cor);
		x = nivel.length;
		for (i = 0; i < x; i++) {
			if (nota[24] >= nivel[i][1] && nota[24] <= nivel[i][2]) {
				nivel_aluno = nivel[i][0];
			}
		}
		nota[rsp_id] = resposta_atual;
		document.getElementById('txt_nota').value = nota[24];
	}
}

// funcões para mexer com opitons
function zerar_options() {
	for (qst_id = 1; qst_id <= 24; qst_id++) {
		var nome = 'cmb_q' + qst_id;
		selcionar_option(nome, 'indice', 0);
	}
}

function travar_options() {
	for (qst_id = 1; qst_id <= 24; qst_id++) {
		var nome = 'cmb_q' + qst_id;
		document.getElementById(nome).disabled = true;
	}
}

function destravar_options() {
	for (qst_id = 1; qst_id <= 24; qst_id++) {
		var nome = 'cmb_q' + qst_id;
		document.getElementById(nome).disabled = false;
	}
}

function cmb_status_onchange() {
	var status = recupera_por_id('cmb_status',
			option_selecionado('cmb_status'), 'text');
	if (status != "Presente") {
		carrega_questionario(false, 2);
		travar_options();
	} else {
		destravar_options();
		cmb_aluno_onchange();
	}
}

function btn_salvar_onclick() {
	if (option_selecionado('cmb_status') == 0) {
		window.alert("Selecione o status do aluno!")
	} else {
		var status = recupera_por_id('cmb_status',
				option_selecionado('cmb_status'), 'text');
		var cod_aluno = recupera_por_id('cmb_aluno',
				option_selecionado('cmb_aluno'), 'value');
		var dados = "&operacao=incluir&cod_aluno=" + cod_aluno + "&status="
				+ status + "&nivel=" + nivel_aluno;
		var id = 1;
		for (i = 0; i <= 24; i++) {
			dados += "&nota_" + id + "=" + nota[i];
			id++;
		}
		var xml = chamar_ajax("php/gravar.php", dados, false, "xml", null);
		window.alert(valor_xml(xml, 'mensagem', 0));
		if (valor_xml(xml, 'teste', 0) == "ok") {
			var xml = chamar_ajax("php/filtros/filtro_sql.php",
					"filtro=6&forma=not exists", false, "xml", null);
			carregar_combo(xml, "cmb_aluno", "nome", "id_cidadao");
			var xml = chamar_ajax("php/filtros/filtro_sql.php",
					"filtro=6&forma=exists", false, "xml", null);
			carregar_combo(xml, "lst_aluno", "nome", "id_cidadao");
			document.getElementById('lst_aluno').remove(0);
			carrega_questionario(false);
			selcionar_option('cmb_status', 'indice', 0);
			travar_options();
		}
	}
}
