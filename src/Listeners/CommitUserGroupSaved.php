<?php

namespace StatamicVaporCompatibility\Listeners;

use StatamicVaporCompatibility\Traits\GitManageable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Statamic\Auth\File\UserGroup;
use Statamic\Events\UserGroupSaved;
use function resource_path;

class CommitUserGroupSaved
{
    use GitManageable;

    /**
     * Handle the event.
     *
     * @param UserGroupSaved $event
     * @return void
     */
    public function handle(UserGroupSaved $event)
    {
        // realpath() will resolve the symlink into the temporary directory
        $path = realpath(
            resource_path('users/groups.yaml')
        );

        $this->commitAsAdded($event, $path);
    }
}
