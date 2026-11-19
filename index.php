<?php
declare(strict_types=1);

session_start();
require __DIR__ . '/config.php';

function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function redirect(string $page): never
{
    header('Location: index.php?p=' . rawurlencode($page));
    exit;
}

function currentUser(): ?array
{
    return $_SESSION['user'] ?? null;
}

function isAdmin(PDO $db): bool
{
    $user = currentUser();
    if (!$user) {
        return false;
    }

    $query = $db->prepare('SELECT 1 FROM auth_groups_users WHERE user_id = ? AND `group` = ? LIMIT 1');
    $query->execute([(int) $user['id'], 'admin']);
    return (bool) $query->fetchColumn();
}

function contentById(PDO $db, int $id): array
{
    $query = $db->prepare('SELECT Id, Titulo, Texto FROM conteudo WHERE Id = ? LIMIT 1');
    $query->execute([$id]);
    return $query->fetch() ?: ['Id' => $id, 'Titulo' => '', 'Texto' => ''];
}

function flash(string $type, string $message): void
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function csrfToken(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

try {
    $db = database();
} catch (Throwable $error) {
    http_response_code(500);
    echo '<h1>Não foi possível conectar ao banco</h1><p>Confira os dados do arquivo .env e tente novamente.</p>';
    exit;
}

$page = $_GET['p'] ?? 'inicio';
$notice = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sentToken = (string) ($_POST['csrf_token'] ?? '');
    if (!hash_equals(csrfToken(), $sentToken)) {
        http_response_code(419);
        exit('Sua sessão expirou. Volte à página e tente novamente.');
    }

    $action = $_POST['action'] ?? '';

    if ($action === 'register') {
        $name = trim((string) ($_POST['name'] ?? ''));
        $email = strtolower(trim((string) ($_POST['email'] ?? '')));
        $password = (string) ($_POST['password'] ?? '');

        if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 8) {
            flash('error', 'Preencha seu nome, informe um e-mail válido e use uma senha com pelo menos 8 caracteres.');
            redirect('cadastro');
        }

        $exists = $db->prepare("SELECT id FROM auth_identities WHERE type = 'email_password' AND secret = ? LIMIT 1");
        $exists->execute([$email]);

        if ($exists->fetch()) {
            flash('error', 'Este e-mail já está cadastrado.');
            redirect('cadastro');
        }

        $db->beginTransaction();
        try {
            $insertUser = $db->prepare('INSERT INTO users (username, active, created_at, updated_at) VALUES (?, 1, NOW(), NOW())');
            $insertUser->execute([$name]);
            $userId = (int) $db->lastInsertId();

            $identity = $db->prepare("INSERT INTO auth_identities (user_id, type, secret, secret2, created_at, updated_at) VALUES (?, 'email_password', ?, ?, NOW(), NOW())");
            $identity->execute([$userId, $email, password_hash($password, PASSWORD_DEFAULT)]);

            $group = $db->prepare("INSERT INTO auth_groups_users (user_id, `group`, created_at) VALUES (?, 'user', NOW())");
            $group->execute([$userId]);
            $db->commit();
        } catch (Throwable $error) {
            $db->rollBack();
            throw $error;
        }

        $_SESSION['user'] = ['id' => $userId, 'name' => $name, 'email' => $email];
        flash('success', 'Cadastro realizado. Que bom ter você por aqui!');
        redirect('inicio');
    }

    if ($action === 'login') {
        $email = strtolower(trim((string) ($_POST['email'] ?? '')));
        $password = (string) ($_POST['password'] ?? '');

        $query = $db->prepare("SELECT u.id, u.username, ai.secret, ai.secret2 FROM users u JOIN auth_identities ai ON ai.user_id = u.id WHERE ai.type = 'email_password' AND ai.secret = ? AND u.deleted_at IS NULL LIMIT 1");
        $query->execute([$email]);
        $account = $query->fetch();

        if (!$account || !password_verify($password, (string) $account['secret2'])) {
            flash('error', 'E-mail ou senha não conferem.');
            redirect('login');
        }

        session_regenerate_id(true);
        $_SESSION['user'] = ['id' => (int) $account['id'], 'name' => (string) $account['username'], 'email' => $email];
        redirect('inicio');
    }

    if ($action === 'save_content') {
        if (!isAdmin($db)) {
            http_response_code(403);
            exit('Acesso não autorizado.');
        }

        $id = (int) ($_POST['id'] ?? 0);
        $title = trim((string) ($_POST['title'] ?? ''));
        $body = trim((string) ($_POST['body'] ?? ''));

        if (!in_array($id, [1, 4], true) || $title === '') {
            flash('error', 'Confira o título e tente novamente.');
            redirect('admin');
        }

        $save = $db->prepare('UPDATE conteudo SET Titulo = ?, Texto = ? WHERE Id = ?');
        $save->execute([$title, $body, $id]);
        flash('success', 'Alterações salvas.');
        redirect('admin');
    }
}

if ($page === 'sair') {
    $_SESSION = [];
    session_destroy();
    header('Location: index.php?p=inicio');
    exit;
}

$publicPages = ['inicio', 'contato'];
if ($page === 'inicio') {
    $content = contentById($db, 1);
} elseif ($page === 'contato') {
    $content = contentById($db, 4);
}

if ($page === 'admin' && !isAdmin($db)) {
    if (!currentUser()) {
        redirect('login');
    }
    http_response_code(403);
    $page = 'sem-permissao';
}

if ($page === 'admin') {
    $contents = $db->query('SELECT Id, Titulo, Texto FROM conteudo WHERE Id IN (1, 4) ORDER BY Id')->fetchAll();
}

