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
    //testar_login();

    //PESQUISAR ESCOLA
    document.getElementById('btnGerarPdf').style.visibility = 'hidden';
    PesquisarEscola('txtEscola');
}

function PesquisarEscola(objDestino){    
    objDestino = document.getElementById(objDestino);  
    var xml = chamar_ajax("php/filtros/filtro_sql.php", "filtro=2", false, "xml", null);
    if((valor_xml(xml, 'nreg', 0))>0){
        objDestino.value = valor_xml(xml,'escola', 0);
        PesquisarAno('txtEscola','cboAno');
    }else{
        objDestino.value = '';
        alert("Registros de escola não encontrados.");        
        document.getElementById('cboAno').length= 0;
        document.getElementById('cboFase').length= 0;
        document.getElementById('cboSerie').length= 0;
        document.getElementById('cboTurma').length= 0;
        document.getElementById('txtPeriodo').value= '';
        document.getElementById('btnGerarPdf').style.visibility = 'hidden';
    }
    xml = null;
}

function PesquisarAno(objOrigem,objDestino){
    objDestino = document.getElementById(objDestino);
    if(objOrigem.value!=''){        
        var xml = chamar_ajax("php/filtros/filtro_sql.php", "filtro=20", false, "xml", null);
        if((valor_xml(xml, 'nreg', 0))>0){
            carregar_combo(xml, objDestino.id, "ano", "ano");
            //carregar_combo(xml, 'cboFase', "dsc_fase", "cod_fase");
            objDestino.style.disabled = false;
        }else{
            objDestino.length = 0;
            alert("Registros não encontrados pesquisa.");
            document.getElementById('cboFase').length= 0;
            document.getElementById('cboSerie').length= 0;
            document.getElementById('cboTurma').length= 0;
            document.getElementById('txtPeriodo').value= '';
            document.getElementById('btnGerarPdf').style.visibility = 'hidden';
        }
    }
    else{
        objDestino.length = 0;
        document.getElementById('cboFase').length= 0;
        document.getElementById('cboSerie').length= 0;
        document.getElementById('cboTurma').length= 0;
        document.getElementById('txtPeriodo').value= '';
        document.getElementById('btnGerarPdf').style.visibility = 'hidden';
    }
    xml = null;
}

function PesquisarFase(objOrigem,objDestino,ano){
    objDestino = document.getElementById(objDestino);
    if(objOrigem.selectedIndex>0){        
        var xml = chamar_ajax("php/filtros/filtro_sql.php", "filtro=21&ano="+ano, false, "xml", null);
        if((valor_xml(xml, 'nreg', 0))>0){
            carregar_combo(xml, objDestino.id, "dsc_fase", "cod_fase");
            objDestino.style.disabled = false;
        }else{
            objDestino.length = 0;
            alert("Registros não encontrados pesquisa.");            
            document.getElementById('cboSerie').length= 0;
            document.getElementById('cboTurma').length= 0;
            document.getElementById('txtPeriodo').value= '';
            document.getElementById('btnGerarPdf').style.visibility = 'hidden';
        }
    }
    else{
        objDestino.length = 0;
        document.getElementById('cboSerie').length= 0;
        document.getElementById('cboTurma').length= 0;
        document.getElementById('txtPeriodo').value= '';
        document.getElementById('btnGerarPdf').style.visibility = 'hidden';
    }
    xml = null;
}

function PesquisarSerie(objOrigem,objDestino){
    objDestino = document.getElementById(objDestino);
    if(objOrigem.selectedIndex>0){
        var dados = "filtro=22&cboAno="+document.getElementById('cboAno').value+"&cboFase="+document.getElementById('cboFase').value;
        var xml = chamar_ajax("php/filtros/filtro_sql.php", dados, false, "xml", null);
        if((valor_xml(xml, 'nreg', 0))>0){
            carregar_combo(xml, objDestino.id, "nome_serie", "idserie");
            objDestino.style.disabled = false;
        }else{
            objDestino.length = 0;
            alert("Registros de série não encontrados na pesquisa.");
            document.getElementById('cboTurma').length= 0;
            document.getElementById('txtPeriodo').value= '';
            document.getElementById('btnGerarPdf').style.visibility = 'hidden';
        }
    }
    else{
        objDestino.length = 0;
        document.getElementById('cboTurma').length= 0;
        document.getElementById('txtPeriodo').value= '';
        document.getElementById('btnGerarPdf').style.visibility = 'hidden';
    }
    xml = null;
}

function PesquisarTurma(objOrigem,objDestino,serie){
    objDestino = document.getElementById(objDestino);
    if(objOrigem.selectedIndex>0){        
        var dados = "filtro=23&idserie="+serie+"&fase="+document.getElementById('cboFase').value;
        dados += "&cboAno="+document.getElementById('cboAno').value;
        var xml = chamar_ajax("php/filtros/filtro_sql.php", dados, false, "xml", null);
        if((valor_xml(xml, 'nreg', 0))>0){
            carregar_combo(xml, objDestino.id, "Turma", "idTurma");
            objDestino.style.disabled = false;
        }else{
            objDestino.length = 0;
            alert("Registros de turma na série "+serie+" não encontrados.");
            document.getElementById('txtPeriodo').value= '';
            document.getElementById('btnGerarPdf').style.visibility = 'hidden';
        }
    }
    else{
        objDestino.length = 0;
        document.getElementById('txtPeriodo').value= '';
        document.getElementById('btnGerarPdf').style.visibility = 'hidden';
    }
    xml = null;
}

function PesquisarPeriodo(objOrigem,objDestino,turma){
    objDestino = document.getElementById(objDestino);
    if(objOrigem.selectedIndex>0){        
        var dados = "filtro=24&idturma=" + turma;
        dados += "&fase="+document.getElementById('cboFase').value;
        dados += "&idserie="+document.getElementById('cboSerie').value;
        dados += "&cboAno="+document.getElementById('cboAno').value;
        //alert(dados)
        var xml = chamar_ajax("php/filtros/filtro_sql.php", dados, false, "xml", null);
        if((valor_xml(xml, 'nreg', 0))>0){
            objDestino.value = valor_xml(xml, 'periodo', 0);
            document.getElementById('btnGerarPdf').style.visibility = '';
        }else{            
            document.getElementById('btnGerarPdf').style.visibility = 'hidden';            
            objDestino.value = '';
            alert("Registros de período não encontrados na turma "+turma+" .");
        }
    }
    else{
        objDestino.value = '';        
        document.getElementById('btnGerarPdf').style.visibility = 'hidden';
    }
    xml = null;
}


function gerarGabatiroPdf(){
    var txtEscola = document.getElementById('txtEscola');
    var ano = document.getElementById('cboAno');
    var fase = document.getElementById('cboFase');
    var serie = document.getElementById('cboSerie');
    var turma = document.getElementById('cboTurma');    
    document.getElementById('txtSerie').value = recupera_por_id(serie.id, serie.selectedIndex, 'text');
    //alert(document.getElementById('txtSerie').value)
    document.getElementById('txtTurma').value = recupera_por_id(turma.id, turma.selectedIndex, 'text');
    document.getElementById('funcao').value = "GerarGabaritoPdf";

    if((txtEscola.value!='')&&(ano.selectedIndex>0)&&(fase.selectedIndex>0)&&(serie.selectedIndex>0)&&(turma.selectedIndex>0)){
        document.frmGabaritoPdf.submit();    
    }else{
        alert("Selecione os dados para esta operação, por favor.");
    }
}


