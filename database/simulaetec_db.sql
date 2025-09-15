-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 23/07/2025 às 22:51
-- Versão do servidor: 8.0.42-0ubuntu0.24.04.2
-- Versão do PHP: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `simulaetec_db`
/*elaborado por Hylari e Maicon e adaptado e incrementado para o sitema por jeferson*/
--
CREATE DATABASE simulaetec_db;
USE simulaetec_db;

CREATE TABLE Usuario (
  id_usuario INT PRIMARY KEY AUTO_INCREMENT,
  nome VARCHAR(100),
  email VARCHAR(100) UNIQUE,
  senha VARCHAR(100),
  data_nascimento DATE
);

CREATE TABLE Simulado (
  id_simulado INT PRIMARY KEY AUTO_INCREMENT,
  titulo VARCHAR(100),
  descricao TEXT,
  data_criacao DATE,
  criado_por INT,
  FOREIGN KEY (criado_por) REFERENCES Usuario(id_usuario)
);

CREATE TABLE Questao (
  id_questao INT PRIMARY KEY AUTO_INCREMENT,
  enunciado TEXT,
  tipo VARCHAR(50),
  nivel_dificuldade VARCHAR(50),
  id_simulado INT,
  FOREIGN KEY (id_simulado) REFERENCES Simulado(id_simulado)
);

CREATE TABLE Alternativa (
  id_alternativa INT PRIMARY KEY AUTO_INCREMENT,
  texto TEXT,
  correta BOOLEAN,
  id_questao INT,
  FOREIGN KEY (id_questao) REFERENCES Questao(id_questao)
);

CREATE TABLE Resposta (
  id_resposta INT PRIMARY KEY AUTO_INCREMENT,
  id_usuario INT,
  id_questao INT,
  id_alternativa INT,
  resposta_texto TEXT,
  correta BOOLEAN,
  FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario),
  FOREIGN KEY (id_questao) REFERENCES Questao(id_questao),
  FOREIGN KEY (id_alternativa) REFERENCES Alternativa(id_alternativa)
);

CREATE TABLE Resultado (
  id_resultado INT PRIMARY KEY AUTO_INCREMENT,
  id_usuario INT,
  id_simulado INT,
  nota_total DECIMAL(5,2),
  data_realizacao DATE,
  FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario),
  FOREIGN KEY (id_simulado) REFERENCES Simulado(id_simulado)
);
-- --------------------------------------------------------

--
-- Estrutura para tabela `desempenho_provas`
--

CREATE TABLE `desempenho_provas` (
  `id` int NOT NULL,
  `usuario_id` int NOT NULL,
  `prova` varchar(50) NOT NULL,
  `acertos` int NOT NULL,
  `erros` int NOT NULL,
  `tempo_gasto` int NOT NULL,
  `pontuacao` int NOT NULL,
  `data_execucao` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--

-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `criado_em` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `desempenho_provas`
--
ALTER TABLE `desempenho_provas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `desempenho_provas`
--
ALTER TABLE `desempenho_provas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `desempenho_provas`
--
ALTER TABLE `desempenho_provas`
  ADD CONSTRAINT `desempenho_provas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

