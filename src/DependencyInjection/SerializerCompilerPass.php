<?php
declare(strict_types=1);

namespace Jamarcer\SymfonyMessengerBundle\DependencyInjection;

use Jamarcer\DDD\Util\Message\Serialization\JsonApi\AggregateMessageJsonApiSerializable;
use Jamarcer\DDD\Util\Message\Serialization\JsonApi\AggregateMessageStreamDeserializer;
use Jamarcer\DDD\Util\Message\Serialization\JsonApi\SimpleMessageJsonApiSerializable;
use Jamarcer\DDD\Util\Message\Serialization\JsonApi\SimpleMessageStreamDeserializer;
use Jamarcer\DDDLogging\DomainTrace\Tracker;
use Jamarcer\SymfonyMessengerBundle\Serializer\AggregateMessageSerializer;
use Jamarcer\SymfonyMessengerBundle\Serializer\SimpleMessageSerializer;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

final class SerializerCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $container->register(Tracker::class, Tracker::class);

        $container->addDefinitions([
            'dddap.messenger.aggregate_message.serializer' => new Definition(
                AggregateMessageSerializer::class,
                [
                    new Reference(Tracker::class),
                    new Reference('dddap.messenger.aggregate_message.serializer.json_api_serializer'),
                    new Reference('dddap.messenger.aggregate_message.serializer.stream_deserializer'),
                ],
            ),
            'dddap.messenger.aggregate_message.serializer.json_api_serializer' => new Definition(
                AggregateMessageJsonApiSerializable::class,
            ),
            'dddap.messenger.aggregate_message.serializer.stream_deserializer' => new Definition(
                AggregateMessageStreamDeserializer::class,
                [
                    new Reference('dddap.messenger.mapping_registry.aggregate_message'),
                ],
            ),
        ]);

        $container->addDefinitions([
            'dddap.messenger.simple_message.serializer' => new Definition(
                SimpleMessageSerializer::class,
                [
                    new Reference(Tracker::class),
                    new Reference('dddap.messenger.simple_message.serializer.json_api_serializer'),
                    new Reference('dddap.messenger.simple_message.serializer.stream_deserializer'),
                ],
            ),
            'dddap.messenger.simple_message.serializer.json_api_serializer' => new Definition(
                SimpleMessageJsonApiSerializable::class,
            ),
            'dddap.messenger.simple_message.serializer.stream_deserializer' => new Definition(
                SimpleMessageStreamDeserializer::class,
                [
                    new Reference('dddap.messenger.mapping_registry.simple_message'),
                ],
            ),
        ]);
    }
}
