# Sistema

Aplicação de páginas públicas e gerenciamento de conteúdo, desenvolvida em PHP com CodeIgniter 4, Shield e MariaDB.

## O que o sistema faz
- Exibe a página inicial e a página de contato.
- Permite cadastro e login de usuários.
- Permite que usuários autenticados consultem e editem conteúdos.
- Possui painel administrativo protegido por grupo.
- Permite ao administrador listar, editar e atualizar conteúdos.
- Permite encerrar a sessão.

## Requisitos
- PHP 8.2 ou superior
- Composer
- MariaDB 10.4+ ou MySQL compatível
- Extensões PHP: intl, mbstring e mysqli

## Instalação
1. Clone este repositório.
2. Execute `composer install`.
3. Copie `.env.example` para `.env`.
4. Crie um banco vazio chamado `sistema` e importe `database/sistema.sql` nele. Atenção: o script recria as tabelas; não o execute sobre um banco com dados que deseja manter.
5. Ajuste as credenciais e a URL no arquivo `.env`.
6. Execute `php spark serve` e abra `http://localhost:8080`.

## Acesso administrativo
O backup original continha dados de uma conta de terceiro, então eles não foram copiados. Cadastre uma conta pela tela de registro e promova o usuário desejado no banco:

```sql
INSERT INTO auth_groups_users (user_id, `group`, created_at)
SELECT id, 'admin', NOW()
FROM users
WHERE username = 'SEU_USUARIO'
  AND NOT EXISTS (
    SELECT 1 FROM auth_groups_users
    WHERE user_id = users.id AND `group` = 'admin'
  );
```

## Banco de dados
A tabela `conteudo` conserva os registros do dump: ID 1 para a página inicial e ID 4 para contato. A página de contato usa o ID 4, conforme os dados reais do SQL recebido.

O arquivo SQL não inclui e-mails, usuários ou hashes de senha de terceiros.

## Configuração no servidor da faculdade

O arquivo `.env.example` já contém o endereço do servidor MySQL utilizado pela faculdade:

- Host: `192.168.51.20`
- Banco: `sistema`
- Driver: `MySQLi`
- Porta: `3306`

No servidor de hospedagem, copie `.env.example` para `.env` e informe o usuário e a senha fornecidos pela faculdade nos campos `database.default.username` e `database.default.password`. Ajuste também `app.baseURL` para o endereço real em que a aplicação será acessada.

**Importante:** não coloque senhas reais no GitHub. O arquivo `.env` está no `.gitignore` justamente para manter credenciais fora do repositório. O servidor onde o PHP roda também precisa ter a extensão `mysqli` habilitada e permissão de conexão TCP com `192.168.51.20:3306`. Se a conexão falhar, verifique com o responsável pela rede/banco se o IP do servidor web está autorizado no MySQL e se a porta está liberada.