$appName = envValue('APP_NAME', 'Portal');
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($appName) ?> · <?= $page === 'inicio' ? 'Início' : e(ucfirst($page)) ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header class="topbar">
    <div class="container nav-wrap">
        <a class="brand" href="index.php?p=inicio"><span class="brand-mark">P</span><span><?= e($appName) ?></span></a>
        <nav aria-label="Navegação principal">
            <a class="<?= $page === 'inicio' ? 'active' : '' ?>" href="index.php?p=inicio">Início</a>
            <a class="<?= $page === 'contato' ? 'active' : '' ?>" href="index.php?p=contato">Contato</a>
            <?php if (currentUser() && isAdmin($db)): ?>
                <a class="<?= $page === 'admin' ? 'active' : '' ?>" href="index.php?p=admin">Painel</a>
            <?php endif; ?>
        </nav>
        <div class="nav-account">
            <?php if (currentUser()): ?>
                <span class="user-greeting">Olá, <?= e(currentUser()['name']) ?></span>
                <a class="button button-small button-quiet" href="index.php?p=sair">Sair</a>
            <?php else: ?>
                <a class="login-link" href="index.php?p=login">Entrar</a>
                <a class="button button-small" href="index.php?p=cadastro">Criar conta</a>
            <?php endif; ?>
        </div>
    </div>
</header>

<main class="container main-content">
    <?php if ($notice): ?>
        <div class="notice <?= e($notice['type']) ?>"><?= e($notice['message']) ?></div>
    <?php endif; ?>

    <?php if (in_array($page, $publicPages, true)): ?>
        <section class="public-card">
            <p class="eyebrow"><?= $page === 'inicio' ? 'BEM-VINDO' : 'FALE COM A GENTE' ?></p>
            <h1><?= e($content['Titulo']) ?></h1>
            <div class="page-copy"><?= nl2br(e($content['Texto'])) ?></div>
            <?php if ($page === 'inicio'): ?>
                <a class="text-link" href="index.php?p=contato">Ir para contato <span aria-hidden="true">→</span></a>
            <?php endif; ?>
        </section>
    <?php elseif ($page === 'login' || $page === 'cadastro'): ?>
        <section class="auth-card">
            <p class="eyebrow"><?= $page === 'login' ? 'ACESSO' : 'NOVO POR AQUI?' ?></p>
            <h1><?= $page === 'login' ? 'Entre na sua conta' : 'Crie sua conta' ?></h1>
            <p class="muted"><?= $page === 'login' ? 'Use seus dados para continuar.' : 'É rapidinho. Preencha os campos abaixo.' ?></p>
            <form method="post" class="form">
                <input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">
                <input type="hidden" name="action" value="<?= $page === 'login' ? 'login' : 'register' ?>">
                <?php if ($page === 'cadastro'): ?>
                    <label for="name">Nome</label>
                    <input id="name" name="name" type="text" maxlength="30" autocomplete="name" required>
                <?php endif; ?>
                <label for="email">E-mail</label>
                <input id="email" name="email" type="email" autocomplete="email" required>
                <label for="password">Senha</label>
                <input id="password" name="password" type="password" minlength="<?= $page === 'cadastro' ? '8' : '1' ?>" autocomplete="<?= $page === 'login' ? 'current-password' : 'new-password' ?>" required>
                <button class="button button-full" type="submit"><?= $page === 'login' ? 'Entrar' : 'Finalizar cadastro' ?></button>
            </form>
            <p class="form-foot"><?= $page === 'login' ? 'Ainda não tem conta? <a href="index.php?p=cadastro">Cadastre-se</a>' : 'Já tem cadastro? <a href="index.php?p=login">Entre por aqui</a>' ?></p>
        </section>
    <?php elseif ($page === 'admin'): ?>
        <div class="admin-heading">
            <div><p class="eyebrow">ÁREA RESTRITA</p><h1>Painel administrativo</h1><p class="muted">Edite os textos que aparecem nas páginas do site.</p></div>
        </div>
        <div class="content-list">
            <?php foreach ($contents as $item): ?>
                <form method="post" class="edit-card">
                    <input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">
                    <input type="hidden" name="action" value="save_content">
                    <input type="hidden" name="id" value="<?= (int) $item['Id'] ?>">
                    <div class="edit-card-head"><span class="content-number">0<?= (int) $item['Id'] ?></span><span><?= (int) $item['Id'] === 1 ? 'Página inicial' : 'Contato' ?></span></div>
                    <label for="title-<?= (int) $item['Id'] ?>">Título</label>
                    <input id="title-<?= (int) $item['Id'] ?>" name="title" maxlength="255" value="<?= e($item['Titulo']) ?>" required>
                    <label for="body-<?= (int) $item['Id'] ?>">Texto</label>
                    <textarea id="body-<?= (int) $item['Id'] ?>" name="body" rows="5"><?= e($item['Texto']) ?></textarea>
                    <div class="edit-actions"><button class="button" type="submit">Salvar alterações</button></div>
                </form>
            <?php endforeach; ?>
        </div>
    <?php elseif ($page === 'sem-permissao'): ?>
        <section class="public-card"><p class="eyebrow">ACESSO RESTRITO</p><h1>Você não tem permissão para acessar esta página.</h1><p class="page-copy">Se acredita que deveria ter acesso, peça ao responsável pelo sistema para verificar seu grupo de usuário.</p><a class="button" href="index.php?p=inicio">Voltar ao início</a></section>
    <?php else: ?>
        <section class="public-card"><p class="eyebrow">PÁGINA NÃO ENCONTRADA</p><h1>Não encontramos essa página.</h1><a class="text-link" href="index.php?p=inicio">Voltar ao início →</a></section>
    <?php endif; ?>
</main>

<footer class="footer"><div class="container footer-inner"><span><?= e($appName) ?></span><span>Informação clara, sem complicação.</span></div></footer>
</body>
</html>
