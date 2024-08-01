<?php

namespace App\Jobs;

use App\Mail\NotificationMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendNotificationMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $employeeProcedure;

    public function __construct($employeeProcedure)
    {
        $this->employeeProcedure = $employeeProcedure;
    }

    public function handle()
    {
        Mail::to($this->employeeProcedure->employee->trainner_email)
            ->send(new NotificationMail($this->employeeProcedure));
    }
}
