<?php

namespace StatamicVaporCompatibility\Listeners;

use StatamicVaporCompatibility\Traits\GitManageable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Statamic\Events\UserGroupDeleted;

class CommitUserGroupDeleted
{
    use GitManageable;

    /**
     * Handle the event.
     *
     * @param UserGroupDeleted $event
     * @return void
     */
    public function handle(UserGroupDeleted $event)
    {
        $this->commitAsDeleted($event);
    }
}
