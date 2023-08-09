-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 20-Jun-2023 às 20:34
-- Versão do servidor: 8.0.27
-- versão do PHP: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `dbpets`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_avaliacao`
--

DROP TABLE IF EXISTS `tb_avaliacao`;
CREATE TABLE IF NOT EXISTS `tb_avaliacao` (
  `ID_AVALIACAO` int NOT NULL AUTO_INCREMENT,
  `NOME_AVALIACAO` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `EMAIL_AVALIACAO` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ASSUNTO_AVALIACAO` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `STATUS_AVALIACAO` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ESTRELA_AVALIACAO` int NOT NULL,
  PRIMARY KEY (`ID_AVALIACAO`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_boleto`
--

DROP TABLE IF EXISTS `tb_boleto`;
CREATE TABLE IF NOT EXISTS `tb_boleto` (
  `ID_BOLETO` int NOT NULL AUTO_INCREMENT,
  `ID_PEDIDO_VENDA` int NOT NULL,
  `DATA_BOLETO` date NOT NULL,
  `VALOR_BOLETO` decimal(7,2) NOT NULL,
  `NUMERO_BOLETO` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `STATUS_BOLETO` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID_BOLETO`),
  UNIQUE KEY `NUMERO_BOLETO` (`NUMERO_BOLETO`),
  KEY `FK_TB_BOLETO_TB_PEDIDO_VENDA` (`ID_PEDIDO_VENDA`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `tb_boleto`
--

INSERT INTO `tb_boleto` (`ID_BOLETO`, `ID_PEDIDO_VENDA`, `DATA_BOLETO`, `VALOR_BOLETO`, `NUMERO_BOLETO`, `STATUS_BOLETO`) VALUES
(1, 1, '2023-05-27', '65.00', '74358062445691836687256127110079034099501686', 'pago'),
(2, 2, '2023-05-31', '60.00', '30352485206726827848292922486350954117999017', 'pago'),
(3, 3, '2023-05-31', '0.00', '89102110389068908635197678604992794534901527', 'pago');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_cartao_cliente`
--

DROP TABLE IF EXISTS `tb_cartao_cliente`;
CREATE TABLE IF NOT EXISTS `tb_cartao_cliente` (
  `ID_CARTAO` int NOT NULL AUTO_INCREMENT,
  `ID_CLIENTE` int NOT NULL,
  `NUMERO_CARTAO` char(19) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `NOME_CARTAO` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `VALIDADE_CARTAO` char(7) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CSV_CARTAO` int DEFAULT NULL,
  `BANDEIRA_CARTAO` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID_CARTAO`),
  KEY `FK_TB_CARTAO_CLIENTE_TB_CLIENTE` (`ID_CLIENTE`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_categoria`
--

DROP TABLE IF EXISTS `tb_categoria`;
CREATE TABLE IF NOT EXISTS `tb_categoria` (
  `ID_CATEGORIA` int NOT NULL AUTO_INCREMENT,
  `DESCRICAO_CATEGORIA` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID_CATEGORIA`),
  UNIQUE KEY `DESCRICAO_CATEGORIA` (`DESCRICAO_CATEGORIA`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `tb_categoria`
--

INSERT INTO `tb_categoria` (`ID_CATEGORIA`, `DESCRICAO_CATEGORIA`) VALUES
(1, 'alimentador'),
(2, 'bebida'),
(3, 'coleira');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_cliente`
--

DROP TABLE IF EXISTS `tb_cliente`;
CREATE TABLE IF NOT EXISTS `tb_cliente` (
  `ID_CLIENTE` int NOT NULL AUTO_INCREMENT,
  `NOME_CLIENTE` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `IDADE_CLIENTE` char(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CPF_CLIENTE` char(11) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FONE_CLIENTE` char(11) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FONE_CLIENTE2` char(11) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `EMAIL_CLIENTE` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SENHA_CLIENTE` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `TOKEN_CLIENTE` varchar(220) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID_CLIENTE`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `tb_cliente`
--

INSERT INTO `tb_cliente` (`ID_CLIENTE`, `NOME_CLIENTE`, `IDADE_CLIENTE`, `CPF_CLIENTE`, `FONE_CLIENTE`, `FONE_CLIENTE2`, `EMAIL_CLIENTE`, `SENHA_CLIENTE`, `TOKEN_CLIENTE`) VALUES
(1, 'Bruna Siva', '20', '47283309829', '11981100566', '', 'anaelizayuki@gmail.com', '12345', 'da5d8c84bb588cbf3ec1fa11e9b43949d04a5f7a0d8e48b6f8cd02bba1869a80'),
(2, 'Daniel Junior', '23', '53656682860', '11949417826', '', 'DanielJr@gmail.com', '8520', NULL),
(3, 'Paula Nascimento', '27', '28950350831', '11997370097', '', 'Paula.Nascimento@gmail.com', '987456', NULL),
(4, 'Gabriel Andrade', '34', '53430106877', '12121212121', '', 'Gabriel.Andrade@gmail.com', '9630', NULL),
(5, 'Giovana Mendes', '29', '75327074587', '98989898989', '', 'Giovana.Mendes@gmail.com', '7534', NULL),
(6, 'Natalia Cardoso', '27', '24720592805', '65656565656', '', 'Natalia.Cardoso@gmail.com', '9512', NULL),
(9, 'Teste', '19', '53656682860', '22222222222', '', 'sla@gmail.com', '22222', NULL),
(10, 'TESTEEEEEEEEE', '25', '28950350831', '22222222222', '', 'aaaaa@gmail.com', '$2y$10$CYTr5acDC5pL4LQfz6dQmOkRc7yQURekx0bjhLxIVsRLZPPGwzLNG', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_contratar_cuidador`
--

DROP TABLE IF EXISTS `tb_contratar_cuidador`;
CREATE TABLE IF NOT EXISTS `tb_contratar_cuidador` (
  `ID_CONTRATAR_CUIDADOR` int NOT NULL AUTO_INCREMENT,
  `ID_CLIENTE` int NOT NULL,
  `PERIODO_INICIO_CONTRATAR_CUIDADOR` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `DTA_INICIO_CONTRATAR_CUIDADOR` varchar(11) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PERIODO_FIM_CONTRATAR_CUIDADOR` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `DTA_FIM_CONTRATAR_CUIDADOR` varchar(11) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VALOR_CONTRATAR_CUIDADOR` float NOT NULL,
  `ID_CUIDADOR` int NOT NULL,
  PRIMARY KEY (`ID_CONTRATAR_CUIDADOR`),
  KEY `FK_TB_CONTRATAR_CUIDADOR_TB_CLIENTE` (`ID_CLIENTE`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `tb_contratar_cuidador`
--

INSERT INTO `tb_contratar_cuidador` (`ID_CONTRATAR_CUIDADOR`, `ID_CLIENTE`, `PERIODO_INICIO_CONTRATAR_CUIDADOR`, `DTA_INICIO_CONTRATAR_CUIDADOR`, `PERIODO_FIM_CONTRATAR_CUIDADOR`, `DTA_FIM_CONTRATAR_CUIDADOR`, `VALOR_CONTRATAR_CUIDADOR`, `ID_CUIDADOR`) VALUES
(17, 10, 'tarde', '05/05/0555', 'noite', '05/05/0555', 0, 0),
(18, 10, 'tarde', '05/05/2021', 'tarde', '16/05/6922', 107404000, 0),
(19, 10, 'manha', '20/06/2023', 'manha', '21/06/2023', 48, 0),
(20, 10, 'manha', '25/06/2023', 'manha', '26/06/2023', 60, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_cuidador`
--

DROP TABLE IF EXISTS `tb_cuidador`;
CREATE TABLE IF NOT EXISTS `tb_cuidador` (
  `ID_CUIDADOR` int NOT NULL AUTO_INCREMENT,
  `ID_CLIENTE` int NOT NULL,
  `IMAGEM_CUIDADOR` blob NOT NULL,
  `DESCRICAO_CUIDADOR` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VALOR_CUIDADOR` decimal(6,2) NOT NULL,
  PRIMARY KEY (`ID_CUIDADOR`),
  KEY `FK_TB_CUIDADOR_TB_CLIENTE` (`ID_CLIENTE`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `tb_cuidador`
--

INSERT INTO `tb_cuidador` (`ID_CUIDADOR`, `ID_CLIENTE`, `IMAGEM_CUIDADOR`, `DESCRICAO_CUIDADOR`, `VALOR_CUIDADOR`) VALUES
(1, 1, 0x312e6a7067, 'Meu nome Ã© Bruna, tenho 20 anos e moro com meus pais. Sempre tive pets em casa e amo a alegria que eles trazem para a casa.', '60.00'),
(2, 2, 0x322e6a7067, 'Tenho muita experiÃªncia com pets. Desde pequeno sempre tive pet de estimaÃ§Ã£o e atualmente tenho um Pinscher de 7 anos o Billy e uma gata angorÃ¡, Mia de 8 anos', '50.00'),
(3, 3, 0x31332e6a7067, 'SerÃ¡ um prazer enorme cuidar dos seus pets. Eles terÃ£o potinho cheio, Ã¡gua fresca, areia limpa, brincadeiras e muito carinho (se eles deixarem, claro). E vocÃª vai receber fotos e vÃ­deos para poder matar a saudade e ter bastante tranquilidade enquanto estiver longe.', '55.00'),
(4, 4, 0x31362e6a7067, 'Sou apaixonado pela natureza, e pelos seres vivos. Tenho um shih-tzu de 1 ano, sou cuidadoso e atencioso e preso pelo bem estar, seguranÃ§a e o conforto dos animais. ', '48.00'),
(5, 5, 0x31312e6a7067, ' Sou filha de veterinÃ¡rios e minha paixÃ£o por animais vem de berÃ§o. AlÃ©m de manter seu pet seguro ele vai se divertir muito', '40.00'),
(6, 6, 0x31342e6a7067, 'Sou tranquila, nÃ£o tenho pets ainda, abri meu lar para os pets, para ter um experiÃªncia com eles por nÃ£o ter ainda o meu, posso cuidar do seu enquanto vocÃª se ausentar, para trabalhar, estudar e passear e etc...', '35.00'),
(7, 7, 0x666f74696e686f2e706e67, 'aaedad', '45.00'),
(8, 8, 0x666f726d2e706e67, ',,,,,,,,,,,,', '30.00'),
(9, 9, '', '', '0.00'),
(10, 10, '', '', '0.00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_endereco_cliente`
--

DROP TABLE IF EXISTS `tb_endereco_cliente`;
CREATE TABLE IF NOT EXISTS `tb_endereco_cliente` (
  `ID_ENDERECO_CLIENTE` int NOT NULL AUTO_INCREMENT,
  `ID_CLIENTE` int NOT NULL,
  `RUA_ENDERECO_CLIENTE` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CEP_ENDERECO_CLIENTE` char(9) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `NUM_ENDERECO_CLIENTE` int NOT NULL,
  `BAIRRO_ENDERECO_CLIENTE` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CIDADE_ENDERECO_CLIENTE` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `UF_ENDERECO_CLIENTE` char(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `COMP_ENDERECO_CLIENTE` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID_ENDERECO_CLIENTE`),
  KEY `FK_TB_ENDERECO_CLIENTE_TB_CLIENTE` (`ID_CLIENTE`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `tb_endereco_cliente`
--

INSERT INTO `tb_endereco_cliente` (`ID_ENDERECO_CLIENTE`, `ID_CLIENTE`, `RUA_ENDERECO_CLIENTE`, `CEP_ENDERECO_CLIENTE`, `NUM_ENDERECO_CLIENTE`, `BAIRRO_ENDERECO_CLIENTE`, `CIDADE_ENDERECO_CLIENTE`, `UF_ENDERECO_CLIENTE`, `COMP_ENDERECO_CLIENTE`) VALUES
(1, 1, 'Rua Matheus Capassi', '09791535', 1, 'MontanhÃ£o', 'SÃ£o Bernardo do Campo', 'SP', ''),
(2, 2, 'Rua Matheus Capassi', '09791535', 2, 'MontanhÃ£o', 'SÃ£o Bernardo do Campo', 'SP', ''),
(3, 3, 'Rua Matheus Capassi', '09791535', 3, 'MontanhÃ£o', 'SÃ£o Bernardo do Campo', 'SP', ''),
(4, 4, 'Rua Matheus Capassi', '09791535', 4, 'MontanhÃ£o', 'SÃ£o Bernardo do Campo', 'SP', ''),
(5, 5, 'Rua Matheus Capassi', '09791535', 5, 'MontanhÃ£o', 'SÃ£o Bernardo do Campo', 'SP', ''),
(6, 6, 'Rua Matheus Capassi', '09791535', 6, 'MontanhÃ£o', 'SÃ£o Bernardo do Campo', 'SP', ''),
(7, 7, 'Rua Matheus Capassi', '09791535', 20, 'MontanhÃ£o', 'SÃ£o Bernardo do Campo', 'SP', ''),
(8, 8, 'Rua Matheus Capassi', '09791535', 9, 'MontanhÃ£o', 'SÃ£o Bernardo do Campo', 'SP', ''),
(9, 9, 'Rua João Biancalana', '09683000', 20, 'Paulicéia', 'São Bernardo do Campo', 'SP', ''),
(10, 10, 'Rua João Biancalana', '09683000', 20, 'Paulicéia', 'São Bernardo do Campo', 'SP', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_faleconosco`
--

DROP TABLE IF EXISTS `tb_faleconosco`;
CREATE TABLE IF NOT EXISTS `tb_faleconosco` (
  `ID_CONTATO` int NOT NULL AUTO_INCREMENT,
  `NOME_CONTATO` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `EMAIL_CONTATO` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ASSUNTO_CONTATO` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `STATUS_CONTATO` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID_CONTATO`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `tb_faleconosco`
--

INSERT INTO `tb_faleconosco` (`ID_CONTATO`, `NOME_CONTATO`, `EMAIL_CONTATO`, `ASSUNTO_CONTATO`, `STATUS_CONTATO`) VALUES
(1, 'aaaaaa', 'anaelizayuki@gmail.com', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'respondido');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_fornecedor`
--

DROP TABLE IF EXISTS `tb_fornecedor`;
CREATE TABLE IF NOT EXISTS `tb_fornecedor` (
  `ID_FORNECEDOR` int NOT NULL AUTO_INCREMENT,
  `RAZAO_FORNECEDOR` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `NOME_FANTASIA_FORNECEDOR` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CONTATO_FORNECEDOR` char(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ENDERECO_FORNECEDOR` varchar(120) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `EMAIL_FORNECEDOR` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CNPJ_FORNECEDOR` char(18) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `STATUS_FORNECEDOR` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID_FORNECEDOR`),
  UNIQUE KEY `RAZAO_FORNECEDOR` (`RAZAO_FORNECEDOR`),
  UNIQUE KEY `NOME_FANTASIA_FORNECEDOR` (`NOME_FANTASIA_FORNECEDOR`),
  UNIQUE KEY `CNPJ_FORNECEDOR` (`CNPJ_FORNECEDOR`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `tb_fornecedor`
--

INSERT INTO `tb_fornecedor` (`ID_FORNECEDOR`, `RAZAO_FORNECEDOR`, `NOME_FANTASIA_FORNECEDOR`, `CONTATO_FORNECEDOR`, `ENDERECO_FORNECEDOR`, `EMAIL_FORNECEDOR`, `CNPJ_FORNECEDOR`, `STATUS_FORNECEDOR`) VALUES
(1, 'kskks', 'sdasasd profissional', '11940377651', 'frdf grdfgdffg', 'danimqnoela@gmail.com', '54145141565', 'disponivel');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_frete`
--

DROP TABLE IF EXISTS `tb_frete`;
CREATE TABLE IF NOT EXISTS `tb_frete` (
  `UF` char(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VALOR_FRETE` decimal(5,2) NOT NULL DEFAULT '0.00',
  `EMPRESA_ENTREGA_VENDA` char(35) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `TEMPO_ENTREGA_DIAS` int NOT NULL,
  PRIMARY KEY (`UF`),
  UNIQUE KEY `UF` (`UF`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `tb_frete`
--

INSERT INTO `tb_frete` (`UF`, `VALOR_FRETE`, `EMPRESA_ENTREGA_VENDA`, `TEMPO_ENTREGA_DIAS`) VALUES
('SP', '20.00', 'Zooli transporte', 3),
('RJ', '25.00', 'Zooli transporte', 2),
('ES', '20.00', 'Zooli transporte', 3),
('RO', '50.00', 'Zooli transporte', 4),
('AC', '45.00', 'Zooli transporte', 5),
('BA', '35.00', 'Zooli transporte', 6),
('AM', '60.00', 'Zooli transporte', 7),
('RR', '55.00', 'Zooli transporte', 8),
('PA', '36.00', 'Zooli transporte', 9),
('AP', '40.00', 'Zooli transporte', 10),
('TO', '60.00', 'Zooli transporte', 11),
('MA', '80.00', 'Zooli transporte', 14),
('PI', '30.00', 'Zooli transporte', 15),
('CE', '40.00', 'Zooli transporte', 16),
('RN', '20.00', 'Zooli transporte', 17),
('PB', '21.00', 'Zooli transporte', 18),
('PE', '36.00', 'Zooli transporte', 19),
('AL', '36.00', 'Zooli transporte', 20),
('SE', '30.00', 'Zooli transporte', 21),
('MG', '25.00', 'Zooli transporte', 22),
('PR', '70.00', 'Zooli transporte', 23),
('SC', '75.00', 'Zooli transporte', 24),
('RS', '65.00', 'Zooli transporte', 25),
('MS', '45.00', 'Zooli transporte', 26),
('MT', '30.00', 'Zooli transporte', 27),
('GO', '27.00', 'Zooli transporte', 28),
('DF', '25.00', 'Zooli transporte', 29);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_item_servico`
--

DROP TABLE IF EXISTS `tb_item_servico`;
CREATE TABLE IF NOT EXISTS `tb_item_servico` (
  `ID_ITEM_SERVICO` int NOT NULL AUTO_INCREMENT,
  `ID_CLIENTE` int NOT NULL,
  `ID_PEDIDO_VENDA` int NOT NULL,
  `N_ITEM_SERVICO` int NOT NULL,
  `VALOR_ITEM_SERVICO` decimal(6,2) NOT NULL,
  PRIMARY KEY (`ID_ITEM_SERVICO`),
  KEY `FK_TB_ITEM_SERVICO_TB_CLIENTE` (`ID_CLIENTE`),
  KEY `FK_TB_ITEM_SERVICO_TB_PEDIDO_VENDA` (`ID_PEDIDO_VENDA`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_item_venda`
--

DROP TABLE IF EXISTS `tb_item_venda`;
CREATE TABLE IF NOT EXISTS `tb_item_venda` (
  `ID_ITEM_VENDA` int NOT NULL AUTO_INCREMENT,
  `ID_PEDIDO_VENDA` int NOT NULL,
  `ID_PROD` int NOT NULL,
  `N_ITEM_PRODUTO` int NOT NULL,
  `QTD_ITEM_PRODUTO` int NOT NULL,
  `VALOR_ITEM_PRODUTO` decimal(6,2) NOT NULL,
  PRIMARY KEY (`ID_ITEM_VENDA`),
  KEY `FK_TB_ITEM_VENDA_TB_PEDIDO_VENDA` (`ID_PEDIDO_VENDA`),
  KEY `FK_TB_ITEM_VENDA_TB_PRODUTO` (`ID_PROD`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `tb_item_venda`
--

INSERT INTO `tb_item_venda` (`ID_ITEM_VENDA`, `ID_PEDIDO_VENDA`, `ID_PROD`, `N_ITEM_PRODUTO`, `QTD_ITEM_PRODUTO`, `VALOR_ITEM_PRODUTO`) VALUES
(1, 1, 5, 5, 1, '45.00'),
(2, 2, 5, 5, 1, '45.00'),
(3, 3, 5, 5, 1, '45.00');

--
-- Acionadores `tb_item_venda`
--
DROP TRIGGER IF EXISTS `Tgr_ItensVenda_Insert`;
DELIMITER $$
CREATE TRIGGER `Tgr_ItensVenda_Insert` AFTER INSERT ON `tb_item_venda` FOR EACH ROW BEGIN
    UPDATE tb_prod SET QNT_PROD = QNT_PROD - NEW.QTD_ITEM_PRODUTO
    WHERE ID_PROD = NEW.ID_PROD;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `Tgr_Produtos_Atualizar`;
DELIMITER $$
CREATE TRIGGER `Tgr_Produtos_Atualizar` AFTER INSERT ON `tb_item_venda` FOR EACH ROW BEGIN
    UPDATE tb_prod SET STATUS_PRODUTO = 'Indisponível' WHERE QNT_PROD = 0;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `Tgr_Produtos_Atualizar_B`;
DELIMITER $$
CREATE TRIGGER `Tgr_Produtos_Atualizar_B` AFTER DELETE ON `tb_item_venda` FOR EACH ROW BEGIN
    UPDATE tb_prod SET STATUS_PRODUTO = 'Indisponível' WHERE QNT_PROD = 0;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `Tgr_Produtos_Atualizar_oM`;
DELIMITER $$
CREATE TRIGGER `Tgr_Produtos_Atualizar_oM` AFTER UPDATE ON `tb_item_venda` FOR EACH ROW BEGIN
    UPDATE tb_prod SET STATUS_PRODUTO = 'Indisponível' WHERE QNT_PROD = 0;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `tg_atualiza_quantidade`;
DELIMITER $$
CREATE TRIGGER `tg_atualiza_quantidade` AFTER INSERT ON `tb_item_venda` FOR EACH ROW BEGIN
  UPDATE tb_prod
  SET QNT_PROD = QNT_PROD - NEW.QTD_ITEM_PRODUTO,
      STATUS_PRODUTO = CASE
                         WHEN QNT_PROD - NEW.QTD_ITEM_PRODUTO = 0 THEN 'Indisponível'
                         ELSE 'Disponível'
                       END
  WHERE ID_PROD = NEW.ID_PROD;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_pedido_venda`
--

DROP TABLE IF EXISTS `tb_pedido_venda`;
CREATE TABLE IF NOT EXISTS `tb_pedido_venda` (
  `ID_PEDIDO_VENDA` int NOT NULL AUTO_INCREMENT,
  `ID_CLIENTE` int NOT NULL,
  `DATA_VENDA` datetime NOT NULL,
  `ENDERECO_VENDA` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PGTO_VENDA` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CONDICAO_VENDA` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CUPOM_VENDA` varchar(8) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `DESCONTO_VENDA` decimal(6,2) DEFAULT '0.00',
  `STATUS_VENDA` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VALOR_VENDA` decimal(7,2) NOT NULL,
  `VALOR_FRETE_VENDA` decimal(5,2) DEFAULT NULL,
  `EMPRESA_ENTREGA_VENDA` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID_PEDIDO_VENDA`),
  KEY `FK_TB_PEDIDO_VENDA_TB_CLIENTE` (`ID_CLIENTE`),
  KEY `FK_TB_PEDIDO_VENDA_TB_FRETE` (`EMPRESA_ENTREGA_VENDA`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `tb_pedido_venda`
--

INSERT INTO `tb_pedido_venda` (`ID_PEDIDO_VENDA`, `ID_CLIENTE`, `DATA_VENDA`, `ENDERECO_VENDA`, `PGTO_VENDA`, `CONDICAO_VENDA`, `CUPOM_VENDA`, `DESCONTO_VENDA`, `STATUS_VENDA`, `VALOR_VENDA`, `VALOR_FRETE_VENDA`, `EMPRESA_ENTREGA_VENDA`) VALUES
(2, 1, '2023-05-31 00:25:22', 'Rua Matheus Capassi, 1, MontanhÃ£o, SÃ£o Bernardo do Campo, SP, ', 'boleto', 'Ã  vista', '0', '0.00', 'pago', '60.00', '20.00', 'Zooli transporte'),
(3, 1, '2023-05-31 00:29:37', 'Rua Matheus Capassi, 1, MontanhÃ£o, SÃ£o Bernardo do Campo, SP, ', 'boleto', 'Ã  vista', '0', '0.00', 'pago', '0.00', '0.00', 'Zooli transporte');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_prod`
--

DROP TABLE IF EXISTS `tb_prod`;
CREATE TABLE IF NOT EXISTS `tb_prod` (
  `ID_PROD` int NOT NULL AUTO_INCREMENT,
  `NOME_PROD` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `DESC_PROD` varchar(300) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `QNT_PROD` int NOT NULL,
  `VALOR_PROD` float NOT NULL,
  `TAMANHO_PROD` varchar(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ID_CATEGORIA` int NOT NULL,
  `ID_FORNECEDOR` int NOT NULL,
  `imagem` blob NOT NULL,
  `VALOR_PAGO_PRODUTO` decimal(7,2) NOT NULL,
  `CODIGO_BARRAS_PRODUTO` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `STATUS_PRODUTO` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID_PROD`),
  UNIQUE KEY `NOME_PROD` (`NOME_PROD`),
  UNIQUE KEY `CODIGO_BARRAS_PRODUTO` (`CODIGO_BARRAS_PRODUTO`),
  KEY `FK_TB_PROD_TB_CATEGORIA` (`ID_CATEGORIA`),
  KEY `FK_TB_PROD_TB_FORNECEDOR` (`ID_FORNECEDOR`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `tb_prod`
--

INSERT INTO `tb_prod` (`ID_PROD`, `NOME_PROD`, `DESC_PROD`, `QNT_PROD`, `VALOR_PROD`, `TAMANHO_PROD`, `ID_CATEGORIA`, `ID_FORNECEDOR`, `imagem`, `VALOR_PAGO_PRODUTO`, `CODIGO_BARRAS_PRODUTO`, `STATUS_PRODUTO`) VALUES
(6, 'alimentador', 'Alimentador profissional', 10, 650, 'x', 1, 1, 0x433a77616d7036347777777a6f6f6c695f6f6663696d6770726f647563747072645045542e706e67, '200.00', '54145141', ''),
(7, 'bebedouro branco', 'bebedouro', 10, 350, 'x', 2, 1, 0x433a77616d7036347777777a6f6f6c695f6f6663696d6770726f647563747072645045542e706e67, '100.00', '541451415', ''),
(8, 'coleira ratreadora', 'coleira ratreadora', 10, 200, 'x', 3, 1, 0x433a77616d7036347777777a6f6f6c695f6f6663696d6770726f6475637470726f6475746f322e706e67, '420.00', '541451412', ''),
(9, 'bebedouro preto', 'bebedouro preto', 10, 850, 'x', 2, 1, 0x433a77616d7036347777777a6f6f6c695f6f6663696d6770726f6475637470726f6475746f332e706e67, '360.00', '541451416', '');

--
-- Acionadores `tb_prod`
--
DROP TRIGGER IF EXISTS `Tgr_produto`;
DELIMITER $$
CREATE TRIGGER `Tgr_produto` BEFORE INSERT ON `tb_prod` FOR EACH ROW BEGIN
IF NEW.QNT_PROD >=1 THEN
SET NEW.STATUS_PRODUTO = 'disponivel';
END IF;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `tgr_produto_INDIS`;
DELIMITER $$
CREATE TRIGGER `tgr_produto_INDIS` BEFORE INSERT ON `tb_prod` FOR EACH ROW BEGIN
    IF NEW.QNT_PROD = 0 THEN
        SET NEW.STATUS_PRODUTO = 'Indisponível';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_promocao`
--

DROP TABLE IF EXISTS `tb_promocao`;
CREATE TABLE IF NOT EXISTS `tb_promocao` (
  `ID_PROMOCAO` int NOT NULL AUTO_INCREMENT,
  `ID_USUARIO_ADM` int NOT NULL,
  `ID_CATEGORIA` int NOT NULL,
  `TOKEN_PROMOCAO` varchar(8) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VALIDADE_PROMOCAO` date NOT NULL,
  `VALOR_PROMOCAO` decimal(6,2) NOT NULL,
  `STATUS_PROMOCAO` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID_PROMOCAO`),
  UNIQUE KEY `TOKEN_PROMOCAO` (`TOKEN_PROMOCAO`),
  KEY `FK_TB_PROMOCAO_TB_USUARIO_ADM` (`ID_USUARIO_ADM`),
  KEY `FK_TB_PROMOCAO_TB_CATEGORIA` (`ID_CATEGORIA`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `tb_promocao`
--

INSERT INTO `tb_promocao` (`ID_PROMOCAO`, `ID_USUARIO_ADM`, `ID_CATEGORIA`, `TOKEN_PROMOCAO`, `VALIDADE_PROMOCAO`, `VALOR_PROMOCAO`, `STATUS_PROMOCAO`) VALUES
(1, 1, 1, 'zooli1', '2023-05-19', '100.00', ''),
(2, 1, 2, 'zooli2', '2023-05-19', '60.00', ''),
(3, 1, 3, 'zooli3', '2023-05-19', '25.00', '');

--
-- Acionadores `tb_promocao`
--
DROP TRIGGER IF EXISTS `Tgr_cupom_ativar`;
DELIMITER $$
CREATE TRIGGER `Tgr_cupom_ativar` BEFORE INSERT ON `tb_promocao` FOR EACH ROW BEGIN
IF NEW.VALIDADE_PROMOCAO >= CURDATE() THEN
SET NEW.STATUS_PROMOCAO = 'disponivel';
END IF;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `Tgr_cupom_atualizar`;
DELIMITER $$
CREATE TRIGGER `Tgr_cupom_atualizar` BEFORE UPDATE ON `tb_promocao` FOR EACH ROW BEGIN
IF NEW.VALIDADE_PROMOCAO < CURDATE() THEN
SET NEW.STATUS_PROMOCAO = 'Expirado';
END IF;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `Tgr_cupom_desativar`;
DELIMITER $$
CREATE TRIGGER `Tgr_cupom_desativar` BEFORE INSERT ON `tb_promocao` FOR EACH ROW BEGIN
IF NEW.VALIDADE_PROMOCAO < CURDATE() THEN
SET NEW.STATUS_PROMOCAO = 'Expirado';
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_servico`
--

DROP TABLE IF EXISTS `tb_servico`;
CREATE TABLE IF NOT EXISTS `tb_servico` (
  `ID_SERVICO` int NOT NULL AUTO_INCREMENT,
  `ID_ITEM_SERVICO` int NOT NULL,
  `ID_CLIENTE` int NOT NULL,
  `DESCRICAO_SERVICO` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VALOR_COMPRA_SERVICO` decimal(7,2) NOT NULL,
  `STATUS_SERVICO` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID_SERVICO`),
  KEY `FK_SERVICO_ID_ITEM_SERVICO` (`ID_ITEM_SERVICO`),
  KEY `FK_SERVICO_TB_CLIENTE` (`ID_CLIENTE`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_tutor`
--

DROP TABLE IF EXISTS `tb_tutor`;
CREATE TABLE IF NOT EXISTS `tb_tutor` (
  `ID_TUTORPET` int NOT NULL AUTO_INCREMENT,
  `ID_CLIENTE` int NOT NULL,
  `NOME_TUTORPET` varchar(35) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `IMAGEM_TUTORPET` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `IDADE_TUTORPET` varchar(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `RACA_TUTORPET` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PESO_TUTORPET` decimal(10,0) NOT NULL,
  `DESCRICAO_TUTORPET` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID_TUTORPET`),
  KEY `FK_TB_TUTOR_TB_CLIENTE` (`ID_CLIENTE`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `tb_tutor`
--

INSERT INTO `tb_tutor` (`ID_TUTORPET`, `ID_CLIENTE`, `NOME_TUTORPET`, `IMAGEM_TUTORPET`, `IDADE_TUTORPET`, `RACA_TUTORPET`, `PESO_TUTORPET`, `DESCRICAO_TUTORPET`) VALUES
(1, 9, 'Calo', 'fotinho.png', '2', 'calopsita', '20', 'linda'),
(2, 10, 'aaaaa', 'doguinho.jpg', '25', 'dog', '2', 'doguinho lindu');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_usuario_adm`
--

DROP TABLE IF EXISTS `tb_usuario_adm`;
CREATE TABLE IF NOT EXISTS `tb_usuario_adm` (
  `ID_USUARIO_ADM` int NOT NULL AUTO_INCREMENT,
  `EMAIL_USUARIO_ADM` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SENHA_USUARIO_ADM` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `STATUS_USUARIO_ADM` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID_USUARIO_ADM`),
  UNIQUE KEY `EMAIL_USUARIO_ADM` (`EMAIL_USUARIO_ADM`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `tb_usuario_adm`
--

INSERT INTO `tb_usuario_adm` (`ID_USUARIO_ADM`, `EMAIL_USUARIO_ADM`, `SENHA_USUARIO_ADM`, `STATUS_USUARIO_ADM`) VALUES
(1, 'usuario_adm@gmail.com', '12345', 'ativo');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
