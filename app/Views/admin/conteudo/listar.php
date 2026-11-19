<?= $this->extend('layout/main') ?>
<?= $this->section('conteudo') ?>
<section class="section-head">
    <p class="eyebrow">ÁREA RESTRITA</p>
    <h1>Conteúdos cadastrados</h1>
    <p class="muted">Aqui ficam os textos que aparecem nas páginas públicas.</p>
</section>
<div class="table-card">
    <table>
        <thead><tr><th>Título</th><th>Texto</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($conteudos as $item): ?>
            <tr>
                <td><?= esc($item['Titulo']) ?></td>
                <td><?= esc(character_limiter(strip_tags($item['Texto'] ?? ''), 90)) ?></td>
                <td><a class="table-link" href="<?= site_url('admin/conteudos/editar/' . $item['Id']) ?>">Editar</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>