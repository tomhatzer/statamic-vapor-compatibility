<?php

namespace StatamicVaporCompatibility\Listeners;

use StatamicVaporCompatibility\Traits\GitManageable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Statamic\Events\CollectionTreeDeleted;

class CommitCollectionTreeDeleted
{
    use GitManageable;

    /**
     * Handle the event.
     *
     * @param CollectionTreeDeleted $event
     * @return void
     */
    public function handle(CollectionTreeDeleted $event)
    {
        $this->commitAsDeleted($event);
    }
}
