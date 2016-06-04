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
 
   ESTE ARQUIVO RESPONSAVEL PELA GUAVAÇÃO DO DADOS DO NIVEL DO ALUNO:
   ELE EXECUTA UMA PESQUISA
   - SE NÃO ENCONTRAR RESGISTRO ELE INSERE UM NOVO
   - SE ENCONTRAR RESGISTRO ELE ALTERA O ENCONTRADO
   */
ob_start();
session_start();
ob_end_clean();
require_once ('banco.php');
$nivel=$_POST['nivel'];
$texto= mb_strtoupper(utf8_decode($_POST['texto']));
$conteudo = "id_nivel_professor = $nivel,";
$conteudo .= "justificativa_professor = '$texto'";
$condicao = "id_classe = $_SESSION[idturma]";
$condicao .= " and id_cidadao = $_POST[cod_aluno]";
$condicao .= " and ano = $_SESSION[ano]";
$condicao .= " and cod_fase = $_SESSION[fase]";
$teste = alterar("aluno_classe",$conteudo,$condicao);
if ($teste){
	$var_dadosxml = '<mensagem>Salvo com sucesso!!!</mensagem>';
    $var_dadosxml .= '<teste>ok</teste>';
}
else{
	$men='Falha ao gravar o nivel tente novamente em alguns minutos caso o ero presista entre ';
	$men.='em contato com o administrador do sistema!';
	$var_dadosxml .= '<teste>false</teste>';
}
$var_dadosxml .= "<gravou>$teste</gravou>";
$meuxml = "<?xml version=\"1.0\" ?>";
$meuxml.="<dados>";
$meuxml.=$var_dadosxml;
$meuxml.="</dados>";
header("Content-type: application/xml");
echo $meuxml;
