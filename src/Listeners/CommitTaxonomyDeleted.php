<?php

namespace StatamicVaporCompatibility\Listeners;

use StatamicVaporCompatibility\Traits\GitManageable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Statamic\Events\TaxonomyDeleted;

class CommitTaxonomyDeleted
{
    use GitManageable;

    /**
     * Handle the event.
     *
     * @param TaxonomyDeleted $event
     * @return void
     */
    public function handle(TaxonomyDeleted $event)
    {
        $this->commitAsDeleted($event);
    }
}
