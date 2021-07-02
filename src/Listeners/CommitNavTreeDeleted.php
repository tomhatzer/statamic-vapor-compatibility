<?php

namespace StatamicVaporCompatibility\Listeners;

use StatamicVaporCompatibility\Traits\GitManageable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Statamic\Events\NavTreeDeleted;

class CommitNavTreeDeleted
{
    use GitManageable;

    /**
     * Handle the event.
     *
     * @param NavTreeDeleted $event
     * @return void
     */
    public function handle(NavTreeDeleted $event)
    {
        $this->commitAsDeleted($event);
    }
}
