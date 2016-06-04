<?php
ob_start();
session_start();
ob_end_clean();
require ('../banco.php');
header('Content-Type: text/plain; charset=utf-8');
$exibir = true;
//$_POST['serie']=139;
//$_SESSION['fase']=2;
//$_SESSION['id_pj'] = 2;
$_SESSION['id_periodo'] = 18;
//$_SESSION['ano']=2009;
//$_POST['filtro']=4;
switch($_POST['filtro']) {
    case 0:
        filtro_0();
        break; // LISTA DE STATUS
    case 1:
        filtro_1();
        break; // LISTA DE NATUREZA
    case 2:
        filtro_2();
        break; // PESQUISA OS
    case 3:
        filtro_3();
        break; // PROBLEMA OS PARA EXIBIR NO ANDAMENTO
    case 4:
        filtro_4();
        break; // PESQUISA OS ANDAMENTO
    case 5:
        filtro_5();
        break; // DADOS DO OS FECHAMENTO
    case 6:
        filtro_6();
        break; // LISTA DE SOLICITENTE
    case 7:
        filtro_7();
        break; // DADOS DO SOLICITENTE
    case 8:
        filtro_8();
        break; // VERIFICA SE EXISTE GUIA DE REMESSA
    case 9:
        filtro_9();
        break; // VERIFICA SE EXISTE GUIA DE REMESSA
    case 10:
        filtro_10();
        break; // VERIFICA SE EXISTE GUIA DE REMESSA
    case 11:
        filtro_11();
        break; // VERIFICA SE EXISTE GUIA DE REMESSA
    case 12:
        filtro_12();
        break; // VERIFICA SE EXISTE GUIA DE REMESSA
    case 13:
        filtro_13();
        break; // VERIFICA SE EXISTE GUIA DE REMESSA
    case 14:
        filtro_14();
        break; // SQL PARA GERAÇÃO DOS GRÁFICOS DE NÍVEL
    case 15:
        filtro_15();
        break; // SQL PARA GERAÇÃO DOS GRÁFICOS DE NÍVEL
    case 16:
        filtro_16();
        break; // SQL PARA GERAÇÃO DOS GRÁFICOS DE NÍVEL
    case 17:
        filtro_17();
        break; // SQL PARA GERAÇÃO DOS GRÁFICOS DE NÍVEL
    case 18:
        filtro_18();
        break; // SQL PARA GERAÇÃO DOS GRÁFICOS DE NÍVEL
    case 19:
        filtro_19();
        break; // SQL PARA GERAÇÃO DOS GRÁFICOS DE NÍVEL
    case 20:
        filtro_20(); //FILTRO CONFECCIONCADO DIA 30/03/2010 POR PAH:
        break;
    case 21:
        filtro_21(); //FILTRO CONFECCIONCADO DIA 30/03/2010 POR PAH:
        break;
    case 22:
        filtro_22(); //FILTRO CONFECCIONCADO DIA 30/03/2010 POR PAH:
        break;
    case 23:
        filtro_23(); //FILTRO CONFECCIONCADO DIA 30/03/2010 POR PAH:
        break;
    case 24:
        filtro_24(); //FILTRO CONFECCIONCADO DIA 31/03/2010 POR PAH:
        break;
}

