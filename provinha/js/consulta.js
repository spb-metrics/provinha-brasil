// declarações globais
var HttpReq = null;
var tipo_retorno = null;
var destino = null;
var funcaoRetorno = null;
var dados = null;
var cod_aluno = null;
var gabarito = new Array(23);
var nota = new Array(24);
var nota_banco = new Array(25);
var nivel = null;
var nivel_aluno = null;

function iniciar(){
    testar_login();
    var xml = chamar_ajax("php/filtros/filtro_sql.php", "filtro=11", false, "xml", null);
    var x = parseInt(valor_xml(xml, 'nreg', 0));
    nivel = new Array(x);
    for (i = 0; i < x; i++) {
        nivel[i] = new Array(3);
        nivel[i][0] = valor_xml(xml, "idnivel", i);
        nivel[i][1] = valor_xml(xml, "menor", i);
        nivel[i][2] = valor_xml(xml, "maior", i);
    }
    var xml = chamar_ajax("php/filtros/filtro_sql.php", "filtro=0", false, "xml", null);
    qst_id = 1;
    for (i = 0; i <= 23; i++) {
        gabarito[i] = valor_xml(xml, "Q" + qst_id, 0);
        qst_id++;
    }
    var xml = chamar_ajax("php/filtros/filtro_sql.php", "filtro=9", false, "xml", null);
    for (i = 1; i <= 24; i++) {
        carregar_combo(xml, "cmb_q" + i, "resposta", "idresposta");
    }
    var xml = chamar_ajax("php/filtros/filtro_sql.php", "filtro=1", false, "xml", null);
    carregar_combo(xml, "cmb_status", "status", "cod_status");
    var xml = chamar_ajax("php/filtros/filtro_sql.php", "filtro=2", false, "xml", null);
    document.getElementById('txt_escola').value = valor_xml(xml, "escola", 0);
    var xml = chamar_ajax("php/filtros/filtro_sql.php", "filtro=3", false, "xml", null);
    carregar_combo(xml, "cmb_serie", "Serie", "idSerie");
    
}

function cmb_serie_onchange(){
    carrega_questionario(false, null, 1);
    travar_options();
    document.getElementById('cmb_status').disabled = true;
    document.getElementById('cmb_aluno').length = 0;
    var serie = recupera_por_id("cmb_serie", option_selecionado("cmb_serie"), "value");
    var xml = chamar_ajax("php/filtros/filtro_sql.php", "filtro=4&serie=" + serie, false, "xml", null);
    carregar_combo(xml, "cmb_turma", "Turma", "idTurma");
}

function cmb_turma_onchange(){
    carrega_questionario(false, null, 1);
    travar_options();
    document.getElementById('cmb_status').disabled = true;
    var turma = recupera_por_id("cmb_turma", option_selecionado("cmb_turma"), "value");
    var xml = chamar_ajax("php/filtros/filtro_sql.php", "&filtro=5&turma=" + turma, false, "xml", null);
    document.getElementById('txt_periodo').value = valor_xml(xml, "PERIODO", 0);
    var xml = chamar_ajax("php/filtros/filtro_sql.php", "filtro=6&forma=exists", false, "xml", null);
    carregar_combo(xml, "cmb_aluno", "nome", "id_cidadao");
}

function cmb_aluno_onchange(){
    caregar_nota_banco();
    carrega_questionario(true, 1, 0);
    selcionar_option('cmb_status', 'text', nota_banco[25]);
    document.getElementById('cmb_status').disabled = false;
    if (nota_banco[25] != 'Presente') {
        travar_options();
    }
}

function caregar_nota_banco(){
    var aluno = recupera_por_id("cmb_aluno", option_selecionado("cmb_aluno"), "value");
    var xml = chamar_ajax("php/filtros/filtro_sql.php", "&filtro=10&aluno=" + aluno, false, "xml", null);
    qst_id = 1;
    for (i = 0; i <= 23; i++) {
        nota_banco[i] = valor_xml(xml, "Q" + qst_id, 0);
        qst_id++;
    }
    nota_banco[24] = valor_xml(xml, 'Nota', 0);
    nota_banco[25] = valor_xml(xml, 'Status', 0);
}

