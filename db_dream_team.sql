-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: 07-Jun-2019 às 14:23
-- Versão do servidor: 5.7.23-23
-- versão do PHP: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dtofic08_db_dream_team`
--
CREATE DATABASE IF NOT EXISTS `db_dream_team` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `db_dream_team`;

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_paga_custom`(in codLiga int(11))
begin
	declare usu1 int(11);
	declare usu2 int(11);
	declare usu3 int(11);
    declare maxPonto decimal(9,2);
    declare base int default 0;
    
	if( (select qt_rodada from tb_liga_customizada where cd_liga_customizada = codLiga) = 0) then
		if( (select qt_usuario from tb_liga_customizada where cd_liga_customizada = codLiga) <= 50 ) then
			set base = (select qt_usuario from tb_liga_customizada where cd_liga_customizada = codLiga) * 3 + (select sum(qt_pontos) from ordem_customizada where cd_liga_customizada = codLiga) * 0.35;
		else 
			set base = (select qt_usuario from tb_liga_customizada where cd_liga_customizada = codLiga) * 2.5 + (select sum(qt_pontos) from ordem_customizada where cd_liga_customizada = codLiga) * 0.30;
		end if;
        begin
			set maxPonto = (select max(qt_pontos) from ordem_customizada where cd_liga_customizada = codLiga);
			set usu1 = (select cd_usuario from ordem_customizada where cd_liga_customizada = codLiga order by qt_pontos DESC LIMIT 1);
			delete from ordem_customizada where cd_usuario = usu1;
			set maxPonto = (select max(qt_pontos) from ordem_customizada where cd_liga_customizada = codLiga);
			set usu2 = (select cd_usuario from ordem_customizada where cd_liga_customizada = codLiga order by qt_pontos DESC LIMIT 1);
			delete from ordem_customizada where cd_usuario = usu2;
			set maxPonto = (select max(qt_pontos) from ordem_customizada where cd_liga_customizada = codLiga);
			set usu3 = (select cd_usuario from ordem_customizada where cd_liga_customizada = codLiga order by qt_pontos DESC LIMIT 1);
			delete from ordem_customizada where cd_usuario = usu3;
			update tb_usuario set qt_dragonitas = qt_dragonitas + base  where cd_usuario = usu1;
			update tb_usuario set qt_dragonitas = qt_dragonitas + base*0.8  where cd_usuario = usu2;
			update tb_usuario set qt_dragonitas = qt_dragonitas + base*0.55  where cd_usuario = usu3;
			delete from ordem_customizada where cd_liga_customizada = codLiga;
			delete from tb_liga_customizada where cd_liga_customizada = codLiga;
        end;
	else 
		select 'Liga ainda não acabou';
     end if;   
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_paga_pat`(in codLiga int(11))
begin
	declare usu1 int(11);
  declare pt1 decimal(9,2);
	declare usu2 int(11);
  declare pt2 decimal(9,2);
	declare usu3 int(11);
  declare pt3 decimal(9,2);
			set usu1 = (select cd_usuario from ordem_patrocinada where cd_liga_patrocinio = codLiga order by qt_pontos DESC LIMIT 1);
      set pt1 = (select qt_pontos * 5 from ordem_patrocinada where cd_usuario = usu1);
			delete from ordem_patrocinada where cd_usuario = usu1;
			set usu2 = (select cd_usuario from ordem_patrocinada where cd_liga_patrocinio = codLiga order by qt_pontos DESC LIMIT 1);
      set pt2 = (select qt_pontos * 4 from ordem_patrocinada where cd_usuario = usu2);
			delete from ordem_patrocinada where cd_usuario = usu2;
			set usu3 = (select cd_usuario from ordem_patrocinada where cd_liga_patrocinio = codLiga order by qt_pontos DESC LIMIT 1);
      set pt3 = (select qt_pontos * 5 from ordem_patrocinada where cd_usuario = usu3);
			delete from ordem_patrocinada where cd_usuario = usu3;
			update tb_usuario set qt_dragonitas = qt_dragonitas + pt1 where cd_usuario = usu1;
			update tb_usuario set qt_dragonitas = qt_dragonitas + pt2 where cd_usuario = usu2;
			update tb_usuario set qt_dragonitas = qt_dragonitas + pt3 where cd_usuario = usu3;
			delete from ordem_patrocinada where cd_liga_patrocinio = codLiga;
end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `backup_acao`
--

CREATE TABLE IF NOT EXISTS `backup_acao` (
  `cd_acao` int(11) DEFAULT NULL,
  `nm_acao` varchar(50) DEFAULT NULL,
  `nm_novo` varchar(30) DEFAULT NULL,
  `nm_velho` varchar(30) DEFAULT NULL,
  `cd_usuario` int(11) DEFAULT NULL,
  `dt_acao` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `backup_acao`
--

DROP TABLE IF EXISTS `backup_acao`;
CREATE TABLE IF NOT EXISTS `backup_acao` (
  `cd_acao` int(11) DEFAULT NULL,
  `nm_acao` varchar(50) DEFAULT NULL,
  `nm_novo` varchar(30) DEFAULT NULL,
  `nm_velho` varchar(30) DEFAULT NULL,
  `cd_usuario` int(11) DEFAULT NULL,
  `dt_acao` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `backup_acao`
--

INSERT INTO `backup_acao` (`cd_acao`, `nm_acao`, `nm_novo`, `nm_velho`, `cd_usuario`, `dt_acao`) VALUES
(1, 'Senha', 'Alli18092001', 'Alisxun0', 5, '2019-05-27 18:37:39'),
(2, 'Apelido', 'nessekrl', 'Jaaj', 2, '2019-06-04 19:41:48');

-- --------------------------------------------------------

--
-- Estrutura da tabela `backup_compras`
--

DROP TABLE IF EXISTS `backup_compras`;
CREATE TABLE IF NOT EXISTS `backup_compras` (
  `cd_compra` int(11) DEFAULT NULL,
  `cd_usuario` int(11) DEFAULT NULL,
  `cd_jogador` int(11) DEFAULT NULL,
  `dt_backup` date DEFAULT NULL,
  `cd_admin` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `backup_jogador`
--

DROP TABLE IF EXISTS `backup_jogador`;
CREATE TABLE IF NOT EXISTS `backup_jogador` (
  `cd_jogador` int(11) NOT NULL,
  `qt_ponto` smallint(3) DEFAULT NULL,
  `qt_rebote` smallint(3) DEFAULT NULL,
  `qt_toco` smallint(3) DEFAULT NULL,
  `qt_bola_recuperada` smallint(3) DEFAULT NULL,
  `qt_assistencia` smallint(3) DEFAULT NULL,
  `qt_arremesso_errado` smallint(3) DEFAULT NULL,
  `qt_turnover` smallint(3) DEFAULT NULL,
  `cd_admin` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `compra`
--

DROP TABLE IF EXISTS `compra`;
CREATE TABLE IF NOT EXISTS `compra` (
  `cd_compra` int(11) NOT NULL,
  `cd_usuario` int(11) DEFAULT NULL,
  `cd_jogador` int(11) DEFAULT NULL,
  PRIMARY KEY (`cd_compra`),
  KEY `fk_compra_usuario` (`cd_usuario`),
  KEY `fk_compra_jogador` (`cd_jogador`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `compra`
--

INSERT INTO `compra` (`cd_compra`, `cd_usuario`, `cd_jogador`) VALUES
(1, 6, 10005),
(2, 6, 10011),
(3, 6, 10016),
(4, 7, 10025),
(5, 1, 10005),
(6, 1, 10002),
(7, 8, 10025),
(8, 2, 10004),
(9, 2, 10011),
(10, 2, 10018);

-- --------------------------------------------------------

--
-- Estrutura da tabela `ordem_customizada`
--

DROP TABLE IF EXISTS `ordem_customizada`;
CREATE TABLE IF NOT EXISTS `ordem_customizada` (
  `cd_usuario` int(11) NOT NULL,
  `cd_liga_customizada` int(11) NOT NULL,
  `qt_pontos` decimal(9,2) NOT NULL DEFAULT '0.00',
  KEY `fk_ordemCustomizada_usuario` (`cd_usuario`),
  KEY `fk_ordemCustomizada_liga` (`cd_liga_customizada`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ordem_icone`
