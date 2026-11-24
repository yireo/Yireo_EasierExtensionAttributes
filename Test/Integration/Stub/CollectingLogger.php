<?php declare(strict_types=1);

namespace Yireo\EasierExtensionAttributes\Test\Integration\Stub;

use Psr\Log\AbstractLogger;
use Stringable;

class CollectingLogger extends AbstractLogger
{
    public array $messages = [];

    public function log($level, string|Stringable $message, array $context = []): void
    {
        $this->messages[] = (string)$message;
    }
}
