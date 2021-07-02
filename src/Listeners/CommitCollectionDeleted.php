<?php

namespace StatamicVaporCompatibility\Listeners;

use StatamicVaporCompatibility\Traits\GitManageable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Statamic\Events\CollectionDeleted;

class CommitCollectionDeleted
{
    use GitManageable;

    /**
     * Handle the event.
     *
     * @param CollectionDeleted $event
     * @return void
     */
    public function handle(CollectionDeleted $event)
    {
        $this->commitAsDeleted($event);
    }
}
