<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\TestEvent;
use App\Mail\TestMail;
use Illuminate\support\Facades\Mail;
use Throwable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Bus;
use App\Jobs\Jobone;
use App\Jobs\JobTwo;
use App\Jobs\JobThree;

class TestListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */

  
    public function __construct()
    {
        // dd('called');
    }

    /**
     * Handle the event.
     */
    public function handle(TestEvent $event): void
    {
        Bus::chain([
              new Jobone,
               new JobTwo,
              new  JobThree
        ])->dispatch();
        // // dd($event);
        // Mail::to('rayoffical352@gmail.com')->send(new TestMail(['name'=>'Manish']));
    }

    public function failed(Throwable $exception){
         Log::info($exception);
    }
}
