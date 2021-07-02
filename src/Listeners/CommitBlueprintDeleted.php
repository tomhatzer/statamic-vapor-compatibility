<?php

namespace StatamicVaporCompatibility\Listeners;

use StatamicVaporCompatibility\Traits\GitManageable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Statamic\Events\BlueprintDeleted;

class CommitBlueprintDeleted
{
    use GitManageable;

    /**
     * Handle the event.
     *
     * @param BlueprintDeleted $event
     * @return void
     */
    public function handle(BlueprintDeleted $event)
    {
        $this->commitAsDeleted($event);
    }
}
