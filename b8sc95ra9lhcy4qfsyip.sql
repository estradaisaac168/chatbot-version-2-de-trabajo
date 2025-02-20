-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: b8sc95ra9lhcy4qfsyip-mysql.services.clever-cloud.com:3306
-- Generation Time: Feb 20, 2025 at 03:53 PM
-- Server version: 8.0.22-13
-- PHP Version: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `b8sc95ra9lhcy4qfsyip`
--

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` int NOT NULL,
  `document_name` varchar(50) NOT NULL,
  `file_path` varchar(250) NOT NULL,
  `created_at` datetime NOT NULL,
  `response_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int NOT NULL,
  `question_text` text NOT NULL,
  `is_root` tinyint NOT NULL DEFAULT '0',
  `parent_question` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `question_text`, `is_root`, `parent_question`) VALUES
(1, 'Hola, Bienvenido soy tu asistente virtual', 1, NULL),
(2, '¿En que puedo ayudarte?', 0, 1),
(3, '¿Que tipo de informacion necesitas?', 0, NULL),
(4, '¿Necesitas algo mas?', 0, NULL),
(5, '¿Que tipo de documento?', 0, NULL),
(6, '¿Como deceas acceder al documento?', 0, NULL),
(7, '¿Como deceas acceder al documento?', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `responses`
--

CREATE TABLE `responses` (
  `id` int NOT NULL,
  `response_text` text NOT NULL,
  `question_id` int DEFAULT NULL,
  `parent_response` int DEFAULT NULL,
  `next_question` int DEFAULT NULL,
  `type_response` int DEFAULT NULL,
  `next_response` tinyint(1) NOT NULL DEFAULT '0',
  `type_document` int DEFAULT NULL
) ;

--
-- Dumping data for table `responses`
--

INSERT INTO `responses` (`id`, `response_text`, `question_id`, `parent_response`, `next_question`, `type_response`, `next_response`, `type_document`) VALUES
(1, 'Informacion', 2, NULL, 3, 1, 0, NULL),
(2, 'Politica de la empresa', 3, NULL, NULL, 1, 1, NULL),
(3, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nobis nemo at accusamus illum odio, vitae eaque non, tenetur maiores aspernatur, deleniti nisi consequuntur mollitia nesciunt inventore officia suscipit eum optio?', NULL, 14, 4, 1, 0, NULL),
(4, 'Si', 4, NULL, 2, 1, 0, NULL),
(5, 'Mision de la empresa', 3, NULL, NULL, 1, 1, NULL),
(6, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nobis nemo at accusamus illum odio, vitae eaque non, tenetur maiores aspernatur, deleniti nisi consequuntur moll', NULL, 15, 4, 1, 0, NULL),
(7, 'No, gracias', 4, NULL, NULL, 1, 1, NULL),
(8, 'Recuerda que estoy aca para ayudarte en lo que necesites, que tengas un buen dia', NULL, 7, NULL, 1, 0, NULL),
(9, 'Documentos', 2, NULL, 5, 2, 0, NULL),
(10, 'Boleta de pago', 5, NULL, NULL, 2, 1, 2),
(11, 'Generando documento espera....', NULL, 10, 6, 2, 0, NULL),
(12, 'Descargar', 6, NULL, NULL, 2, 0, NULL),
(13, 'Mandar por correo', 6, NULL, NULL, 2, 0, NULL),
(14, 'Estas son las politicas de la empresa...', NULL, 2, NULL, 1, 1, NULL),
(15, 'Esta es la mision de la empresa.', NULL, 5, NULL, 1, 1, NULL),
(16, 'Desde el siguiente enlace podras acceder a tu documento.', 7, NULL, NULL, 2, 0, NULL),
(17, 'Email', 7, NULL, NULL, 2, 0, NULL),
(18, 'Constancia Salarial', 5, NULL, NULL, NULL, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE `types` (
  `id` int NOT NULL,
  `name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `types`
--

INSERT INTO `types` (`id`, `name`) VALUES
(1, 'Normal'),
(2, 'Documento');

-- --------------------------------------------------------

--
-- Table structure for table `types_documents`
--

CREATE TABLE `types_documents` (
  `id` int NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `types_documents`
--

INSERT INTO `types_documents` (`id`, `name`) VALUES
(1, 'Constancia Salario'),
(2, 'Boleta de pago'),
(3, 'Constancia Trabajo');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `document_name` (`document_name`),
  ADD KEY `documents_response_id_responses_id` (`response_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `questions_parent_question_questions_id` (`parent_question`);

--
-- Indexes for table `responses`
--
ALTER TABLE `responses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `responses_question_id_questions_id` (`question_id`),
  ADD KEY `responses_parent_response_responses_id` (`parent_response`),
  ADD KEY `responses_next_question_questions_id` (`next_question`),
  ADD KEY `responses_type_response_types_id` (`type_response`),
  ADD KEY `responses_type_document_type_document` (`type_document`);

--
-- Indexes for table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `types_documents`
--
ALTER TABLE `types_documents`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `responses`
--
ALTER TABLE `responses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `types`
--
ALTER TABLE `types`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `types_documents`
--
ALTER TABLE `types_documents`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_response_id_responses_id` FOREIGN KEY (`response_id`) REFERENCES `responses` (`id`);

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_parent_question_questions_id` FOREIGN KEY (`parent_question`) REFERENCES `questions` (`id`);

--
-- Constraints for table `responses`
--
ALTER TABLE `responses`
  ADD CONSTRAINT `responses_next_question_questions_id` FOREIGN KEY (`next_question`) REFERENCES `questions` (`id`),
  ADD CONSTRAINT `responses_parent_response_responses_id` FOREIGN KEY (`parent_response`) REFERENCES `responses` (`id`),
  ADD CONSTRAINT `responses_question_id_questions_id` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`),
  ADD CONSTRAINT `responses_type_document_type_document` FOREIGN KEY (`type_document`) REFERENCES `types_documents` (`id`),
  ADD CONSTRAINT `responses_type_response_types_id` FOREIGN KEY (`type_response`) REFERENCES `types` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
