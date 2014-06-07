<?php

// CONSTANTES DE CONFIGURATION
// Configuration accès base de données pour PDO
define("BD_USERNAME", "root");
define("BD_PASSWD", "");
define("BD_TYPE", "mysql");
define("BD_HOST", "127.0.0.1");
define("BD_DBNAME", "ldvelh");
define("BD_CHARSET", "utf8");
define("BD_DSN", BD_TYPE . ":host=" . BD_HOST . ";dbname=" . BD_DBNAME . ";charset=" . BD_CHARSET);
