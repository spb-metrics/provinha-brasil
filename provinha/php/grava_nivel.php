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
 
   ESTE ARQUIVO RESPONSAVEL PELA GUAVA��O DO DADOS DO NIVEL DO ALUNO:
   ELE EXECUTA UMA PESQUISA
   - SE N�O ENCONTRAR RESGISTRO ELE INSERE UM NOVO
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
