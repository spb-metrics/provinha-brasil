function iniciar(){
    testar_login();
    travar_resultado();
    var xml = chamar_ajax("php/filtros/filtro_sql.php", "filtro=8", false, "xml", null);
    carregar_combo(xml, "cmb_nivel", "dsc_nivel", "id_nivel");
    var xml = chamar_ajax("php/filtros/filtro_sql.php", "filtro=2", false, "xml", null);
    document.getElementById('txt_escola').value = valor_xml(xml, "escola", 0);
    var xml = chamar_ajax("php/filtros/filtro_sql.php", "filtro=3", false, "xml", null);
    carregar_combo(xml, "cmb_serie", "Serie", "idSerie");
}

function cmb_serie_onchange(){
    travar_resultado();
    document.getElementById('cmb_aluno').length = 0;
    var serie = recupera_por_id("cmb_serie", option_selecionado("cmb_serie"), "value");
    var xml = chamar_ajax("php/filtros/filtro_sql.php", "filtro=4&serie=" + serie, false, "xml", null);
    carregar_combo(xml, "cmb_turma", "Turma", "idTurma");
}

function cmb_turma_onchange(){
    travar_resultado();
    var turma = recupera_por_id("cmb_turma", option_selecionado("cmb_turma"), "value");
    var xml = chamar_ajax("php/filtros/filtro_sql.php", "&filtro=5&turma=" + turma, false, "xml", null);
    document.getElementById('txt_periodo').value = valor_xml(xml, "PERIODO", 0);
    var xml = chamar_ajax("php/filtros/filtro_sql.php", "filtro=6&forma=exists", false, "xml", null);
    var nreg = valor_xml(xml, "nreg", 0);
    if (nreg == 0) {
        window.alert("Ainda não foi cadastrado nenhum resultado de prova desta turma!");
        selcionar_option("cmb_turma", "indice", 0);
        document.getElementById('cmb_aluno').length = 0;
    }
    else {
        carregar_combo(xml, "cmb_aluno", "nome", "id_cidadao");
    }
}

function cmb_aluno_onchange(){
    destravar_resultado();
    var aluno = recupera_por_id("cmb_aluno", option_selecionado("cmb_aluno"), "value");
    var xml = chamar_ajax("php/filtros/filtro_sql.php", "filtro=12&cod_aluno=" + aluno, false, "xml", null);
    document.getElementById('txt_nivel').innerHTML = valor_xml(xml, "nivel_prova", 0);
    selcionar_option("cmb_nivel", "value", valor_xml(xml, "nivel_professor", 0));
    document.getElementById('txt_texto').value = valor_xml(xml, "justificativa", 0);
}

function btn_salvar_onclick(){
    var nivel_professor = recupera_por_id("cmb_nivel", option_selecionado("cmb_nivel"), "text");
    var nivel_prova = document.getElementById('txt_nivel').innerHTML;
    if (vazio('txt_texto') && nivel_prova != nivel_professor) {
        window.alert('você não justificou os aspectos que podem ter influenciado o desempenho do educando!');
    }
    else {
        var dados = "cod_aluno=" + recupera_por_id('cmb_aluno', option_selecionado('cmb_aluno'), 'value');
        dados += "&nivel=" + recupera_por_id("cmb_nivel", option_selecionado("cmb_nivel"), "value");
        dados += "&texto=" + document.getElementById('txt_texto').value;
        var xml = chamar_ajax("php/grava_nivel.php", dados, false, "xml", null);
        window.alert(valor_xml(xml, 'mensagem', 0));
    }
}

function travar_resultado(){
    document.getElementById('cmb_nivel').disabled = true;
    try {
        selcionar_option('cmb_nivel', "indice", 0);
    } 
    catch (e) {
    }
    document.getElementById('txt_texto').readOnly = true;
    document.getElementById('txt_texto').value = "";
    cor_nome = 'LightGray';
    cor_hexa = '191970';
    def_cor_fundo('txt_texto', cor_nome, cor_hexa);
}

function destravar_resultado(){
    document.getElementById('cmb_nivel').disabled = false;
    document.getElementById('txt_texto').readOnly = false;
    document.getElementById('txt_texto').value = "";
    cor_nome = 'white';
    cor_hexa = 'ffffff';
    def_cor_fundo('txt_texto', cor_nome, cor_hexa);
}
