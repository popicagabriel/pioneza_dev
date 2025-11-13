<?php

declare(strict_types=1);

$pageTitle = 'Acces interzis';
$bodyClass = 'page page--error page--error-403';
$currentMessage = $errorMessage ?? 'Nu ai acces la această resursă.';

ob_start();
?>
<section class="error">
    <div class="error__badge">403</div>
    <h1 class="error__title">Nu ai acces la această resursă</h1>
    <p class="error__message"><?= htmlspecialchars($currentMessage, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php if (!empty($errorDetails)) : ?>
        <pre class="error__details"><?= htmlspecialchars((string) $errorDetails, ENT_QUOTES, 'UTF-8'); ?></pre>
    <?php endif; ?>
    <div class="error__actions">
        <a class="hero__cta" href="/">Înapoi la pagina principală</a>
        <a class="error__link" href="mailto:contact@pioneza.ro">Trimite un mesaj</a>
    </div>
</section>
<?php
$content = ob_get_clean();

require __DIR__ . '/../layout.php';

