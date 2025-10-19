<?php
// ---------------------------
// Configuración de errores
// ---------------------------
// Suprimir Deprecated y mostrar solo errores críticos
error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);
ini_set('display_errors', 1); // 1 en desarrollo, 0 en producción

// Crear carpeta logs si no existe
$logDir = __DIR__ . '/../logs';
if (!is_dir($logDir)) {
    mkdir($logDir, 0755, true);
}

// Definir archivo de log
ini_set('log_errors', 1);
ini_set('error_log', $logDir . '/error.log');

// ---------------------------
// Cargar dependencias
// ---------------------------
require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use Model\ActiveRecord;

// Cargar variables de entorno
$dotenv = Dotenv::createImmutable(__DIR__);
if (function_exists('opcache_reset')) opcache_reset();
$dotenv->safeLoad();

error_log("DB_HOST=" . ($_ENV['DB_HOST'] ?? 'NO DEFINIDO'));
error_log("DB_USER=" . ($_ENV['DB_USER'] ?? 'NO DEFINIDO'));
error_log("DB_NAME=" . ($_ENV['DB_NAME'] ?? 'NO DEFINIDO'));
error_log("SMTP_FROM_NAME=" . ($_ENV['SMTP_FROM_NAME'] ?? 'NO DEFINIDO'));

// Funciones y base de datos
require __DIR__ . '/funciones.php';
require __DIR__ . '/database.php';

// Conectarnos a la base de datos
ActiveRecord::setDB($db);
