<?php

namespace StatamicVaporCompatibility\Listeners;

use StatamicVaporCompatibility\Traits\GitManageable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Statamic\Events\FieldsetDeleted;

class CommitFieldsetDeleted
{
    use GitManageable;

    /**
     * Handle the event.
     *
     * @param FieldsetDeleted $event
     * @return void
     */
    public function handle(FieldsetDeleted $event)
    {
        $this->commitAsDeleted($event);
    }
}
