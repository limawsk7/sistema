<?= $this->extend('layout/main') ?>
<?= $this->section('conteudo') ?>
<section class="form-card">
    <p class="eyebrow">GERENCIAMENTO</p>
    <h1>Editar conteúdo</h1>
    <?php if (!empty($erros)): ?><div class="notice error"><?php foreach ($erros as $erro): ?><p><?= esc($erro) ?></p><?php endforeach; ?></div><?php endif; ?>
    <form action="<?= site_url('conteudos/atualizar/' . $conteudo['Id']) ?>" method="post" class="form">
        <?= csrf_field() ?>
        <label for="Titulo">Título</label>
        <input id="Titulo" name="Titulo" maxlength="255" value="<?= esc($conteudo['Titulo'] ?? '') ?>" required>
        <label for="Texto">Texto</label>
        <textarea id="Texto" name="Texto" rows="7" required><?= esc($conteudo['Texto'] ?? '') ?></textarea>
        <div class="form-actions"><a class="btn btn-light" href="<?= site_url('conteudos') ?>">Cancelar</a><button class="btn" type="submit">Salvar alterações</button></div>
    </form>
</section>
<?= $this->endSection() ?>