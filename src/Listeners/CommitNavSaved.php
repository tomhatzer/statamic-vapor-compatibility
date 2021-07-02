<?php

namespace StatamicVaporCompatibility\Listeners;

use StatamicVaporCompatibility\Traits\GitManageable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Statamic\Events\NavSaved;
use Statamic\Structures\Nav;

class CommitNavSaved
{
    use GitManageable;

    /**
     * Handle the event.
     *
     * @param NavSaved $event
     * @return void
     */
    public function handle(NavSaved $event)
    {
        /** @var Nav $nav */
        $nav = $event->nav;

        // realpath() will resolve the symlink into the temporary directory
        $path = realpath(
            $nav->path()
        );

        $this->commitAsAdded($event, $path);
    }
}
