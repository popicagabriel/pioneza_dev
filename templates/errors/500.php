<?php

declare(strict_types=1);

$pageTitle = 'Eroare internă';
$bodyClass = 'page page--error page--error-500';
$currentMessage = $errorMessage ?? 'A apărut o eroare neașteptată. Te rugăm să încerci mai târziu.';

ob_start();
?>
<section class="error">
    <div class="error__badge">500</div>
    <h1 class="error__title">Ne pare rău, a apărut o problemă.</h1>
    <p class="error__message"><?= htmlspecialchars($currentMessage, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php if (!empty($errorDetails)) : ?>
        <pre class="error__details"><?= htmlspecialchars((string) $errorDetails, ENT_QUOTES, 'UTF-8'); ?></pre>
    <?php endif; ?>
    <div class="error__actions">
        <a class="hero__cta" href="/">Reîncarcă pagina</a>
        <a class="error__link" href="mailto:contact@pioneza.ro">Raportează problema</a>
    </div>
</section>
<?php
$content = ob_get_clean();

require __DIR__ . '/../layout.php';

