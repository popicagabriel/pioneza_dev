<?php

declare(strict_types=1);

$pageTitle = $pageTitle ?? 'Pagina în construcție';
$bodyClass = 'page page--under-construction';

ob_start();
?>
<section class="hero">
    <div class="hero__content">
        <h1 class="hero__title">Revenim în curând</h1>
        <p class="hero__subtitle">
            Lucrăm la ceva special pentru aplicația <strong>SMIL</strong>. Te rugăm să revii mai târziu.
        </p>
        <a class="hero__cta" href="mailto:contact@pioneza.ro">Contactează-ne</a>
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

