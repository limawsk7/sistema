<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($titulo ?? 'Portal') ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body>
<header class="topbar">
    <div class="wrap nav-wrap">
        <a class="brand" href="<?= site_url('/') ?>"><span class="brand-mark">P</span><span>Portal</span></a>
        <nav>
            <a href="<?= site_url('/') ?>">Início</a>
            <a href="<?= site_url('contato') ?>">Contato</a>
            <?php if (auth()->loggedIn()): ?>
                <a href="<?= site_url('conteudos') ?>">Conteúdos</a>
                <?php if (auth()->user()->inGroup('admin')): ?><a href="<?= site_url('admin') ?>">Painel</a><?php endif; ?>
            <?php endif; ?>
        </nav>
        <div class="account">
            <?php if (auth()->loggedIn()): ?>
                <span>Olá, <?= esc(auth()->user()->username ?? 'usuário') ?></span>
                <form action="<?= site_url('admin/sair') ?>" method="post"><?= csrf_field() ?><button class="btn btn-light" type="submit">Sair</button></form>
            <?php else: ?>
                <a class="plain-link" href="<?= site_url('login') ?>">Entrar</a>
                <a class="btn" href="<?= site_url('register') ?>">Criar conta</a>
            <?php endif; ?>
        </div>
    </div>
</header>
<main class="wrap main">
    <?php if (session()->getFlashdata('mensagem')): ?><div class="notice"><?= esc(session()->getFlashdata('mensagem')) ?></div><?php endif; ?>
    <?= $this->renderSection('conteudo') ?>
</main>
<footer class="footer"><div class="wrap footer-inner"><span>Portal</span><span>Informação clara, sem complicação.</span></div></footer>
</body>
</html>