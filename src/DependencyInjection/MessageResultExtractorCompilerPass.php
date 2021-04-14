<?php
declare(strict_types=1);

namespace Jamarcer\SymfonyMessengerBundle\DependencyInjection;

use Jamarcer\SymfonyMessengerBundle\Bus\AllHandledStampExtractor;
use Jamarcer\SymfonyMessengerBundle\Bus\LastHandledStampExtractor;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

final class MessageResultExtractorCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $container->addDefinitions(
            [
                'dddap.messenger.bus.all_handled.extractor' => new Definition(AllHandledStampExtractor::class),
                'dddap.messenger.bus.last_handled.extractor' => new Definition(LastHandledStampExtractor::class),
            ],
        );
    }
}
