<?php
namespace Dino\Play;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

require __DIR__.'/../vendor/autoload.php';

$cachedContainer = __DIR__.'/cached_container.php';

$start = microtime(true);
if(!file_exists($cachedContainer)) {

$container = new ContainerBuilder();
$container->setParameter('root_dir', __DIR__);
$loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/config'));
$loader->load('services.yaml');

/* $loggerDefinition = new Definition('Monolog\Logger');
$loggerDefinition->setArguments(array('main', array(new Reference('logger.stream_handler'))));
$loggerDefinition->addMethodCall('pushHandler', array(new Reference(('logger.std_out_handler'))));
$loggerDefinition->addMethodCall('debug', array('Logger just got started'));

$handlerDefinition = new Definition('Monolog\Handler\StreamHandler');
$handlerDefinition->setArguments(array(__DIR__.'/dino.log'));
$container->setDefinition('logger.stream_handler', $handlerDefinition);

$stdOutLoggerDefinition = new Definition('Monolog\Handler\StreamHandler');
$stdOutLoggerDefinition->setArguments(array('php://stdout'));

$container->setDefinition('logger.std_out_handler', $stdOutLoggerDefinition);
$container->setDefinition('logger', $loggerDefinition); */

$container->compile();
$dumper = new PhpDumper($container);

\file_put_contents(__DIR__.'/cached_container.php', $dumper->dump());
}

require $cachedContainer;
$container = new \ProjectServiceContainer();

runApp($container);
$elapsed = round((microtime(true) - $start) * 1000);
$container->get('logger')->debug('Elapsed Time: '.$elapsed.'ms');

function runApp(ContainerInterface $container)
{
    $container->get('logger')->info('ROOOOOR');
}