function caregar_nota(destino){
    for (i = 0; i <= 24; i++) {
        if (destino == 1) {
            nota[i] = nota_banco[i];
        }
        else {
            nota[i] = gabarito[i];
        }
    }
	if (destino != 1) {
	   nota[24] = 24;
	}
    x = nivel.length;
    for (i = 0; i < x; i++) {
        if (nota[24] >= nivel[i][1] && nota[24] <= nivel[i][2]) {
            nivel_aluno = nivel[i][0];
        }
    }
}

function zerar_notas(){
    for (i = 0; i <= 24; i++) {
        nota[i] = 0;
    }
    nivel_aluno = nivel[0][0];
}

function carrega_questionario(carregar, modo, cor){
    destravar_options()
    if (carregar) {
        if (modo == 1) {
            caregar_nota(1);
            if (nota_banco[25] != "Presente") {
                cor = 2;
            }
        }
        else {
            if (nota_banco[25] != "Presente") {
                caregar_nota(0);
                cor = 1
            }
            else {
                caregar_nota(1);
            }
        }
        document.getElementById('txt_nota').value = nota[24];
        modo = 'value'
    }
    else {
        zerar_notas()
        document.getElementById('txt_nota').value = 0;
        modo = 'indice'
    }
    var qst_id = 1;
    for (i = 0; i <= 23; i++) {
        var nome = 'cmb_q' + qst_id;
        if (modo == 'value' && nota[i] == 0) {
            selcionar_option(nome, 'indice', 0);
        }
        else {
            selcionar_option(nome, modo, nota[i]);
            var cor_atual = cor;
            if (cor == 0) {
                if (nota[i] == gabarito[i]) {
                    cor = 1;
                }
                else {
                    cor = 3;
                }
            }
        }
        muda_cor(nome, cor);
        cor = cor_atual;
        qst_id++;
    }
}

function resposta(qst_id){
    var nome = 'cmb_q' + qst_id;
    var rsp_id = qst_id - 1;
    var resposta_atual = parseInt(recupera_por_id(nome, option_selecionado(nome), 'value'));
    if (isNaN(resposta_atual)) {
        resposta_atual = 0;
    }
    if (resposta_atual != nota[rsp_id]) {
        if (nota[rsp_id] != gabarito[rsp_id]) {
            if (resposta_atual == gabarito[rsp_id]) {
                cor = 1;
                nota[24]++;
            }
        }
        else {
            if (resposta_atual != gabarito[rsp_id]) {
                cor = 3;
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


function btn_salvar_onclick(){
	if (option_selecionado('cmb_status') == 0) {
		window.alert("Selecione o status do aluno!")
	}
	else {
		var status = recupera_por_id('cmb_status', option_selecionado('cmb_status'), 'text');
		var cod_aluno = recupera_por_id('cmb_aluno', option_selecionado('cmb_aluno'), 'value');
		var dados = "&operacao=alterar&cod_aluno=" + cod_aluno + "&status=" + status + "&nivel=" + nivel_aluno;
		var id = 1;
		for (i = 0; i <= 24; i++) {
			dados += "&nota" + id + "=" + nota[i];
			id++;
		}
		var xml = chamar_ajax("php/gravar.php", dados, false, "xml", null);
		window.alert(valor_xml(xml, 'mensagem', 0));
		var alunos_atual = option_selecionado("cmb_aluno")
		selcionar_option("cmb_aluno", 'indice', 0);
		selcionar_option("cmb_aluno", 'indice', alunos_atual);
		cmb_aluno_onchange();
	}
}

function travar_options(){
    for (qst_id = 1; qst_id <= 24; qst_id++) {
        var nome = 'cmb_q' + qst_id;
        document.getElementById(nome).disabled = true;
    }
}

function destravar_options(){
    for (qst_id = 1; qst_id <= 24; qst_id++) {
        var nome = 'cmb_q' + qst_id;
        document.getElementById(nome).disabled = false;
    }
}

function cmb_status_onchange(){
    var status = recupera_por_id('cmb_status', option_selecionado('cmb_status'), 'text');
    if (status != "Presente") {
        carrega_questionario(false, null, 2);
        travar_options();
    }
    else {
        destravar_options();
        carrega_questionario(true, null, 0);
    }
}
