<?php

namespace StatamicVaporCompatibility\Listeners;

use StatamicVaporCompatibility\Traits\GitManageable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Statamic\Events\TermDeleted;

class CommitTermDeleted
{
    use GitManageable;

    /**
     * Handle the event.
     *
     * @param TermDeleted $event
     * @return void
     */
    public function handle(TermDeleted $event)
    {
        $this->commitAsDeleted($event);
    }
}
