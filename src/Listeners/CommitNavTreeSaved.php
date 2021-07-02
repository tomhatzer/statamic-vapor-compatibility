<?php

namespace StatamicVaporCompatibility\Listeners;

use StatamicVaporCompatibility\Traits\GitManageable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Statamic\Events\NavTreeSaved;
use Statamic\Structures\NavTree;

class CommitNavTreeSaved
{
    use GitManageable;

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(NavTreeSaved $event)
    {
        /** @var NavTree $navTree */
        $navTree = $event->tree;

        // realpath() will resolve the symlink into the temporary directory
        $path = realpath(
            $navTree->path()
        );

        $this->commitAsAdded($event, $path);
    }
}
