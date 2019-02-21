<?php

namespace App\Listeners;

use App\Events\WordDiscovered;
use App\Services\MecabService;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class WordDiscoveryNotification
 * @package App\Listeners
 */
class WordDiscoveryNotification implements ShouldQueue
{
    protected $mecabService;
    
    /**
     * Create the event listener.
     *
     * @param MecabService $mecabService
     */
    public function __construct(MecabService $mecabService)
    {
        \Log::debug('WordDiscoveryNotificationListener start.');
        $this->mecabService = $mecabService;
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
        \Log::debug($event->word);
        $this->mecabService->putWords($this->mecabService->separateWord($event->word));
        \Log::debug('WordDiscoveryNotificationListener end.');
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
