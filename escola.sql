-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 10/05/2025 às 00:58
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
  `nacionalidade` varchar(100) DEFAULT NULL,
  `deficiencia` enum('sim','nao') DEFAULT 'nao',
  `nome_pai` varchar(255) DEFAULT NULL,
  `nome_mae` varchar(255) DEFAULT NULL,
  `responsavel` varchar(255) NOT NULL,
  `rg_responsavel` varchar(12) DEFAULT NULL,
  `tipo_responsavel` varchar(100) DEFAULT NULL,
  `tel_responsavel` varchar(15) DEFAULT NULL,
  `trabalho_responsavel` varchar(255) DEFAULT NULL,
  `tel_trabalho_responsavel` varchar(15) DEFAULT NULL,
  `renda_responsavel` decimal(10,2) DEFAULT NULL,
  `email_responsavel` varchar(255) DEFAULT NULL,
  `email_aluno` varchar(255) DEFAULT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `bairro` varchar(100) DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `uf` char(2) DEFAULT NULL,
  `cep` varchar(8) DEFAULT NULL,
  `complemento` varchar(100) DEFAULT NULL,
  `telefone_fixo` varchar(15) DEFAULT NULL,
  `cel_responsavel` varchar(15) DEFAULT NULL,
  `cor` varchar(50) DEFAULT NULL,
  `ra` varchar(20) NOT NULL,
  `registro_sus` varchar(20) DEFAULT NULL,
  `nis` varchar(20) DEFAULT NULL,
  `tipo_sanguineo` varchar(3) DEFAULT NULL,
  `medicamento` varchar(255) DEFAULT NULL,
  `genero` varchar(20) DEFAULT NULL,
  `tem_gemeos` enum('sim','nao') DEFAULT 'nao',
  `quantos_gemeos` int(11) DEFAULT 0,
  `sala` enum('1º Ano Fundamental','2º Ano Fundamental','3º Ano Fundamental','4º Ano Fundamental','5º Ano Fundamental','6º Ano Fundamental','7º Ano Fundamental','8º Ano Fundamental','9º Ano Fundamental','1º Ano Médio','2º Ano Médio','3º Ano Médio') NOT NULL DEFAULT '1º Ano Fundamental'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `alunos`
--

