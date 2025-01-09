<?php

declare(strict_types=1);

namespace App\Domain\Enum;

final class CategoryEnum
{
    public const BOOTS_CATEGORY = 'boots';
    public const SANDALS_CATEGORY = 'sandals';
    public const SNEAKERS_CATEGORY = 'sneakers';

    public const AVAILABLE_CATEGORIES = [
        self::BOOTS_CATEGORY,
        self::SANDALS_CATEGORY,
        self::SNEAKERS_CATEGORY,
    ];
}
