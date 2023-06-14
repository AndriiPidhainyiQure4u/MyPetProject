<?php

declare(strict_types=1);

namespace App\Container;

use Modules\Auth\Service\Tokenizer;

class ResetTokenizerFactory
{
    /**
     * @throws \Exception
     */
    public static function create(string $interval): Tokenizer
    {
        return new Tokenizer(new \DateInterval($interval));
    }
}
