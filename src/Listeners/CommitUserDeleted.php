<?php

namespace StatamicVaporCompatibility\Listeners;

use StatamicVaporCompatibility\Traits\GitManageable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Statamic\Events\UserDeleted;

class CommitUserDeleted
{
    use GitManageable;

    /**
     * Handle the event.
     *
     * @param UserDeleted $event
     * @return void
     */
    public function handle(UserDeleted $event)
    {
        $this->commitAsDeleted($event);
    }
}
