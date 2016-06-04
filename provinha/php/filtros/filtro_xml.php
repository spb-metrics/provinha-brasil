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
 ARQUIVO PMONTADO PARA MONTAR RESPOSTAS QUE NÃO PRECISAM EXECUTAR UMA
 QUERY
 VERIFICA SE HÁ UM USUARIO LOGADO PELA EXISTENCIA DA VARIAVE DE SEÇÃO
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
