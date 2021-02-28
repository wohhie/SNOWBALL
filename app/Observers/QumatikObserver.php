<?php

namespace App\Observers;

use App\Models\Qumatik;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redis;

class QumatikObserver
{
    /**
     * Handle the qumatik "created" event.
     *
     * @param  App\Models\Qumatik  $qumatik
     * @return void
     */
    public function created(Qumatik $qumatik){
        Redis::del('qumatiks:all');
        $qumatiks = serialize(self::getAllQUMATIKs());
        Redis::set('qumatiks:all', $qumatiks);
    }

    /**
     * Handle the qumatik "updated" event.
     *
     * @param  \App\Qumatik  $qumatik
     * @return void
     */
    public function updated(Qumatik $qumatik){
        //
        Redis::del('qumatiks:all');
        $qumatiks = serialize(self::getAllQUMATIKs());
        Redis::set('qumatiks:all', $qumatiks);
    }



    /**
     * Handle the qumatik "deleted" event.
     *
     * @param  \App\Qumatik  $qumatik
     * @return void
     */
    public function deleted(Qumatik $qumatik)
    {
        //
        Redis::del('qumatiks:all');
        $qumatiks = serialize(self::getAllQUMATIKs());
        Redis::set('qumatiks:all', $qumatiks);
    }

    /**
     * Handle the qumatik "restored" event.
     *
     * @param  \App\Qumatik  $qumatik
     * @return void
     */
    public function restored(Qumatik $qumatik)
    {
        //
    }

    /**
     * Handle the qumatik "force deleted" event.
     *
     * @param  \App\Qumatik  $qumatik
     * @return void
     */
    public function forceDeleted(Qumatik $qumatik)
    {
        //
    }


    private function getAllQUMATIKs() : Collection{
        $buoys = Qumatik::with('community')->get();
        return $buoys;
    }
}
