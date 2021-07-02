<?php

namespace StatamicVaporCompatibility\Listeners;

use StatamicVaporCompatibility\Traits\GitManageable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Statamic\Events\NavDeleted;

class CommitNavDeleted
{
    use GitManageable;

    /**
     * Handle the event.
     *
     * @param NavDeleted $event
     * @return void
     */
    public function handle(NavDeleted $event)
    {
        $this->commitAsDeleted($event);
    }
}
