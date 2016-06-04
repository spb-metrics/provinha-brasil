<?php


/**********************************************************************
 *  PREFEITURA MUNUCIPAL DE GUARULHOS                                 *
 *  SECRETARIA MUNICIPAL DA EDUCA��O                                  *
 *  DPIE - DEPARTAMENTO DE PLANEJANMENTO E INFORMÁTICA NA EDUCA��O    *
 *  PROVINHA BRASIL                                                   *
 *                                                                    *
 *  Copyright 2010, 2011, 2012 da Prefeitura Municipal de Guarulhos - *
 *  Secretaria de Educa��o                                            *
 *  Este arquivo � parte do programa Provinha Brasil.                 *
 *  O Provinha Brasil � um software livre; voc� pode redistribu�-lo   *
 *   e/ou modific�-lo dentro dos termos da Licen�a P�blica Geral GNU  *
 *   como publicada pela Funda��o do Software Livre (FSF); na vers�o 2*
 *  da  licen�a.                                                      *
 *  Este programa � distribu�do na esperan�a que possa ser �til,      *
 *   mas SEM NENHUMA GARANTIA;uma garantia impl�cita de ADEQUA��O a   *
 *   qualquer MERCADO ou APLICA��O EM PARTICULAR.                     *
 *  Veja a Licen�a P�blica Geral GNU/GPL em portugu�s para            *
 *   maiores detalhes.                                                *
 *  Voc� deve ter recebido uma c�pia da Licen�a P�blica Geral GNU,    *
 *   sob o t�tulo "LICENCA.txt",                                      *
 *  junto com este programa, se n�o, acesse o Portal do Software      *
 *   P�blico Brasileiro no endere�o www.softwarepublico.gov.br ou     *
 *   escreva para a Funda��o do Software Livre (FSF) Inc.,            *
 *   51 Franklin St, Fifth Floor, Boston, MA 02110-1301, USA          *
 **********************************************************************
 ARQUIVO PMONTADO PARA MONTAR RESPOSTAS QUE PRECISAM EXECUTAR UMA
 QUERY
 A VARIAVEL FILTRO INDICA QUAL FILTRO IRA SER EXECUTADO
 - AS FUN��ES filtro_(n)
     MONTAM UM STRING QUE FORMA UM QUERY E PASSAM PARA A
 - A FUN��O  montar_resposta($pesquisa)
   EXECULTA A QUERY MONTADA E MONTA O CORPO DO DOCUMENTO XMLE PASSA PARA A
 - A FUN��O monta_xml RECEBE UMA STRING E MONTA UM DOCUMENTO XML E A
   EXIBI PARA PODER MANDAR COMO RETORNO PARA APLICA��O
 */
