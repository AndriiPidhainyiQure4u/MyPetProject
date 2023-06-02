<?php

declare(strict_types=1);

namespace Modules;

interface Flusher
{
    public function flush(): void;
}
