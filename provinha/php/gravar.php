<?php
/**********************************************************************
 *  PREFEITURA MUNUCIPLA DE GUARULHOS                                 *
 *  SECRETARIA MUNICIPAL DA EDUCAÇÃO                                  *
 *  DPIE - DEPARTAMENTO DE PLANEJANMENTO E INFORMÃTICA NA EDUCAÇÃO   *
 *  PROVINHA BRASIL                                                   *
 *                                                                    *
 *  Copyright 2010, 2011, 2012 da Prefeitura Municipal de Guarulhos - *
 *  Secretaria de Educação                                            *
 *  Este arquivo é parte do programa Provinha Brasil.                 *
 *  O Provinha Brasil é um software livre; você pode redistribuí-lo   *
 *   e/ou modificá-lo dentro dos termos da Licença Pública Geral GNU  *
 *   como publicada pela Fundação do Software Livre (FSF); na versão 2*
 *  da  licença.                                                      *
 *  Este programa é distribuído na esperança que possa ser útil,      *
 *   mas SEM NENHUMA GARANTIA;uma garantia implícita de ADEQUAÇÃO a   *
 *   qualquer MERCADO ou APLICAÇÃO EM PARTICULAR.                     *
 *  Veja a Licença Pública Geral GNU/GPL em português para            *
 *   maiores detalhes.                                                *
 *  Você deve ter recebido uma cópia da Licença Pública Geral GNU,    *
 *   sob o título "LICENCA.txt",                                      *
 *  junto com este programa, se não, acesse o Portal do Software      *
 *   Público Brasileiro no endereço www.softwarepublico.gov.br ou     *
 *   escreva para a Fundação do Software Livre (FSF) Inc.,            *
 *   51 Franklin St, Fifth Floor, Boston, MA 02110-1301, USA          *
 **********************************************************************
    ESTE ARQUIVO RESPONSAVEL PELA GUAVAÇÃO DAS RESPOSTAS DOS ALUNOS
    E RECEBE UM PARAMETRO CHAMAODO OPERAÇÃO:
    - SE OPERAÇÃO FOR = INCLUIR
      * ELE INCLUI UM NOVO REGISTRO NO BANCO
   - SE OPERAÇÃO FOR = SALVAR
      * ELE ALTERA UM REGISTRO DO BANCO
    A function monta_xml RECEBE UMA STRING E MONTA UM DOCUMENTO XML E A
   EXIBI PARA PODER MANDAR COMO RETORNO PARA APLICAÇÃO
 */
session_start();
require_once ('banco.php');
$cod_aluno = $_POST['cod_aluno'];
$pesquisa = "select * from resultados";
$pesquisa .= " where ID_Cidadao = $cod_aluno";
$pesquisa .= " and ano = $_SESSION[ano]";
$pesquisa .= " and fase = $_SESSION[fase]";
$resposta = pesquisar($pesquisa);
$_SESSION[nreg] = $resposta->rowCount();
if ($_POST[operacao] == 'incluir') {
  incluir_resrposta();
}
else {
  alterar_resrposta();
}
$_SESSION['var_dadosxml'] .= "<pesquisa>$pesquisa</pesquisa>";
$_SESSION['var_dadosxml'] .= "<mensagem>$_SESSION[men]</mensagem>";
monta_xml($_SESSION['var_dadosxml']);




function incluir_resrposta() {
  $cod_aluno = $_POST['cod_aluno'];
  $id_pj = $_SESSION['id_pj'];
  $status = $_POST['status'];
  $fase = $_SESSION['fase'];
  $ano = $_SESSION['ano'];
  $usuario = $_SESSION['usuario'];
  $nivel = $_POST['nivel'];
  if ($_SESSION[nreg] == 0) {
    $campos = "Q1"; // prepara insert na tabela resultados onde vai ficar o resultado das prova
    $valor = $_POST['nota_1'];
    $valores = "'$valor'";
    for ($i = 2; $i <= 24; $i++) {
      $campos .= ",Q$i";
      $nome_valor = "nota_$i";
      $valores .= ",'$_POST[$nome_valor]'";
    }
    $campos .= ",Nota,ID_Cidadao,ID_PJ,Status,fase,";
    $campos .= "ano,cod_usuario_inc,cod_usuario_alt,id_periodo_letivo";
    $valores .= ",$_POST[nota_25],'$cod_aluno','$id_pj','$status','$fase',";
    $valores .= "'$ano','$usuario','0',$_SESSION[id_periodo]";
    $teste = incluir("resultados", $campos, $valores);
    if ($teste == true) {
      $campos = "id_classe,id_nivel_prova,id_cidadao,cod_fase,ano";// prepara insert na tabela aluno_classe e define nivel da prov
      $valores = "'$_SESSION[idturma]','$nivel','$cod_aluno','$fase','$ano'";
      $teste1 = incluir("aluno_classe", $campos, $valores);
      $_SESSION['men'] = 'Salvo com sucesso!!!';
      $_SESSION['var_dadosxml'] = '<teste>ok</teste>';
    }
    else {
      $_SESSION['men'] = 'falha ao gravar as respostas tente novamento caso o problema';
      $_SESSION['men'] .= 'persistir entre em contato com o administrado do sitema!!!';
      $_SESSION['var_dadosxml'] = '<teste>false</teste>';
    }
  }
  else {
    $_SESSION['men'] = 'Aluno já cadastrado!!!';
    $_SESSION['var_dadosxml'] = '<teste>false</teste>';
  }
  $_SESSION['var_dadosxml'] .= "<gravou>$teste1</gravou>";
}
function alterar_resrposta() {
  $cod_aluno = $_POST['cod_aluno'];
  $id_pj = $_SESSION['id_pj'];
  $status = $_POST['status'];
  $fase = $_SESSION['fase'];
  $ano = $_SESSION['ano'];
  $usuario = $_SESSION['usuario'];
  $nivel = $_POST['nivel'];
  $conteudo = "Q1=$_POST[nota1]";
  for ($i = 2; $i <= 24; $i++) {
    $valor = $_POST["nota$i"];
    $conteudo .= ",Q$i='$valor'";
  }
  $conteudo .= ",nota='$_POST[nota25]'";
  $conteudo .= ",status='$status',cod_usuario_alt='$usuario'";
  $condicao = "ID_Cidadao = $cod_aluno and fase = $fase and ano = $ano";
  $teste = alterar("resultados", $conteudo, $condicao);
  if ($teste == true) {
    $conteudo = "id_nivel_prova=$nivel";// prepara update na tabela aluno_classe e define nivel da prov
    $condicao = "ID_Cidadao = $cod_aluno  and cod_fase = $fase and ano = $ano";
    $teste1 = alterar("aluno_classe", $conteudo, $condicao);
    $_SESSION['men'] = 'Alterado com sucesso!!!';
    $_SESSION['var_dadosxml'] = '<teste>ok</teste>';
  }
  else {
    $_SESSION['men'] = 'falha ao gravar as respostas tente novamento caso o problema';
    $_SESSION['men'] .= 'persistir entre em contato com o administrado do sitema!!!';
    $_SESSION['var_dadosxml'] = '<teste>false</teste>';
  }
  $_SESSION['var_dadosxml'] .= "<gravou>$teste1</gravou>";
}



function monta_xml($var_dadosxml) {
$meuxml = "<?xml version=\"1.0\" ?>";
$meuxml.="<dados>";
$meuxml.=$var_dadosxml;
$meuxml.="</dados>";
header("Content-type: application/xml");
echo $meuxml;
}
?>
