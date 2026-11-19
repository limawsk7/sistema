# Sistema de conteúdo

Projeto PHP com MariaDB para publicar e editar os textos das páginas inicial e contato. A área administrativa exige uma conta autorizada.

## Requisitos
- PHP 8.1 ou superior
- MariaDB 10.4+ ou MySQL compatível
- Servidor Apache ou PHP embutido

## Instalação
1. Crie um banco chamado `sistema`.
2. Importe o arquivo SQL fornecido pelo responsável pelo projeto.
3. Copie `.env.example` para `.env` e preencha os dados de conexão.
4. Configure o servidor para apontar para a pasta pública do projeto (ou use `php -S localhost:8000` na raiz para testar).
5. Acesse `/index.php`.

## Primeiro acesso administrativo
Por segurança, novos cadastros recebem apenas o grupo `user`. Para liberar a área administrativa a uma conta já cadastrada, execute no banco, substituindo o e-mail:

```sql
UPDATE auth_groups_users agu
JOIN auth_identities ai ON ai.user_id = agu.user_id
SET agu.`group` = 'admin'
WHERE ai.type = 'email_password'
  AND ai.secret = 'seu-email@exemplo.com';
```

O dump de exemplo contém um usuário chamado Admin, mas ele está no grupo `user`. Não reutilize hashes ou credenciais de terceiros.

## Estrutura
- `index.php`: rotas, autenticação, páginas públicas e área administrativa.
- `config.php`: leitura das variáveis de ambiente e conexão PDO.
- `assets/css/style.css`: estilos da interface.
- `.env.example`: modelo de configuração local.

As páginas públicas leem os registros da tabela `conteudo`: ID 1 para início e ID 4 para contato, conforme o dump recebido. O painel permite editar esses registros sem criar novas seções ou recursos fora do escopo.
