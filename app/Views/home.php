<?= $this->extend('layout/main') ?>
<?= $this->section('conteudo') ?>
<section class="public-card">
    <p class="eyebrow">BEM-VINDO</p>
    <h1><?= esc($conteudo['Titulo'] ?? 'Página inicial') ?></h1>
    <div class="page-copy"><?= nl2br(esc($conteudo['Texto'] ?? '')) ?></div>
    <a class="text-link" href="<?= site_url('contato') ?>">Ir para contato <span>→</span></a>
</section>
<?= $this->endSection() ?>