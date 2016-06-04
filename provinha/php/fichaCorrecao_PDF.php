<?php
ob_start();
session_start();
ob_end_clean();

require_once ('fpdf/fpdf.php');
require_once ('banco.php');

if (($_POST[funcao])&&($_POST[funcao]=='GerarGabaritoPdf')) {
    // =>>>   =>>>  =>>>   =>>>  =>>>   =>>>  BUSCAR DADOS
    $fichaCorrecao_Dados = new fichaCorrecao_Dados();
    $dados = $fichaCorrecao_Dados->gerarDados();
    // =>>>   =>>>  =>>>   =>>>  =>>>   =>>>  GERAR PÁGINA PDF
    $ClasseGera_PDF = new ClasseGera_PDF();
    $ClasseGera_PDF->geraPdf($dados);
}

class fichaCorrecao_Dados {
    public function gerarDados() {
        $dados[ano] = $_POST[cboAno];
        $dados[txtEscola] = $_POST[txtEscola];
        $dados[txtSerie]  = $_POST[txtSerie];
        $dados[txtTurma]  = $_POST[txtTurma];
        $dados[txtPeriodo]  = $_POST[txtPeriodo];
        //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> GABARITO >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>        
        $sql = "SELECT * FROM gabarito g WHERE g.fase = ".$_POST[cboFase]." AND g.ano = ".$_POST[cboAno];
        //echo $sql;       exit;
        $retorno = $this->pesquisar($sql);
        if ($retorno[n_reg]>0) {
            $Q=1;
            while ($retorno[res][0][Q.$Q]) {
                //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> LETRAS DO GABARITO >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
                $sql = "SELECT * FROM tipo_respostas t WHERE t.cod_resposta = ".$retorno[res][0][Q.$Q];
                //echo $sql;       exit;
                $letra = $this->pesquisar($sql);
                $dados[gabarito][$Q] = $letra[res][0][resposta];
                $Q++;
            }
        }
        else
            {
            echo "<script>alert('A pesquisa não encontrou alunos.');window.location.href='../gabarito.html';</script>";
            exit;
            }

        //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> ALUNOS >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
        $sql = "SELECT vc.nome FROM vcadastrados2009 vc INNER JOIN ( series2009 s INNER JOIN gabarito g ON g.ano=s.ano) ON s.idturma=vc.id_turma ";
        $sql .= "WHERE vc.id_PJ=". $_SESSION[id_pj]." AND vc.id_serie=".$_POST[cboSerie]." AND vc.id_turma=".$_POST[cboTurma];
        //echo $sql;exit;
        $retorno = $this->pesquisar($sql);        
        if ($retorno[n_reg]>0) {
            $x=0;
            while ($retorno[res][$x][nome]) {
                $dados[alunos][$x] = $retorno[res][$x][nome];
                $x++;
            }
            $dados[qtd_alunos]=$retorno[n_reg];
            return $dados;
        }
        else
            {
            echo "<script>alert('A pesquisa não encontrou resultados/gabaritos.');window.location.href='../gabarito.html';</script>";
            exit;
            }
    }

    public function pesquisar($sql) {  // inicio do function PESQUISAR
        if (!$con) {
            $con = conect();
        }
        if ($con) {
            try {
                $rs = $con->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $rs->execute(); //executa a instrução sql
                $retorno[n_reg] = $rs->rowCount();
                $retorno[n_cols] = $rs->columnCount();
                if (($retorno[n_reg])>0) {
                    $retorno[res]=$rs->fetchAll(PDO::FETCH_ASSOC);
                }
                else {
                    $retorno[msg] .= "Registro(s) não encontrado(s).";
                }
            }
            catch (Exception $e) {
                $retorno[msg] .= "\nErro: Código: " . $e->getCode() . "Mensagem " . $e->getMessage();
            }
        }
        return $retorno;
    }
}
// Dados =>dAdos => daDos => dadOs =>dadoS => DADOS => Dados =>dAdos => daDos => dadOs =>dadoS
class ClasseGera_PDF {

