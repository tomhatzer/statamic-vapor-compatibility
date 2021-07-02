<?php

namespace StatamicVaporCompatibility\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Str;

class StatamicVaporFileModificationSubscriber
{
    /**
     * Handle the event.
     *
     * @param  object  $events
     * @return void
     */
    public function subscribe($events)
    {
        collect(config('statamic-vapor-compatibility.events'))->each(function($listener, $event) use($events) {
            $events->listen(
                $event,
                [$listener, 'handle'],
            );
        });
    }
}
