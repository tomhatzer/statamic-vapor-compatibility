<?php

namespace StatamicVaporCompatibility\Listeners;

use StatamicVaporCompatibility\Tools\TemporaryStorage;
use StatamicVaporCompatibility\Traits\GitManageable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Statamic\Events\FieldsetSaved;
use Statamic\Fields\Fieldset;
use function realpath;

class CommitFieldsetSaved
{
    use GitManageable;

    /**
     * Handle the event.
     *
     * @param FieldsetSaved $event
     * @return void
     */
    public function handle(FieldsetSaved $event)
    {
        /** @var Fieldset $fieldset */
        $fieldset = $event->fieldset;

        // realpath() will resolve the symlink into the temporary directory
        $path = realpath(
            resource_path('fieldsets/' . $fieldset->handle() . '.yaml')
        );

        $this->commitAsAdded($event, $path);
    }
}