ob_start();
session_start();
ob_end_clean();
require ('../banco.php');
header('Content-Type: text/plain; charset=utf-8');
$exibir = true;
$_SESSION['id_periodo'] = 19;
switch ($_POST['filtro']) {
	case 0 :
		filtro_0();
		break; // LISTA DE STATUS
	case 1 :
		filtro_1();
		break; // LISTA DE NATUREZA
	case 2 :
		filtro_2();
		break; // PESQUISA OS
	case 3 :
		filtro_3();
		break; // PROBLEMA OS PARA EXIBIR NO ANDAMENTO
	case 4 :
		filtro_4();
		break; // PESQUISA OS ANDAMENTO
	case 5 :
		filtro_5();
		break; // DADOS DO OS FECHAMENTO
	case 6 :
		filtro_6();
		break; // LISTA DE SOLICITENTE
	case 7 :
		filtro_7();
		break; // DADOS DO SOLICITENTE
	case 8 :
		filtro_8();
		break; // VERIFICA SE EXISTE GUIA DE REMESSA
	case 9 :
		filtro_9();
		break; // VERIFICA SE EXISTE GUIA DE REMESSA  
	case 10 :
		filtro_10();
		break; // VERIFICA SE EXISTE GUIA DE REMESSA    
	case 11 :
		filtro_11();
		break; // VERIFICA SE EXISTE GUIA DE REMESSA    
	case 12 :
		filtro_12();
		break; // VERIFICA SE EXISTE GUIA DE REMESSA    
	case 13 :
		filtro_13();
		break; // VERIFICA SE EXISTE GUIA DE REMESSA  	
	case 14 :
		filtro_14();
		break; // SQL PARA GERA��O DOS GR�FICOS DE N�VEL
	case 15 :
		filtro_15();
		break; // SQL PARA GERA��O DOS GR�FICOS DE N�VEL
	case 16 :
		filtro_16();
		break; // SQL PARA GERA��O DOS GR�FICOS DE N�VEL
	case 17 :
		filtro_17();
		break; // SQL PARA GERA��O DOS GR�FICOS DE N�VEL
	case 18 :
		filtro_18();
		break; // SQL PARA GERA��O DOS GR�FICOS DE N�VEL
	case 19 :
		filtro_19();
		break; // SQL PARA GERA��O DOS GR�FICOS DE N�VEL
	case 20 :
		filtro_20(); //FILTRO CONFECCIONCADO DIA 30/03/2010 POR PAH:
		break;
	case 21 :
		filtro_21(); //FILTRO CONFECCIONCADO DIA 30/03/2010 POR PAH:
		break;
	case 22 :
		filtro_22(); //FILTRO CONFECCIONCADO DIA 30/03/2010 POR PAH:
		break;
	case 23 :
		filtro_23(); //FILTRO CONFECCIONCADO DIA 30/03/2010 POR PAH:
		break;
	case 24 :
		filtro_24(); //FILTRO CONFECCIONCADO DIA 31/03/2010 POR PAH:
		break;
}

function filtro_0() {
	$pesquisa = "select * from gabarito where ((ano = '".$_SESSION['ano']."')";
	$pesquisa = $pesquisa . " and (fase = '".$_SESSION['fase']."'))";
	montar_resposta($pesquisa);
}
function filtro_1() {
	$pesquisa = "select status,cod_status from  status_aluno order by status asc";
	montar_resposta($pesquisa);
}
function filtro_2() {

	$pesquisa .= "select NOME as escola from  escolas where ID_PJ = ".$_SESSION['id_pj'];
	montar_resposta($pesquisa);
}
function filtro_3() {
	$pesquisa = "select distinct NOME_SERIE as Serie,IDSERIE as idSerie from series2009 where ";
	$pesquisa = $pesquisa . " ((IDPESSOA_JURIDICA = '".$_SESSION['id_pj']."')";
	$pesquisa = $pesquisa . " and (fase = '".$_SESSION['fase']."')";
	$pesquisa = $pesquisa . " and (id_periodo_letivo = '".$_SESSION['id_periodo']."'))";
	montar_resposta($pesquisa);
}
function filtro_4() {
	$_SESSION['idserie'] = $_POST['serie'];
	$pesquisa = "select distinct NOME_CLASSE as Turma,IDTURMA as idTurma from series2009 where";
	$pesquisa = $pesquisa . " ((IDPESSOA_JURIDICA = ".$_SESSION['id_pj'];
	$pesquisa = $pesquisa . " )and (IDSERIE = ".$_SESSION['idserie'];
	$pesquisa = $pesquisa . " )and (id_periodo_letivo = ".$_SESSION['id_periodo'];
	$pesquisa = $pesquisa . " )and (fase = ".$_SESSION['fase'].")) order by NOME_CLASSE asc";
	montar_resposta($pesquisa);
}
function filtro_5() {
	$_SESSION['idturma'] = $_POST['turma'];
	$pesquisa = "select distinct PERIODO from series2009 where";
	$pesquisa = $pesquisa . " IDPESSOA_JURIDICA = '".$_SESSION['id_pj']."'";
	$pesquisa = $pesquisa . " and IDSERIE = '".$_SESSION['idserie']."'";
	$pesquisa = $pesquisa . " and IDTURMA = '".$_SESSION['idturma']."'";
	$pesquisa = $pesquisa . " and id_periodo_letivo = '".$_SESSION['id_periodo']."'";
	$pesquisa = $pesquisa . " and fase = '".$_SESSION['fase']."'";
	montar_resposta($pesquisa);
}


