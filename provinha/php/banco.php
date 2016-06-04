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


 ESTE ARQUIVO TEM COMTEM FUN��ES PARA TRABALHAR COM BANCO DE DADOS:
    - conact
      * cria uma conex�o com o banco se ocorrer erro ela retorna um valor
      * false do contrario ele retorna a propria conex�o.
    - pesquisar($pesquisa)
      * executa um query no banco e retorna um resultset
      * $pesquisa � a query que deve ser executada.
    - incluir($tabela,$campos,$valores)
      * faz uma inclus�o no banco de dados
      * $tabela : nome da tabela em que ser� inserido os dados.
      * $campos : nome dos campos em que ser� inserido na tabela.
      * $valores : Valores que ser�m inseridos na tabela.
    - alterar($tabela,$conteudo,$condicao){
      * faz uma alter��o no banco de dados
      * $tabela : nome da tabela em que ser� alterado os dados.
      * $conteudo : conteudo que ser� alterado na tabela.
      * $condicao : condi��o em que os conteudo vai ser alterado.
     - excluir($tabela,$condicao)
      * faz uma exclus�o no banco de dados
      * $tabela : nome da tabela em que ser� excluido os dados.
      * $condicao : condi��o em que os conteudo vai ser excluido.
 */
function conect(){
    try{
    	$db= new PDO('mysql:host=localhost;dbname=provinhabrasil','root','root') ;
    	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, 1);    
    	return $db;
    }  
    catch (PDOException $e){        
        codigos_erros($e->getCode(),$e->getMessage());
		return false;
	}
}

function pesquisar($pesquisa){		
    $db=conect();
	if (!$db){// EXECUTA A PESQUISA 'SELECT' NA TABELA
	    return $db;
	}
	else{
		try {
            $result = new PDOStatement();
            $result  = $db->prepare($pesquisa);
            $result->execute();            
            return $result;            
            $db=null;
			}
		catch ( PDOException  $e){
            codigos_erros($e->getCode(),$e->getMessage());
            return false;
        }
	}
}

function incluir($tabela,$campos,$valores){
	$db=conect();
	if (!$db){// EXECUTA A PESQUISA 'SELECT' NA TABELA
	    return $db;
	}
	else{
		try	{
            $valores = utf8_decode($valores);
            $result= $db->prepare("insert into $tabela ($campos) values ($valores)");
			$result = $db->exec("insert into $tabela ($campos) values ($valores)");			
			$db=null;			
			return "insert into $tabela ($campos) values ($valores)";
		}
		catch (PDOException $e){			
			codigos_erros($e->getCode(),$e->getMessage());
            return "insert into $tabela ($campos) values ($valores)";
		}
	}
}


function alterar($tabela,$conteudo,$condicao){
	$db=conect();
	if (!$db){// EXECUTA A PESQUISA 'SELECT' NA TABELA
	    return $db;
	}
	else{
		try{
			$result = $db->exec("update $tabela set $conteudo where $condicao");
			$db=null;
			return "update $tabela set $conteudo where $condicao";
		}
		catch (PDOException $e){			
			codigos_erros($e->getCode(),$e->getMessage());
            return "update $tabela set $conteudo where $condicao";
		}
	}
}

function excluir($tabela,$condicao){
	$db=conect();
	if (!$db){// EXECUTA A PESQUISA 'SELECT' NA TABELA
	    return $db;
	}
	else{
		try{
			if (condicao != ""){
				$result = $db->exec("delete from $tabela where $condicao");
				$db=null;
				return true;
			}
			else{
				return "comando sem condi��oo";
			}
		}
		catch (PDOException $e){			
			codigos_erros($e->getCode(),$e->getMessage());
            return false;
		}
	}
}



function codigos_erros($cod,$msg )
{
print "Erro de Código: $cod  e a  Mensagem é:  $msg ";
}
