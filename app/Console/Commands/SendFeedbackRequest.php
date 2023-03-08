<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class SendFeedbackRequest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:feedbackrequest';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send feedback request';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $proposal =  DB::table('proposals')->where('delivery_time', '<', Carbon::now())->get();
        $id =  $proposal->collect()->pluck('id');
        foreach ($id as  $value) {
            $toUser =  DB::table('proposals')->where('delivery_time', '<', Carbon::now())->value('from_user');
            $fromUser = DB::table('proposals')->where('delivery_time', '<', Carbon::now())->value('to_user');
            DB::table('feedback')->when(count($proposal) > 0)->insert([
                'from_user' => $fromUser,
                'to_user' => $toUser
            ]);
            $old =  DB::table('proposals')->where('delivery_time', '<', Carbon::now())->where('id', '=', $value);
            $old->delete();
        }

    }
}
