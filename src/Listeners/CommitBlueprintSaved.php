<?php

namespace StatamicVaporCompatibility\Listeners;

use StatamicVaporCompatibility\Traits\GitManageable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Statamic\Events\BlueprintSaved;
use Statamic\Fields\Blueprint;

class CommitBlueprintSaved
{
    use GitManageable;

    /**
     * Handle the event.
     *
     * @param BlueprintSaved $event
     * @return void
     */
    public function handle(BlueprintSaved $event)
    {
        /** @var Blueprint $blueprint */
        $blueprint = $event->blueprint;

        // realpath() will resolve the symlink into the temporary directory
        $path = realpath(
            $blueprint->path()
        );

        $this->commitAsAdded($event, $path);
    }
}
