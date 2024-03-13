<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SupportMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\Contact;
use Illuminate\Support\Facades\Hash;

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

    function updateUserData(Request $request, $phoneNumber)
    {
        $user = User::findOrFail($phoneNumber);

        // Validazione dei dati inviati
        $request->validate([
            'nome' => 'required|string|max:255',
            'cognome' => 'required|string|max:255',
            'avatar' => 'nullable|image|max:2048', // Immagine con dimensione massima di 2MB
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id, // L'email deve essere unica, escludendo l'email dell'utente attuale
            'password' => 'nullable|string|min:8|confirmed', // La password deve avere almeno 8 caratteri e corrispondere al campo di conferma
        ]);

        // Aggiornamento dei campi
        $user->nome = $request->input('nome');
        $user->cognome = $request->input('cognome');
        $user->email = $request->input('email');

        // Aggiornamento dell'avatar se è stato fornito
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarPath = $avatar->store('avatars', 'public'); // Memorizza l'avatar nella cartella 'public/avatars'
            $user->avatar = $avatarPath;
        }

        // Aggiornamento della password se è stata fornita
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->save(); // Salva le modifiche

        return response()->json(['message' => 'Dati utente aggiornati con successo']);
    }
}
