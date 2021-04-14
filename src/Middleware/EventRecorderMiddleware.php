<?php
declare(strict_types=1);

namespace Jamarcer\SymfonyMessengerBundle\Middleware;

use Jamarcer\DDD\Domain\Model\DomainEvent;
use Jamarcer\DDD\Infrastructure\Repository\EventStoreRepository;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;

final class EventRecorderMiddleware implements MiddlewareInterface
{
    private EventStoreRepository $eventStore;

    public function __construct(EventStoreRepository $eventStore)
    {
        $this->eventStore = $eventStore;
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $message = $envelope->getMessage();

        if ($message instanceof DomainEvent) {
            $this->eventStore->add($message);
        }

        return $stack->next()->handle($envelope, $stack);
    }
}
