<?php

namespace App\Listeners;

use App\Models\Buoy;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class BuoyCacheListener
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
     * @param object $event
     * @return void
     * @throws \Exception
     */
    public function handle($event){
        Redis::del('buoys:all');
        $buoys = serialize(self::getAllBuoy());
        Redis::set('buoys:all', $buoys);
    }

    private function getAllBuoy() : Collection{
        $buoys = Buoy::with('community')->get();
        return $buoys;
    }
}
