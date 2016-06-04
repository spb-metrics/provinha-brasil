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

  ESTE AQUIVO É REPONSAVEL PELA ALTERÇÃO DE SEMNHA DO USUARIO;ANTES DE
  ALTERAR ELE CONFIRMA A SENHA DO USUARIO WE DEPOIS ALTERA SE NÃO OCERRER
  ERROS NA ALTERÇÃO ELE RETORNA UMA MENSGEM NUM DOCUMENTO XML COM OK CASO
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
$valor=$result->fetch(); // APRESENTA ERRO NESSA LINHA ..... ?????  NA EXECUSSï¿½O DO SCRIPT
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
