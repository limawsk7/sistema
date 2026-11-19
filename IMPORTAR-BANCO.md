# Como importar o banco de dados

O arquivo `sistema.sql` cria um banco próprio do projeto. Ele não usa o backup do outro aluno.

## Pelo phpMyAdmin (XAMPP)

1. Abra o XAMPP e inicie **Apache** e **MySQL**.
2. Acesse http://localhost/phpmyadmin
3. Clique na aba **Importar**.
4. Em **Escolher arquivo**, selecione o arquivo `sistema.sql` deste repositório.
5. Mantenha o formato **SQL** e clique em **Importar** no fim da página.
6. Quando terminar, confirme que apareceu o banco `sistema`, com as tabelas `usuarios` e `conteudos`.

O script cria o banco automaticamente. Não é necessário criar as tabelas manualmente.

## Administradora inicial

O banco já cadastra a conta administradora abaixo. A senha é armazenada no banco como hash bcrypt, não em texto puro.

- E-mail: alicegplima10@gmail.com
- Senha: a senha definida pela proprietária do projeto.

**Importante:** não publique nem compartilhe sua senha. Se este repositório for público, considere trocar a senha depois do primeiro acesso.

## Observação

Este arquivo prepara somente o banco de dados. A aplicação PHP precisa estar configurada para usar as tabelas `usuarios` e `conteudos` e validar senhas com `password_verify()`.