    public function geraPdf($dados) {
        $pdf = new FPDF('L','mm','A4');
        $pdf->SetAutoPageBreak(true);
        $dados[pdf]=$pdf;
        // -> -> -> ->   CONTEÚDO
        $dados = $this->Conteudo($dados);
        $pdf = $dados[pdf];
        // -> -> -> ->   SAÍDA / IMPRIMIR
        $pdf->Output("serie_2009.pdf", 'I');
    }

    // =>>>   =>>>  =>>>   =>>>  =>>>   =>>>  CABEÇALHO
    function Header($dados) {

        $pdf=$dados[pdf];

        $titulo1 = utf8_decode("Secretaria de Educação\n");
        $titulo2 = utf8_decode("Provinha Brasil ".$dados[ano]);
        $titulo3 = utf8_decode("FICHA DE CORREÇÃO");

        // ################################ IN�CIO DA P�GINA ################################
        $pdf->AliasNbPages();
        $pdf->AddPage();

        // LOGOTIPO
        $pdf->Image('../images/educacao_retangulo.jpg', $m = 12, $a = 4, $l_img = 30, $a_img = 15, jpg);
        $pdf->SetFillColor(232, 232, 232);

        //TITULO
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetXY($m += $l_img+8, $a); // posicao x do titulo

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->MultiCell(200, 5, $titulo1, 0, 'C', 0);
        $pdf->SetXY($m, $a += 5); // posicao x do titulo
        $pdf->MultiCell(200, 5, $titulo2, 0, 'C', 0);
        $pdf->SetXY($m, $a += 5); // posicao x do titulo
        $pdf->MultiCell(200, 5, $titulo3, 0, 'C', 0);

        //||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||

        $pdf->SetXY($m = 8, $a += 8); // posicao x do titulo
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->MultiCell($lc = 18, 5, 'ESCOLA: ', 0, 'L', 0);
        $pdf->SetXY($m += $lc, $a); // posicao x do titulo
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell($lc = 140, 5, utf8_decode($dados[txtEscola]), 0, 'L', 0);
//¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetXY($m = 8, $a += 5); // posicao x do titulo
        $pdf->MultiCell($lc = 15, 5, utf8_decode('SÉRIE: '), 0, 'L', 0);
        $pdf->SetXY($m += $lc, $a); // posicao x do titulo
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell($lc = 25, 5, utf8_decode($dados[txtSerie]), 0, 'L', 0);
//¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetXY($m += $lc, $a);
        $pdf->MultiCell($lc = 16, 5, 'TURMA: ', 0, 'L', 0);
        $pdf->SetXY($m += $lc, $a);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell($lc = 8, 5, utf8_decode($dados[txtTurma]), 0, 'L', 0);
//¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetXY($m += $lc, $a);
        $pdf->MultiCell($lc = 20, 5, utf8_decode('PERÍODO: '), 0, 'L', 0);
        $pdf->SetXY($m += $lc, $a);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell($lc = 28, 5, utf8_decode($dados[txtPeriodo]), 0, 'L', 0);
//¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetXY($m += $lc, $a);
        $pdf->Cell($lc = 10, 5, "Data: ", 0, 0, L, false);
        $pdf->SetXY($m += $lc, $a);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell($lc = 23, 5, "__/__/______", 0, 'L', 0);
//¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetXY($m += $lc, $a); // posicao x do titulo
        $pdf->MultiCell($lc = 32, 5, 'PROFESSOR(A): ', 0, 'L', 0);
        $pdf->SetXY($m += $lc, $a);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell($lc = 50, 5, '.......................................................', 0, 'L', 0);
//¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetXY($m += $lc, $a); // posicao x do titulo
        $pdf->MultiCell($lc = 35, 5, utf8_decode('MÉDIA DA TURMA: '), 0, 'L', 0);
        $pdf->SetXY($m += $lc, $a);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell($lc = 20, 5, '..........', 0, 'L', 0);

        // $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$

        $a = 35;
        //********************************************************************************************************
        // POSIÇÃO X DAS COLUNAS
        $m_col1=8;
        $m_col2=$m_col1+8;
        $m_col3=$m_col2+83;
        $m_col4=$m_col3+80;

        $pdf->SetXY($m_col1, $a); // posicao x do titulo
        $pdf->SetFont('Arial', 'B', 6);
        $pdf->MultiCell($lc_a=8, $ac = 15, utf8_decode('Nº'), 1, 'C', 1);
//¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨
        $pdf->SetXY($m_col2, $a); // posicao x do titulo
        $pdf->MultiCell($lc_a += 80, $ac, 'Nome', 1, 'C', 1);
//¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨
        $pdf->SetXY($m_col4+=$lc_a, $a); // posicao x do titulo
        $pdf->MultiCell(15, 5, utf8_decode('Total de Acertos Por Aluno'), 1, 'C', 1);
//¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨
        $pdf->SetXY($m_col3,$a); // posicao x do titulo
        $pdf->MultiCell($lc_a += 80, $ac = 5, utf8_decode('Questões e Gabaritos - Teste'), 1, 'C', 1);
//¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨
        $a+=5;
        $pdf->SetXY($m_col3, $a);
        $m = $m_col3;
        for($x=1; $x<=24; $x++) {
            $pdf->SetXY($m, $a); // posicao x do titulo
            $pdf->MultiCell($c=7, 5, $x, 1, 'C', 1);
            $m+=$c;
        }

        $pdf->SetXY($m_col3, $a+=5); // posicao x do titulo
        $m = $m_col3;
        
        foreach ($dados[gabarito] as $letra) {
            $pdf->SetXY($m, $a);
            $pdf->MultiCell($c=7, 5, '('.$letra.')', 1, 'C', 1);
            $m+=$c;
        }
// $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
        $dados[pdf] = $pdf;
//¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨
        $this->Footer($dados);
        return $dados;
    }

