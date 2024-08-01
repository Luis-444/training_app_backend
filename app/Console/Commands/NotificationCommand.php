<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificationMail;

class NotificationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para enviar nofiticacion al correo';

    /**
     * Execute the console command.
     * @return int
     */
    public function handle()
    {
        Mail::to('admin@gmail.com')->send(new NotificationMail);
        return Command::SUCCESS;
    }
}
