DROP TABLE IF EXISTS questions;
DROP TABLE IF EXISTS types_documents;
DROP TABLE IF EXISTS documents;
DROP TABLE IF EXISTS responses;
DROP TABLE IF EXISTS types_responses;


CREATE TABLE questions (
id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
question_text TEXT NOT NULL,
is_root TINYINT NOT NULL DEFAULT 0,
parent_question INT DEFAULT NULL);

CREATE TABLE types_documents (
id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
name VARCHAR(25) NOT NULL);

CREATE TABLE documents (
id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
document_name VARCHAR(50) NOT NULL UNIQUE,
file_path VARCHAR(250) NOT NULL,
created_at DATETIME NOT NULL,
response_id INT NOT NULL);

CREATE TABLE responses (
id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
response_text TEXT NOT NULL,
question_id INT DEFAULT NULL,
next_question INT DEFAULT NULL,
next_response INT DEFAULT NULL,
parent_response TINYINT NOT NULL DEFAULT 0,
type_document INT DEFAULT NULL,
type_response INT DEFAULT NULL);

CREATE TABLE types_responses (
id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
name VARCHAR(25) NOT NULL);

ALTER TABLE questions ADD CONSTRAINT questions_parent_question_questions_id FOREIGN KEY (parent_question) REFERENCES questions(id);
ALTER TABLE documents ADD CONSTRAINT documents_response_id_responses_id FOREIGN KEY (response_id) REFERENCES responses(id);
ALTER TABLE responses ADD CONSTRAINT responses_question_id_questions_id FOREIGN KEY (question_id) REFERENCES questions(id);
ALTER TABLE responses ADD CONSTRAINT responses_next_question_questions_id FOREIGN KEY (next_question) REFERENCES questions(id);
ALTER TABLE responses ADD CONSTRAINT responses_next_response_responses_id FOREIGN KEY (next_response) REFERENCES responses(id);
ALTER TABLE responses ADD CONSTRAINT responses_type_document_types_documents_id FOREIGN KEY (type_document) REFERENCES types_documents(id);
ALTER TABLE responses ADD CONSTRAINT responses_type_response_types_responses_id FOREIGN KEY (type_response) REFERENCES types_responses(id);