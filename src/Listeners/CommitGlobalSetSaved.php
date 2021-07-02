<?php

namespace StatamicVaporCompatibility\Listeners;

use StatamicVaporCompatibility\Traits\GitManageable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Statamic\Events\GlobalSetSaved;
use Statamic\Globals\GlobalSet;

class CommitGlobalSetSaved
{
    use GitManageable;

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(GlobalSetSaved $event)
    {
        /** @var GlobalSet $globals */
        $globals = $event->globals;

        // realpath() will resolve the symlink into the temporary directory
        $path = realpath(
            $globals->path()
        );

        $this->commitAsAdded($event, $path);
    }
}
