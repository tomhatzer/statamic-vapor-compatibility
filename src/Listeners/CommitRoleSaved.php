<?php

namespace StatamicVaporCompatibility\Listeners;

use StatamicVaporCompatibility\Traits\GitManageable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Statamic\Events\RoleSaved;

class CommitRoleSaved
{
    use GitManageable;

    /**
     * Handle the event.
     *
     * @param RoleSaved $event
     * @return void
     */
    public function handle(RoleSaved $event)
    {
        // realpath() will resolve the symlink into the temporary directory
        $path = realpath(
            resource_path('users/roles.yaml')
        );

        $this->commitAsAdded($event, $path);
    }
}
