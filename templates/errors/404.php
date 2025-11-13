<?php

declare(strict_types=1);

$pageTitle = 'Pagina nu a fost găsită';
$bodyClass = 'page page--error page--error-404';
$currentMessage = $errorMessage ?? 'Pagina solicitată nu există.';

ob_start();
?>
<section class="error">
    <div class="error__badge">404</div>
    <h1 class="error__title">Ups! Pagina nu există.</h1>
    <p class="error__message"><?= htmlspecialchars($currentMessage, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php if (!empty($errorDetails)) : ?>
        <pre class="error__details"><?= htmlspecialchars((string) $errorDetails, ENT_QUOTES, 'UTF-8'); ?></pre>
    <?php endif; ?>
    <div class="error__actions">
        <a class="hero__cta" href="/">Înapoi la pagina principală</a>
    </div>
</section>
<?php
$content = ob_get_clean();

require __DIR__ . '/../layout.php';

