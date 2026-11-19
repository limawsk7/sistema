<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->renderSection('title') ?> · Portal</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body>
<header class="topbar"><div class="wrap nav-wrap">
    <a class="brand" href="<?= site_url('/') ?>"><span class="brand-mark">P</span><span>Portal</span></a>
    <nav><a href="<?= site_url('/') ?>">Início</a><a href="<?= site_url('contato') ?>">Contato</a></nav>
    <div class="account"><a class="plain-link" href="<?= site_url('login') ?>">Entrar</a></div>
</div></header>
<main class="wrap main"><?= $this->renderSection('main') ?></main>
<footer class="footer"><div class="wrap footer-inner"><span>Portal</span><span>Informação clara, sem complicação.</span></div></footer>
</body>
</html>