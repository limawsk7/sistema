<!doctype html>
<html lang="pt-BR">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title><?= esc($title ?? 'Erro') ?></title>
<style>
body{font-family:Arial,sans-serif;background:#f4f4f5;color:#222;margin:0;padding:40px}
main{max-width:900px;margin:0 auto;background:#fff;padding:28px;border-radius:10px}
h1{font-size:24px;color:#b42318}pre{white-space:pre-wrap;overflow-wrap:anywhere;background:#f7f7f7;padding:16px;border-radius:6px}
small{color:#666}
</style></head>
<body><main>
<h1><?= esc($title ?? 'Erro na aplicação') ?></h1>
<p><?= nl2br(esc($message ?? ($exception->getMessage() ?? 'Ocorreu um erro.'))) ?></p>
<?php if (ENVIRONMENT !== 'production' && isset($exception)) : ?>
<p><small><?= esc(clean_path($exception->getFile())) ?>:<?= esc((string) $exception->getLine()) ?></small></p>
<pre><?= esc($exception->getTraceAsString()) ?></pre>
<?php endif; ?>
</main></body></html>