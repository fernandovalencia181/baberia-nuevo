<div class="titulo-seccion">
    <img src="/build/img/calendar-week.svg"/>
    <p>Mis Citas</p>
</div>

<?php include_once __DIR__ . '/../templates/menu.php'; ?>

<?php if (empty($citas)): ?>
    <h3>No tienes citas activas</h3>
<?php else: ?>

    <?php
    // Agrupamos los servicios por ID de cita
    $citasAgrupadas = [];
    foreach ($citas as $cita) {
        $citasAgrupadas[$cita->id]['fecha'] = $cita->fecha;
        $citasAgrupadas[$cita->id]['hora'] = $cita->hora;
        $citasAgrupadas[$cita->id]['barbero'] = $cita->barbero;
        $citasAgrupadas[$cita->id]['servicios'][] = [
            'nombre' => $cita->servicio,
            'precio' => $cita->precio
        ];
    }
    ?>

    <ul class="citas">
        <?php foreach ($citasAgrupadas as $id => $info): ?>
            <li>
                <?php $fechaFormateada = date("d-m-Y", strtotime($info['fecha'])); ?>
                <p><strong>Fecha:</strong> <span><?= $fechaFormateada ?></span></p>
                <p><strong>Hora:</strong> <span><?= substr($info['hora'], 0, 5) ?></span></p>
                <p><strong>Barbero:</strong> <span><?= htmlspecialchars($info['barbero']) ?></span></p>

                <h3>Servicios</h3>
                <?php foreach ($info['servicios'] as $servicio): ?>
                    <p class="servicio"><?= htmlspecialchars($servicio['nombre']) ?> - $ <?= htmlspecialchars($servicio['precio']) ?></p>
                <?php endforeach; ?>

                <form action="/api/eliminar" method="POST">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <input type="hidden" name="csrf_token" value="<?= generarTokenCSRF() ?>">
                    <input type="button" class="boton-eliminar" value="Cancelar Cita">
                </form>
            </li>
        <?php endforeach; ?>
    </ul>

<?php endif; ?>
