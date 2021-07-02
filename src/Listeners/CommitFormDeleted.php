<?php

namespace StatamicVaporCompatibility\Listeners;

use StatamicVaporCompatibility\Traits\GitManageable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Statamic\Events\FormDeleted;

class CommitFormDeleted
{
    use GitManageable;

    /**
     * Handle the event.
     *
     * @param FormDeleted $event
     * @return void
     */
    public function handle(FormDeleted $event)
    {
        $this->commitAsDeleted($event);
    }
}
