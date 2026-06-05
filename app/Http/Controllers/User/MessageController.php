<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Contact::where('user_id', auth()->id())->latest()->paginate(10);
        return view('user.messages.index', compact('messages'));
    }
}
