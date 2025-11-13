<?php

declare(strict_types=1);

$pageTitle = $pageTitle ?? 'Pagina în construcție';
$bodyClass = 'page page--under-construction';

ob_start();
?>
<section class="hero">
    <div class="hero__content">
        <h1 class="hero__title hero__title--accent">Revenim în curând</h1>
        <p class="hero__subtitle">
            <span class="hero__subtitle-line">Site-ul este în construcție.</span>
            <span class="hero__subtitle-line">Pregătim ceva frumos pentru tine.</span>
        </p>
    </div>
    <div class="hero__illustration" aria-hidden="true">
        <div class="gear gear--large"></div>
        <div class="gear gear--medium"></div>
        <div class="gear gear--small"></div>
    </div>
</section>
<?php
$content = ob_get_clean();

require __DIR__ . '/layout.php';

