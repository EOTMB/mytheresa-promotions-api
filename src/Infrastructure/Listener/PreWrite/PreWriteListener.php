<?php

declare(strict_types=1);

namespace App\Infrastructure\Listener\PreWrite;

use Symfony\Component\HttpKernel\Event\ViewEvent;

interface PreWriteListener
{
    public function onKernelView(ViewEvent $event): void;
}
