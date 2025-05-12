-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 13/05/2025 às 01:12
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `escola`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `alunos`
--

CREATE TABLE `alunos` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `nome_social` varchar(255) DEFAULT NULL,
  `cpf` varchar(14) NOT NULL,
  `rg` varchar(12) DEFAULT NULL,
  `data_nascimento` date NOT NULL,
  `deficiencia` enum('sim','nao') DEFAULT 'nao',
  `nome_pai` varchar(255) NOT NULL,
  `nome_mae` varchar(255) NOT NULL,
  `responsavel` varchar(255) NOT NULL,
  `rg_responsavel` varchar(12) DEFAULT NULL,
  `tipo_responsavel` varchar(100) NOT NULL,
  `tel_responsavel` varchar(15) NOT NULL,
  `trabalho_responsavel` varchar(255) DEFAULT NULL,
  `tel_trabalho_responsavel` varchar(15) DEFAULT NULL,
  `renda_responsavel` decimal(10,2) DEFAULT NULL,
  `email_responsavel` varchar(255) DEFAULT NULL,
  `email_aluno` varchar(255) DEFAULT NULL,
  `endereco` varchar(255) NOT NULL,
  `bairro` varchar(100) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `uf` char(2) NOT NULL,
  `cep` varchar(8) DEFAULT NULL,
  `complemento` varchar(100) DEFAULT NULL,
  `telefone_fixo` varchar(15) DEFAULT NULL,
  `cel_responsavel` varchar(15) NOT NULL,
  `cor` varchar(50) NOT NULL,
  `ra` varchar(20) NOT NULL,
  `registro_sus` varchar(20) DEFAULT NULL,
  `nis` varchar(20) DEFAULT NULL,
  `tipo_sanguineo` varchar(3) NOT NULL,
  `medicamento` varchar(255) DEFAULT NULL,
  `genero` enum('Masculino','Feminino','Outro') NOT NULL,
  `tem_gemeos` enum('sim','nao') DEFAULT 'nao',
  `quantos_gemeos` int(11) DEFAULT 0,
  `sala` enum('1º Ano Fundamental','2º Ano Fundamental','3º Ano Fundamental','4º Ano Fundamental','5º Ano Fundamental','6º Ano Fundamental','7º Ano Fundamental','8º Ano Fundamental','9º Ano Fundamental','1º Ano Médio','2º Ano Médio','3º Ano Médio') NOT NULL DEFAULT '1º Ano Fundamental',
  `pais` enum('Afeganistão','África do Sul','Albânia','Alemanha','Andorra','Angola','Antígua e Barbuda','Arábia Saudita','Argélia','Argentina','Armênia','Austrália','Áustria','Azerbaijão','Bahamas','Bahrein','Bangladesh','Barbados','Bélgica','Belize','Benin','Bielorrússia','Bolívia','Bósnia e Herzegovina','Botsuana','Brasil','Brunei','Bulgária','Burquina Faso','Burundi','Butão','Cabo Verde','Camarões','Camboja','Canadá','Catar','Cazaquistão','Chade','Chile','China','Chipre','Colômbia','Comores','Congo','Coreia do Norte','Coreia do Sul','Costa do Marfim','Costa Rica','Croácia','Cuba','Dinamarca','Djibuti','Dominica','Egito','El Salvador','Emirados Árabes Unidos','Equador','Eritreia','Eslováquia','Eslovênia','Espanha','Estados Unidos','Estônia','Eswatini','Etiópia','Fiji','Filipinas','Finlândia','França','Gabão','Gâmbia','Gana','Geórgia','Granada','Grécia','Guatemala','Guiana','Guiné','Guiné Equatorial','Guiné-Bissau','Haiti','Holanda','Honduras','Hungria','Iémen','Ilhas Marshall','Ilhas Salomão','Índia','Indonésia','Irã','Iraque','Irlanda','Islândia','Israel','Itália','Jamaica','Japão','Jordânia','Kiribati','Kuwait','Laos','Lesoto','Letônia','Líbano','Libéria','Líbia','Liechtenstein','Lituânia','Luxemburgo','Macedônia do Norte','Madagáscar','Malásia','Malawi','Maldivas','Mali','Malta','Marrocos','Maurício','Mauritânia','México','Mianmar','Micronésia','Moçambique','Moldávia','Mônaco','Mongólia','Montenegro','Namíbia','Nauru','Nepal','Nicarágua','Níger','Nigéria','Noruega','Nova Zelândia','Omã','Palau','Panamá','Papua-Nova Guiné','Paquistão','Paraguai','Peru','Polônia','Portugal','Quênia','Quirguistão','Reino Unido','República Centro-Africana','República Checa','República Democrática do Congo','República Dominicana','Romênia','Ruanda','Rússia','Saara Ocidental','Saint Kitts e Nevis','Saint Vincent e Granadinas','Samoa','San Marino','Santa Lúcia','São Tomé e Príncipe','Senegal','Serra Leoa','Sérvia','Singapura','Síria','Somália','Sri Lanka','Suazilândia','Sudão','Sudão do Sul','Suécia','Suíça','Suriname','Tailândia','Taiwan','Tajiquistão','Tanzânia','Timor-Leste','Togo','Tonga','Trindade e Tobago','Tunísia','Turcomenistão','Turquia','Tuvalu','Ucrânia','Uganda','Uruguai','Uzbequistão','Vanuatu','Vaticano','Venezuela','Vietnã','Zâmbia','Zimbábue') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