function filtro_0() {
    $pesquisa = "select * from gabarito where ano = '$_SESSION[ano]'";
    $pesquisa = $pesquisa." and fase = '$_SESSION[fase]'";
    montar_resposta($pesquisa);
}
function filtro_1() {
    $pesquisa = "select status,cod_status from  status_aluno order by status asc";
    montar_resposta($pesquisa);
}
function filtro_2() {

    $pesquisa .= "select NOME as escola from  escolas where ID_PJ like '$_SESSION[id_pj]'";
    montar_resposta($pesquisa);
}
function filtro_3() {
    $pesquisa = "select distinct NOME_SERIE as Serie,IDSERIE as idSerie from series2009 where ";
    $pesquisa = $pesquisa." IDPESSOA_JURIDICA = '$_SESSION[id_pj]'";
    $pesquisa = $pesquisa." and fase = '$_SESSION[fase]'";
    montar_resposta($pesquisa);
}
function filtro_4() {
    $_SESSION['idserie'] = $_POST['serie'];
    $pesquisa = "select distinct NOME_CLASSE as Turma,IDTURMA as idTurma from series2009 where";
    $pesquisa = $pesquisa." IDPESSOA_JURIDICA = '$_SESSION[id_pj]'";
    $pesquisa = $pesquisa." and IDSERIE = '$_SESSION[idserie]'";
    $pesquisa = $pesquisa." and fase = '$_SESSION[fase]' order by NOME_CLASSE asc";
    montar_resposta($pesquisa);
}
function filtro_5() {
    $_SESSION['idturma'] = $_POST['turma'];
    $pesquisa = "select distinct PERIODO from series2009 where";
    $pesquisa = $pesquisa." IDPESSOA_JURIDICA = '$_SESSION[id_pj]'";
    $pesquisa = $pesquisa." and IDSERIE = '$_SESSION[idserie]'";
    $pesquisa = $pesquisa." and IDTURMA = '$_SESSION[idturma]'";
    $pesquisa = $pesquisa." and fase = '$_SESSION[fase]'";
    montar_resposta($pesquisa);
}
function filtro_6() {
    $pesquisa = "SELECT nome,id_cidadao FROM vw_matriculados_2f_2009 ";
    $pesquisa .= " where id_periodo_letivo= $_SESSION[id_periodo] ";
    $pesquisa .= " and id_pj= $_SESSION[id_pj]";
    $pesquisa .= " and id_serie=$_SESSION[idserie]";
    $pesquisa .= " and id_turma=$_SESSION[idturma]";
    montar_resposta($pesquisa);
}

function filtro_7() {
    $pesquisa = "SELECT valunos.NOME as nome,";
    $pesquisa .= "resultados.ID_Cidadao as id_cidadao";
    $pesquisa .= " FROM valunos INNER JOIN resultados";
    $pesquisa .= " ON valunos.ID_CIDADAO = resultados.ID_Cidadao";
    $pesquisa .= "  WHERE (((valunos.ID_PJ)=$_SESSION[id_pj])";
    $pesquisa .= " AND ((valunos.ID_SERIE)=$_SESSION[idserie])";
    $pesquisa .= " AND ((valunos.ID_TURMA)=$_SESSION[idturma])";
    $pesquisa .= " AND ((valunos.id_periodo_letivo)=$_SESSION[id_periodo])";
    $pesquisa .= " AND ((resultados.ano)= $_SESSION[ano])";
    $pesquisa .= " AND ((resultados.fase)= $_SESSION[fase]))order by valunos.NOME;";
    montar_resposta($pesquisa);
}

function filtro_8() {
    $pesquisa = "SELECT id_nivel, ";
    $pesquisa .= "dsc_nivel";
    $pesquisa .= " FROM nivel";
    $pesquisa .= " WHERE ano =$_SESSION[ano]";
    $pesquisa .= " and cod_fase = $_SESSION[fase] order by id_nivel desc ;";
    montar_resposta($pesquisa);
}
function filtro_9() {
    $pesquisa = "SELECT tipo_respostas.resposta as resposta, ";
    $pesquisa .= "tipo_respostas.cod_resposta as idresposta";
    $pesquisa .= " FROM tipo_respostas";
    $pesquisa .= " WHERE tipo_respostas.resposta <>'BRANCO';";
    montar_resposta($pesquisa);
}
function filtro_10() {
    $pesquisa = "SELECT * ";
    $pesquisa .= " FROM resultados";
    $pesquisa .= " WHERE (((resultados.ID_Cidadao)=$_POST[aluno])";
    $pesquisa .= " AND ((resultados.ano)=$_SESSION[ano])";
    $pesquisa .= " AND ((resultados.fase)=$_SESSION[fase]));";
    montar_resposta($pesquisa);
}
function filtro_11() {
    $pesquisa = "SELECT nivel.id_nivel as idnivel,";
    $pesquisa .= "nivel.faixa_inicial as menor,";
    $pesquisa .= "nivel.faixa_final as maior";
    $pesquisa .= " FROM nivel";
    $pesquisa .= " WHERE nivel.ano=$_SESSION[ano]";
    $pesquisa .= " AND nivel.cod_fase=$_SESSION[fase];";
    montar_resposta($pesquisa);
}
function filtro_12() {
    $pesquisa = "SELECT aluno_classe.justificativa_professor as justificativa,";
    $pesquisa .= "aluno_classe.id_nivel_professor nivel_professor,";
    $pesquisa .= "nivel.dsc_nivel nivel_prova";
    $pesquisa .= " FROM nivel INNER JOIN";
    $pesquisa .= " aluno_classe ON nivel.id_nivel = aluno_classe.id_nivel_prova";
    $pesquisa .= " WHERE aluno_classe.id_cidadao = $_POST[cod_aluno];";
    montar_resposta($pesquisa);
}

