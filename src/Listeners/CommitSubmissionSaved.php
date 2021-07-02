<?php

namespace StatamicVaporCompatibility\Listeners;

use StatamicVaporCompatibility\Traits\GitManageable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Statamic\Events\SubmissionSaved;
use Statamic\Forms\Submission;

class CommitSubmissionSaved
{
    use GitManageable;

    /**
     * Handle the event.
     *
     * @param SubmissionSaved $event
     * @return void
     */
    public function handle(SubmissionSaved $event)
    {
        /** @var Submission $submission */
        $submission = $event->submission;

        // realpath() will resolve the symlink into the temporary directory
        $path = realpath(
            $submission->getPath()
        );

        $this->commitAsAdded($event, $path);
    }
}
