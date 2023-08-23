<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\RabbitMQController;

class MQConsumerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mq:consumer-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consume the mq queue';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $mqService = new RabbitMQController();
        $mqService->receive();
    }
}
