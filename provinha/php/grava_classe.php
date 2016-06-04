<?php
/**********************************************************************
 *  PREFEITURA MUNUCIPLA DE GUARULHOS                                 *
 *  SECRETARIA MUNICIPAL DA EDUCA��O                                  *
 *  DPIE - DEPARTAMENTO DE PLANEJANMENTO E INFORMÁTICA NA EDUCA��O   *
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

   ESTE ARQUIVO RESPONSAVEL PELA GUAVA��O DO DADOS DA CLASSE:
   ELE EXECUTA UMA PESQUISA  E RECEBE UM PARAMETRO CHAMAODO OPERA��O
   - SE OPERA��O FOR = PESQUISAR ELE APENAS RETORNA UMA REPOSTA EM UM
   DOCUMENTO NO FORMATO XML
   - SE OPERA��O FOR = SALVAR
     - SE N�O ENCONTRAR RESGISTRO ELE INSERE UM NOVO
     - SE ENCONTRAR RESGISTRO ELE ALTERA O ENCONTRADO
   A function monta_xml RECEBE UMA STRING E MONTA UM DOCUMENTO XML E A
   EXIBI PARA PODER MANDAR COMO RETORNO PARA APLICA��O
 */
ob_start();
session_start();
ob_end_clean();
require_once ('banco.php');
$pesquisa = "SELECT $_POST[campos_select]";
$pesquisa .= " FROM classe";
$pesquisa .= " INNER JOIN series2009 ON classe.IDTURMA = series2009.IDTURMA";
$pesquisa .= " WHERE (((classe.cod_fase)=$_SESSION[fase])";
$pesquisa .= " AND ((classe.ano)=$_SESSION[ano])";
$pesquisa .= " AND ((classe.IDTURMA)=$_SESSION[idturma])";
$pesquisa .= " AND ((series2009.IDPESSOA_JURIDICA)=$_SESSION[id_pj])";
$pesquisa .= " AND ((series2009.IDSERIE)=$_SESSION[idserie]));";
if ($_POST['operacao'] == "pesquisar") {
  montar_resposta($pesquisa);
}
if ($_POST['operacao'] == "salvar") {
  $resposta = pesquisar($pesquisa);
  $valor = $resposta->fetch();
  if ($resposta->rowCount() == 0) {
  //insert
  incluir_classe();
  }
  else {
  //update
  alterar_classe($valor['id_classe']);
  }

}

function montar_resposta($pesquisa) {
  $tb_dados = pesquisar($pesquisa);
  $var_nreg = $tb_dados->rowCount();
  $var_dadosxml .= "<pesquisa>$pesquisa</pesquisa>";
  $var_dadosxml .= "<nreg>$var_nreg</nreg>";
  if ($tb_dados->rowCount() > 0) {
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
  monta_xml($var_dadosxml);
}

function incluir_classe() {
  $campos = "cod_fase,IDTURMA,ano,nome_professor,conclusao_proletrado,qtd_ano_rede,qtd_mes_rede";
  $valor = mb_strtoupper(utf8_decode($_POST['professor']));
  $valor1 = $_POST['proletramento'];
  $valor2 = mb_strtoupper(utf8_decode($_POST['qtd_ano_rede']));
  $valor3 = mb_strtoupper(utf8_decode($_POST['qtd_mes_rede']));
  $valores = "'$_SESSION[fase]','$_SESSION[idturma]','$_SESSION[ano]','$valor','$valor1','$valor2','$valor3'";
  for ($i = 1; $i <= 10; $i++) {
    if ($i <= 5) {
      $valor = mb_strtoupper(utf8_decode($_POST["txt_inter$i"]));
      $campos .= ",inter_pedagogica$i";
      $valores .= ",'$valor'";
    }
    $valor = mb_strtoupper(utf8_decode($_POST["txt_D$i"]));
    $campos .= ",desc_opniao_prof_d$i";
    $valores .= ",'$valor'";
    $valor = $_POST['chk_D'.$i.'Q1'];
    $campos .= ',d'.$i.'_maior_dificuldade';
    $campos .= ',d'.$i.'_opniao_prof';
    $valores .= ",'$valor'";
    $valores .= ",'$valor'";
  }
  $campos .= ',obs_classe';
  $valor = mb_strtoupper(utf8_decode($_POST['txt_obs']));
  $valores .=",'$valor'";
  $teste = incluir('classe', $campos, $valores);
  if ($teste) {
    $var_dadosxml = '<mensagem>Salvo com sucesso!!!</mensagem>';
    $var_dadosxml .= '<teste>ok</teste>';
//    $var_dadosxml .= "<gravou>$teste</gravou>";
  }
  else {
    $men = 'Falha ao gravar os dados da classe tente novamente em alguns minutos caso o erro persistir entre ';
    $men .= 'em contato com o administrador do sistema!';
    $var_dadosxml = '<mensagem>$men</mensagem>';
    $var_dadosxml .= '<teste>false</teste>';
    //$var_dadosxml .= "<gravou>$teste</gravou>";
  }
  monta_xml($var_dadosxml);
}

function alterar_classe($id_classe) {
  $valor = mb_strtoupper(utf8_decode($_POST['professor']));
  $valor1 = $_POST['proletramento'];
  $valor2 = mb_strtoupper(utf8_decode($_POST['qtd_ano_rede']));
  $valor3 = mb_strtoupper(utf8_decode($_POST['qtd_mes_rede']));
  $conteudo = "nome_professor='$valor',";
  $conteudo .= "conclusao_proletrado='$valor1',";
  $conteudo .= "qtd_ano_rede='$valor2',";
  $conteudo .= "qtd_mes_rede='$valor3',";
  for ($i = 1; $i <= 10; $i++) {
    if ($i
    <= 5) {
      $valor = mb_strtoupper(utf8_decode($_POST["txt_inter$i"]));
      $conteudo .= "inter_pedagogica$i='$valor',";
      $condicao = "id_classe='$id_classe'";
    }
    $valor = mb_strtoupper(utf8_decode($_POST["txt_D$i"]));
    $conteudo .= "desc_opniao_prof_d$i='$valor',";
    $valor = utf8_decode($_POST['chk_D'.$i.'Q1']);
    $nome_campo = 'd'.$i.'_maior_dificuldade';
    $nome_campo1 = 'd'.$i.'_opniao_prof';
    $conteudo .= "$nome_campo='$valor',";
    $conteudo .= "$nome_campo1='$valor',";
  }
  $valor = mb_strtoupper(utf8_decode($_POST['txt_obs']));
  $conteudo .= "obs_classe='$valor'";
  $teste = alterar('classe', $conteudo, $condicao);

  if ($teste) {
    $var_dadosxml = '<mensagem>Alterado com sucesso!!!</mensagem>';
    $var_dadosxml .= '<teste>ok</teste>';
//    $var_dadosxml .= "<gravou>$teste</gravou>";
  }
  else {
    $men = 'Falha ao gravar os dados da classe tente novamente em alguns minutos caso o ero presista entre ';
    $men .= 'em contato com o administrador do sistema!';
    $var_dadosxml = '<mensagem>$men</mensagem>';
    $var_dadosxml .= '<teste>false</teste>';
    //$var_dadosxml .= "<gravou>$teste</gravou>";
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