function filtro_6() {
	$pesquisa = "SELECT 	mat.nome nome,
			         mat.id_cidadao id_cidadao
		             FROM 	valunos mat
		             where ((mat.id_pj 	 = (" . $_SESSION['id_pj'] . ")) 
					 and   	(mat.id_serie = (" . $_SESSION['idserie'] . "))
					 and   	(mat.id_turma = (" . $_SESSION['idturma'] . "))
					 and   	(" . $_POST['forma'] . "
					(
					 SELECT 	res.id_cidadao
					 FROM resultados res
					 where 	((res.id_cidadao 	= mat.id_cidadao)
					 and	(res.id_pj	= mat.id_pj)
					 and 	(res.fase	= (" . $_SESSION['fase'] . "))) 
					 and 	(res.ano	= (" . $_SESSION['ano'] . ")))		
					 )) order by mat.nome ;";
	montar_resposta($pesquisa);
}

function filtro_8() {
	$pesquisa = "SELECT id_nivel, ";
	$pesquisa .= "dsc_nivel";
	$pesquisa .= " FROM nivel";
	$pesquisa .= " WHERE ano =".$_SESSION['ano'];
	$pesquisa .= " and cod_fase = ".$_SESSION['fase']." order by id_nivel desc;";
	montar_resposta($pesquisa);
}
function filtro_9() {
	$pesquisa = "SELECT tipo_respostas.resposta as resposta, ";
	$pesquisa .= "tipo_respostas.cod_resposta as idresposta";
	$pesquisa .= " FROM tipo_respostas";
	$pesquisa .= " WHERE tipo_respostas.resposta != 'BRANCO';";
	montar_resposta($pesquisa);
}
function filtro_10() {
	$pesquisa = "SELECT * ";
	$pesquisa .= " FROM resultados";
	$pesquisa .= " WHERE (((resultados.ID_Cidadao)=".$_POST['aluno'];
	$pesquisa .= ") AND ((resultados.ano)=".$_SESSION['ano'];
	$pesquisa .= ") AND ((resultados.fase)=".$_SESSION['fase']."));";
	montar_resposta($pesquisa);
}
function filtro_11() {
	$pesquisa = "SELECT nivel.id_nivel as idnivel,";
	$pesquisa .= "nivel.faixa_inicial as menor,";
	$pesquisa .= "nivel.faixa_final as maior";
	$pesquisa .= " FROM nivel";
	$pesquisa .= " WHERE ((nivel.ano=".$_SESSION['ano'];
	$pesquisa .= " )AND (nivel.cod_fase=".$_SESSION['fase']."));";
	montar_resposta($pesquisa);
}
function filtro_12() {
	$pesquisa = "SELECT aluno_classe.justificativa_professor as justificativa,";
	$pesquisa .= "aluno_classe.id_nivel_professor nivel_professor,";
	$pesquisa .= "nivel.dsc_nivel nivel_prova";
	$pesquisa .= " FROM nivel INNER JOIN";
	$pesquisa .= " aluno_classe ON nivel.id_nivel = aluno_classe.id_nivel_prova";
	$pesquisa .= " WHERE aluno_classe.id_cidadao =".$_POST['cod_aluno'];
	$pesquisa .= " AND aluno_classe.ano = 2010 ";
	$pesquisa .= " AND aluno_classe.cod_fase =".$_SESSION['fase'];
	montar_resposta($pesquisa);
}
function filtro_14() { //Nível Escola
	$pesquisa = "select matriculados.ID_PJ,";
	$pesquisa .= " ac.ano,ac.cod_fase,";
	$pesquisa .= " if(isnull(ac.id_nivel_professor),ac.id_nivel_prova,ac.id_nivel_professor) AS id_nivel_aluno,";
	$pesquisa .= " dsc_nivel as nivel,";
	$pesquisa .= " count(if(isnull(ac.id_nivel_professor),ac.id_nivel_prova,ac.id_nivel_professor)) as qtd";
	$pesquisa .= " from (matriculados join aluno_classe ac on matriculados.ID_CIDADAO = ac.id_cidadao) inner join";
	$pesquisa .= " nivel on if(isnull(ac.id_nivel_professor),ac.id_nivel_prova,ac.id_nivel_professor) = id_nivel";
	$pesquisa .= " where matriculados.ano =". $_SESSION['gano']." and ac.ano = ". $_SESSION['gano'] ." and ac.cod_fase = ".$_SESSION['gfase']." and id_pj = ".$_SESSION['id_pj'];
	$pesquisa .= " group by matriculados.ID_PJ,";
	$pesquisa .= " ac.ano,ac.cod_fase,";
	$pesquisa .= " if(isnull(ac.id_nivel_professor),ac.id_nivel_prova,ac.id_nivel_professor)";

	if ($_SESSION['gtipo'] == 1) {
		unset ($_SESSION['gtipo']);
		unset ($_SESSION['gano']);
		unset ($_SESSION['gfase']);
		unset ($_SESSION['gserie']);
		unset ($_SESSION['gturma']);
	}

	montar_resposta($pesquisa);
}

