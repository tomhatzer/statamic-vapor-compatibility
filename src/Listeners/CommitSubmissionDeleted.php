<?php

namespace StatamicVaporCompatibility\Listeners;

use StatamicVaporCompatibility\Traits\GitManageable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Statamic\Events\SubmissionDeleted;

class CommitSubmissionDeleted
{
    use GitManageable;

    /**
     * Handle the event.
     *
     * @param SubmissionDeleted $event
     * @return void
     */
    public function handle(SubmissionDeleted $event)
    {
        $this->commitAsDeleted($event);
    }
}
