<?php 
    // Aseguramos que la sesión esté disponible para las comprobaciones
    if(!isset($_SESSION)) {
        session_start();
    }
    
    $auth = $_SESSION["login"] ?? false;
    $rol = $_SESSION["rol"] ?? '';
?>

<!-- CASO 1: USUARIO INVITADO (NO LOGUEADO) -->
<?php if(!$auth): ?>
<div class="barra">
    <a href="/" class="logo-link">
        <img src="/build/img/logo-nuevo.png" alt="Logo Barbería">
    </a>

    <div class="menu-guest">
        <a href="/login" class="boton-nav">Iniciar Sesión</a>
    </div>
</div>
<?php endif; ?>


<!-- CASO 2: CLIENTE LOGUEADO (Y NO ADMIN) -->
<?php if($auth === true && $rol !== 'admin'): ?>
<div class="barra">
    <a href="/" class="logo-link">
        <img src="/build/img/logo-nuevo.png" alt="Logo Barbería">
    </a>

    <div class="menu-icon" id="menu-icon-user">
        <img src="/build/img/menu-deep.svg" alt="Menú">
    </div>

    <div class="menu glass-menu" id="menu-user">
        <ul>
            <!-- He cambiado href="/cita" a "/" para que sea consistente con la nueva home -->
            <li><a href="/">Servicios</a></li>
            <li><a href="/perfil">Editar Perfil</a></li>
            <li><a href="/citas">Mis Citas</a></li>
            <li><a href="/logout">Cerrar Sesión</a></li>
        </ul>
    </div>
</div>
<?php endif; ?>


<!-- CASO 3: ADMINISTRADOR -->
<?php if($auth === true && $rol === 'admin'): ?> 
<div class="barra">
    <a href="/admin" class="logo-link">
        <img src="/build/img/logo-nuevo.png" alt="Logo Barbería">
    </a>

    <div class="menu-icon" id="menu-icon-admin">
        <img src="/build/img/menu-deep.svg" alt="Menú">
    </div>

    <div class="menu glass-menu" id="menu-admin">
        <ul>
            <li><a href="/admin">Ver Citas</a></li>
            <li><a href="/servicios">Ver Servicios</a></li>
            <li><a href="/servicios/crear">Agregar Servicio</a></li>
            <li><a href="/barberos">Ver Barberos</a></li>
            <li><a href="/barberos/crear">Agregar Barbero</a></li>
            <li><a href="/bloqueos">Bloqueos</a></li>
            <li><a href="/logout">Cerrar Sesión</a></li>
        </ul>
    </div>
</div>
<?php endif; ?>