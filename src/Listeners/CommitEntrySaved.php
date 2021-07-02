<?php

namespace StatamicVaporCompatibility\Listeners;

use StatamicVaporCompatibility\Tools\TemporaryStorage;
use StatamicVaporCompatibility\Traits\GitManageable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Statamic\Entries\Entry;
use Statamic\Events\EntrySaved;
use function base_path;
use function str_replace;

class CommitEntrySaved
{
    use GitManageable;

    /**
     * Handle the event.
     *
     * @param EntrySaved $event
     * @return void
     */
    public function handle(EntrySaved $event)
    {
        /** @var Entry $entry */
        $entry = $event->entry;

        // realpath() will resolve the symlink into the temporary directory
        $path = realpath(
            $entry->path()
        );

        $this->commitAsAdded($event, $path);
    }
}
