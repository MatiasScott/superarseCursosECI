<?php

// Base de datos
define('DB_HOST', getenv('DB_HOST') ?: 'mariadb');
define('DB_NAME', getenv('DB_NAME') ?: 'superar1_sistema_educacion_continua');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');

// PayPhone
define('PAYPHONE_TOKEN', getenv('PAYPHONE_TOKEN') ?: '');
define('PAYPHONE_STORE_ID', getenv('PAYPHONE_STORE_ID') ?: '');
