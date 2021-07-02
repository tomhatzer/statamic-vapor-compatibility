<?php

namespace StatamicVaporCompatibility\Listeners;

use StatamicVaporCompatibility\Tools\TemporaryStorage;
use StatamicVaporCompatibility\Traits\GitManageable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Statamic\Entries\Collection;
use Statamic\Events\CollectionSaved;

class CommitCollectionSaved
{
    use GitManageable;

    /**
     * Handle the event.
     *
     * @param CollectionSaved $event
     * @return void
     */
    public function handle(CollectionSaved $event)
    {
        /** @var Collection $collection */
        $collection = $event->collection;

        // realpath() will resolve the symlink into the temporary directory
        $path = realpath(
            $collection->path()
        );

        $this->commitAsAdded($event, $path);
    }
}
