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
 ARQUIVO PMONTADO PARA MONTAR RESPOSTAS QUE N�O PRECISAM EXECUTAR UMA
 QUERY
 VERIFICA SE H� UM USUARIO LOGADO PELA EXISTENCIA DA VARIAVE DE SE��O
 DO USUARIO */
ob_start();
session_start();
ob_end_clean();
header('Content-Type: text/plain; charset=utf-8');
if ( isset ($_SESSION['usuario'])) {
  $var_dadosxml .= "<existe>sim</existe>";
}
else {
  $var_dadosxml .= "<existe>nao</existe>";
}
$meuxml = "<?xml version=\"1.0\" ?>";
$meuxml.="<dados>";
$meuxml.=$var_dadosxml;
$meuxml.="</dados>";
header("Content-type: application/xml");
echo $meuxml;
?>