function filtro_15() { //Nível Turma
	$pesquisa = "select matriculados.ID_PJ,";
	$pesquisa .= " matriculados.ID_TURMA,matriculados.TURMA,";
	$pesquisa .= " matriculados.PERIODO,matriculados.ID_SERIE,matriculados.SERIE,";
	$pesquisa .= " ac.ano,ac.cod_fase,ac.id_classe,";
	$pesquisa .= " dsc_nivel as nivel,";
	$pesquisa .= " if(isnull(ac.id_nivel_professor),ac.id_nivel_prova,ac.id_nivel_professor) AS id_nivel_aluno,";
	$pesquisa .= " count(if(isnull(ac.id_nivel_professor),ac.id_nivel_prova,ac.id_nivel_professor)) as qtd";
	$pesquisa .= " from (matriculados join aluno_classe ac on matriculados.ID_CIDADAO = ac.id_cidadao) inner join";
	$pesquisa .= " nivel on if(isnull(ac.id_nivel_professor),ac.id_nivel_prova,ac.id_nivel_professor) = id_nivel";
	$pesquisa .= " where ac.ano = ".$_SESSION['gano']." and ac.cod_fase = ". $_SESSION['gfase']." and id_pj = ".$_SESSION['id_pj']." and matriculados.id_serie = ". $_SESSION['gserie']." and id_classe =". $_SESSION['gturma'] ." and matriculados.id_turma = ".$_SESSION['gturma'];
	$pesquisa .= " group by matriculados.ID_PJ,";
	$pesquisa .= " matriculados.ID_TURMA,matriculados.TURMA,";
	$pesquisa .= " matriculados.PERIODO,matriculados.ID_SERIE,matriculados.SERIE,";
	$pesquisa .= " ac.ano,ac.cod_fase,ac.id_classe,";
	$pesquisa .= " if(isnull(ac.id_nivel_professor),ac.id_nivel_prova,ac.id_nivel_professor)";

	unset ($_SESSION['gtipo']);
	unset ($_SESSION['gano']);
	unset ($_SESSION['gfase']);
	unset ($_SESSION['gserie']);
	unset ($_SESSION['gturma']);

	montar_resposta($pesquisa);
}

function filtro_16() { //Carrega Ano
	$pesquisa = "SELECT distinct ano FROM aluno_classe ";
	$pesquisa .= " order by ano desc";
	montar_resposta($pesquisa);
}

function filtro_17() { //Carrega Fase
	$pesquisa = "SELECT distinct cod_fase FROM aluno_classe ";
	$pesquisa .= " Where ano =". $_POST[ano];
	$pesquisa .= " order by cod_fase desc";
	montar_resposta($pesquisa);
}

function filtro_18() { //Carrega Série
	$pesquisa = "select distinct NOME_SERIE as Serie,IDSERIE as idSerie from series2009";
	$pesquisa = $pesquisa . " where ano =". $_POST[ano];
	//$pesquisa = $pesquisa." and fase = '$_POST[fase]'";
	montar_resposta($pesquisa);
}

