-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: b8sc95ra9lhcy4qfsyip-mysql.services.clever-cloud.com:3306
-- Generation Time: Feb 20, 2025 at 06:53 PM
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
(1, 'Hola, Bienvenid@', 1, NULL),
(2, '¿En que puedo ayudarte?', 0, 1),
(3, '¿Que tipo de informacion necesitas?', 0, NULL),
(4, '¿Necesitas algo mas?', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `responses`
--

CREATE TABLE `responses` (
  `id` int NOT NULL,
  `response_text` text NOT NULL,
  `question_id` int DEFAULT NULL,
  `next_question` int DEFAULT NULL,
  `next_response` int DEFAULT NULL,
  `parent_response` tinyint NOT NULL DEFAULT '0',
  `type_document` int DEFAULT NULL,
  `type_response` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `responses`
--

INSERT INTO `responses` (`id`, `response_text`, `question_id`, `next_question`, `next_response`, `parent_response`, `type_document`, `type_response`) VALUES
(1, 'Informacion sobre la empresa', 2, 3, NULL, 0, NULL, 1),
(2, 'Politica de privacidad', 3, NULL, 3, 1, NULL, NULL),
(3, 'Estoy recopilando tu informacion', NULL, NULL, 4, 1, NULL, NULL),
(4, 'Texto Politicas de privacidad Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquam commodi totam dolorum illo ullam itaque molestiae sapiente laboriosam consequuntur neque! Dolor suscipit voluptates odio repellendus consequuntur? Veritatis quasi soluta optio! Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquam commodi totam dolorum illo ullam itaque molestiae sapiente laboriosam consequuntur neque! Dolor suscipit voluptates odio repellendus consequuntur? Veritatis quasi soluta optio! Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquam commodi totam dolorum illo ullam itaque molestiae sapiente laboriosam consequuntur neque! Dolor suscipit voluptates odio repellendus consequuntur? Veritatis quasi soluta optio!', NULL, 4, NULL, 0, NULL, NULL),
(5, 'Si', 4, 2, NULL, 0, NULL, NULL),
(6, 'No', 4, NULL, 7, 1, NULL, NULL),
(7, 'Adios cuidate!!', NULL, NULL, NULL, 0, NULL, NULL),
(8, 'Mision de la empresa', 3, NULL, NULL, 0, NULL, NULL),
(9, 'Mision Lorem ipsum dolor sit amet consectetur adipisicing elit. Aperiam natus, impedit itaque dolor, ex illum, aspernatur porro rem voluptatibus molestiae quis odio labore mollitia eveniet eaque cupiditate quo! Magnam, ex!', NULL, NULL, NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `types_documents`
--

CREATE TABLE `types_documents` (
  `id` int NOT NULL,
  `name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `types_documents`
--

INSERT INTO `types_documents` (`id`, `name`) VALUES
(1, 'Boleta de pago'),
(2, 'Constancia de trabajo'),
(3, 'Constancia salarial');

-- --------------------------------------------------------

--
-- Table structure for table `types_responses`
--

CREATE TABLE `types_responses` (
  `id` int NOT NULL,
  `name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `types_responses`
--

INSERT INTO `types_responses` (`id`, `name`) VALUES
(1, 'Normal'),
(2, 'Documento'),
(3, 'Documento generado');

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
  ADD KEY `responses_next_question_questions_id` (`next_question`),
  ADD KEY `responses_next_response_responses_id` (`next_response`),
  ADD KEY `responses_type_document_types_documents_id` (`type_document`),
  ADD KEY `responses_type_response_types_responses_id` (`type_response`);

--
-- Indexes for table `types_documents`
--
ALTER TABLE `types_documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `types_responses`
--
ALTER TABLE `types_responses`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `responses`
--
ALTER TABLE `responses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `types_documents`
--
ALTER TABLE `types_documents`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `types_responses`
--
ALTER TABLE `types_responses`
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
  ADD CONSTRAINT `responses_next_response_responses_id` FOREIGN KEY (`next_response`) REFERENCES `responses` (`id`),
  ADD CONSTRAINT `responses_question_id_questions_id` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`),
  ADD CONSTRAINT `responses_type_document_types_documents_id` FOREIGN KEY (`type_document`) REFERENCES `types_documents` (`id`),
  ADD CONSTRAINT `responses_type_response_types_responses_id` FOREIGN KEY (`type_response`) REFERENCES `types_responses` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
