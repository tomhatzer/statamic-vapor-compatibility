<?php

namespace StatamicVaporCompatibility\Listeners;

use StatamicVaporCompatibility\Traits\GitManageable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Statamic\Events\RoleDeleted;

class CommitRoleDeleted
{
    use GitManageable;

    /**
     * Handle the event.
     *
     * @param RoleDeleted $event
     * @return void
     */
    public function handle(RoleDeleted $event)
    {
        $this->commitAsDeleted($event);
    }
}
