<?php

namespace StatamicVaporCompatibility\Listeners;

use StatamicVaporCompatibility\Tools\TemporaryStorage;
use StatamicVaporCompatibility\Traits\GitManageable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Statamic\Events\CollectionTreeSaved;
use Statamic\Structures\Tree;

class CommitCollectionTreeSaved
{
    use GitManageable;

    /**
     * Handle the event.
     *
     * @param CollectionTreeSaved $event
     * @return void
     */
    public function handle(CollectionTreeSaved $event)
    {
        /** @var Tree $tree */
        $tree = $event->tree;

        // realpath() will resolve the symlink into the temporary directory
        $path = realpath(
            $tree->path()
        );

        $this->commitAsAdded($event, $path);
    }
}
