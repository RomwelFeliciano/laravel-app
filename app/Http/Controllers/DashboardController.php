<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeEmail;
use App\Models\Idea;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // For Testing the View of Email
        // return new WelcomeEmail(auth()->user());

        // Inline Eager Loading in the controller but much better to do it inside the model
        // $ideas = Idea::with('user', 'comments.user')->orderBy('created_at', 'DESC');
        $ideas = Idea::orderBy('created_at', 'DESC');

        if (request()->has('search')) {
            $ideas = $ideas->where('content', 'like', '%' . request()->get('search', '') . '%');
        }

        return view('dashboard', [
            'ideas' => $ideas->paginate(5),
        ]);
    }

    public function terms()
    {
        return view('terms');
    }
}
