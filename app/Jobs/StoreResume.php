<?php

namespace App\Jobs;

use App\Resume;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StoreResume implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $resume;

    /**
     * Create a new job instance.
     *
     * @param Resume $resume
     */
    public function __construct(Resume $resume)
    {
        $this->resume = $resume;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        logs()->info("Created new resume: {$this->resume->id}");
    }
}