INSERT INTO `alunos` (`id`, `nome`, `nome_social`, `cpf`, `rg`, `data_nascimento`, `nacionalidade`, `deficiencia`, `nome_pai`, `nome_mae`, `responsavel`, `rg_responsavel`, `tipo_responsavel`, `tel_responsavel`, `trabalho_responsavel`, `tel_trabalho_responsavel`, `renda_responsavel`, `email_responsavel`, `email_aluno`, `endereco`, `bairro`, `cidade`, `uf`, `cep`, `complemento`, `telefone_fixo`, `cel_responsavel`, `cor`, `ra`, `registro_sus`, `nis`, `tipo_sanguineo`, `medicamento`, `genero`, `tem_gemeos`, `quantos_gemeos`, `sala`) VALUES
(13, 'Enzo Rafael', '', '444.444.444-44', '44.444.444-4', '2008-01-30', 'Brasileiro', 'nao', 'Roberto Lima', 'Juliana Lima', 'Juliana Lima', '44.444.444-4', 'mae', '(11) 90000-0004', 'Empresa C', '(11) 93333-0004', 4000.00, 'juliana@email.com', 'enzo@email.com', 'Rua da Paz, 303', 'Centro', 'Ribeirão Preto', 'SP', '14000-00', '', '', '(11) 98888-0004', 'Branca', '69004', '', '', 'AB+', '', 'Masculino', 'nao', 0, '1º Ano Fundamental'),
(14, 'Helena Sophia', '', '555.555.555-55', '55.555.555-5', '2012-12-05', 'Brasileira', 'sim', 'Felipe Rocha', 'Camila Rocha', 'Felipe Rocha', '55.555.555-5', 'pai', '(11) 90000-0005', 'Empresa D', '(11) 93333-0005', 2700.00, 'felipe@email.com', 'helena@email.com', 'Rua Verde, 12', 'Jardim Europa', 'São Paulo', 'SP', '01400-00', '', '', '(11) 98888-0005', 'Amarela', '32323', '', '', 'O-', 'asthma', 'Feminino', 'nao', 0, '1º Ano Fundamental'),
(15, 'Miguel Henrique', 'Mig', '666.666.666-66', '66.666.666-6', '2013-09-18', 'Brasileiro', 'nao', 'André Santos', 'Bianca Santos', 'Bianca Santos', '66.666.666-6', 'mae', '(11) 90000-0006', 'Empresa E', '(11) 93333-0006', 2200.00, 'bianca@email.com', 'miguel@email.com', 'Rua Azul, 45', 'Lapa', 'São Paulo', 'SP', '05000-00', '', '', '(11) 98888-0006', 'Parda', '87878', '', '', 'A-', '', 'Masculino', 'sim', 2, '1º Ano Fundamental'),
(16, 'Lara Valentina', '', '777.777.777-77', '77.777.777-7', '2014-02-12', 'Brasileira', 'nao', 'Marcos Farias', 'Luciana Farias', 'Luciana Farias', '77.777.777-7', 'mae', '(11) 90000-0007', 'Empresa F', '(11) 93333-0007', 3100.00, 'luciana@email.com', 'lara@email.com', 'Rua Cinza, 11', 'Ipiranga', 'São Paulo', 'SP', '04200-00', '', '', '(11) 98888-0007', 'Negra', '12121', '', '', 'B+', '', 'Feminino', 'nao', 0, '1º Ano Fundamental'),
(17, 'Pedro Henrique', '', '888.888.888-88', '88.888.888-8', '2011-05-20', 'Brasileiro', 'nao', 'Daniel Costa', 'Renata Costa', 'Daniel Costa', '88.888.888-8', 'pai', '(11) 90000-0008', 'Empresa G', '(11) 93333-0008', 4500.00, 'daniel@email.com', 'pedro@email.com', 'Rua Preta, 77', 'Tatuapé', 'São Paulo', 'SP', '03300-00', '', '', '(11) 98888-0008', 'Branca', '45678', '', '', 'O+', '', 'Masculino', 'nao', 0, '1º Ano Fundamental'),
(18, 'Isabela Fernanda', '', '999.999.999-99', '99.999.999-9', '2010-03-15', 'Brasileira', 'nao', 'Carlos Souza', 'Ana Souza', 'Ana Souza', '99.999.999-9', 'mae', '(11) 90000-0009', 'Empresa H', '(11) 93333-0009', 3700.00, 'ana@email.com', 'isabela@email.com', 'Rua Rosa, 101', 'Liberdade', 'São Paulo', 'SP', '01500-00', '', '', '(11) 98888-0009', 'Parda', '11223', '', '', 'AB-', '', 'Feminino', 'nao', 0, '1º Ano Fundamental'),
(19, 'João Miguel', '', '111.111.111-12', '11.111.111-2', '2009-09-09', 'Brasileiro', 'sim', 'Alfredo Dias', 'Sônia Dias', 'Alfredo Dias', '11.111.111-2', 'pai', '(11) 90000-0010', 'Empresa I', '(11) 93333-0010', 2000.00, 'alfredo@email.com', 'joao@email.com', 'Rua Verde Claro, 99', 'Mooca', 'São Paulo', 'SP', '03100-00', '', '', '(11) 98888-0010', 'Indígena', '66554', '', '', 'A+', 'alergia alimentar', 'Masculino', 'nao', 0, '1º Ano Fundamental'),
(20, 'Sofia Alice', '', '222.222.222-21', '22.222.222-1', '2013-07-25', 'Brasileira', 'nao', 'Bruno Mello', 'Carla Mello', 'Carla Mello', '22.222.222-1', 'mae', '(11) 90000-0011', 'Empresa J', '(11) 93333-0011', 4200.00, 'carla@email.com', 'sofia@email.com', 'Rua Laranja, 12', 'Bela Vista', 'São Paulo', 'SP', '01300-00', '', '', '(11) 98888-0011', 'Branca', '99887', '', '', 'O+', '', 'Feminino', 'nao', 0, '1º Ano Fundamental'),
(21, 'Lucas Gabriel', '', '123.123.123-12', '12.312.312-3', '2011-08-01', 'Brasileiro', 'nao', 'Maurício Gabriel', 'Silvana Gabriel', 'Maurício Gabriel', '12.312.312-3', 'pai', '(11) 90000-0012', 'Empresa K', '(11) 93333-0012', 3500.00, 'mauricio@email.com', 'lucas@email.com', 'Rua Lilás, 33', 'Vila Mariana', 'São Paulo', 'SP', '04000-00', '', '', '(11) 98888-0012', 'Parda', '33445', '', '', 'B+', '', 'Masculino', 'sim', 2, '1º Ano Fundamental'),
(22, 'Alice Vitória', '', '234.234.234-23', '23.423.423-4', '2010-02-11', 'Brasileira', 'sim', 'Eduardo Freitas', 'Rita Freitas', 'Rita Freitas', '23.423.423-4', 'mae', '(11) 90000-0013', 'Empresa L', '(11) 93333-0013', 2800.00, 'rita@email.com', 'alice@email.com', 'Rua Marfim, 21', 'Penha', 'São Paulo', 'SP', '03600-00', '', '', '(11) 98888-0013', 'Branca', '44556', '', '', 'AB-', '', 'Feminino', 'nao', 0, '1º Ano Fundamental'),
(23, 'Davi Lucca', '', '345.345.345-34', '34.534.534-5', '2012-10-19', 'Brasileiro', 'nao', 'Luciano Pires', 'Beatriz Pires', 'Beatriz Pires', '34.534.534-5', 'mae', '(11) 90000-0014', 'Empresa M', '(11) 93333-0014', 3000.00, 'beatriz@email.com', 'davi@email.com', 'Rua Bege, 65', 'Perdizes', 'São Paulo', 'SP', '05000-00', '', '', '(11) 98888-0014', 'Negra', '55667', '', '', 'O+', '', 'Masculino', 'nao', 0, '1º Ano Fundamental'),
(24, 'Manuela Clara', '', '456.456.456-45', '45.645.645-6', '2009-06-05', 'Brasileira', 'nao', 'Otávio Nunes', 'Sueli Nunes', 'Otávio Nunes', '45.645.645-6', 'pai', '(11) 90000-0015', 'Empresa N', '(11) 93333-0015', 3200.00, 'otavio@email.com', 'manuela@email.com', 'Rua Oliva, 88', 'Aclimação', 'São Paulo', 'SP', '04100-00', '', '', '(11) 98888-0015', 'Branca', '66778', '', '', 'A+', '', 'Feminino', 'nao', 0, '1º Ano Fundamental'),
(25, 'Rafael Augusto', '', '567.567.567-56', '56.756.756-7', '2011-01-21', 'Brasileiro', 'nao', 'Adriano Peixoto', 'Glória Peixoto', 'Glória Peixoto', '56.756.756-7', 'mae', '(11) 90000-0016', 'Empresa O', '(11) 93333-0016', 3100.00, 'gloria@email.com', 'rafael@email.com', 'Rua Gelo, 17', 'Santana', 'São Paulo', 'SP', '02400-00', '', '', '(11) 98888-0016', 'Parda', '77889', '', '', 'B-', '', 'Masculino', 'nao', 0, '1º Ano Fundamental'),
(26, 'Valentina Beatriz', '', '678.678.678-67', '67.867.867-8', '2012-04-09', 'Brasileira', 'sim', 'César Rocha', 'Janaina Rocha', 'Janaina Rocha', '67.867.867-8', 'mae', '(11) 90000-0017', 'Empresa P', '(11) 93333-0017', 2700.00, 'janaina@email.com', 'valentina@email.com', 'Rua Marrom, 44', 'Butantã', 'São Paulo', 'SP', '05500-00', '', '', '(11) 98888-0017', 'Branca', '88990', '', '', 'AB+', '', 'Feminino', 'nao', 0, '1º Ano Fundamental'),
(27, 'Henrique Samuel', '', '789.789.789-78', '78.978.978-9', '2010-12-17', 'Brasileiro', 'nao', 'Ricardo Martins', 'Fabiana Martins', 'Fabiana Martins', '78.978.978-9', 'mae', '(11) 90000-0018', 'Empresa Q', '(11) 93333-0018', 3600.00, 'fabiana@email.com', 'henrique@email.com', 'Rua Prata, 70', 'Barra Funda', 'São Paulo', 'SP', '01100-00', '', '', '(11) 98888-0018', 'Negra', '99001', '', '', 'O-', '', 'Masculino', 'sim', 2, '1º Ano Fundamental'),
(28, 'Beatriz Helena', '', '890.890.890-89', '89.089.089-0', '2013-11-27', 'Brasileira', 'nao', 'Flávio Lima', 'Renata Lima', 'Flávio Lima', '89.089.089-0', 'pai', '(11) 90000-0019', 'Empresa R', '(11) 93333-0019', 2900.00, 'flavio@email.com', 'beatriz@email.com', 'Rua Ouro, 10', 'Vila Madalena', 'São Paulo', 'SP', '05400-00', '', '', '(11) 98888-0019', 'Amarela', '10112', '', '', 'A-', '', 'Feminino', 'nao', 0, '1º Ano Fundamental'),
(29, 'Gabriel Lucas', '', '901.901.901-90', '90.190.190-1', '2012-03-23', 'Brasileiro', 'nao', 'Fernando Silva', 'Cristina Silva', 'Cristina Silva', '90.190.190-1', 'mae', '(11) 90000-0020', 'Empresa S', '(11) 93333-0020', 3300.00, 'cristina@email.com', 'gabriel@email.com', 'Rua Bronze, 25', 'Vila Prudente', 'São Paulo', 'SP', '03150-00', '', '', '(11) 98888-0020', 'Branca', '11223', '', '', 'B+', '', 'Masculino', 'nao', 0, '1º Ano Fundamental'),
(30, 'Camila Eduarda', '', '012.012.012-01', '01.201.201-2', '2010-06-30', 'Brasileira', 'sim', 'Jorge Mendes', 'Patrícia Mendes', 'Jorge Mendes', '01.201.201-2', 'pai', '(11) 90000-0021', 'Empresa T', '(11) 93333-0021', 2500.00, 'jorge@email.com', 'camila@email.com', 'Rua Safira, 66', 'Vila Clementino', 'São Paulo', 'SP', '04030-00', '', '', '(11) 98888-0021', 'Indígena', '22334', '', '', 'O+', 'epilepsia', 'Feminino', 'nao', 0, '1º Ano Fundamental'),
(31, 'Thiago Antônio', '', '345.456.567-89', '34.546.567-8', '2011-09-14', 'Brasileiro', 'nao', 'Paulo Moura', 'Elaine Moura', 'Elaine Moura', '34.546.567-8', 'mae', '(11) 90000-0022', 'Empresa U', '(11) 93333-0022', 3800.00, 'elaine@email.com', 'thiago@email.com', 'Rua Topázio, 77', 'Consolação', 'São Paulo', 'SP', '01310-00', '', '', '(11) 98888-0022', 'Branca', '33445', '', '', 'AB-', '', 'Masculino', 'nao', 0, '1º Ano Fundamental'),
(32, 'Luana Cecília', '', '456.567.678-90', '45.656.678-9', '2013-01-01', 'Brasileira', 'nao', 'Igor Teixeira', 'Nádia Teixeira', 'Nádia Teixeira', '45.656.678-9', 'mae', '(11) 90000-0023', 'Empresa V', '(11) 93333-0023', 3400.00, 'nadia@email.com', 'luana@email.com', 'Rua Esmeralda, 100', 'Brooklin', 'São Paulo', 'SP', '04500-00', '', '', '(11) 98888-0023', 'Negra', '55667', '', '', 'A+', '', 'Feminino', 'nao', 0, '1º Ano Fundamental'),
(33, 'Caio Emanuel', '', '567.678.789-01', '56.767.789-0', '2009-10-08', 'Brasileiro', 'sim', 'Leandro Costa', 'Paula Costa', 'Leandro Costa', '56.767.789-0', 'pai', '(11) 90000-0024', 'Empresa W', '(11) 93333-0024', 2600.00, 'leandro@email.com', 'caio@email.com', 'Rua Rubi, 88', 'Luz', 'São Paulo', 'SP', '01120-00', '', '', '(11) 98888-0024', 'Parda', '66778', '', '', 'O-', '', 'Masculino', 'nao', 0, '1º Ano Fundamental'),
(34, 'Mariana Júlia', '', '678.789.890-12', '67.878.890-1', '2012-05-12', 'Brasileira', 'nao', 'Sandro Lima', 'Tatiane Lima', 'Tatiane Lima', '67.878.890-1', 'mae', '(11) 90000-0025', 'Empresa X', '(11) 93333-0025', 2900.00, 'tatiane@email.com', 'mariana@email.com', 'Rua Ametista, 45', 'Casa Verde', 'São Paulo', 'SP', '02500-00', '', '', '(11) 98888-0025', 'Branca', '77889', '', '', 'B+', '', 'Feminino', 'sim', 2, '1º Ano Fundamental');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
