<?php

declare(strict_types=1);

$documentTitle = $pageTitle ?? 'Pioneza';
$bodyClass = $bodyClass ?? '';
$content = $content ?? '';
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($documentTitle, ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="stylesheet" href="/assets/css/main.css">
</head>
<body class="<?= htmlspecialchars($bodyClass, ENT_QUOTES, 'UTF-8'); ?>">
<main class="page-wrapper">
    <?= $content; ?>
</main>
<script src="/assets/js/main.js" defer></script>
</body>
</html>

