<?= $this->extend('layout/main') ?>
<?= $this->section('conteudo') ?>
<section class="section-head">
    <p class="eyebrow">ÁREA RESTRITA</p>
    <h1>Painel administrativo</h1>
    <p class="muted">Escolha uma opção para continuar.</p>
</section>
<div class="admin-option">
    <div><span class="option-mark">01</span><div><h2>Conteúdos</h2><p>Consulte e atualize os textos das páginas.</p></div></div>
    <a class="btn" href="<?= site_url('admin/conteudos') ?>">Abrir conteúdos</a>
</div>
<?= $this->endSection() ?>