<?php

namespace App\Jobs;

use App\Models\User;
use DateTime;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Log;


class SendEmailJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $emailData;

    /**
     * Create a new job instance.
     */
    public function __construct($emailData)
    {
        //
        $this->emailData = $emailData;
        Log::info('pidiendo datos |'. $emailData);

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        Log::info('enviando 22 dada |');

    }
}
