<?php

namespace StatamicVaporCompatibility\Listeners;

use StatamicVaporCompatibility\Traits\GitManageable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Statamic\Events\TaxonomySaved;
use Statamic\Taxonomies\Taxonomy;

class CommitTaxonomySaved
{
    use GitManageable;

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(TaxonomySaved $event)
    {
        /** @var Taxonomy $taxonomy */
        $taxonomy = $event->taxonomy;

        // realpath() will resolve the symlink into the temporary directory
        $path = realpath(
            $taxonomy->path(),
        );

        $this->commitAsAdded($event, $path);
    }
}
