DROP TABLE IF EXISTS questions;
DROP TABLE IF EXISTS options;
DROP TABLE IF EXISTS types;
DROP TABLE IF EXISTS documents;
DROP TABLE IF EXISTS documents_access;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS response;


CREATE TABLE questions (
id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
question_text TEXT NOT NULL,
parent_question INT DEFAULT NULL);

CREATE TABLE options (
id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
option_text TEXT NOT NULL,
type_option INT NOT NULL,
question_id INT NOT NULL,
next_question INT DEFAULT NULL);

CREATE TABLE responses (
id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
response_text TEXT NOT NULL,
option_id INT NOT NULL,
next_question INT DEFAULT NULL);


CREATE TABLE types (
id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
name VARCHAR(25) NOT NULL);

CREATE TABLE documents (
id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
document_name VARCHAR(50) NOT NULL UNIQUE,
file_path VARCHAR(250) NOT NULL,
created_at DATETIME NOT NULL,
option_id INT NOT NULL);

CREATE TABLE documents_access (
id  INT(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
user_id INT(11) NOT NULL,
document_id INT NOT NULL,
accessed_at DATETIME NOT NULL);

CREATE TABLE users (
id INT(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
carnet INT(20) NOT NULL UNIQUE,
password VARCHAR(250) NOT NULL);

ALTER TABLE questions ADD CONSTRAINT question_parent_question_questions_id FOREIGN KEY (parent_question) REFERENCES questions(id);
ALTER TABLE options ADD CONSTRAINT options_type_option_type_id FOREIGN KEY (type_option) REFERENCES types(id);
ALTER TABLE options ADD CONSTRAINT options_question_id_questions_id FOREIGN KEY (question_id) REFERENCES questions(id);
ALTER TABLE options ADD CONSTRAINT options_next_question_questions_id FOREIGN KEY (next_question) REFERENCES questions(id);
ALTER TABLE documents ADD CONSTRAINT document_option_id_options_id FOREIGN KEY (option_id) REFERENCES options(id);
ALTER TABLE documents_access ADD CONSTRAINT document_access_user_id_user_id FOREIGN KEY (user_id) REFERENCES users(id);
ALTER TABLE documents_access ADD CONSTRAINT document_access_document_id_document_id FOREIGN KEY (document_id) REFERENCES documents(id);
ALTER TABLE responses ADD CONSTRAINT responses_next_question_qustions_id FOREIGN KEY (next_question) REFERENCES questions(id);
ALTER TABLE responses ADD CONSTRAINT responses_option_id_options_id FOREIGN KEY (option_id) REFERENCES options(id);