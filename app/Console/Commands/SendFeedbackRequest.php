<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

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
        $proposals = DB::table('proposals')
            ->where('delivery_time', '<', Carbon::now()->format('Y-m-d'))
            ->get();
    
        if ($proposals->isEmpty()) {
            Log::debug('No proposals found for the given condition.');
            return;
        }
    
        foreach ($proposals as $proposal) {
            DB::table('feedback')->insert([
                'from_user' => $proposal->to_user,
                'to_user' => $proposal->from_user,
            ]);
    
            DB::table('proposals')->where('id', $proposal->id)->delete();
        }
    
        Log::debug('Feedback records created and proposals deleted successfully.');
    }
    
    
} 
