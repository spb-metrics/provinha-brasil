var alterar = null;
function iniciar(){
    document.getElementById('btn_imprimir').style.visibility = 'Hidden';
	document.getElementById('btn_salvar').style.visibility = 'Hidden';
	document.getElementById('caixa1').style.display = 'none';
	document.getElementById('caixa2').style.display = 'none';
	document.getElementById('caixa3').style.display = 'none';
	document.getElementById('caixa4').style.display = 'none';
    testar_login();
    bloquear_text();
    carregar_options();    
	document.getElementById('txt_periodo').value = ""
    var xml = chamar_ajax("php/filtros/filtro_sql.php", "filtro=2", false, "xml", null);
    document.getElementById('txt_escola').value = valor_xml(xml, "escola", 0);
    var xml = chamar_ajax("php/filtros/filtro_sql.php", "filtro=3", false, "xml", null);
    carregar_combo(xml, "cmb_serie", "Serie", "idSerie");
    mostra_dados(null, false);
}

function carregar_options(){
	for (var i = 0; i <= 40; i++) {
      criar_option('cmb_ano_rede',i,i,i);	
	}
	for (var i = 0; i <= 11; i++) {
      criar_option('cmb_mes_rede',i,i,i);	
	}
	criar_option('cmb_letra', 1, "SIM", 1);
    criar_option('cmb_letra', 2, "NÃO", 0);
}
function cmb_serie_onchange(){
    document.getElementById('btn_imprimir').style.visibility = 'Hidden';
	document.getElementById('btn_salvar').style.visibility = 'Hidden';
	document.getElementById('txt_periodo').value = ""
    mostra_dados(null, false);
    var serie = recupera_por_id("cmb_serie", option_selecionado("cmb_serie"), "value");
    var xml = chamar_ajax("php/filtros/filtro_sql.php", "filtro=4&serie=" + serie, false, "xml", null);
    carregar_combo(xml, "cmb_turma", "Turma", "idTurma");
	document.getElementById('caixa1').style.display = 'none';
	document.getElementById('caixa2').style.display = 'none';
	document.getElementById('caixa3').style.display = 'none';
	document.getElementById('caixa4').style.display = 'none';
}

function cmb_turma_onchange(){
    document.getElementById('btn_imprimir').style.visibility = 'Hidden';
	document.getElementById('btn_salvar').style.visibility = '';
    var turma = recupera_por_id("cmb_turma", option_selecionado("cmb_turma"), "value");
    var xml = chamar_ajax("php/filtros/filtro_sql.php", "&filtro=5&turma=" + turma, false, "xml", null);
    document.getElementById('txt_periodo').value = valor_xml(xml, "PERIODO", 0);
    var xml = chamar_ajax("php/grava_classe.php", "operacao=pesquisar&campos_select=classe.*", false, "xml", null);
    if (parseInt(valor_xml(xml, 'nreg', 0)) > 0) {
        mostra_dados(xml, true);
        document.getElementById('btn_imprimir').style.visibility = '';
    }
    else {
        mostra_dados(null, false);
    }
	document.getElementById('caixa1').style.display = 'inline';
	document.getElementById('caixa2').style.display = 'inline';
	document.getElementById('caixa3').style.display = 'inline';
	document.getElementById('caixa4').style.display = 'inline';
}

function validar(){
    if (vazio('txt_professor')) {
        window.alert('Digite o nome do professor da turma');
        return false;
    }
    if (option_selecionado('cmb_mes_rede') == 0) {
		if (option_selecionado('cmb_ano_rede') == 0) {
			window.alert('Informe a quanto tempo o professor já atua na rede como professor!');
			return false;
			
		}
	}
	if (option_selecionado('cmb_letra') == 0) {
        window.alert('Informe se o professor já concluiu o Pró Letramento!');
        return false;
    }
	if (option_selecionado('cmb_letra') == 0) {
        window.alert('Informe se o professor já concluiu o Pró Letramento!');
        return false;
    }
    var dados = '&professor=' + document.getElementById('txt_professor').value;
    dados += '&qtd_ano_rede=' + recupera_por_id('cmb_ano_rede', option_selecionado('cmb_ano_rede'), 'value');
	dados += '&qtd_mes_rede=' + recupera_por_id('cmb_mes_rede', option_selecionado('cmb_mes_rede'), 'value');
	dados += '&proletramento=' + recupera_por_id('cmb_letra', option_selecionado('cmb_letra'), 'value');
    for (var i = 1; i <= 10; i++) {
        if (i <= 5) {
            if (!vazio('txt_inter' + i)) {
                texto = document.getElementById('txt_inter' + i).value;
            }
            else {
                texto = '';
            }
            dados += '&txt_inter' + i + '=' + texto;
        }
        if (document.getElementById('chk_D' + i + 'Q1').checked) {
            if (vazio('txt_D' + i)) {
                window.alert("Você assinalou uma ou mais dificuldades a serem trabalhadas mas não explicou o motivo!");
                return false;
            }
            valor = '1'
            texto = document.getElementById('txt_D' + i).value;
        }
        else {
            valor = '0'
            texto = '';
        }
        dados += '&chk_D' + i + 'Q1=' + valor;
		dados += '&txt_D' + i + '=' + texto;
    }
    if (!vazio('txt_obs')) {
        texto = document.getElementById('txt_obs').value;
    }
    else {
        var texto = '';
    }
    dados += '&txt_obs' + '=' + texto;
    return dados;
}

