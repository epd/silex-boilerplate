<?php
/**
 * @file
 * Application initialization file.
 *
 * Loads other providers, components, and registers namespaces used in the app.
 */

// Symfony Request and Response components
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// Register namespace for Silex Extensions
$app['autoloader']->registerNamespace('SilexExtension', __DIR__ . '/vendor/silex-extension/src');

// Include Monolog to add application debug logging
$app->register(new Silex\Provider\MonologServiceProvider(), array(
  'monolog.class_path' => __DIR__ . '/vendor/monolog/monolog/src',
  'monolog.logfile'    => __DIR__ . '/logs/app.log',
));

// Include Twig component for template rendering
$app->register(new Silex\Provider\TwigServiceProvider(), array(
  'twig.path'       => __DIR__ . '/app/templates',
  'twig.class_path' => __DIR__ . '/vendor/twig/twig/lib',
));

// Include Doctrine/MongoDB component for database connection
$app->register(new SilexExtension\MongoDbExtension(), array(
  'mongodb.class_path' => __DIR__ . '/vendor/mongodb/lib',
  'mongodb.connection' => array(
    'server' => 'mongodb://localhost',
  )
));
