<?= $this->extend('layout/main') ?>
<?= $this->section('conteudo') ?>
<section class="public-card">
    <p class="eyebrow">FALE COM A GENTE</p>
    <h1><?= esc($conteudo['Titulo'] ?? 'Contato') ?></h1>
    <div class="page-copy"><?= nl2br(esc($conteudo['Texto'] ?? '')) ?></div>
</section>
<?= $this->endSection() ?>