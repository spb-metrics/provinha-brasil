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
 ESTE ARQUIVO � REPONSAVEL POR MONTAR O RELATORIO DE CLASSE EM PDF.
 A function montar_pdf($resultset) recebe um resutset e  monta o
 documento pdf apartir dele.
 */
ob_start();
session_start();
ob_end_clean();
require_once ('fpdf/fpdf.php');
require_once ('banco.php');

$pesquisa = "SELECT escolas.NOME as escola,";
$pesquisa .= "series2009.NOME_SERIE as serie,";
$pesquisa .= "series2009.NOME_CLASSE as classe,";
$pesquisa .= " series2009.PERIODO as periodo,";
$pesquisa .= " classe.nome_professor as professor,";
$pesquisa .= " classe.conclusao_proletrado as pro_letrado,";
$pesquisa .= " classe.tempo_educador_rede as t_rede,";
for ($i = 1; $i <= 10; $i++) {
  if ($i <= 5) {
    $pesquisa .= "classe.inter_pedagogica$i as inter_pedagogica$i,";
  }
  $pesquisa .= 'classe.d'.$i.'_maior_dificuldade as d'.$i.'_maior_dificuldade,';
  $pesquisa .= 'classe.desc_opniao_prof_d'.$i.' as desc_opniao_prof_d'.$i.',';
  $pesquisa .= 'classe.d'.$i.'_opniao_prof as d'.$i.'_opniao_prof,';
}
$pesquisa .= "classe.obs_classe as obs,";
$pesquisa .= "classe.ano as ano";
$pesquisa .= " FROM classe";
$pesquisa .= " INNER JOIN";
$pesquisa .= " (series2009 INNER JOIN escolas";
$pesquisa .= " ON series2009.IDPESSOA_JURIDICA = escolas.ID_PJ)";
$pesquisa .= " ON classe.IDTURMA = series2009.IDTURMA";
$pesquisa .= " WHERE (((classe.ano)=$_SESSION[ano])";
$pesquisa .= " AND ((classe.cod_fase)=$_SESSION[fase])";
$pesquisa .= " AND ((classe.IDTURMA)=$_SESSION[idturma])";
$pesquisa .= " AND ((series2009.IDSERIE)=$_SESSION[idserie])";
$pesquisa .= " AND ((escolas.ID_PJ)=$_SESSION[id_pj]));";
$reposta = pesquisar($pesquisa);
if ($reposta->rowCount() > 0) {
  montar_pdf($reposta);
}else{
	echo $pesquisa;
}



