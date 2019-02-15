<?php

namespace App\Listeners;

use App\Events\WordDiscovered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class WordDicoveryNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  WordDiscovered  $event
     * @return void
     */
    public function handle(WordDiscovered $event)
    {
        sleep(5);
        \Log::info('@@@@@');
    }
}
