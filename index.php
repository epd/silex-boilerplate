<?php
/**
 * @file
 * Application router file.
 */

// Initialize our Silex-based app
require_once __DIR__ . '/system/silex.phar';
$app = new Silex\Application();

// Turn Silex debugging on
$app['debug'] = TRUE;

// Initialize namespaces, routing, and other components
require_once __DIR__ . '/system/init.php';

// All systems are go!
$app->run();
