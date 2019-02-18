<?php

namespace App\Listeners;

use App\Events\WordDiscovered;
use Illuminate\Contracts\Queue\ShouldQueue;

class WordDicoveryNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        \Log::debug('WordDicoveryNotificationListener start.');
    }

    /**
     * Handle the event.
     *
     * @param  WordDiscovered  $event
     * @return void
     */
    public function handle(WordDiscovered $event)
    {
        \Log::debug('WordDiscovered handle');
    }

    /**
     * 失敗したジョブの処理
     *
     * @param  \App\Events\WordDiscovered $event
     * @param  \Exception  $exception
     * @return void
     */
    public function failed(WordDiscovered $event, $exception)
    {
        // TODO
    }
}
