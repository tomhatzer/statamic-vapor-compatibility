<?php

namespace StatamicVaporCompatibility\Listeners;

use StatamicVaporCompatibility\Traits\GitManageable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Statamic\Auth\File\User;
use Statamic\Events\UserSaved;

class CommitUserSaved
{
    use GitManageable;

    /**
     * Handle the event.
     *
     * @param UserSaved $event
     * @return void
     */
    public function handle(UserSaved $event)
    {
        /** @var User $user */
        $user = $event->user;

        // realpath() will resolve the symlink into the temporary directory
        $path = realpath(
            $user->path()
        );

        $this->commitAsAdded($event, $path);
    }
}
