<head>
    <link rel="stylesheet" href="<?= base_url ?>assets/css/foda/index.css">
</head>

<div class="foda-container">
    <h1>Análisis FODA</h1>

    <?php foreach (['fortaleza', 'debilidad', 'oportunidad', 'amenaza'] as $tipo): ?>
        <?php if (isset($_SESSION["{$tipo}_guardada"])): ?>
            <div class="alert <?= $_SESSION["{$tipo}_guardada"] == 'completado' ? 'alert-success' : 'alert-error' ?>">
                <?= $_SESSION["{$tipo}_guardada"] == 'completado' ? "✅ $tipo guardada correctamente." : "❌ Error al guardar $tipo." ?>
            </div>
            <?php unset($_SESSION["{$tipo}_guardada"]); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION["{$tipo}_eliminada"])): ?>
            <div class="alert <?= $_SESSION["{$tipo}_eliminada"] == 'completado' ? 'alert-success' : 'alert-error' ?>">
                <?= $_SESSION["{$tipo}_eliminada"] == 'completado' ? "✅ $tipo eliminada correctamente." : "❌ Error al eliminar $tipo." ?>
            </div>
            <?php unset($_SESSION["{$tipo}_eliminada"]); ?>
        <?php endif; ?>
    <?php endforeach; ?>

    <!-- FORTALEZAS -->
    <div class="foda-section">
        <h2>Fortalezas</h2>
        <?php if (!empty($fortalezas)): ?>
            <ul>
                <?php foreach($fortalezas as $f): ?>
                    <li><?= htmlspecialchars($f->fortaleza) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No hay fortalezas registradas aún.</p>
        <?php endif; ?>
    </div>

    <!-- DEBILIDADES -->
    <div class="foda-section">
        <h2>Debilidades</h2>
        <?php if (!empty($debilidades)): ?>
            <ul>
                <?php foreach($debilidades as $d): ?>
                    <li><?= htmlspecialchars($d->debilidad) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No hay debilidades registradas aún.</p>
        <?php endif; ?>
    </div>

    <!-- OPORTUNIDADES -->
    <div class="foda-section">
        <h2>Oportunidades</h2>
        <?php if (!empty($oportunidades)): ?>
            <ul>
                <?php foreach($oportunidades as $o): ?>
                    <li><?= htmlspecialchars($o->oportunidad) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No hay oportunidades registradas aún.</p>
        <?php endif; ?>
    </div>

    <!-- AMENAZAS -->
    <div class="foda-section">
        <h2>Amenazas</h2>
        <?php if (!empty($amenazas)): ?>
            <ul>
                <?php foreach($amenazas as $a): ?>
                    <li><?= htmlspecialchars($a->amenaza) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No hay amenazas registradas aún.</p>
        <?php endif; ?>
    </div>
</div>
