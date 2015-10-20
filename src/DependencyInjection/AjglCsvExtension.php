<?php
/**
 * This file is part of the AJ General Libraries Bundles
 *
 * Copyright (C) 2010-2014 Antonio J. García Lagar <aj@garcialagar.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Ajgl\Bundle\CsvBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * @author Antonio J. García Lagar <aj@garcialagar.es>
 */
class AjglCsvExtension extends Extension
{
    public function load(array $config, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $config);

        $container->setParameter('ajgl_csv.reader.default_type', $config['reader_default_type']);
        $container->setParameter('ajgl_csv.writer.default_type', $config['writer_default_type']);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('csv.xml');

        $csvDefinition = $container->getDefinition('ajgl_csv');
        $csvDefinition->addMethodCall('setDefaultReaderType', array('%ajgl_csv.reader.default_type%'));
        $csvDefinition->addMethodCall('setDefaultWriterType', array('%ajgl_csv.writer.default_type%'));

    }
}