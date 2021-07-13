<?php

namespace App\Console\Commands;

use App\Mail\NotifyUsers;
use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class Notify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'mail notification';

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
        // $users = User::select('email')->get();
        $users = User::pluck('email')->toArray();
        foreach ($users as $user) {
            Mail::to($user)->send(new NotifyUsers());
        }
        // Mail::to(User::select('email'))->send(new NotifyUsers);
    }
}