function filtro_14() { //Nível Escola
    $pesquisa = "select matriculados.ID_PJ,";
    $pesquisa .= " ac.ano,ac.cod_fase,";
    $pesquisa .= " if(isnull(ac.id_nivel_professor),ac.id_nivel_prova,ac.id_nivel_professor) AS nivel,";
    $pesquisa .= " count(if(isnull(ac.id_nivel_professor),ac.id_nivel_prova,ac.id_nivel_professor)) as qtd";
    $pesquisa .= " from (matriculados join aluno_classe ac on matriculados.ID_CIDADAO = ac.id_cidadao)";
    $pesquisa .= " where ano = $_SESSION[gano] and cod_fase = $_SESSION[gfase] and id_pj = $_SESSION[id_pj]";
    $pesquisa .= " group by matriculados.ID_PJ,";
    $pesquisa .= " ac.ano,ac.cod_fase,";
    $pesquisa .= " if(isnull(ac.id_nivel_professor),ac.id_nivel_prova,ac.id_nivel_professor)";

    if ($_SESSION['gtipo']==1) {
        unset($_SESSION['gtipo']);
        unset($_SESSION['gano']);
        unset($_SESSION['gfase']);
        unset($_SESSION['gserie']);
        unset($_SESSION['gturma']);
    }

    montar_resposta($pesquisa);
}

function filtro_15() { //Nível Turma
    $pesquisa = "select matriculados.ID_PJ,";
    $pesquisa .= " matriculados.ID_TURMA,matriculados.TURMA,";
    $pesquisa .= " matriculados.PERIODO,matriculados.ID_SERIE,matriculados.SERIE,";
    $pesquisa .= " ac.ano,ac.cod_fase,ac.id_classe,";
    $pesquisa .= " if(isnull(ac.id_nivel_professor),ac.id_nivel_prova,ac.id_nivel_professor) AS nivel,";
    $pesquisa .= " count(if(isnull(ac.id_nivel_professor),ac.id_nivel_prova,ac.id_nivel_professor)) as qtd";
    $pesquisa .= " from (matriculados join aluno_classe ac on matriculados.ID_CIDADAO = ac.id_cidadao)";
    $pesquisa .= " where ano = $_SESSION[gano] and cod_fase = $_SESSION[gfase] and id_pj = $_SESSION[id_pj] and id_serie = $_SESSION[gserie] and id_classe = $_SESSION[gturma] and id_turma = $_SESSION[gturma]";
    $pesquisa .= " group by matriculados.ID_PJ,";
    $pesquisa .= " matriculados.ID_TURMA,matriculados.TURMA,";
    $pesquisa .= " matriculados.PERIODO,matriculados.ID_SERIE,matriculados.SERIE,";
    $pesquisa .= " ac.ano,ac.cod_fase,ac.id_classe,";
    $pesquisa .= " if(isnull(ac.id_nivel_professor),ac.id_nivel_prova,ac.id_nivel_professor)";

    unset($_SESSION['gtipo']);
    unset($_SESSION['gano']);
    unset($_SESSION['gfase']);
    unset($_SESSION['gserie']);
    unset($_SESSION['gturma']);

    montar_resposta($pesquisa);
}

function filtro_16() { //Carrega Ano
    $pesquisa = "SELECT distinct ano FROM aluno_classe ";
    $pesquisa .= " order by ano desc";
    montar_resposta($pesquisa);
}

function filtro_17() { //Carrega Ano
    $pesquisa = "SELECT distinct cod_fase FROM aluno_classe ";
    $pesquisa .= " Where ano = $_POST[ano]";
    $pesquisa .= " order by cod_fase desc";
    montar_resposta($pesquisa);
}

function filtro_18() {
    $pesquisa = "select distinct NOME_SERIE as Serie,IDSERIE as idSerie from series2009";
    //$pesquisa = $pesquisa." IDPESSOA_JURIDICA = '$_SESSION[id_pj]'";
    //$pesquisa = $pesquisa." and fase = '$_POST[fase]'";
    montar_resposta($pesquisa);
}

