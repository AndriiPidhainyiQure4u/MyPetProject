<?php

declare(strict_types=1);

namespace App\Exception;

final class BookCategoryNotFoundException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Book category not found');
    }
}
