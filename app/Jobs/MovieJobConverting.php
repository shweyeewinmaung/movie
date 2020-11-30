<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Movie;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MovieJobConverting implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
      public $movie;
      public $mm;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Movie $movie,array $mm)
    {
       $this->movie = $movie;
       $this->mm = $mm;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        dd($mm);
    }
}