function filtro_19() {
    $pesquisa = "select distinct NOME_CLASSE as Turma,IDTURMA as idTurma from series2009 where";
    $pesquisa = $pesquisa." IDPESSOA_JURIDICA = $_SESSION[id_pj]";
    $pesquisa = $pesquisa." and IDSERIE = $_POST[serie]";
    $pesquisa = $pesquisa." and fase = $_POST[fase] order by NOME_CLASSE asc";
    montar_resposta($pesquisa);
}

// ---------------------------

//FILTRO CONFECCIONCADO DIA 30/03/2010 POR PAH:
function filtro_20() {
    $pesquisa = "SELECT g.ano FROM gabarito g";
    $pesquisa .= " GROUP BY g.ano ORDER BY g.ano";
    //echo $pesquisa; exit;
    montar_resposta($pesquisa);
}
//FILTRO CONFECCIONCADO DIA 30/03/2010 POR PAH:
function filtro_21() {
    $pesquisa = "SELECT f.* FROM gabarito g INNER JOIN fase f ON g.fase = f.cod_fase WHERE g.ano = '".$_POST[ano]."'";
    $pesquisa .= " GROUP BY f.dsc_fase ORDER BY f.dsc_fase";
    montar_resposta($pesquisa);
}
//FILTRO CONFECCIONCADO DIA 30/03/2010 POR PAH:
function filtro_22() {
    $pesquisa = "SELECT s.idserie, s.nome_serie FROM series2009 s INNER JOIN gabarito g ON s.fase = g.fase WHERE s.IDPESSOA_JURIDICA = '".$_SESSION[id_pj]."'";
    $pesquisa .= " GROUP BY s.nome_serie ORDER BY s.nome_serie";
    //echo $pesquisa; exit;
    montar_resposta($pesquisa);
}

function filtro_23() {
    $pesquisa = "SELECT s.NOME_CLASSE as Turma, s.IDTURMA as idTurma FROM series2009 s INNER JOIN gabarito g ON s.fase = g.fase ";
    $pesquisa .= " WHERE s.IDPESSOA_JURIDICA = $_SESSION[id_pj]";
    $pesquisa .= " AND s.IDSERIE = $_POST[idserie]";
    $pesquisa .= " AND s.FASE = ".$_POST[fase];
    $pesquisa .= " GROUP BY s.NOME_CLASSE ORDER BY s.IDTURMA";
    //echo $pesquisa; exit;
    montar_resposta($pesquisa);
}

function filtro_24() {
    $pesquisa = "SELECT s.IDPERIODO_DO_DIA as id, s.PERIODO as periodo FROM series2009 s INNER JOIN gabarito g ON s.fase = g.fase ";
    $pesquisa .= " WHERE s.IDPESSOA_JURIDICA = ". $_SESSION[id_pj]." AND s.IDSERIE = ".$_POST[idserie];
    $pesquisa .= " AND s.FASE = ".$_POST[fase]." AND s.IDTURMA= ".$_POST[idturma];
    $pesquisa .= " GROUP BY s.PERIODO ORDER BY s.IDPERIODO_DO_DIA";
    montar_resposta($pesquisa);
}


function montar_resposta($pesquisa) {
    $tb_dados = pesquisar($pesquisa);
    if ($tb_dados->rowCount() > 0) {
        $var_nreg = $tb_dados->rowCount();
        //$var_dadosxml .= "<pesquisa>$pesquisa</pesquisa>";
        $var_dadosxml .= "<nreg>$var_nreg</nreg>";
        while ($var_conteudo = $tb_dados->fetch()) {
            $cmax = $tb_dados->columnCount();
            for ($c = 0; $c < $cmax; $c++) {
                $texto = key($var_conteudo);
                $valor = utf8_encode(current($var_conteudo));
                $var_dadosxml .= "<$texto>$valor</$texto>";
                next($var_conteudo);
                next($var_conteudo);
            }
        }
    }
    else {
        $var_nreg = $tb_dados->rowCount();
        //$var_dadosxml .= "<pesquisa>$pesquisa</pesquisa>";
        $var_dadosxml .= "<nreg>$var_nreg</nreg>";
    }
    monta_xml($var_dadosxml);
}

function monta_xml($var_dadosxml) {
    $meuxml = "<?xml version=\"1.0\"
?>
";
    $meuxml.="
<dados>
    ";
    $meuxml.=$var_dadosxml;
    $meuxml.="
</dados>";
    header("Content-type: application/xml");
    echo $meuxml;
}
?>
