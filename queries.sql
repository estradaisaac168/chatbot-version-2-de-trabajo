INSERT INTO questions (question_text) VALUES ('Hola, Bienvenido');
INSERT INTO questions (question_text, parent_question) VALUES ('En que puedo ayudarte?', 1);

INSERT INTO options 

SELECT * FROM questions;


SELECT * FROM questions WHERE parent_question IS NULL;

SELECT * FROM options;
SELECT * FROM documents;

SELECT * FROM options WHERE next_question IS NOT NULL ORDER BY id DESC

SELECT * FROM types

INSERT INTO types (name) 
VALUES ('Opcion normal'),
        ('Opcion documento');

SELECT * FROM responses

ALTER TABLE responses
MODIFY COLUMN next_question INT  NULL

SELECT * FROM options;
SELECT * FROM documents;


SHOW CREATE TABLE options

ALTER TABLE options DROP FOREIGN KEY options_type_option_type_id;

ALTER TABLE options DROP COLUMN type_option;

DROP TABLE documents_access


DROP TABLE documents


DROP TABLE responses


DROP TABLE options


DROP TABLE types

DROP TABLE questions


select * from questions

select * from options

select * from responses

ALTER TABLE questions 
ADD COLUMN is_root TINYINT(1) NOT NULL DEFAULT 0 CHECK (is_root IN (0,1));

ALTER TABLE responses 
ADD COLUMN parent_response_id INT DEFAULT NULL,
ADD CONSTRAINT fk_parent_response
FOREIGN KEY (parent_response_id) REFERENCES responses(id) ON DELETE SET NULL;

ALTER TABLE responses ALTER COLUMN question_id SET DEFAULT NULL;


ALTER TABLE responses 
ADD COLUMN type_document INT DEFAULT NULL

select * from types

select * from questions

select * from responses

select * from documents