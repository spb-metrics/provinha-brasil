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

  ESTE AQUIVO � REPONSAVEL PELA ALTER��O DE SEMNHA DO USUARIO;ANTES DE
  ALTERAR ELE CONFIRMA A SENHA DO USUARIO WE DEPOIS ALTERA SE N�O OCERRER
  ERROS NA ALTER��O ELE RETORNA UMA MENSGEM NUM DOCUMENTO XML COM OK CASO
  CONTRARIO ELE AVISA QUE ACORREU ERRO.
*/
 
ob_start();
session_start();
ob_end_clean();
header('Content-Type: text/plain; charset=utf-8');
require_once("banco.php");
// PESQUISA O COD_FUNCIONAL / SENHA / IDESCOLA NO B.D.
$pesquisa ="SELECT usuariosweb.senha as SENHA ";
$pesquisa .="FROM usuariosweb ";
$pesquisa .="WHERE (((usuariosweb.COD_FUNCIONAL='$_SESSION[usuario]')))";
$result = pesquisar($pesquisa);
$valor=$result->fetch(); // APRESENTA ERRO NESSA LINHA ..... ?????  NA EXECUSS�O DO SCRIPT
$senha= $valor['SENHA'];
$nreg=$result->rowCount();
if ($senha == $_POST['txt_atual']){
	$tabela = 'usuariosweb';
	$conteudo = "senha='$_POST[txt_nova]'";
	$condicao = "COD_FUNCIONAL='$_SESSION[usuario]'";
	$teste = alterar($tabela,$conteudo,$condicao);
	if ($teste){
	    $dadosxml='<men>ok</men>';
	}
	else{
		$dadosxml ="<msg>Falha ao alterar sua senha. Tente novamente, caso o problema ";
	    $dadosxml.="persista, por gentileza, contate o administrador do sistema!</msg>";
	}
}
else{
	$dadosxml="<men>senha atual incorreta!!!</men>";
	$dadosxml.="<pesquisa>$pesquisa</pesquisa>";	
}
$meuxml = "<?xml version=\"1.0\" ?>";
$meuxml.="<dados>";
$meuxml.=$dadosxml; 
$meuxml.="</dados>";
header("Content-type: application/xml");
echo $meuxml;
