<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function getFeedback()
    {
        $feedback = Feedback::all()
            ->where('from_user', '=', Auth::user()->id)
            ->where('in_pending', '=', true);

        return $feedback;
    }
    
    public function submitFeedback(Request $request, $id)
    {
        $feedback = Feedback::find($id);

        if (!$feedback) {
            return response()->json(['error' => 'Feedback not found'], 404);
        }

        $feedback->rate = $request->input('rate');
        $feedback->rate = $request->input('rate');
        $feedback->notes = $request->input('notes');
        $feedback->in_pending = false;
        $feedback->save();

        return response()->json($feedback);
    }


    public function editFeedback(Request $request, $id)
    {
        $request->validate([
            'rate' => 'required|between:1,5',
            'notes' => 'required',
        ]);

        $feedback = Feedback::find($id);
        $feedback->rate = $request->input('rate');
        $feedback->notes = $request->input('notes');
        $feedback->save();

        return $feedback;
    }
}
