<?php

namespace StatamicVaporCompatibility\Listeners;

use StatamicVaporCompatibility\Traits\GitManageable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Statamic\Events\TermSaved;
use Statamic\Taxonomies\Term;
use function realpath;

class CommitTermSaved
{
    use GitManageable;

    /**
     * Handle the event.
     *
     * @param TermSaved $event
     * @return void
     */
    public function handle(TermSaved $event)
    {
        /** @var Term $term */
        $term = $event->term;

        // realpath() will resolve the symlink into the temporary directory
        $path = realpath(
            $term->path(),
        );

        $this->commitAsAdded($event, $path);
    }
}
