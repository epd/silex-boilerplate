<?php
/**
 * @file
 * Initialization file.
 *
 * Registers namespaces, adds components, handles routes and LESS compilation.
 */

// Register namespace for Silex Extensions
$app['autoloader']->registerNamespace('SilexExtension', __DIR__ . '/vendor/silex-extension/src');
$app['autoloader']->registerNamespace('evNN', __DIR__ . '/vendor/evNN/less-service-provider/src');
$app['autoloader']->registerNamespace('LessElephant', __DIR__ . '/vendor/cypresslab/less-elephant/src');
$app['autoloader']->registerNamespace('Symfony\\Component\\Finder', __DIR__ . '/vendor/symfony/finder');
$app['autoloader']->registerNamespace('Symfony\\Component\\Process', __DIR__ . '/vendor/symfony/process');

// Symfony Request and Response components
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Process\Process;

// Include Monolog to add application debug logging
$app->register(new Silex\Provider\MonologServiceProvider(), array(
  'monolog.class_path' => __DIR__ . '/vendor/monolog/monolog/src',
  'monolog.logfile'    => __DIR__ . '/logs/app.log',
));

// Include Twig component for template rendering
$app->register(new Silex\Provider\TwigServiceProvider(), array(
  'twig.path'       => __DIR__ . '/../app/templates',
  'twig.class_path' => __DIR__ . '/vendor/twig/twig/lib',
));

// Include Doctrine/MongoDB component for database connection
$app->register(new SilexExtension\MongoDbExtension(), array(
  'mongodb.class_path' => __DIR__ . '/vendor/mongodb/lib',
  'mongodb.connection' => array(
    'server' => 'mongodb://localhost',
  )
));

// Include the LESS CSS component
$app->register(new evNN\Silex\Less\LessServiceProvider(), array(
  'less.less_dir' => __DIR__ . '/../assets/less',
  'less.app_less' => 'app.less',
  'less.app_css'  => __DIR__ . '/../assets/css/app.css',
  'less.flags'    => '--yui-compress',
));

// Inject our application routes
require_once __DIR__ . "/../app/routes.php";

// Compile LESS files in a "before" filter
$app->before(function () use($app) {

  // Check if we need to compile or not
  if (!$app['less']->isClean()) {
    // Execute our compile command with optional debug parameters
    $cmd = sprintf('%s' . (!$app['debug'] ? ' ' . $app['less.flags'] : '') . ' %s > %s', $app['less']->getLessBinary()->getPath(), $app['less']->getSourceFolder() . '/' . $app['less']->getSourceFile(), $app['less']->getDestination());
    $process = new Process($cmd, $app['less']->getSourceFolder());
    $process->run();

    // Throw error in debug mode
    if ($app['debug'] && !$process->isSuccessful()) {
      $app['monolog']->addError('LESS compilation failed. Turn on debug mode for more info.');
      throw new \RuntimeException($process->getErrorOutput());
    }
  }
});