function filtro_19() { //Carrega Turma
	$pesquisa = "select distinct NOME_CLASSE as Turma,IDTURMA as idTurma from series2009 where";
	$pesquisa = $pesquisa . " IDPESSOA_JURIDICA = ". $_SESSION[id_pj];
	$pesquisa = $pesquisa . " and IDSERIE =". $_POST[serie];
	$pesquisa = $pesquisa . " and fase =". $_POST[fase]." order by NOME_CLASSE asc";
	montar_resposta($pesquisa);
}

// ---------------------------

//FILTRO CONFECCIONCADO DIA 30/03/2010 POR PAH:
function filtro_20() {
	$pesquisa = "SELECT g.ano FROM gabarito g INNER JOIN ( series2009 s INNER JOIN vcadastrados2009 v ON s.idturma=v.id_turma) ON g.ano=s.ano";
	$pesquisa .= " GROUP BY g.ano ORDER BY g.ano";
	//echo $pesquisa; exit;
	montar_resposta($pesquisa);
}
//FILTRO CONFECCIONCADO DIA 30/03/2010 POR PAH:
function filtro_21() {
	$pesquisa = "SELECT f.* FROM fase f INNER JOIN (gabarito g INNER JOIN ( series2009 s INNER JOIN vcadastrados2009 v ON v.id_turma=s.idturma) ON g.ano=s.ano) ON g.fase = f.cod_fase";
	$pesquisa .= " WHERE g.ano = '" . $_POST['ano'] . "' GROUP BY f.dsc_fase ORDER BY f.dsc_fase";
	//echo $pesquisa; exit;
	montar_resposta($pesquisa);
}
//FILTRO CONFECCIONCADO DIA 30/03/2010 POR PAH:
function filtro_22() {
	$pesquisa = "SELECT s.idserie, s.nome_serie FROM series2009 s INNER JOIN vcadastrados2009 v ON v.id_turma=s.idturma WHERE v.id_PJ = '" . $_SESSION['id_pj'] . "'";
	$pesquisa .= " AND s.idserie=v.id_serie AND s.ano=" . $_POST['cboAno'] . " AND s.fase=" . $_POST['cboFase'] . " GROUP BY s.nome_serie ORDER BY s.nome_serie";
	//echo $pesquisa; exit;
	montar_resposta($pesquisa);
}

function filtro_23() {
	$pesquisa = "SELECT s.NOME_CLASSE as Turma, s.IDTURMA as idTurma FROM vcadastrados2009 v INNER JOIN (series2009 s INNER JOIN gabarito g ON s.ano=g.ano ) ON s.idturma= v.id_turma ";
	$pesquisa .= " WHERE s.IDPESSOA_JURIDICA = " . $_SESSION['id_pj'] . " AND s.IDSERIE = " . $_POST['idserie'] . " AND s.FASE = " . $_POST['fase'];
	$pesquisa .= " AND g.ano = " . $_POST['cboAno'];
	$pesquisa .= " GROUP BY s.NOME_CLASSE ORDER BY s.IDTURMA";
	//echo $pesquisa; exit;
	montar_resposta($pesquisa);
}

function filtro_24() {
	$pesquisa = "SELECT s.IDPERIODO_DO_DIA as id, s.PERIODO as periodo FROM series2009 s INNER JOIN gabarito g ON s.fase = g.fase ";
	$pesquisa .= " WHERE s.IDPESSOA_JURIDICA = " . $_SESSION['id_pj'] . " AND s.IDSERIE = " . $_POST['idserie'];
	$pesquisa .= " AND s.ano = g.ano AND s.FASE = " . $_POST['fase'] . " AND s.IDTURMA= " . $_POST['idturma'] . " AND g.ano= " . $_POST['cboAno'];
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
	} else {
		$var_nreg = $tb_dados->rowCount();
		//$var_dadosxml .= "<pesquisa>$pesquisa</pesquisa>";
		$var_dadosxml .= "<nreg>$var_nreg</nreg>";
	}
	monta_xml($var_dadosxml);
}

function monta_xml($var_dadosxml) {
	$meuxml = "<?xml version=\"1.0\" ?>";
	$meuxml .= "<dados>";
	$meuxml .= $var_dadosxml;
	$meuxml .= "</dados>";
	header("Content-type: application/xml");
	echo $meuxml;
}

/*
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
} */
?>