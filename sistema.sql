-- Banco de dados independente do Portal
-- MySQL 8+ / MariaDB 10.4+
-- Importe este arquivo em um banco vazio.

CREATE DATABASE IF NOT EXISTS sistema CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE sistema;
SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS usuarios (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  nome VARCHAR(120) NOT NULL,
  email VARCHAR(190) NOT NULL,
  senha_hash VARCHAR(255) NOT NULL,
  perfil ENUM('admin','usuario') NOT NULL DEFAULT 'usuario',
  ativo TINYINT(1) NOT NULL DEFAULT 1,
  criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  atualizado_em TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uk_usuarios_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS conteudos (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  slug VARCHAR(80) NOT NULL,
  titulo VARCHAR(180) NOT NULL,
  texto TEXT NOT NULL,
  criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  atualizado_em TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uk_conteudos_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Administradora inicial: senha gravada somente como hash bcrypt.
INSERT INTO usuarios (nome,email,senha_hash,perfil,ativo)
SELECT 'Alice Lima','alicegplima10@gmail.com',
'$2y$12$aaAR98C5gNkTdI8lUoGIqeWMmcE71M102HoymcjQVYpG9MBWwsGL2','admin',1
WHERE NOT EXISTS (SELECT 1 FROM usuarios WHERE email='alicegplima10@gmail.com');

INSERT INTO conteudos (slug,titulo,texto)
SELECT 'inicio','Página Inicial','Bem-vindo ao portal. Aqui você encontra as principais informações.'
WHERE NOT EXISTS (SELECT 1 FROM conteudos WHERE slug='inicio');

INSERT INTO conteudos (slug,titulo,texto)
SELECT 'contato','Contato','Entre em contato conosco pelos canais de atendimento.'
WHERE NOT EXISTS (SELECT 1 FROM conteudos WHERE slug='contato');
