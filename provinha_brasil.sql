-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.0.41-community-nt


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema provinha_brasil
--

CREATE DATABASE IF NOT EXISTS provinhabrasil;
USE provinhabrasil;

--
-- Temporary table structure for view `valunos`
--
DROP TABLE IF EXISTS `valunos`;
DROP VIEW IF EXISTS `valunos`;
CREATE TABLE `valunos` (
  `ID_PJ` double,
  `NOME` varchar(255),
  `ID_CIDADAO` double,
  `DT_NASCIMENTO` varchar(255),
  `SEXO` double,
  `ENDERECO` varchar(255),
  `NUMERO` varchar(255),
  `BAIRRO` varchar(255),
  `CIDADE` varchar(255),
  `ESTADO` varchar(255),
  `CEP` varchar(255),
  `RG` varchar(255),
  `ID_TURMA` double,
  `TURMA` varchar(255),
  `PERIODO` varchar(255),
  `ID_SERIE` double,
  `SERIE` varchar(255),
  `TEL_1` varchar(255),
  `TEL_2` varchar(255),
  `NUMERO_CHAMADA` double,
  `id_periodo_letivo` double
);

--
-- Definition of table `aluno_classe`
--

DROP TABLE IF EXISTS `aluno_classe`;
CREATE TABLE `aluno_classe` (
  `id_alunoclasse` int(10) unsigned NOT NULL auto_increment,
  `id_classe` int(10) unsigned NOT NULL,
  `id_nivel_prova` int(10) unsigned NOT NULL,
  `id_cidadao` int(10) unsigned NOT NULL,
  `cod_fase` int(10) unsigned NOT NULL,
  `ano` int(10) unsigned NOT NULL,
  `justificativa_professor` varchar(1000) default NULL,
  `id_nivel_professor` int(10) unsigned default NULL,
  PRIMARY KEY  (`id_alunoclasse`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `aluno_classe`
--

/*!40000 ALTER TABLE `aluno_classe` DISABLE KEYS */;
/*!40000 ALTER TABLE `aluno_classe` ENABLE KEYS */;


--
-- Definition of table `ativo`
--

DROP TABLE IF EXISTS `ativo`;
CREATE TABLE `ativo` (
  `id_ativo` int(10) unsigned NOT NULL,
  `fase` int(10) unsigned NOT NULL,
  `ano` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id_ativo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ativo`
--

/*!40000 ALTER TABLE `ativo` DISABLE KEYS */;
INSERT INTO `ativo` (`id_ativo`,`fase`,`ano`) VALUES 
 (1,2,2010);
/*!40000 ALTER TABLE `ativo` ENABLE KEYS */;


--
-- Definition of table `classe`
--

DROP TABLE IF EXISTS `classe`;
CREATE TABLE `classe` (
  `id_classe` int(10) unsigned NOT NULL auto_increment,
  `cod_fase` int(10) unsigned NOT NULL,
  `IDTURMA` int(10) unsigned NOT NULL,
  `ano` int(10) unsigned NOT NULL,
  `nome_professor` varchar(150) NOT NULL,
  `mtvo_dificuldade` varchar(150) default NULL,
  `inter_pedagogica1` varchar(300) default NULL,
  `inter_pedagogica2` varchar(300) default NULL,
  `inter_pedagogica3` varchar(300) default NULL,
  `inter_pedagogica4` varchar(300) default NULL,
  `inter_pedagogica5` varchar(300) default NULL,
  `d1_maior_dificuldade` char(1) NOT NULL,
  `d2_maior_dificuldade` char(1) NOT NULL,
  `d3_maior_dificuldade` char(1) NOT NULL,
  `d4_maior_dificuldade` char(1) NOT NULL,
  `d5_maior_dificuldade` char(1) NOT NULL,
  `d6_maior_dificuldade` char(1) NOT NULL,
  `d7_maior_dificuldade` char(1) NOT NULL,
  `d8_maior_dificuldade` char(1) NOT NULL,
  `d9_maior_dificuldade` char(1) NOT NULL,
  `d10_maior_dificuldade` char(1) NOT NULL,
  `d1_opniao_prof` char(1) NOT NULL,
  `desc_opniao_prof_d1` varchar(255) default NULL,
  `d2_opniao_prof` char(1) NOT NULL,
  `desc_opniao_prof_d2` varchar(255) default NULL,
  `d3_opniao_prof` char(1) NOT NULL,
  `desc_opniao_prof_d3` varchar(255) default NULL,
  `d4_opniao_prof` char(1) NOT NULL,
  `desc_opniao_prof_d4` varchar(255) default NULL,
  `d5_opniao_prof` char(1) NOT NULL,
  `desc_opniao_prof_d5` varchar(255) default NULL,
  `d6_opniao_prof` char(1) NOT NULL,
  `desc_opniao_prof_d6` varchar(255) default NULL,
  `d7_opniao_prof` char(1) NOT NULL,
  `desc_opniao_prof_d7` varchar(255) default NULL,
  `d8_opniao_prof` char(1) NOT NULL,
  `desc_opniao_prof_d8` varchar(255) default NULL,
  `d9_opniao_prof` char(1) NOT NULL,
  `desc_opniao_prof_d9` varchar(1255) default NULL,
  `d10_opniao_prof` char(1) NOT NULL,
  `desc_opniao_prof_d10` varchar(255) default NULL,
  `obs_classe` varchar(1000) default NULL,
  `conclusao_proletrado` char(1) NOT NULL,
  `tempo_educador_rede` varchar(80) default NULL,
  `qtd_ano_rede` int(10) unsigned NOT NULL,
  `qtd_mes_rede` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id_classe`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `classe`
--

/*!40000 ALTER TABLE `classe` DISABLE KEYS */;
/*!40000 ALTER TABLE `classe` ENABLE KEYS */;


--
-- Definition of table `escolas`
--

DROP TABLE IF EXISTS `escolas`;
CREATE TABLE `escolas` (
  `ID_PJ` double default NULL,
  `TIPO_ESCOLA` varchar(255) default NULL,
  `NOME` varchar(255) default NULL,
  `CODIGO` varchar(255) default NULL,
  `ENDEREÇO` varchar(255) default NULL,
  `NUMERO` varchar(255) default NULL,
  `BAIRRO` varchar(255) default NULL,
  `CIDADE` varchar(255) default NULL,
  `CEP` varchar(255) default NULL,
  `ESTADO` varchar(255) default NULL,
  `TELEFONE` varchar(10) default NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `escolas`
--

/*!40000 ALTER TABLE `escolas` DISABLE KEYS */;
INSERT INTO `escolas` (`ID_PJ`,`TIPO_ESCOLA`,`NOME`,`CODIGO`,`ENDEREÇO`,`NUMERO`,`BAIRRO`,`CIDADE`,`CEP`,`ESTADO`,`TELEFONE`) VALUES 
 (1,'Propria','Escola Teste','1','Rua Das Flores','123','Jardim','Brasil','07195-888','SP','-1111');
/*!40000 ALTER TABLE `escolas` ENABLE KEYS */;


--
-- Definition of table `fase`
--

DROP TABLE IF EXISTS `fase`;
CREATE TABLE `fase` (
  `cod_fase` int(10) unsigned NOT NULL auto_increment,
  `dsc_fase` varchar(45) NOT NULL,
  PRIMARY KEY  (`cod_fase`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fase`
--

/*!40000 ALTER TABLE `fase` DISABLE KEYS */;
INSERT INTO `fase` (`cod_fase`,`dsc_fase`) VALUES 
 (1,'FASE 1'),
 (2,'FASE 2'),
 (3,'FASE 3');
/*!40000 ALTER TABLE `fase` ENABLE KEYS */;


--
-- Definition of table `gabarito`
--

DROP TABLE IF EXISTS `gabarito`;
CREATE TABLE `gabarito` (
  `Q1` int(10) unsigned NOT NULL,
  `Q2` int(10) unsigned NOT NULL,
  `Q3` int(10) unsigned NOT NULL,
  `Q4` int(10) unsigned NOT NULL,
  `Q5` int(10) unsigned NOT NULL,
  `Q6` int(10) unsigned NOT NULL,
  `Q7` int(10) unsigned NOT NULL,
  `Q8` int(10) unsigned NOT NULL,
  `Q9` int(10) unsigned NOT NULL,
  `Q10` int(10) unsigned NOT NULL,
  `Q11` int(10) unsigned NOT NULL,
  `Q12` int(10) unsigned NOT NULL,
  `Q13` int(10) unsigned NOT NULL,
  `Q14` int(10) unsigned NOT NULL,
  `Q15` int(10) unsigned NOT NULL,
  `Q16` int(10) unsigned NOT NULL,
  `Q17` int(10) unsigned NOT NULL,
  `Q18` int(10) unsigned NOT NULL,
  `Q19` int(10) unsigned NOT NULL,
  `Q20` int(10) unsigned NOT NULL,
  `Q21` int(10) unsigned NOT NULL,
  `Q22` int(10) unsigned NOT NULL,
  `Q23` int(10) unsigned NOT NULL,
  `Q24` int(10) unsigned NOT NULL,
  `id` int(10) unsigned NOT NULL,
  `fase` int(10) unsigned NOT NULL,
  `ano` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gabarito`
--

/*!40000 ALTER TABLE `gabarito` DISABLE KEYS */;
INSERT INTO `gabarito` (`Q1`,`Q2`,`Q3`,`Q4`,`Q5`,`Q6`,`Q7`,`Q8`,`Q9`,`Q10`,`Q11`,`Q12`,`Q13`,`Q14`,`Q15`,`Q16`,`Q17`,`Q18`,`Q19`,`Q20`,`Q21`,`Q22`,`Q23`,`Q24`,`id`,`fase`,`ano`) VALUES 
 (1,3,2,1,4,3,2,2,4,4,3,3,1,2,2,2,4,3,3,2,4,2,2,4,1,1,2008),
 (3,3,2,4,4,2,2,4,2,4,1,3,4,3,4,2,3,3,4,2,1,1,2,3,2,2,2008),
 (2,2,3,1,3,4,3,2,2,4,1,2,2,1,4,2,3,2,4,3,3,4,1,2,3,1,2009),
 (3,3,2,4,3,4,3,4,2,4,3,3,2,3,2,4,1,4,1,4,1,4,2,4,4,2,2009),
 (1,4,4,2,3,3,2,4,4,3,2,1,3,4,4,4,2,2,3,4,2,3,2,3,5,1,2010),
 (3,3,2,3,1,4,4,2,1,2,3,4,3,2,3,1,4,4,3,4,3,1,4,3,6,2,2010);
/*!40000 ALTER TABLE `gabarito` ENABLE KEYS */;


--
-- Definition of table `matriculados`
--

DROP TABLE IF EXISTS `matriculados`;
CREATE TABLE `matriculados` (
  `ID_PJ` double default NULL,
  `NOME` varchar(255) default NULL,
  `ID_CIDADAO` double default NULL,
  `DT_NASCIMENTO` varchar(255) default NULL,
  `SEXO` double default NULL,
  `ENDERECO` varchar(255) default NULL,
  `NUMERO` varchar(255) default NULL,
  `BAIRRO` varchar(255) default NULL,
  `CIDADE` varchar(255) default NULL,
  `ESTADO` varchar(255) default NULL,
  `CEP` varchar(255) default NULL,
  `RG` varchar(255) default NULL,
  `ID_TURMA` double default NULL,
  `TURMA` varchar(255) default NULL,
  `PERIODO` varchar(255) default NULL,
  `ID_SERIE` double default NULL,
  `SERIE` varchar(255) default NULL,
  `TEL_1` varchar(255) default NULL,
  `TEL_2` varchar(255) default NULL,
  `NUMERO_CHAMADA` double default NULL,
  `id_periodo_letivo` double default NULL,
  `FASE` char(1) default NULL,
  `id` int(10) unsigned zerofill NOT NULL auto_increment,
  `ANO` varchar(10) default NULL,
  `IDDEFICIENCIA` int(10) unsigned default NULL,
  `DESC_DEFICIENCIA` varchar(100) default NULL,
  `SIGLA_DEFICIENCIA` varchar(10) default NULL,
  PRIMARY KEY  (`id`),
  KEY `Index_1` (`id_periodo_letivo`,`ID_CIDADAO`),
  KEY `Index_2` USING BTREE (`ID_PJ`,`id_periodo_letivo`,`FASE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `matriculados`
--

/*!40000 ALTER TABLE `matriculados` DISABLE KEYS */;
INSERT INTO `matriculados` (`ID_PJ`,`NOME`,`ID_CIDADAO`,`DT_NASCIMENTO`,`SEXO`,`ENDERECO`,`NUMERO`,`BAIRRO`,`CIDADE`,`ESTADO`,`CEP`,`RG`,`ID_TURMA`,`TURMA`,`PERIODO`,`ID_SERIE`,`SERIE`,`TEL_1`,`TEL_2`,`NUMERO_CHAMADA`,`id_periodo_letivo`,`FASE`,`id`,`ANO`,`IDDEFICIENCIA`,`DESC_DEFICIENCIA`,`SIGLA_DEFICIENCIA`) VALUES 
 (1,'Rafael',1,'06/05/2005',1,'Rua das Flores','22','Jardim','Guarulhos','SP','07195-896','000000',1,'A','MANHA',123,'2º ANO',NULL,NULL,1,19,'2',0000000001,'2010',1,'Baixa Visão','BV');
/*!40000 ALTER TABLE `matriculados` ENABLE KEYS */;


--
-- Definition of table `nivel`
--

DROP TABLE IF EXISTS `nivel`;
CREATE TABLE `nivel` (
  `id_nivel` int(10) unsigned NOT NULL auto_increment,
  `dsc_nivel` varchar(20) NOT NULL,
  `faixa_inicial` int(10) unsigned NOT NULL,
  `faixa_final` int(10) unsigned NOT NULL,
  `ano` int(10) unsigned NOT NULL,
  `cod_fase` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id_nivel`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nivel`
--

/*!40000 ALTER TABLE `nivel` DISABLE KEYS */;
INSERT INTO `nivel` (`id_nivel`,`dsc_nivel`,`faixa_inicial`,`faixa_final`,`ano`,`cod_fase`) VALUES 
 (1,'NÍVEL 1',0,7,2009,2),
 (2,'NÍVEL 2',8,11,2009,2),
 (3,'NÍVEL 3',12,18,2009,2),
 (4,'NÍVEL 4',19,21,2009,2),
 (5,'NÍVEL 5',22,24,2009,2),
 (6,'NÍVEL 1',0,6,2010,1),
 (7,'NÍVEL 2',7,11,2010,1),
 (8,'NÍVEL 3',12,17,2010,1),
 (9,'NÍVEL 4',18,21,2010,1),
 (10,'NÍVEL 5',22,24,2010,1),
 (11,'NÍVEL 1',0,6,2010,2),
 (12,'NÍVEL 2',7,11,2010,2),
 (13,'NÍVEL 3',12,16,2010,2),
 (14,'NÍVEL 4',17,22,2010,2),
 (15,'NÍVEL 5',23,24,2010,2);
/*!40000 ALTER TABLE `nivel` ENABLE KEYS */;


--
-- Definition of table `periodo`
--

DROP TABLE IF EXISTS `periodo`;
CREATE TABLE `periodo` (
  `id_periodo_letivo` int(10) unsigned NOT NULL auto_increment,
  `dsc_periodo` varchar(45) NOT NULL,
  PRIMARY KEY  (`id_periodo_letivo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `periodo`
--

/*!40000 ALTER TABLE `periodo` DISABLE KEYS */;
INSERT INTO `periodo` (`id_periodo_letivo`,`dsc_periodo`) VALUES 
 (19,'2010'),
 (20,'2011');
/*!40000 ALTER TABLE `periodo` ENABLE KEYS */;


--
-- Definition of table `relatorios`
--

DROP TABLE IF EXISTS `relatorios`;
CREATE TABLE `relatorios` (
  `codigo` int(10) unsigned NOT NULL auto_increment,
  `descricao` varchar(45) NOT NULL,
  `arquivo` varchar(45) NOT NULL,
  PRIMARY KEY  (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `relatorios`
--

/*!40000 ALTER TABLE `relatorios` DISABLE KEYS */;
INSERT INTO `relatorios` (`codigo`,`descricao`,`arquivo`) VALUES 
 (2,'Média por Escola','media por escola'),
 (3,'Média por Turma','media por turma'),
 (4,'Média por Aluno','media por aluno');
/*!40000 ALTER TABLE `relatorios` ENABLE KEYS */;


--
-- Definition of table `resultados`
--

DROP TABLE IF EXISTS `resultados`;
CREATE TABLE `resultados` (
  `ID_PJ` int(10) unsigned NOT NULL,
  `ID_Cidadao` int(10) unsigned NOT NULL,
  `Q1` int(10) unsigned NOT NULL,
  `Q2` int(10) unsigned NOT NULL,
  `Q3` int(10) unsigned NOT NULL,
  `Q4` int(10) unsigned NOT NULL,
  `Q5` int(10) unsigned NOT NULL,
  `Q6` int(10) unsigned NOT NULL,
  `Q7` int(10) unsigned NOT NULL,
  `Q8` int(10) unsigned NOT NULL,
  `Q9` int(10) unsigned NOT NULL,
  `Q10` int(10) unsigned NOT NULL,
  `Q11` int(10) unsigned NOT NULL,
  `Q12` int(10) unsigned NOT NULL,
  `Q13` int(10) unsigned NOT NULL,
  `Q14` int(10) unsigned NOT NULL,
  `Q15` int(10) unsigned NOT NULL,
  `Q16` int(10) unsigned NOT NULL,
  `Q17` int(10) unsigned NOT NULL,
  `Q18` int(10) unsigned NOT NULL,
  `Q19` int(10) unsigned NOT NULL,
  `Q20` int(10) unsigned NOT NULL,
  `Q21` int(10) unsigned NOT NULL,
  `Q22` int(10) unsigned NOT NULL,
  `Q23` int(10) unsigned NOT NULL,
  `Q24` int(10) unsigned NOT NULL,
  `Nota` int(10) unsigned NOT NULL,
  `Status` varchar(45) NOT NULL,
  `cod_usuario_inc` int(10) unsigned NOT NULL,
  `cod_usuario_alt` int(10) unsigned default NULL,
  `fase` int(10) unsigned default NULL,
  `ano` int(10) unsigned default NULL,
  `id_periodo_letivo` int(10) unsigned default NULL,
  KEY `Index_1` (`ano`,`fase`,`ID_Cidadao`),
  KEY `Index_2` (`fase`,`ID_Cidadao`),
  KEY `Index_3` (`id_periodo_letivo`,`fase`,`ID_PJ`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `resultados`
--

/*!40000 ALTER TABLE `resultados` DISABLE KEYS */;
/*!40000 ALTER TABLE `resultados` ENABLE KEYS */;


--
-- Definition of table `series2009`
--

DROP TABLE IF EXISTS `series2009`;
CREATE TABLE `series2009` (
  `IDPESSOA_JURIDICA` double default NULL,
  `NOME_PESSOA_JURIDICA` varchar(255) default NULL,
  `IDTURMA` double default NULL,
  `NOME_CLASSE` varchar(255) default NULL,
  `IDSERIE` double default NULL,
  `NOME_SERIE` varchar(255) default NULL,
  `IDPERIODO_DO_DIA` double default NULL,
  `PERIODO` varchar(255) default NULL,
  `FASE` char(1) default NULL,
  `id_periodo_letivo` varchar(45) default NULL,
  `id` int(10) unsigned zerofill NOT NULL auto_increment,
  `ano` varchar(10) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `series2009`
--

/*!40000 ALTER TABLE `series2009` DISABLE KEYS */;
INSERT INTO `series2009` (`IDPESSOA_JURIDICA`,`NOME_PESSOA_JURIDICA`,`IDTURMA`,`NOME_CLASSE`,`IDSERIE`,`NOME_SERIE`,`IDPERIODO_DO_DIA`,`PERIODO`,`FASE`,`id_periodo_letivo`,`id`,`ano`) VALUES 
 (1,'Escola Teste',1,'A',123,'2º ANO',19,'MANHA','2','19',0000000001,'2010');
/*!40000 ALTER TABLE `series2009` ENABLE KEYS */;


--
-- Definition of table `sexo`
--

DROP TABLE IF EXISTS `sexo`;
CREATE TABLE `sexo` (
  `id_sexo` int(10) unsigned NOT NULL auto_increment,
  `dsc_sexo` varchar(45) NOT NULL,
  PRIMARY KEY  (`id_sexo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sexo`
--

/*!40000 ALTER TABLE `sexo` DISABLE KEYS */;
INSERT INTO `sexo` (`id_sexo`,`dsc_sexo`) VALUES 
 (1,'MASCULINO'),
 (2,'FEMININO');
/*!40000 ALTER TABLE `sexo` ENABLE KEYS */;


--
-- Definition of table `status_aluno`
--

DROP TABLE IF EXISTS `status_aluno`;
CREATE TABLE `status_aluno` (
  `cod_status` int(10) unsigned NOT NULL auto_increment,
  `status` varchar(45) NOT NULL,
  PRIMARY KEY  (`cod_status`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `status_aluno`
--

/*!40000 ALTER TABLE `status_aluno` DISABLE KEYS */;
INSERT INTO `status_aluno` (`cod_status`,`status`) VALUES 
 (1,'Não respondeu'),
 (2,'Presente'),
 (3,'Transferido'),
 (4,'Faltou'),
 (5,'Desistente');
/*!40000 ALTER TABLE `status_aluno` ENABLE KEYS */;


--
-- Definition of table `tipo_respostas`
--

DROP TABLE IF EXISTS `tipo_respostas`;
CREATE TABLE `tipo_respostas` (
  `cod_resposta` int(10) unsigned NOT NULL auto_increment,
  `resposta` varchar(45) NOT NULL,
  PRIMARY KEY  (`cod_resposta`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tipo_respostas`
--

/*!40000 ALTER TABLE `tipo_respostas` DISABLE KEYS */;
INSERT INTO `tipo_respostas` (`cod_resposta`,`resposta`) VALUES 
 (0,'BRANCO'),
 (1,'A'),
 (2,'B'),
 (3,'C'),
 (4,'D');
/*!40000 ALTER TABLE `tipo_respostas` ENABLE KEYS */;


--
-- Definition of table `tipo_usuario`
--

DROP TABLE IF EXISTS `tipo_usuario`;
CREATE TABLE `tipo_usuario` (
  `cod_tipo` int(10) unsigned NOT NULL,
  `tipo` varchar(45) NOT NULL,
  PRIMARY KEY  (`cod_tipo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tipo_usuario`
--

/*!40000 ALTER TABLE `tipo_usuario` DISABLE KEYS */;
INSERT INTO `tipo_usuario` (`cod_tipo`,`tipo`) VALUES 
 (1,'Administrador'),
 (2,'Usuário Avançado'),
 (3,'Usuário Intermediario'),
 (4,'Usuário Básico');
/*!40000 ALTER TABLE `tipo_usuario` ENABLE KEYS */;


--
-- Definition of table `usuariosweb`
--

DROP TABLE IF EXISTS `usuariosweb`;
CREATE TABLE `usuariosweb` (
  `IDSERVIDOR_PUBLICO` double default NULL,
  `NOME` varchar(255) default NULL,
  `COD_FUNCIONAL` varchar(255) default NULL,
  `senha` varchar(255) default NULL,
  `UNIDADE_TRABALHO` varchar(255) default NULL,
  `IDESCOLA` double default NULL,
  `PERIODO` varchar(255) default NULL,
  `FUNÇÃO` varchar(255) default NULL,
  `IDFUNÇÃO` double default NULL,
  `OCUPAÇÃO` varchar(255) default NULL,
  `IDOCUPAÇÃO` double default NULL,
  `ID` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usuariosweb`
--

/*!40000 ALTER TABLE `usuariosweb` DISABLE KEYS */;
INSERT INTO `usuariosweb` (`IDSERVIDOR_PUBLICO`,`NOME`,`COD_FUNCIONAL`,`senha`,`UNIDADE_TRABALHO`,`IDESCOLA`,`PERIODO`,`FUNÇÃO`,`IDFUNÇÃO`,`OCUPAÇÃO`,`IDOCUPAÇÃO`,`ID`) VALUES 
 (1,'usuario','usuario','123','Escola Teste',1,'Manha','Assistente',1,'1',1,1);
/*!40000 ALTER TABLE `usuariosweb` ENABLE KEYS */;


--
-- Definition of view `valunos`
--

DROP TABLE IF EXISTS `valunos`;
DROP VIEW IF EXISTS `valunos`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `valunos` AS select `matriculados`.`ID_PJ` AS `ID_PJ`,`matriculados`.`NOME` AS `NOME`,`matriculados`.`ID_CIDADAO` AS `ID_CIDADAO`,`matriculados`.`DT_NASCIMENTO` AS `DT_NASCIMENTO`,`matriculados`.`SEXO` AS `SEXO`,`matriculados`.`ENDERECO` AS `ENDERECO`,`matriculados`.`NUMERO` AS `NUMERO`,`matriculados`.`BAIRRO` AS `BAIRRO`,`matriculados`.`CIDADE` AS `CIDADE`,`matriculados`.`ESTADO` AS `ESTADO`,`matriculados`.`CEP` AS `CEP`,`matriculados`.`RG` AS `RG`,`matriculados`.`ID_TURMA` AS `ID_TURMA`,`matriculados`.`TURMA` AS `TURMA`,`matriculados`.`PERIODO` AS `PERIODO`,`matriculados`.`ID_SERIE` AS `ID_SERIE`,`matriculados`.`SERIE` AS `SERIE`,`matriculados`.`TEL_1` AS `TEL_1`,`matriculados`.`TEL_2` AS `TEL_2`,`matriculados`.`NUMERO_CHAMADA` AS `NUMERO_CHAMADA`,`matriculados`.`id_periodo_letivo` AS `id_periodo_letivo` from `matriculados` where ((`matriculados`.`id_periodo_letivo` = 19) and (`matriculados`.`FASE` = 2));



/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
