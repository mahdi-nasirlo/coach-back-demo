<?php

namespace App\Enums;

use App\Traits\EnumHelperTrait;

enum ProductTypeEnums: string
{

    use EnumHelperTrait;

    case PRODUCT = "product";
    case SERVICE = "service";

    case  MEET = "meet";

}
