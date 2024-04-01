<?php

namespace App\Observers;

use App\Models\CollectionTranslation;

class CollectionTranslationObserver
{

    public function creating(CollectionTranslation $collection): void
    {
        if (is_null($collection->slug))
        {
            $collection->slug = slugGenerator($collection->name);
        }else
            slugGenerator($collection->slug);
    }

}
