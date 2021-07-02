<?php

namespace StatamicVaporCompatibility\Listeners;

use StatamicVaporCompatibility\Traits\GitManageable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Statamic\Events\EntryDeleted;

class CommitEntryDeleted
{
    use GitManageable;

    /**
     * Handle the event.
     *
     * @param EntryDeleted $event
     * @return void
     */
    public function handle(EntryDeleted $event)
    {
        $this->commitAsDeleted($event);
    }
}
