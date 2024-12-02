<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use Illuminate\Http\Request;

class IdeaController extends Controller
{
    //
    public function store()
    {
        request()->validate([
            'idea' => 'required|min:3|max:240',
        ]);
        $content = request()->get('idea', '');

        Idea::create([
            'content' => $content,
        ]);

        return redirect()->route(route: 'dashboard')->with('success', 'Idea was created successfully!');
    }

    public function destroy(Idea $id)
    {
       $id->delete();

        return redirect()->route('dashboard')->with('success', 'Deleted Idea');
    }
}
