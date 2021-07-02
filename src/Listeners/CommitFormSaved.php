<?php

namespace StatamicVaporCompatibility\Listeners;

use StatamicVaporCompatibility\Traits\GitManageable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Statamic\Events\FormSaved;
use Statamic\Forms\Form;

class CommitFormSaved
{
    use GitManageable;

    /**
     * Handle the event.
     *
     * @param FormSaved $event
     * @return void
     */
    public function handle(FormSaved $event)
    {
        /** @var Form $form */
        $form = $event->form;

        // realpath() will resolve the symlink into the temporary directory
        $path = realpath(
            $form->path()
        );

        $this->commitAsAdded($event, $path);
    }
}
