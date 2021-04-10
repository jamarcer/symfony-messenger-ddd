<?php
declare(strict_types=1);

namespace Jamarcer\SymfonyMessengerBundle;

use Jamarcer\SymfonyMessengerBundle\DependencyInjection\MappingRegistryCompilerPass;
use Jamarcer\SymfonyMessengerBundle\DependencyInjection\MessageResultExtractorCompilerPass;
use Jamarcer\SymfonyMessengerBundle\DependencyInjection\SerializerCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class SymfonyMessengerBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(
            new MappingRegistryCompilerPass(),
        );

        $container->addCompilerPass(
            new SerializerCompilerPass(),
        );

        $container->addCompilerPass(
            new MessageResultExtractorCompilerPass(),
        );
    }
}
