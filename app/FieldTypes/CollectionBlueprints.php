<?php

namespace App\FieldTypes;

use Statamic\CP\Column;
use Statamic\Facades\Collection;
use Statamic\Facades\Entry;
use Statamic\Facades\GraphQL;
use Statamic\Fieldtypes\Relationship;
use Statamic\GraphQL\Types\CollectionType;

class CollectionBlueprints extends Relationship
{
    protected $categories = ['relationship'];
    protected $canEdit = false;
    protected $canCreate = false;
    protected $canSearch = false;
    protected $statusIcons = false;

    protected function toItemArray($id, $site = null)
    {
            [$collectionHandle, $blueprintHandle] = explode('.', $id);
            $collection = Collection::findByHandle($collectionHandle);
            $blueprint = $collection->entryBlueprints()->filter(function ($item) use ($blueprintHandle) {
                return $item->handle() === $blueprintHandle;
            })->first();
            return [
                'title' => $blueprint->title() .' ('.$collection->title().')',
                'id' => $id,
            ];

    }

    public function getIndexItems($request)
    {
        $blueprints = [];

        foreach (Collection::all() as $collection) {
            foreach ($collection->entryBlueprints()->all() as $blueprint) {
                $blueprints[] = [
                    'id' => $collection->handle() .'.'. $blueprint->handle(),
                    'title' => $blueprint->contents()['title'] . ' ('.$collection->title().')',
                ];
            }
        }

        return $blueprints;
    }

    protected function getColumns()
    {
        return [
            Column::make('title'),
        ];
    }

    protected function augmentValue($value)
    {
        [$collectionHandle, $blueprintHandle] = explode('.', $value);

        return Entry::query()
            ->where('collection', $collectionHandle)
            ->where('blueprint', $blueprintHandle)
            ->get()
        ;
    }

    public function toGqlType()
    {
        $type = GraphQL::type(CollectionType::NAME);

        if ($this->config('max_items') !== 1) {
            $type = GraphQL::listOf($type);
        }

        return $type;
    }
}
