<?= $this->extend(config('Auth')->views['layout']) ?>
<?= $this->section('title') ?>Entrar<?= $this->endSection() ?>
<?= $this->section('main') ?>
<section class="form-card auth-card">
    <p class="eyebrow">BOM TER VOCÊ DE VOLTA</p>
    <h1>Entrar na conta</h1>
    <p class="muted">Informe seus dados para continuar.</p>
    <?php if (session('error')): ?><div class="notice error"><?= esc(session('error')) ?></div><?php endif; ?>
    <?php if (session('errors')): ?><div class="notice error"><?php foreach ((array) session('errors') as $erro): ?><p><?= esc($erro) ?></p><?php endforeach; ?></div><?php endif; ?>
    <?php if (session('message')): ?><div class="notice"><?= esc(session('message')) ?></div><?php endif; ?>
    <form action="<?= url_to('login') ?>" method="post" class="form">
        <?= csrf_field() ?>
        <label for="email">E-mail</label>
        <input id="email" name="email" type="email" autocomplete="email" value="<?= old('email') ?>" required>
        <label for="password">Senha</label>
        <input id="password" name="password" type="password" autocomplete="current-password" required>
        <button class="btn btn-full" type="submit">Entrar</button>
    </form>
    <p class="auth-foot">Ainda não tem uma conta? <a href="<?= url_to('register') ?>">Cadastre-se</a></p>
</section>
<?= $this->endSection() ?>