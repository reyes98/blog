<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\SentContactMeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactMeController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:50'],
            'phone' => ['required', 'string', 'max:20'],
            'message' => ['required', 'string', 'max:200'],
        ]);

        Mail::to('guapacha2@hotmail.com')->send(new SentContactMeMail($data));

        return response()->json([
            'message' => 'Your message has been submitted successfully.',
        ]);
    }
    
}
