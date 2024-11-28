-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 28/11/2024 às 17:01
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
-- Banco de dados: `fastfood`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `encomendas`
--

CREATE TABLE `encomendas` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `data_nascimento` date NOT NULL,
  `morada` text NOT NULL,
  `produto_id` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `preco_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `encomendas`
--

INSERT INTO `encomendas` (`id`, `nome`, `data_nascimento`, `morada`, `produto_id`, `quantidade`, `preco_total`) VALUES
(1, 'Bruno', '2003-07-21', 'rua das flores 1356', 1, 3, 7.50),
(2, 'diogo', '1995-02-13', 'Porto', 1, 1, 6.50),
(3, 'diogo', '1995-02-13', 'Porto', 4, 2, 6.50),
(4, 'Python', '2002-03-07', 'Lisboa', 1, 1, 17.50),
(5, 'Python', '2002-03-07', 'Lisboa', 3, 3, 17.50),
(6, 'lucas', '1333-03-12', 'Merlim', 2, 8, 32.00),
(7, 'Amo Pizza', '2000-02-21', 'Pizzaria Lisboa', 3, 7, 35.00),
(8, 'Carlos', '2003-12-21', 'Grjí', 2, 1, 4.00),
(9, 'Python', '1999-02-09', 'rua 123', 5, 1, 4.50),
(10, 'edson', '2001-09-21', 'local 123', 6, 1, 3.50),
(27, 'comprotudo', '2003-07-21', 'estrada foz', 11, 1, 46.50),
(28, 'comprotudo', '2003-07-21', 'estrada foz', 12, 1, 46.50);

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `preco` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `quantidade`, `preco`) VALUES
(1, 'Hot-Dog', 8, 2.50),
(2, 'Hamburguer', 6, 4.00),
(3, 'Pizza', 9, 5.00),
(4, 'Refrigerante', 9, 2.00),
(5, 'Kebab', 9, 4.50),
(6, 'Gelado', 7, 3.50),
(7, 'Francesinha', 8, 10.00),
(8, 'Pudim', 10, 3.50),
(9, 'Limonada', 0, 1.00),
(10, 'Bolo', 10, 5.00),
(11, 'Batata-Frita', 10, 2.50),
(12, 'Chocolate', 10, 4.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `utilizadores`
--

CREATE TABLE `utilizadores` (
  `id` int(11) NOT NULL,
  `nome_utilizador` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `utilizadores`
--

INSERT INTO `utilizadores` (`id`, `nome_utilizador`, `senha`) VALUES
(1, 'dono', '123');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `encomendas`
--
ALTER TABLE `encomendas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produto_id` (`produto_id`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `utilizadores`
--
ALTER TABLE `utilizadores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome_utilizador` (`nome_utilizador`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `encomendas`
--
ALTER TABLE `encomendas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `utilizadores`
--
ALTER TABLE `utilizadores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `encomendas`
--
ALTER TABLE `encomendas`
  ADD CONSTRAINT `encomendas_ibfk_1` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
