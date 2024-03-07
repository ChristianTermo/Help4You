<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SupportMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\Contact;

class MeController extends Controller
{
    function disableProfile()
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        $user->disbled = true;

        return $user;
    }

    public function submitSupportForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'firstName' => 'required',
            'lastName' => 'required',
            'reason' => 'required',
            'attachments' => 'required',
            'description' => 'required',
        ]);

        Mail::to("support@mail.it")->send(new SupportMail(
            $request->email,
            $request->firstName,
            $request->lastName,
            $request->reason,
            $request->attachments,
            $request->description
        ));

        return 'We have e-mailed!';
    }

    public function saveContact(Request $request)
    {
        $contactsData = $request->json()->all();

        if (!isset($contactsData) || !is_array($contactsData)) {
            return response()->json(['error' => 'Dati dei contatti non validi'], 400);
        }

        foreach ($contactsData as $contactData) {

            $phoneNumbers = $contactData['phoneNumbers'] ?? [];

            foreach ($phoneNumbers as $phoneNumberData) {

                if (!isset($phoneNumberData['label']) || !isset($phoneNumberData['number'])) {
                    return response()->json(['error' => 'Dati del numero di telefono non validi'], 400);
                }

                $phoneNumber = new Contact([
                    'label' => $phoneNumberData['label'],
                    'number' => $phoneNumberData['number'],
                    'user_id' => Auth::user()->id
                ]);

                $phoneNumber->save();
            }
        }

        return response()->json(['message' => 'Contatti salvati con successo'], 200);
    }
}
