-- Banco novo do projeto. Não contém contas nem senhas de terceiros.
-- Importe este arquivo no MySQL/phpMyAdmin.
CREATE DATABASE IF NOT EXISTS sistema
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;

USE sistema;

CREATE TABLE IF NOT EXISTS conteudo (
  Id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  Titulo VARCHAR(255) NOT NULL,
  Texto TEXT DEFAULT NULL,
  PRIMARY KEY (Id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO conteudo (Id, Titulo, Texto) VALUES
(1, 'Página Inicial', 'Bem-vindo ao nosso site. Aqui você encontra as principais informações.'),
(4, 'Contato', 'Entre em contato conosco para tirar dúvidas ou solicitar mais informações.')
ON DUPLICATE KEY UPDATE
  Titulo = VALUES(Titulo),
  Texto = VALUES(Texto);
