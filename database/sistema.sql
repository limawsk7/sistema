-- Estrutura MariaDB do projeto Sistema.
-- Baseada no dump fornecido, sem contas, e-mails ou hashes de senha de terceiros.
CREATE DATABASE IF NOT EXISTS sistema CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE sistema;

SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS auth_remember_tokens;
DROP TABLE IF EXISTS auth_permissions_users;
DROP TABLE IF EXISTS auth_groups_users;
DROP TABLE IF EXISTS auth_identities;
DROP TABLE IF EXISTS auth_logins;
DROP TABLE IF EXISTS auth_token_logins;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS conteudo;
DROP TABLE IF EXISTS migrations;
DROP TABLE IF EXISTS settings;
SET FOREIGN_KEY_CHECKS=1;

CREATE TABLE users (
 id INT UNSIGNED NOT NULL AUTO_INCREMENT,
 username VARCHAR(30) DEFAULT NULL,
 status VARCHAR(255) DEFAULT NULL,
 status_message VARCHAR(255) DEFAULT NULL,
 active TINYINT(1) NOT NULL DEFAULT 0,
 last_active DATETIME DEFAULT NULL,
 created_at DATETIME DEFAULT NULL,
 updated_at DATETIME DEFAULT NULL,
 deleted_at DATETIME DEFAULT NULL,
 PRIMARY KEY (id),
 UNIQUE KEY username (username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE auth_groups_users (
 id INT UNSIGNED NOT NULL AUTO_INCREMENT,
 user_id INT UNSIGNED NOT NULL,
 `group` VARCHAR(255) NOT NULL,
 created_at DATETIME NOT NULL,
 PRIMARY KEY (id),
 KEY auth_groups_users_user_id_foreign (user_id),
 CONSTRAINT auth_groups_users_user_id_foreign FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE auth_identities (
 id INT UNSIGNED NOT NULL AUTO_INCREMENT,
 user_id INT UNSIGNED NOT NULL,
 type VARCHAR(255) NOT NULL,
 name VARCHAR(255) DEFAULT NULL,
 secret VARCHAR(255) NOT NULL,
 secret2 VARCHAR(255) DEFAULT NULL,
 expires DATETIME DEFAULT NULL,
 extra TEXT DEFAULT NULL,
 force_reset TINYINT(1) NOT NULL DEFAULT 0,
 last_used_at DATETIME DEFAULT NULL,
 created_at DATETIME DEFAULT NULL,
 updated_at DATETIME DEFAULT NULL,
 PRIMARY KEY (id),
 UNIQUE KEY type_secret (type,secret),
 KEY user_id (user_id),
 CONSTRAINT auth_identities_user_id_foreign FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE auth_logins (
 id INT UNSIGNED NOT NULL AUTO_INCREMENT,
 ip_address VARCHAR(255) NOT NULL,
 user_agent VARCHAR(255) DEFAULT NULL,
 id_type VARCHAR(255) NOT NULL,
 identifier VARCHAR(255) NOT NULL,
 user_id INT UNSIGNED DEFAULT NULL,
 `date` DATETIME NOT NULL,
 success TINYINT(1) NOT NULL,
 PRIMARY KEY (id),
 KEY id_type_identifier (id_type,identifier),
 KEY user_id (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE auth_permissions_users (
 id INT UNSIGNED NOT NULL AUTO_INCREMENT,
 user_id INT UNSIGNED NOT NULL,
 permission VARCHAR(255) NOT NULL,
 created_at DATETIME NOT NULL,
 PRIMARY KEY (id),
 KEY auth_permissions_users_user_id_foreign (user_id),
 CONSTRAINT auth_permissions_users_user_id_foreign FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE auth_remember_tokens (
 id INT UNSIGNED NOT NULL AUTO_INCREMENT,
 selector VARCHAR(255) NOT NULL,
 hashedValidator VARCHAR(255) NOT NULL,
 user_id INT UNSIGNED NOT NULL,
 expires DATETIME NOT NULL,
 created_at DATETIME NOT NULL,
 updated_at DATETIME NOT NULL,
 PRIMARY KEY (id),
 UNIQUE KEY selector (selector),
 KEY auth_remember_tokens_user_id_foreign (user_id),
 CONSTRAINT auth_remember_tokens_user_id_foreign FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE auth_token_logins (
 id INT UNSIGNED NOT NULL AUTO_INCREMENT,
 ip_address VARCHAR(255) NOT NULL,
 user_agent VARCHAR(255) DEFAULT NULL,
 id_type VARCHAR(255) NOT NULL,
 identifier VARCHAR(255) NOT NULL,
 user_id INT UNSIGNED DEFAULT NULL,
 `date` DATETIME NOT NULL,
 success TINYINT(1) NOT NULL,
 PRIMARY KEY (id),
 KEY id_type_identifier (id_type,identifier),
 KEY user_id (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE conteudo (
 Id INT NOT NULL AUTO_INCREMENT,
 Titulo VARCHAR(255) NOT NULL,
 Texto TEXT DEFAULT NULL,
 PRIMARY KEY (Id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO conteudo (Id,Titulo,Texto) VALUES
(1,'Página Inicial - Sistema','Bem-vindo ao portal oficial do sistema. Aqui você encontra as principais informações.'),
(4,'Contato','Entre em contacto conosco através do e-mail de suporte.');

CREATE TABLE migrations (
 id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
 version VARCHAR(255) NOT NULL,
 class VARCHAR(255) NOT NULL,
 `group` VARCHAR(255) NOT NULL,
 namespace VARCHAR(255) NOT NULL,
 time INT NOT NULL,
 batch INT UNSIGNED NOT NULL,
 PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE settings (
 id INT NOT NULL AUTO_INCREMENT,
 class VARCHAR(255) NOT NULL,
 `key` VARCHAR(255) NOT NULL,
 value TEXT DEFAULT NULL,
 type VARCHAR(31) NOT NULL DEFAULT 'string',
 context VARCHAR(255) DEFAULT NULL,
 created_at DATETIME NOT NULL,
 updated_at DATETIME NOT NULL,
 PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO migrations (id,version,class,`group`,namespace,time,batch) VALUES
(1,'2020-12-28-223112','CodeIgniter\\Shield\\Database\\Migrations\\CreateAuthTables','default','CodeIgniter\\Shield',1793382922,1),
(2,'2021-07-04-041948','CodeIgniter\\Settings\\Database\\Migrations\\CreateSettingsTable','default','CodeIgniter\\Settings',1793382922,1),
(3,'2021-11-14-143905','CodeIgniter\\Settings\\Database\\Migrations\\AddContextColumn','default','CodeIgniter\\Settings',1793382922,1),
(4,'2026-07-20-181246','CodeIgniter\\Settings\\Database\\Migrations\\ConvertSqlsrvValueColumn','default','CodeIgniter\\Settings',1793382922,1);