function checar(box, text){
    if (document.getElementById(box + 1).checked == true) {
        document.getElementById(text).readOnly = false;
        cor_nome = 'white';
        cor_hexa = 'ffffff';
    }
    else {
        document.getElementById(text).value = "";
        document.getElementById(text).readOnly = true;
        cor_nome = 'LightGray';
        cor_hexa = 'D3D3D3';
    }
    def_cor_fundo(text, cor_nome, cor_hexa);
}

function Salvar(){
    var teste = validar();
    if (teste != false) {
        var dados = "operacao=salvar&campos_select=classe.id_classe as id_classe" + teste;
        var xml = chamar_ajax("php/grava_classe.php", dados, false, "xml", null);
        window.alert(valor_xml(xml, 'mensagem', 0));
        if (valor_xml(xml, 'teste', 0) == 'ok') {
            document.getElementById('btn_imprimir').style.visibility = '';
        }
        else {
            document.getElementById('btn_imprimir').style.visibility = 'Hidden';
        }
    }
}

function bloquear_text(){
    for (var i = 1; i <= 10; i++) {
        document.getElementById('txt_D' + i).readOnly = true;
        cor_nome = 'LightGray';
        cor_hexa = 'D3D3D3';
        def_cor_fundo('txt_D' + i, cor_nome, cor_hexa);
    }
}

function mostra_dados(xml, preecher){
    if (preecher) {
        document.getElementById('txt_professor').value = valor_xml(xml, 'nome_professor', 0);
        try {
            selcionar_option('cmb_ano_rede', 'value', valor_xml(xml, 'qtd_ano_rede', 0));
        } 
        catch (e) {
            selcionar_option('cmb_ano_rede', 'indice', 0);
        }
		try {
            selcionar_option('cmb_mes_rede', 'value', valor_xml(xml, 'qtd_mes_rede', 0));
        } 
        catch (e) {
            selcionar_option('cmb_mes_rede', 'indice', 0);
        }
		try {
            selcionar_option('cmb_letra', 'value', valor_xml(xml, 'conclusao_proletrado', 0));
        } 
        catch (e) {
            selcionar_option('cmb_letra', 'indice', 0);
        }
        for (var i = 1; i <= 10; i++) {
            if (i <= 5) {
                texto = document.getElementById('txt_inter' + i).value = valor_xml(xml, 'inter_pedagogica' + i, 0);
            }
            if (parseInt(valor_xml(xml, 'd' + i + '_maior_dificuldade', 0)) == 1) {
                valor = true;
            }
            else {
                valor = false;
            }
            document.getElementById('chk_D' + i + 'Q1').checked = valor;
            if (parseInt(valor_xml(xml, 'd' + i + '_opniao_prof', 0)) == 1) {
                valor = true
                document.getElementById('txt_D' + i).value = valor_xml(xml, 'desc_opniao_prof_d' + i, 0);
                document.getElementById('txt_D' + i).readOnly = false;
                cor_nome = 'white';
                cor_hexa = 'ffffff';
            }
            else {
                valor = false;
                document.getElementById('txt_D' + i).value = '';
                document.getElementById('txt_D' + i).readOnly = true;
                cor_nome = 'LightGray';
                cor_hexa = 'D3D3D3';
            }
            def_cor_fundo('txt_D' + i, cor_nome, cor_hexa);
        }
        document.getElementById('txt_obs').value = valor_xml(xml, 'obs_classe', 0);
    }
    else {
        document.getElementById('txt_professor').value = "";
        selcionar_option('cmb_ano_rede', 'indice', 0);
		selcionar_option('cmb_mes_rede', 'indice', 0);
		selcionar_option('cmb_letra', 'indice', 0);
        recupera_por_id();
        for (var i = 1; i <= 10; i++) {
            if (i <= 5) {
                texto = document.getElementById('txt_inter' + i).value = "";
            }
            document.getElementById('chk_D' + i + 'Q1').checked = false;
            document.getElementById('txt_D' + i).value = '';
            document.getElementById('txt_D' + i).readOnly = true;
            def_cor_fundo('txt_D' + i, 'LightGray', 'D3D3D3');
        }
        document.getElementById('txt_obs').value="";
    }
}

function imprimir(){
    window.open('php/rel_nivel.php')
}