function montar_pdf($resultset) {
  $dados = $resultset->fetch();
  //DADOS DO POST ou do B.D.
  // APLICAR OS DADOS CONFORME A VARIÁVEL AO SEGUNDO PARÂMETRO DE CONCATENAÇÃO
  $d_pdf[escola] = utf8_decode('ESCOLA: ').utf8_decode($dados['escola']);
  $d_pdf[serie] = utf8_decode('SÉRIE: ').utf8_decode($dados['serie']);
  $d_pdf[turma] = utf8_decode('    TURMA: ').utf8_decode($dados['classe']);
  $d_pdf[periodo] = utf8_decode('    PERÍODO: ').utf8_decode($dados['periodo']);
  $d_pdf[professor] = utf8_decode('PROFESSOR(A): ').utf8_decode($dados['professor']);
  if ($dados['pro_letrado'] == 0) {
    $pro_letrado = 'sim';
  }
  else {
    $pro_letrado = 'não';
  }
  $d_pdf[letramento] = utf8_decode('    CONCLUIU PRÓ-LETRAMENTO?: ').utf8_decode($pro_letrado);
  $d_pdf[prof_t_rede] = utf8_decode('Tempo, na rede, como professor: ').utf8_decode($dados['t_rede']); // tempo do professor na rede
  $d_pdf[ano_atual] = date("Y");


  $d_pdf[da] = utf8_decode('Levando em consideração os descritores apresentados na Provinha Brasil (Apropriação do Sistema de Escrita e Leitura) e analisando os resultados da sua classe:');
  $d_pdf[db] = utf8_decode('Assinale os descritores que sua classe apresentou maior dificuldade:');
  //$d_pdf[dc] = utf8_decode('Assinale os descritores que você considera mais difícil de serem trabalhados em sua prática:');
  $d_pdf[dd] = utf8_decode('Explique o porquê da dificuldade para trabalhar os Itens assinalados:');

  for ($i = 1; $i <= 10; $i++) {
    if ($dados['d'.$i.'_maior_dificuldade'] == 1) {
      $maior_dificuldade = 'sim';
    }
    else {
      $maior_dificuldade = 'não';
    }
    /*if ($dados["desc_opniao_prof_d.$i"] == 0) {
     $desc_opniao_prof_d = 'sim';
     }
     else {
     $desc_opniao_prof_d = 'não';
     }*/
    $d_pdf[d.$i.b] = utf8_decode($maior_dificuldade);
    $d_pdf[d.$i.d] = utf8_decode(utf8_encode($dados['desc_opniao_prof_d'.$i]));
    //$d_pdf[d.$i.d] = utf8_decode($dados[]);
  }

  $d_pdf[d1a] = utf8_decode('D1:Reconhecer letras:');
  $d_pdf[d2a] = utf8_decode('D2:Reconhecer sílabas:');
  $d_pdf[d3a] = utf8_decode('D3:Estabelecer relações entre unidades sonoras e suas representações gráficas:');
  $d_pdf[d4a] = utf8_decode('D4:Ler palavras:');
  $d_pdf[d5a] = utf8_decode('D5:Ler frases:');
  $d_pdf[d6a] = utf8_decode('D6:Localizar informação explicita em texto:');
  $d_pdf[d7a] = utf8_decode('D7:Reconhecer assunto de um texto:');
  $d_pdf[d8a] = utf8_decode('D8:Identificar a finalidade do texto:');
  $d_pdf[d9a] = utf8_decode('D9:Estabelecer relação entre partes do texto:');
  $d_pdf[d10a] = utf8_decode('D10:Inferir informação:');

  $d_pdf[dt_atual] = date("d/m/y");

  $d_pdf[descritor] = utf8_decode('Baseando-se nesses Descritores, suas avaliações e os resultados da Provinha Brasil na sua classe, que intervenções pedagógicas você acredita que são importantes para que este grupo avance no processo de Alfabetização e Letramento, na continuidade do Ciclo?....');
  $d_pdf[descritor_1] = utf8_decode('1:').utf8_decode($dados['inter_pedagogica1']);
  $d_pdf[descritor_2] = utf8_decode('2:').utf8_decode($dados['inter_pedagogica2']);
  $d_pdf[descritor_3] = utf8_decode('3:').utf8_decode($dados['inter_pedagogica3']);
  $d_pdf[descritor_4] = utf8_decode('4:').utf8_decode($dados['inter_pedagogica4']);
  $d_pdf[descritor_5] = utf8_decode('5:').utf8_decode($dados['inter_pedagogica5']);
  $d_pdf[descritor_obs] = utf8_decode('OUTRAS OBSERVAÇÕES:').utf8_decode($dados['obs']);

  //NÃO MEXER A PARTIR DAQUI ...NÃO MEXER A PARTIR DAQUI ...NÃO MEXER A PARTIR DAQUI ...NÃO MEXER A PARTIR DAQUI ...NÃO MEXER A PARTIR DAQUI ...
  //NÃO MEXER A PARTIR DAQUI ...NÃO MEXER A PARTIR DAQUI ...NÃO MEXER A PARTIR DAQUI ...NÃO MEXER A PARTIR DAQUI ...NÃO MEXER A PARTIR DAQUI ...
  //NÃO MEXER A PARTIR DAQUI ...NÃO MEXER A PARTIR DAQUI ...NÃO MEXER A PARTIR DAQUI ...NÃO MEXER A PARTIR DAQUI ...NÃO MEXER A PARTIR DAQUI ...

  $titulo1 = "SECRETARIA DA EDUCAÇÃO\n";
  $titulo2 = "DEPARTAMENTO DE PLANEJAMENTO E INFORMÁTICA NA EDUCAÇÃO\n";
  $titulo3 = "PROVINHA BRASIL";
  //$titulo4="SEÇÃO TÉCNICA DE DESENVOLVIMENTO E SUPORTE\n";
  $titulo1 = utf8_decode($titulo1);
  $titulo2 = utf8_decode($titulo2);
  $titulo3 = utf8_decode($titulo3);
  //$titulo4=utf8_decode($titulo4);

  $pdf = new FPDF();
  $pdf->SetAutoPageBreak(false);
  $pdf->AddPage();

  // ################################ IN�CIO DA P�GINA ################################
  $m = 10;
  $a = 8; //margem esquerda // altura
  $pdf->SetXY($m, $a); // POSICIONAMENTO X / Y
  // LOGOTIPO
  $l_img = 40;
  $a_img = 20; //largura da imagem // altura da imagem
  $pdf->Image('../images/educacao_retangulo.jpg', $m, $a, $l_img, $a_img, jpg);
  $pdf->SetFillColor(232, 232, 232);
  //TITULO
  $pdf->SetFont('Arial', 'B', 10);
  $m += $l_img+8;
  $pdf->SetXY($m, $a); // posicao x do titulo
  //escreve o conteudo de novo.. parametros posicao inicial,altura,conteudo(*texto),borda,quebra de linha,alinhamento

  $pdf->MultiCell(140, 5, $titulo1, 0, 'C', 0);
  $pdf->SetXY($m, $a += 5); // posicao x do titulo
  $pdf->MultiCell(140, 5, $titulo2, 0, 'C', 0);
  $pdf->SetXY($m, $a += 5); // posicao x do titulo
  $pdf->MultiCell(140, 5, $titulo3, 0, 'C', 0);

  //NIVEL
  $relatorio = utf8_decode('RELATÓRIOQUALITATIVO:ProvinhaBrasil-'.$d_pdf[ano_atual].':');

  $pdf->SetXY($m = 10, $a += 18);
  $pdf->SetFont('Arial', 'BU', 14);
  $pdf->Cell(20, 5, $relatorio, 0, 0, L, false);

  $pdf->SetXY($m += 175, $a);
  $pdf->SetFont('Arial', 'U', 8);
  $pdf->Cell(20, 5, $d_pdf[dt_atual], 0, 0, L, false);

  $pdf->SetXY($m = 10, $a += 10); // posicao x do titulo
  $pdf->SetFont('Arial', 'B', 10);
  $pdf->MultiCell(140, 5, $d_pdf[escola], 0, 'L', 0);
  $pdf->SetXY($m += 85, $a); // posicao x do titulo
  $pdf->MultiCell(140, 5, $d_pdf[serie], 0, 'L', 0);
  $pdf->SetXY($m += 25, $a); // posicao x do titulo
  $pdf->MultiCell(140, 5, $d_pdf[turma], 0, 'L', 0);
  $pdf->SetXY($m += 25, $a); // posicao x do titulo
  $pdf->MultiCell(140, 5, $d_pdf[periodo], 0, 'L', 0);

  $pdf->SetXY($m = 10, $a += 5); // posicao x do titulo
  $pdf->MultiCell(140, 5, $d_pdf[professor], 0, 'L', 0);
  $pdf->SetXY($m += 101, $a); // posicao x do titulo
  $pdf->MultiCell(140, 5, $d_pdf[prof_t_rede], 0, 'L', 0);

  // COLUNAS x LINHAS

  $lc_a = 55;
  $lc_b = 25;
  $lc_c = 30;
  $lc_d = 80;

  $pdf->SetFont('Arial', 'B', 6);
  $pdf->SetXY($m = 10, $a += 10); // posicao x do titulo
  $pdf->MultiCell($lc_a, $ac = 5, $d_pdf[da], 0, 'L', 1);
  $pdf->SetXY($m += $lc_a, $a); // posicao x do titulo
  $pdf->MultiCell($lc_b, $ac, $d_pdf[db], 0, 'L', 1);
  //$pdf->SetXY($m += $lc_b, $a); // posicao x do titulo
  //$pdf->MultiCell($lc_c, $ac, $d_pdf[dc], 0, 'L', 1);
  $pdf->SetXY($m += $lc_b, $a); // posicao x do titulo
  $pdf->Cell($lc_d, 20, $d_pdf[dd], '', 0, 'J', 1);
  //$pdf->MultiCell($lc_d,$ac,$d_pdf[dd],1,'L',1);
  $a += 25;
  $pdf->line($m = 10, $a, 200, $a);
  $a += 3;
  // DESCR. OPINIÕES
  for ($lin = 1; $lin <= 10; $lin++)
  {
    $pdf->SetFont('Arial', '', 8);
    $pdf->SetXY($m = 10, $a); // posicao x do titulo
    $pdf->MultiCell($lc_a, $ac = 5, $d_pdf[d.$lin.a], 0, 't', 0);
    $pdf->SetXY($m += $lc_a, $a); // posicao x do titulo
    $pdf->MultiCell($lc_b, $ac, $d_pdf[d.$lin.b], 0, 'C', 0);
    $pdf->SetXY($m += $lc_b, $a); // posicao x do titulo
    $pdf->MultiCell($lc_c, $ac, $d_pdf[d.$lin.c], 0, 'C', 0);
    $pdf->SetXY($m += $lc_c, $a); // posicao x do titulo
    $pdf->MultiCell($lc_d, $ac, $d_pdf[d.$lin.d], 0, 'L', 0);
    $a += 10;
    $pdf->line($m = 10, $a, 200, $a);
  }
  // TITULO DESCRITOR
  $a += 2;
  $pdf->line($m = 10, $a, 200, $a);
  $pdf->SetFont('Arial', '', 7);
  $pdf->SetXY($m = 10, $a += 5); // posicao x do titulo
  $pdf->MultiCell(190, 5, $d_pdf[descritor], 0, 'J', 1);
  // DESCRITORES
  $pdf->SetXY($m = 10, $a += 13); // posicao x do titulo
  $lc = 190;
  $ac = 5;
  for ($lin = 1; $lin <= 5; $lin++)
  {
    $pdf->SetFont('Arial', '', 7);
    $descritor = "descritor_".$lin;
    $pdf->SetXY($m = 10, $a); // posicao x do titulo
    $pdf->MultiCell($lc, $ac, $d_pdf[$descritor], 1, 'L', 0);
    $a += 10;
  }
  // DESCRITOR OBS
  $pdf->SetFont('Arial', '', 7);
  $pdf->SetXY($m = 10, $a); // posicao x do titulo
  $pdf->MultiCell($lc, $ac, $d_pdf[descritor_obs], 1, 'L', 0);
  // BARRA DE STATUS
  $pdf->SetXY($m, $a += 20); // POSICIONAMENTO X / Y
  $l_img = 190;
  $a_img = 10; //largura da imagem // altura da imagem
  $pdf->Image('../images/rodape.jpg', $m, $a, $l_img, $a_img, jpg);
  $pdf->SetFillColor(232, 232, 232);


  $pdf->SetFont('Arial', '', 6);
  $pdf->Output($d_pdf[professor].$d_pdf[ano_atual].'.pdf', 'I');
}
?>