    // =>>>   =>>>  =>>>   =>>>  =>>>   =>>>  RODAPÉ
    public function Footer($dados) {
        $pdf = $dados[pdf];
        $pdf->SetY(-15);
        $pdf->SetFont('Arial','I',10);
        $pdf->Cell(0,10,utf8_decode('Página ').$pdf->PageNo()." de {nb}",0,0,'C');
    }

    public function Conteudo($dados) {
        // -> -> -> ->   CABEÇALHO
        $dados = $this->Header($dados);
        $pdf = $dados[pdf];
        //********************************************************************************************************
        $pdf->SetXY($m_col=8,$a = 45);
        $key=0;
        while ($dados[alunos][$key]) {
            $aluno = $dados[alunos][$key];
            //*********************************** COLUNA 1
            $pdf->SetXY($m_col=8, $a+=5);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell($lc_a = 8, $ac=5, $key+1, 1, 'C', 0);
            //*********************************** COLUNA 2
            $pdf->SetXY($m_col+=8, $a);
            $pdf->MultiCell($lc_a += 75, $ac, utf8_decode($aluno), 1, 'L', 0);
            $pdf->SetXY($m = $m_col+=83, $a);
            $pdf->SetFont('Arial', '', 14);
            //*********************************** COLUNA 3 (quadrinhos)
            for($x=0; $x<24; $x++) {
                $pdf->SetXY($m, $a);
                $pdf->MultiCell(7, $ac, 'O', 1, 'C', 0);
                $m+=7;
            }
            //*********************************** COLUNA 4
            $pdf->SetXY($m_col+=168 , $a);
            $pdf->MultiCell(15, $ac, '', 1, 'C', 0);
            //*********************************** SALTAR PÁGINA???
            if ((($key%27)==0)&&($key>0)) {
                $dados[pdf]=$pdf;
                $dados = $this->Header($dados);
                $pdf->SetXY(10, $a = 45);
                $pdf=$dados[pdf];
            }
            $key++;
        }
        //*********************************** RETORNA P/ IMPRIMIR
        return $dados;
    }
}
?>