--

DROP TABLE IF EXISTS `ordem_icone`;
CREATE TABLE IF NOT EXISTS `ordem_icone` (
  `cd_compra` int(11) NOT NULL DEFAULT '0',
  `ic_escolhido` tinyint(1) DEFAULT NULL,
  `cd_usuario` int(11) DEFAULT NULL,
  `cd_icone` int(11) DEFAULT NULL,
  PRIMARY KEY (`cd_compra`),
  KEY `fk_ordemIcone_usuario` (`cd_usuario`),
  KEY `fk_ordemIcone_icone` (`cd_icone`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `ordem_icone`
--

INSERT INTO `ordem_icone` (`cd_compra`, `ic_escolhido`, `cd_usuario`, `cd_icone`) VALUES
(1, 1, 1, 6),
(2, 1, 2, 6),
(3, 0, 1, 2),
(4, 0, 2, 1),
(5, 1, 5, 6),
(6, 1, 6, 5),
(7, 1, 7, 6),
(8, 0, 2, 4),
(9, 0, 1, 1),
(10, 0, 8, 5),
(11, 1, 8, 3),
(12, 1, 9, 6);

-- --------------------------------------------------------

--
-- Estrutura da tabela `ordem_patrocinada`
--

DROP TABLE IF EXISTS `ordem_patrocinada`;
CREATE TABLE IF NOT EXISTS `ordem_patrocinada` (
  `cd_liga_patrocinio` int(11) NOT NULL,
  `cd_usuario` int(11) NOT NULL,
  `qt_pontos` decimal(9,2) NOT NULL DEFAULT '0.00',
  KEY `fk_ordemPatrocinada_usario` (`cd_usuario`),
  KEY `fk_ordemPatrocinada_liga` (`cd_liga_patrocinio`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `ordem_patrocinada`
--

INSERT INTO `ordem_patrocinada` (`cd_liga_patrocinio`, `cd_usuario`, `qt_pontos`) VALUES
(2901, 1, '0.00'),
(2901, 2, '0.00'),
(2901, 5, '0.00'),
(2903, 6, '0.00'),
(2901, 7, '0.00'),
(2904, 8, '0.00'),
(2901, 9, '0.00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_acao`
--

DROP TABLE IF EXISTS `tb_acao`;
CREATE TABLE IF NOT EXISTS `tb_acao` (
  `cd_acao` int(11) NOT NULL DEFAULT '0',
  `nm_acao` varchar(50) DEFAULT NULL,
  `nm_novo` varchar(30) DEFAULT NULL,
  `nm_velho` varchar(30) DEFAULT NULL,
  `dt_acao` timestamp NULL DEFAULT NULL,
  `cd_usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`cd_acao`),
  KEY `fk_acao_usuario` (`cd_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_acao`
--

INSERT INTO `tb_acao` (`cd_acao`, `nm_acao`, `nm_novo`, `nm_velho`, `dt_acao`, `cd_usuario`) VALUES
(1, 'Senha', 'Alisxun0', 'Alisxun0', '2019-05-22 19:27:59', 1),
(3, 'Senha', 'bananahit', 'Alisxun0', '2019-05-27 18:35:00', 5),
(4, 'Senha', 'bananaokk', 'Alisxun0', '2019-05-27 18:36:24', 5);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_admin`
--

DROP TABLE IF EXISTS `tb_admin`;
CREATE TABLE IF NOT EXISTS `tb_admin` (
  `cd_admin` int(11) NOT NULL DEFAULT '0',
  `nm_admin` varchar(80) DEFAULT NULL,
  `cd_cpf` char(13) DEFAULT NULL,
  `nm_senha` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`cd_admin`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_admin`
--

INSERT INTO `tb_admin` (`cd_admin`, `nm_admin`, `cd_cpf`, `nm_senha`) VALUES
(1, 'Alison de Oliveira', '49754217807', 'Alisxun0');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_icone`
--

DROP TABLE IF EXISTS `tb_icone`;
CREATE TABLE IF NOT EXISTS `tb_icone` (
  `cd_icone` int(11) NOT NULL DEFAULT '0',
  `nm_icone` varchar(60) DEFAULT NULL,
  `nm_path` varchar(60) DEFAULT NULL,
  `qt_raridade` smallint(1) DEFAULT NULL,
  PRIMARY KEY (`cd_icone`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_icone`
--

INSERT INTO `tb_icone` (`cd_icone`, `nm_icone`, `nm_path`, `qt_raridade`) VALUES
(1, 'Bola estrelada', '/img/icone-usuario/ballstar.png', 2),
(2, 'Lobo Alfa', '/img/icone-usuario/lobo.png', 2),
(3, 'LeÃ£o DanÃ§ante', '/img/icone-usuario/liao.gif', 3),
(4, 'Calango Lango', '/img/icone-usuario/calango-nuvens.png', 4),
(5, 'Bola nas nuvens', '/img/icone-usuario/bola-nuvens.png', 1),
(6, 'Cesta estrelada', '/img/icone-usuario/cesta-nuvens.png', 1),
(7, 'Cesta!', '/img/icone-usuario/cesta-bola-nuvens.png', 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_jogador`
--

DROP TABLE IF EXISTS `tb_jogador`;
CREATE TABLE IF NOT EXISTS `tb_jogador` (
  `cd_jogador` int(11) NOT NULL,
  `nm_jogador` varchar(80) DEFAULT NULL,
  `nm_posicao` varchar(20) DEFAULT NULL,
  `qt_ponto` smallint(3) DEFAULT NULL,
  `qt_rebote` smallint(3) DEFAULT NULL,
  `qt_toco` smallint(3) DEFAULT NULL,
  `qt_bola_recuperada` smallint(3) DEFAULT NULL,
  `qt_assistencia` smallint(3) DEFAULT NULL,
  `qt_arremesso_errado` smallint(3) DEFAULT NULL,
  `qt_turnover` smallint(3) DEFAULT NULL,
  `cd_imagem` varchar(120) DEFAULT NULL,
  `cd_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`cd_jogador`),
  KEY `fk_jogador_time` (`cd_time`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_jogador`
--

INSERT INTO `tb_jogador` (`cd_jogador`, `nm_jogador`, `nm_posicao`, `qt_ponto`, `qt_rebote`, `qt_toco`, `qt_bola_recuperada`, `qt_assistencia`, `qt_arremesso_errado`, `qt_turnover`, `cd_imagem`, `cd_time`) VALUES
(10001, 'Lucas', 'PivÃ´', 1, 1, 1, 1, 1, 1, 1, '/img/foto-jogador/lucas.png', 2002),
(10002, 'Gustavo', 'Ala', 18, 4, 0, 0, 2, 5, 6, '/img/foto-jogador/gustavo.png', 2002),
(10003, 'Feliciano', 'PivÃ´', 16, 5, 1, 1, 4, 2, 5, '/img/foto-jogador/feliciano.png', 2001),
(10004, 'Brite', 'Ala/Armador', 0, 0, 0, 0, 0, 0, 0, '/img/foto-jogador/brite.png', 2001),
(10005, 'CauÃª', 'Ala', 8, 2, 0, 0, 4, 6, 1, '/img/foto-jogador/caue.png', 2003),
(10006, 'Coelho', 'Armador', 19, 8, 0, 3, 8, 2, 1, '/img/foto-jogador/coelho.png', 2003),
(10007, 'Arthur', 'Ala', 0, 0, 0, 0, 0, 0, 0, '/img/foto-jogador/arthur.png', 2004),
(10008, 'Zach Graham', 'Ala/Armador', 21, 3, 3, 2, 6, 3, 0, '/img/foto-jogador/zach.png', 2004),
(10009, 'Shilton', 'PivÃ´', 11, 5, 1, 0, 5, 3, 0, '/img/foto-jogador/shilton.png', 2005),
(10010, 'Gustavinho', 'Armador', 6, 5, 3, 7, 2, 4, 0, '/img/foto-jogador/gustavinho.png', 2005),
(10011, 'Crescenzi', 'Ala/Armador', 12, 0, 2, 4, 4, 3, 2, '/img/foto-jogador/crescenzi.png', 2006),
(10012, 'Mineiro', 'PivÃ´', 8, 4, 2, 6, 5, 1, 3, '/img/foto-jogador/mineiro.png', 2006),
(10013, 'Elinho', 'Armador', 14, 0, 1, 4, 3, 2, 2, '/img/foto-jogador/elinho.png', 2007),
(10014, 'Didi', 'Ala', 22, 5, 7, 3, 4, 3, 6, '/img/foto-jogador/didi.png', 2007),
(10015, 'Collmerio', 'Ala/PivÃ´', 18, 3, 0, 4, 2, 1, 4, '/img/foto-jogador/colimerio.png', 2008),
(10016, 'F. Vezaro', 'Ala/Armador', 9, 4, 2, 4, 3, 0, 2, '/img/foto-jogador/vezaro.png', 2008),
(10017, 'Daniel', 'Ala/PivÃ´', 12, 0, 1, 4, 6, 3, 2, '/img/foto-jogador/daniel.png', 2009),
(10018, 'Augusto', 'Armador', 14, 3, 0, 5, 3, 0, 3, '/img/foto-jogador/augusto.png', 2009),
(10019, 'Deodato', 'Ala', 16, 0, 4, 3, 3, 2, 3, '/img/foto-jogador/deodato.png', 2010),
(10020, 'Batista', 'PivÃ´', 4, 1, 0, 3, 2, 5, 0, '/img/foto-jogador/batista.png', 2010),
(10021, 'Yago', 'Armador', 10, 2, 4, 4, 3, 0, 5, '/img/foto-jogador/yago.png', 2011),
(10022, 'Roquemore', 'Ala/Armador', 20, 4, 0, 5, 6, 3, 2, '/img/foto-jogador/roquemore.png', 2011),
(10023, 'Toledo', 'PivÃ´', 18, 3, 1, 5, 3, 4, 6, '/img/foto-jogador/toledo.png', 2012),
(10024, 'Dawkins', 'Armador', 15, 0, 2, 3, 5, 2, 3, '/img/foto-jogador/dawkins.png', 2012),
(10025, 'Sahdi', 'Ala', 8, 0, 2, 1, 0, 1, 3, '/img/foto-jogador/sahdi.png', 2013),
(10026, 'Panunzio', 'Ala/Armador', 16, 4, 0, 3, 3, 4, 2, '/img/foto-jogador/panunzio.png', 2013),
(10027, 'LucÃ£o', 'PivÃ´', 11, 0, 2, 5, 4, 3, 3, '/img/foto-jogador/lucao.png', 2014),
(10028, 'Armani', 'Armador', 7, 0, 0, 4, 3, 2, 4, '/img/foto-jogador/armani.png', 2014);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_liga_customizada`
--

DROP TABLE IF EXISTS `tb_liga_customizada`;
CREATE TABLE IF NOT EXISTS `tb_liga_customizada` (
  `cd_liga_customizada` int(11) NOT NULL,
  `nm_liga_customizada` varchar(30) DEFAULT NULL,
  `qt_rodada` smallint(3) DEFAULT NULL,
  `qt_usuario` smallint(2) DEFAULT NULL,
  `ic_privacidade` tinyint(1) DEFAULT NULL,
  `cd_liga_key` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`cd_liga_customizada`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_liga_customizada`
--

INSERT INTO `tb_liga_customizada` (`cd_liga_customizada`, `nm_liga_customizada`, `qt_rodada`, `qt_usuario`, `ic_privacidade`, `cd_liga_key`) VALUES
(1, 'Paula Lanches U U AAAAAAAAA', 21, 80, 0, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_liga_patrocinio`
--

DROP TABLE IF EXISTS `tb_liga_patrocinio`;
CREATE TABLE IF NOT EXISTS `tb_liga_patrocinio` (
  `cd_liga_patrocinio` int(11) NOT NULL,
  `nm_liga_patrocinio` varchar(80) DEFAULT NULL,
  `cd_patrocinador` int(11) DEFAULT NULL,
  PRIMARY KEY (`cd_liga_patrocinio`),
  KEY `fk_liga_patrocinador` (`cd_patrocinador`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_liga_patrocinio`
--

INSERT INTO `tb_liga_patrocinio` (`cd_liga_patrocinio`, `nm_liga_patrocinio`, `cd_patrocinador`) VALUES
(2901, 'Nike Be True', 1701),
(2902, 'Liga Caixa', 1702),
(2903, 'Voe com a Infraero', 1703),
(2904, 'Liga Penalty', 1704),
(2905, 'Liga Guarani', 1705);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_partida`
--

DROP TABLE IF EXISTS `tb_partida`;
CREATE TABLE IF NOT EXISTS `tb_partida` (
  `cd_partida` int(11) NOT NULL,
  `dt_partida` date DEFAULT NULL,
  `hr_partida` time DEFAULT NULL,
  `cd_time_casa` int(11) DEFAULT NULL,
  `cd_time_visitante` int(11) DEFAULT NULL,
  `cd_semana` int(11) DEFAULT NULL,
  PRIMARY KEY (`cd_partida`),
  KEY `fk_time_visitante` (`cd_time_visitante`),
  KEY `fk_time_casa` (`cd_time_casa`),
  KEY `fk_partida_semana` (`cd_semana`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_partida`
--

INSERT INTO `tb_partida` (`cd_partida`, `dt_partida`, `hr_partida`, `cd_time_casa`, `cd_time_visitante`, `cd_semana`) VALUES
(16001, '2018-10-13', '13:35:00', 2011, 2010, 1901),
(16002, '2018-10-13', '15:25:00', 2004, 2014, 1901),
(16003, '2018-10-13', '18:00:00', 2012, 2002, 1901),
(16004, '2018-10-13', '18:00:00', 2001, 2006, 1901),
(16005, '2018-10-15', '20:00:00', 2004, 2006, 1901),
(16006, '2018-10-15', '20:00:00', 2003, 2008, 1901),
(16007, '2018-10-15', '20:00:00', 2012, 2013, 1901),
(16008, '2018-10-16', '20:00:00', 2005, 2007, 1901),
(16009, '2018-10-17', '20:00:00', 2013, 2001, 1901),
(16010, '2018-10-17', '20:30:00', 2006, 2008, 1901),
(16011, '2018-10-18', '20:45:00', 2010, 2012, 1901),
(16012, '2018-10-19', '19:00:00', 2014, 2008, 1901),
(16013, '2018-10-19', '21:10:00', 2005, 2011, 1901),
(16014, '2018-10-20', '14:00:00', 2007, 2003, 1901),
(16015, '2018-10-20', '19:00:00', 2010, 2001, 1901),
(16016, '2018-10-22', '19:00:00', 2008, 2012, 1902),
(16017, '2018-10-22', '20:00:00', 2011, 2001, 1902),
(16018, '2018-10-22', '20:00:00', 2013, 2009, 1902),
(16019, '2018-10-23', '19:00:00', 2002, 2014, 1902),
(16020, '2018-10-24', '19:15:00', 2011, 2009, 1902),
(16021, '2018-10-24', '21:00:00', 2005, 2004, 1902),
(16022, '2018-10-25', '19:00:00', 2002, 2003, 1902),
(16023, '2018-10-25', '20:45:00', 2007, 2014, 1902),
(16024, '2018-10-26', '19:15:00', 2012, 2005, 1902),
(16025, '2018-10-26', '21:10:00', 2010, 2004, 1902),
(16026, '2018-10-27', '14:00:00', 2002, 2007, 1902),
(16027, '2018-10-29', '20:00:00', 2009, 2008, 1903),
(16028, '2018-10-30', '20:00:00', 2006, 2010, 1903),
(16029, '2018-10-30', '20:00:00', 2003, 2011, 1903),
(16030, '2018-10-31', '19:00:00', 2009, 2014, 1903),
(16031, '2018-10-31', '20:00:00', 2001, 2007, 1903),
(16032, '2018-10-31', '20:45:00', 2004, 2002, 1903),
(16033, '2018-11-01', '19:00:00', 2008, 2005, 1903),
(16034, '2018-11-01', '20:00:00', 2003, 2010, 1903),
(16035, '2018-11-01', '20:45:00', 2006, 2012, 1903),
(16036, '2018-11-02', '19:15:00', 2004, 2007, 1903),
(16037, '2018-11-02', '20:00:00', 2001, 2002, 1903),
(16038, '2018-11-02', '21:10:00', 2014, 2011, 1903),
(16039, '2018-11-03', '14:00:00', 2006, 2005, 1903),
(16040, '2018-11-03', '17:00:00', 2009, 2012, 1903),
(16041, '2018-11-05', '20:00:00', 2013, 2010, 1904),
(16042, '2018-11-06', '20:00:00', 2002, 2006, 1904),
(16043, '2018-11-06', '20:10:00', 2007, 2009, 1904),
(16044, '2018-11-07', '19:00:00', 2008, 2001, 1904),
(16045, '2018-11-07', '20:00:00', 2012, 2011, 1904),
(16046, '2018-11-08', '20:10:00', 2007, 2013, 1904),
(16047, '2018-11-08', '20:45:00', 2002, 2009, 1904),
(16048, '2018-11-09', '21:10:00', 2003, 2005, 1904),
(16049, '2018-11-10', '14:00:00', 2006, 2014, 1904),
(16050, '2018-11-10', '18:00:00', 2002, 2013, 1904),
(16051, '2018-11-10', '18:00:00', 2012, 2001, 1904),
(16052, '2018-11-12', '20:00:00', 2005, 2001, 1905),
(16053, '2018-11-13', '19:00:00', 2008, 2002, 1905),
(16054, '2018-11-13', '20:00:00', 2010, 2007, 1905),
(16055, '2018-11-14', '20:00:00', 2013, 2006, 1905),
(16056, '2018-11-14', '20:00:00', 2004, 2003, 1905),
(16057, '2018-11-15', '20:00:00', 2010, 2002, 1905),
(16058, '2018-11-16', '19:30:00', 2011, 2006, 1905),
(16059, '2018-11-16', '20:00:00', 2001, 2003, 1905),
(16060, '2018-11-17', '14:00:00', 2014, 2005, 1905),
(16061, '2018-11-19', '19:00:00', 2009, 2005, 1906),
(16062, '2018-11-20', '19:30:00', 2011, 2013, 1906),
(16063, '2018-11-21', '20:00:00', 2012, 2004, 1906),
(16064, '2018-11-22', '20:00:00', 2005, 2013, 1906),
(16065, '2018-11-23', '19:00:00', 2009, 2010, 1906),
(16066, '2018-11-23', '19:00:00', 2008, 2004, 1906),
(16067, '2018-11-24', '14:00:00', 2007, 2011, 1906),
(16068, '2018-11-27', '20:00:00', 2003, 2013, 1907),
(16069, '2018-11-29', '19:00:00', 2014, 2013, 1907),
(16070, '2018-12-01', '14:00:00', 2014, 2003, 1907),
(16071, '2018-12-04', '19:00:00', 2009, 2003, 1908),
(16072, '2018-12-05', '20:00:00', 2001, 2004, 1908),
(16073, '2018-12-06', '20:00:00', 2010, 2008, 1908),
(16074, '2018-12-06', '20:00:00', 2002, 2011, 1908),
(16075, '2018-12-06', '20:00:00', 2012, 2007, 1908),
(16076, '2018-12-07', '20:00:00', 2001, 2014, 1908),
(16077, '2018-12-07', '20:30:00', 2006, 2003, 1908),
(16078, '2018-12-08', '14:00:00', 2010, 2005, 1908),
(16079, '2018-12-08', '18:00:00', 2013, 2008, 1908),
(16080, '2018-12-10', '19:30:00', 2011, 2008, 1909),
(16081, '2018-12-10', '20:00:00', 2004, 2009, 1909),
(16082, '2018-12-11', '19:00:00', 2014, 2012, 1909),
(16083, '2018-12-12', '20:00:00', 2001, 2009, 1909),
(16084, '2018-12-13', '20:00:00', 2013, 2004, 1909),
(16085, '2018-12-13', '20:00:00', 2003, 2012, 1909),
(16086, '2018-12-14', '19:00:00', 2014, 2010, 1909),
(16087, '2018-12-14', '19:00:00', 2008, 2007, 1909),
(16088, '2018-12-15', '14:00:00', 2005, 2002, 1909),
(16089, '2018-12-15', '17:00:00', 2009, 2006, 1909),
(16090, '2018-12-15', '18:00:00', 2011, 2004, 1909),
(16091, '2019-01-05', '14:00:00', 2011, 2005, 1910),
(16092, '2019-01-07', '20:00:00', 2010, 2013, 1910),
(16093, '2019-01-08', '20:00:00', 2005, 2009, 1910),
(16094, '2019-01-09', '19:00:00', 2014, 2002, 1910),
(16095, '2019-01-09', '20:00:00', 2001, 2011, 1910),
(16096, '2019-01-10', '20:00:00', 2012, 2009, 1910),
(16097, '2019-01-11', '20:00:00', 2003, 2002, 1910),
(16098, '2019-01-11', '20:00:00', 2004, 2002, 1910),
(16099, '2019-01-12', '14:00:00', 2005, 2006, 1910),
(16100, '2019-01-12', '18:00:00', 2007, 2001, 1910),
(16101, '2019-01-14', '19:00:00', 2008, 2014, 1911),
(16102, '2019-01-14', '20:00:00', 2002, 2001, 1911),
(16103, '2019-01-14', '20:00:00', 2012, 2006, 1911),
(16104, '2019-01-15', '20:00:00', 2004, 2010, 1911),
(16105, '2019-01-16', '19:00:00', 2009, 2013, 1911),
(16106, '2019-01-16', '20:00:00', 2005, 2012, 1911),
(16107, '2019-01-17', '19:00:00', 2014, 2007, 1911),
(16108, '2019-01-17', '20:00:00', 2001, 2010, 1911),
(16109, '2019-01-18', '20:00:00', 2006, 2013, 1911),
(16110, '2019-01-19', '14:00:00', 2003, 2007, 1911),
(16111, '2019-01-19', '18:00:00', 2008, 2009, 1911),
(16112, '2019-01-21', '20:00:00', 2010, 2009, 1912),
(16113, '2019-01-22', '19:30:00', 2011, 2012, 1912),
(16114, '2019-01-22', '20:00:00', 2003, 2001, 1912),
(16115, '2019-01-23', '20:00:00', 2002, 2004, 1912),
(16116, '2019-01-24', '19:00:00', 2008, 2006, 1912),
(16117, '2019-01-24', '19:00:00', 2014, 2001, 1912),
(16118, '2019-01-25', '20:10:00', 2007, 2004, 1912),
(16119, '2019-01-26', '14:00:00', 2010, 2006, 1912),
(16120, '2019-01-26', '18:00:00', 2011, 2003, 1912),
(16121, '2019-01-28', '20:00:00', 2013, 2003, 1913),
(16122, '2019-01-29', '20:00:00', 2001, 2005, 1913),
(16123, '2019-01-30', '19:00:00', 2009, 2011, 1913),
(16124, '2019-01-31', '20:00:00', 2004, 2005, 1913),
(16125, '2019-02-01', '20:30:00', 2006, 2011, 1913),
(16126, '2019-02-02', '14:00:00', 2007, 2002, 1913),
(16127, '2019-02-04', '19:00:00', 2008, 2010, 1914),
(16128, '2019-02-04', '20:00:00', 2013, 2012, 1914),
(16129, '2019-02-05', '20:00:00', 2003, 2014, 1914),
(16130, '2019-02-05', '20:00:00', 2004, 2001, 1914),
(16131, '2019-02-05', '20:30:00', 2006, 2007, 1914),
(16132, '2019-02-13', '20:00:00', 2010, 2014, 1915),
(16133, '2019-02-13', '20:00:00', 2001, 2013, 1915),
(16134, '2019-02-13', '20:00:00', 2012, 2008, 1915),
(16135, '2019-02-14', '19:00:00', 2009, 2002, 1915),
(16136, '2019-02-15', '20:00:00', 2004, 2013, 1915),
(16137, '2019-02-15', '20:00:00', 2005, 2008, 1915),
(16138, '2019-02-15', '20:00:00', 2010, 2011, 1915),
(16139, '2019-02-16', '14:00:00', 2006, 2003, 1915),
(16140, '2019-02-16', '17:00:00', 2009, 2007, 1915),
(16141, '2019-02-19', '19:00:00', 2008, 2003, 1916),
(16142, '2019-02-23', '14:00:00', 2014, 2009, 1916),
(16143, '2019-02-25', '20:00:00', 2003, 2004, 1917),
(16144, '2019-02-26', '20:00:00', 2013, 2014, 1917),
(16145, '2019-02-26', '20:00:00', 2001, 2008, 1917),
(16146, '2019-02-27', '20:00:00', 2002, 2012, 1917),
(16147, '2019-02-28', '19:30:00', 2011, 2014, 1917),
(16148, '2019-02-28', '20:00:00', 2004, 2008, 1917),
(16149, '2019-02-28', '20:00:00', 2005, 2010, 1917),
(16150, '2019-02-28', '20:00:00', 2012, 2010, 1917),
(16151, '2019-03-01', '20:00:00', 2007, 2012, 1917),
(16152, '2019-03-06', '20:00:00', 2012, 2010, 1918),
(16153, '2019-03-07', '19:00:00', 2014, 2004, 1918),
(16154, '2019-03-07', '20:00:00', 2002, 2005, 1918),
(16155, '2019-03-08', '20:30:00', 2006, 2009, 1918),
(16156, '2019-03-09', '11:00:00', 2003, 2004, 1918),
(16157, '2019-03-09', '14:00:00', 2007, 2006, 1918),
(16158, '2019-03-11', '19:00:00', 2008, 2013, 1919),
(16159, '2019-03-12', '19:30:00', 2011, 2002, 1919),
(16160, '2019-03-14', '20:00:00', 2001, 2012, 1919),
(16161, '2019-03-14', '20:00:00', 2013, 2002, 1919),
(16162, '2019-03-15', '19:00:00', 2008, 2011, 1919),
(16163, '2019-03-15', '20:00:00', 2010, 2003, 1919),
(16164, '2019-03-16', '14:00:00', 2014, 2006, 1919),
(16165, '2019-03-16', '18:00:00', 2013, 2007, 1919),
(16166, '2019-03-16', '20:00:00', 2004, 2012, 1919),
(16167, '2019-03-18', '19:30:00', 2011, 2007, 1920),
(16168, '2019-03-19', '20:00:00', 2013, 2005, 1920),
(16169, '2019-03-24', '11:00:00', 2009, 2001, 1921),
(16170, '2019-03-24', '11:00:00', 2006, 2004, 1921),
(16171, '2019-03-24', '11:00:00', 2005, 2014, 1921),
(16172, '2019-03-24', '11:00:00', 2011, 2003, 1921),
(16173, '2019-03-24', '11:00:00', 2002, 2008, 1921),
(16174, '2019-03-24', '11:00:00', 2007, 2010, 1921),
(16175, '2019-03-26', '20:00:00', 2002, 2010, 1921),
(16176, '2019-03-26', '20:00:00', 2007, 2008, 1921),
(16177, '2019-03-26', '20:00:00', 2005, 2003, 1921),
(16178, '2019-03-26', '20:00:00', 2012, 2014, 1921),
(16179, '2019-03-26', '20:00:00', 2006, 2001, 1921),
(16180, '2019-03-26', '20:00:00', 2009, 2004, 1921),
(16181, '2019-03-26', '20:00:00', 2013, 2011, 1921);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_patrocinador`
--

DROP TABLE IF EXISTS `tb_patrocinador`;
CREATE TABLE IF NOT EXISTS `tb_patrocinador` (
  `cd_patrocinador` int(11) NOT NULL,
  `nm_patrocinador` varchar(100) DEFAULT NULL,
  `nm_nick_patrocinador` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`cd_patrocinador`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_patrocinador`
--

INSERT INTO `tb_patrocinador` (`cd_patrocinador`, `nm_patrocinador`, `nm_nick_patrocinador`) VALUES
(1701, 'Nike, Inc', 'Nike'),
(1702, 'Caixa Econômica Federal', 'Caixa'),
(1703, 'Empresa Brasileirade Infraestrutura Aeroportuária', 'Infraero'),
(1704, 'Penalty', 'Penalty'),
(1705, 'Guarani S.A', 'Guarani Mais que Açúcar');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_pre_cadastro`
--

DROP TABLE IF EXISTS `tb_pre_cadastro`;
CREATE TABLE IF NOT EXISTS `tb_pre_cadastro` (
  `cd_usuario` int(11) NOT NULL,
  `cd_cpf` char(11) DEFAULT NULL,
  `nm_usuario` varchar(80) DEFAULT NULL,
  `cd_email` varchar(80) DEFAULT NULL,
  `dt_nascimento` date DEFAULT NULL,
  `nm_senha` varchar(30) DEFAULT NULL,
  `dt_cadastro` date DEFAULT NULL,
  PRIMARY KEY (`cd_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_pre_cadastro`
--

INSERT INTO `tb_pre_cadastro` (`cd_usuario`, `cd_cpf`, `nm_usuario`, `cd_email`, `dt_nascimento`, `nm_senha`, `dt_cadastro`) VALUES
(2, '49015365830', 'Denis Lima', 'denis.lima1999@gmail.com', '1999-05-10', 'cuzinhocuzinho', '2019-05-28'),
(3, '75843008045', 'Bryan Kevin Dias', 'bryankevin@gmail.com', '1992-03-14', 'picaseca', '2019-06-03'),
(4, '33130539808', 'Isabelly Cunha', 'isabellycunha32716@gmail.com', '1998-11-26', 'Isa88444', '2019-06-03');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_semana`
--

DROP TABLE IF EXISTS `tb_semana`;
CREATE TABLE IF NOT EXISTS `tb_semana` (
  `cd_semana` int(11) NOT NULL,
  `qt_partida` int(11) DEFAULT NULL,
  `dt_inicio` date DEFAULT NULL,
  `dt_fim` date DEFAULT NULL,
  PRIMARY KEY (`cd_semana`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_semana`
--

INSERT INTO `tb_semana` (`cd_semana`, `qt_partida`, `dt_inicio`, `dt_fim`) VALUES
(1901, 15, '2018-10-13', '2018-10-20'),
(1902, 11, '2018-10-22', '2018-10-27'),
(1903, 14, '2018-10-29', '2018-11-03'),
(1904, 11, '2018-11-05', '2018-11-10'),
(1905, 9, '2018-11-12', '2018-11-17'),
(1906, 7, '2018-11-19', '2018-11-24'),
(1907, 3, '2018-11-27', '2018-12-01'),
(1908, 9, '2018-12-04', '2018-12-08'),
(1909, 11, '2018-12-10', '2018-12-15'),
(1910, 10, '2019-01-05', '2019-01-12'),
(1911, 11, '2019-01-14', '2019-01-19'),
(1912, 9, '2019-01-21', '2019-01-26'),
(1913, 6, '2019-01-28', '2019-02-05'),
(1914, 5, '2019-02-04', '2019-02-05'),
(1915, 9, '2019-02-13', '2019-02-23'),
(1916, 2, '2019-02-19', '2019-02-23'),
(1917, 9, '2019-02-25', '2019-03-09'),
(1918, 6, '2019-03-06', '2019-03-09'),
(1919, 9, '2019-03-11', '2019-03-19'),
(1920, 2, '2019-03-18', '2019-03-19'),
(1921, 13, '2019-03-24', '2019-03-26');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_suporte`
--

DROP TABLE IF EXISTS `tb_suporte`;
CREATE TABLE IF NOT EXISTS `tb_suporte` (
  `cd_suporte` int(11) NOT NULL DEFAULT '0',
  `nm_tipo_suporte` varchar(50) DEFAULT NULL,
  `ds_mensagem` varchar(500) DEFAULT NULL,
  `ds_resposta` varchar(500) DEFAULT NULL,
  `cd_usuario` int(11) DEFAULT NULL,
  `cd_admin` int(11) DEFAULT NULL,
  PRIMARY KEY (`cd_suporte`),
  KEY `fk_suporte_usuario` (`cd_usuario`),
  KEY `fk_suporte_admin` (`cd_admin`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_suporte`
--

INSERT INTO `tb_suporte` (`cd_suporte`, `nm_tipo_suporte`, `ds_mensagem`, `ds_resposta`, `cd_usuario`, `cd_admin`) VALUES
(1, 'Dúvida', 'Sim sou eu kkkkkkkkkkkkkkkkkkkkkk meme tlgd aaaaaaaaaaaaaaaaa sim', 'KKKKKKKKKKKKKKKKKKKKK se fudeu maluco otário KKK se fode fodase eh isso maluco eh nois fodase', 2, 1),
(2, 'Bug', 'UM LIXO DE SISTEMA ARRUMA A MASK DO CPF SE DESLOGA NAO PODE ENTRAR DE NOVO DO VAL GORDINHO GAY LIXO OBRIGADO PELA ATENCAO THALES DA PAZ', 'Sua mãe aquela vagabunda gorda filha da puta gorda do kr', 8, 1),
(3, 'Sugestão/opinião', 'MUITA FALTA DE PROFISSIONALISMO DESSA EQUIPE COM CERTEZA FOI AQUELE GORDINHO PANCUDO QUE ME RESPONDEU VOU DENUNCIAR PARA A DANIELA TU ACHA QUE EU NAO VI TUA FOTINHA DE PAU DURO GORDINHO GAY', 'sua ame cuiofiofwerjiofwhiojipwefwefiopwfweiowefioprokpwjkpw', 8, 1),
(4, 'Sugestão/opinião', 'SABE NEM RESPONDE SEU LIXO AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', NULL, 8, NULL),
(5, 'Sugestão/opinião', 'SABE NEM RESPONDE SEU LIXO AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', NULL, 8, NULL),
(6, 'Dúvida', 'meu deus eu amo tanto o renan queria taaaanto um mb em tm pq eu n sei nada rs', 'nossa eu vou te dar um mb pq esse site tá demais vc eh zika', 2, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_time`
--

DROP TABLE IF EXISTS `tb_time`;
CREATE TABLE IF NOT EXISTS `tb_time` (
  `cd_time` int(11) NOT NULL,
  `nm_time` varchar(80) DEFAULT NULL,
  `cd_logo` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`cd_time`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_time`
--

INSERT INTO `tb_time` (`cd_time`, `nm_time`, `cd_logo`) VALUES
(2001, 'Basquete Cearense', '/img/icone-time/cearense.png'),
(2002, 'Bauru', '/img/icone-time/bauru.png'),
(2003, 'Botafogo', '/img/icone-time/botafogo.png'),
(2004, 'BrasÃ­lia', '/img/icone-time/brasilia.png'),
(2005, 'Corinthians', '/img/icone-time/corinthians.png'),
(2006, 'Flamengo', '/img/icone-time/flamengo.png'),
(2007, 'SESI Franca', '/img/icone-time/sesi.png'),
(2008, 'Joinville / AABJ', '/img/icone-time/joinville.png'),
(2009, 'Minas', '/img/icone-time/minas.png'),
(2010, 'Mogi', '/img/icone-time/mogi.png'),
(2011, 'Paulistano', '/img/icone-time/paulistano.png'),
(2012, 'Pinheiros', '/img/icone-time/pinheiros.png'),
(2013, 'SÃ£o JosÃ©', '/img/icone-time/sao-jose.png'),
(2014, 'Vasco da Gama', '/img/icone-time/vasco.png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_usuario`
--

DROP TABLE IF EXISTS `tb_usuario`;
CREATE TABLE IF NOT EXISTS `tb_usuario` (
  `cd_usuario` int(11) NOT NULL,
  `cd_cpf` char(11) DEFAULT NULL,
  `nm_usuario` varchar(80) DEFAULT NULL,
  `cd_email` varchar(80) DEFAULT NULL,
  `dt_nascimento` date DEFAULT NULL,
  `qt_dragonitas` int(9) NOT NULL DEFAULT '0',
  `nm_senha` varchar(30) DEFAULT NULL,
  `nm_apelido` varchar(8) DEFAULT NULL,
  PRIMARY KEY (`cd_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_usuario`
--

INSERT INTO `tb_usuario` (`cd_usuario`, `cd_cpf`, `nm_usuario`, `cd_email`, `dt_nascimento`, `qt_dragonitas`, `nm_senha`, `nm_apelido`) VALUES
(1, '49754217807', 'Alison de Oliveira', 'a.docalves@gmail.com', '2001-09-18', 0, 'Alli18092001', 'Zaslavsk'),
(2, '44640590822', 'João Gorgonio', 'joao-gorgonio16@outlook.com', '2002-04-03', 99990259, 'mechupa1', 'nessekrl'),
(3, '12345678910', 'Luiz Enrique', 'danteviado@gmail.com', '2002-05-04', 1000, 'sifodasi1', 'China'),
(4, '12345678910', 'Gabriel Ferreira do Val', 'gabrielfdoval1@gmail.com', '2002-03-28', 1000, 'dovalviado', 'gueizao'),
(5, '50679441026', 'alison de oliveira', 'th3.end405@gmail.com', '2001-09-18', 1000, 'Alli18092001', 'Alisxun'),
(6, '46922936833', 'Rian Renatinho', 'kraselsparda@gmail.com', '2002-06-05', 830, 'naruto123', 'Travetao'),
(7, '42995286894', 'Allanis Cruz', 'allanafdc@gmail.com', '2001-10-16', 930, '110818lu', 'Allanis'),
(8, '28199667648', 'Manoel Thales da Paz', 'nsl28933@cndps.com', '2001-12-16', 30, 'rs123321', 'paz'),
(9, '46561621832', 'Samuel Modesto Nunes', 'nunesmsamuel@gmail.com', '2001-04-12', 1000, 'marrentinho2010', 'sam');

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `fk_compra_jogador` FOREIGN KEY (`cd_jogador`) REFERENCES `tb_jogador` (`cd_jogador`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_compra_usuario` FOREIGN KEY (`cd_usuario`) REFERENCES `tb_usuario` (`cd_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `ordem_customizada`
--
ALTER TABLE `ordem_customizada`
  ADD CONSTRAINT `fk_ordemCustomizada_liga` FOREIGN KEY (`cd_liga_customizada`) REFERENCES `tb_liga_customizada` (`cd_liga_customizada`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ordemCustomizada_usuario` FOREIGN KEY (`cd_usuario`) REFERENCES `tb_usuario` (`cd_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `ordem_icone`
--
ALTER TABLE `ordem_icone`
  ADD CONSTRAINT `fk_ordemIcone_icone` FOREIGN KEY (`cd_icone`) REFERENCES `tb_icone` (`cd_icone`),
  ADD CONSTRAINT `fk_ordemIcone_usuario` FOREIGN KEY (`cd_usuario`) REFERENCES `tb_usuario` (`cd_usuario`);

--
-- Limitadores para a tabela `ordem_patrocinada`
--
ALTER TABLE `ordem_patrocinada`
  ADD CONSTRAINT `fk_ordemPatrocinada_liga` FOREIGN KEY (`cd_liga_patrocinio`) REFERENCES `tb_liga_patrocinio` (`cd_liga_patrocinio`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ordemPatrocinada_usario` FOREIGN KEY (`cd_usuario`) REFERENCES `tb_usuario` (`cd_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_acao`
--
ALTER TABLE `tb_acao`
  ADD CONSTRAINT `fk_acao_usuario` FOREIGN KEY (`cd_usuario`) REFERENCES `tb_usuario` (`cd_usuario`);

--
-- Limitadores para a tabela `tb_jogador`
--
ALTER TABLE `tb_jogador`
  ADD CONSTRAINT `fk_jogador_time` FOREIGN KEY (`cd_time`) REFERENCES `tb_time` (`cd_time`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_liga_patrocinio`
--
ALTER TABLE `tb_liga_patrocinio`
  ADD CONSTRAINT `fk_liga_patrocinador` FOREIGN KEY (`cd_patrocinador`) REFERENCES `tb_patrocinador` (`cd_patrocinador`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_partida`
--
ALTER TABLE `tb_partida`
  ADD CONSTRAINT `fk_partida_semana` FOREIGN KEY (`cd_semana`) REFERENCES `tb_semana` (`cd_semana`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_time_casa` FOREIGN KEY (`cd_time_casa`) REFERENCES `tb_time` (`cd_time`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_time_visitante` FOREIGN KEY (`cd_time_visitante`) REFERENCES `tb_time` (`cd_time`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_suporte`
--
ALTER TABLE `tb_suporte`
  ADD CONSTRAINT `fk_suporte_admin` FOREIGN KEY (`cd_admin`) REFERENCES `tb_admin` (`cd_admin`),
  ADD CONSTRAINT `fk_suporte_usuario` FOREIGN KEY (`cd_usuario`) REFERENCES `tb_usuario` (`cd_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
