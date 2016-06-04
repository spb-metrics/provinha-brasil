<?
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
  EXECUTA UM QUERY PARA SABER SE O USUARIO EXISTE OU SE A SENHA DIGITADA
  EST� CORRETA, VERIFITANBEM SE O USUARIO EST� VINCULADO A UMA ESCOLA
  AO FINAL ELE RETORNA UMA RESPOSTA PARA APLICA��O NUM DOCUMENTO NO
  FORMATO XML
 */
session_start();
require_once ("banco.php");
$pesquisa = "select COD_FUNCIONAL,senha,IDESCOLA  from  usuariosweb where COD_FUNCIONAL like '".$_POST['txt_nome']."'";
$result = pesquisar($pesquisa);
$valor = $result->fetch();
$usuario = $valor['COD_FUNCIONAL'];
$senha = $valor['senha'];
$nreg = $result->rowCount();
if ($nreg == 0) {
  $dadosxml = "<men>Usuário inexistente!</men>";
}
else {
  if ($senha == $_POST['txt_senha']) {
    $_SESSION['usuario'] = $usuario;
    $_SESSION['id_pj'] = $valor['IDESCOLA'];
    if ($_SESSION['id_pj'] == 0) {
      $dadosxml = '<men>usuario n�o est�; vinculada a nenhuma escola!!!</men>';
      session_destroy();
    }
    else {
      $_SESSION['usuario'] = $usuario;
      $_SESSION['tipo_usuario'] = $tipo;
      $pesquisa = "select * FROM ativo";
      $respostas = pesquisar($pesquisa);
      $valor = $respostas->fetch();
      $_SESSION['ano'] = $valor['ano'];
      $_SESSION['fase'] = $valor['fase'];
      $dadosxml = '<men>ok</men>';
    }
  }
  else {
    $dadosxml = '<men>Usuário inexistente!</men>';
  }
}
$meuxml = "<?xml version=\"1.0\" ?>";
$meuxml.="<dados>$dadosxml</dados>"; 
header("Content-type: application/xml");  
echo $meuxml; 
