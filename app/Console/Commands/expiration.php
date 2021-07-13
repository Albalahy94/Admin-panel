<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class expiration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'expire after selected time';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // return 0;
        $users = User::where('expire', 1)->get();
        foreach ($users as $user) {
            $user->update(['expire' => 0]);
        }
    }
}