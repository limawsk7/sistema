<?= $this->extend(config('Auth')->views['layout']) ?>
<?= $this->section('title') ?>Criar conta<?= $this->endSection() ?>
<?= $this->section('main') ?>
<section class="form-card auth-card">
    <p class="eyebrow">SEU ACESSO COMEÇA AQUI</p>
    <h1>Criar uma conta</h1>
    <p class="muted">Preencha os campos para fazer seu cadastro.</p>
    <?php if (session('error')): ?><div class="notice error"><?= esc(session('error')) ?></div><?php endif; ?>
    <?php if (session('errors')): ?><div class="notice error"><?php foreach ((array) session('errors') as $erro): ?><p><?= esc($erro) ?></p><?php endforeach; ?></div><?php endif; ?>
    <form action="<?= url_to('register') ?>" method="post" class="form">
        <?= csrf_field() ?>
        <label for="username">Nome de usuário</label>
        <input id="username" name="username" type="text" maxlength="30" autocomplete="username" value="<?= old('username') ?>" required>
        <label for="email">E-mail</label>
        <input id="email" name="email" type="email" autocomplete="email" value="<?= old('email') ?>" required>
        <label for="password">Senha</label>
        <input id="password" name="password" type="password" autocomplete="new-password" required>
        <label for="password_confirm">Confirme a senha</label>
        <input id="password_confirm" name="password_confirm" type="password" autocomplete="new-password" required>
        <button class="btn btn-full" type="submit">Finalizar cadastro</button>
    </form>
    <p class="auth-foot">Já tem cadastro? <a href="<?= url_to('login') ?>">Entre por aqui</a></p>
</section>
<?= $this->endSection() ?>