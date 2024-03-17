<?php

namespace App\Enums;

use App\Traits\EnumHelperTrait;

enum ProductStatusEnums: string
{
    use EnumHelperTrait;

    case PUBLISH = "published";

    case DRAFT = "draft";

    case PENDING = "pending";

}
