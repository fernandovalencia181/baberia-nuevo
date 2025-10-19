<h1 class="nombre-pagina">Agregar Contraseña</h1>
<p class="descripcion-pagina">Crea una contraseña para usar el login tradicional</p>

<?php include_once __DIR__ . "/../templates/alertas.php" ?>

<form class="formulario" method="POST" action="/agregar-password">

    <!-- Teléfono -->
    <div class="campo">
        <label for="telefono">Teléfono <?= $usuario->telefono ? "(ya registrado)" : "(obligatorio)" ?></label>
        <input 
            type="text" 
            id="telefono" 
            name="telefono" 
            placeholder="Tu teléfono"
            value="<?= htmlspecialchars($usuario->telefono ?? '') ?>"
            <?= $usuario->telefono ? 'readonly' : '' ?>
        >
    </div>

    <!-- Contraseña -->
    <?php if(!$usuario->password){ ?>
        <div class="campo">
            <label for="password">Contraseña (opcional)</label>
            <input type="password" id="password" name="password" placeholder="Tu nueva contraseña" autocomplete="new-password">
        </div>

        <div class="campo">
            <label for="password2">Repetir Contraseña (opcional)</label>
            <input type="password" id="password2" name="password2" placeholder="Repite tu contraseña" autocomplete="new-password">
        </div>
    <?php } ?>

    <input type="hidden" name="csrf_token" value="<?php echo generarTokenCSRF(); ?>">
    <input type="submit" class="boton sesion" value="Guardar / Continuar">
</form>

