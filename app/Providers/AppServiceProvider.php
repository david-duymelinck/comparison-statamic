<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Statamic\Facades\Collection;
use Statamic\Facades\Entry;
use Statamic\Statamic;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Collection::computed('pages', 'translations', function($entry, $value) {
            if(is_null($entry->origin())) {
                $entries = Entry::query()
                            ->where('origin', $entry->id())
                            ->get();

            } else {
                $entries = Entry::query()
                            ->where(function($query) use ($entry) {
                                $query->where('origin', $entry->origin()->id())
                                    ->orWhere('id', $entry->origin()->id());
                            })
                            ->where('id', '!=', $entry->id())
                            ->get();
            }

            $siteGroup = $entry->site()->attributes()['group'];

            return $entries->filter(function($item) use ($siteGroup) {
                    return $item->site()->attributes()['group'] === $siteGroup;
                })
                ->all();
        });
    }
}
