<?php

namespace App\Actions;

use Statamic\Actions\Action;
use Statamic\Contracts\Entries\Entry;

class Delete extends Action
{
    protected $dangerous = true;

    public function run($items, $values)
    {
        $items->each(function($item) {
           if(is_null($item->origin())) {
               $item->translations->each->delete();
           }

           $item->delete();
        });

        return trans_choice('Item deleted.|:count items deleted.', $items);
    }

    public function visibleTo($item)
    {
        return $item instanceof Entry;
    }
}
