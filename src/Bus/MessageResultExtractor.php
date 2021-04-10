<?php
declare(strict_types=1);

namespace Jamarcer\SymfonyMessengerBundle\Bus;

use Symfony\Component\Messenger\Envelope;

interface MessageResultExtractor
{
    public function extract(Envelope $message);
}
