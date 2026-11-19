<?= $this->extend('layout/main') ?>
<?= $this->section('conteudo') ?>
<section class="section-head">
    <p class="eyebrow">GERENCIAMENTO</p>
    <h1>Conteúdos</h1>
    <p class="muted">Consulte e edite os textos cadastrados no sistema.</p>
</section>
<div class="table-card">
    <table>
        <thead><tr><th>Título</th><th>Texto</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($conteudos as $item): ?>
            <tr>
                <td><?= esc($item['Titulo']) ?></td>
                <td><?= esc(character_limiter(strip_tags($item['Texto'] ?? ''), 90)) ?></td>
                <td><a class="table-link" href="<?= site_url('conteudos/editar/' . $item['Id']) ?>">Editar</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>