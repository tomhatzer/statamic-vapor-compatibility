<?php

namespace StatamicVaporCompatibility\Listeners;

use StatamicVaporCompatibility\Traits\GitManageable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Statamic\Events\GlobalSetDeleted;

class CommitGlobalSetDeleted
{
    use GitManageable;

    /**
     * Handle the event.
     *
     * @param GlobalSetDeleted $event
     * @return void
     */
    public function handle(GlobalSetDeleted $event)
    {
        $this->commitAsDeleted($event);
    }
}
