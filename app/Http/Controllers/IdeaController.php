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
            'content' => 'required|min:3|max:240',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);
        $content = request()->get('content', '');

        $imageName = time() . '.' . request()->image->getClientOriginalExtension();

        request()->image->move(public_path('images'), $imageName);

        Idea::create([
            'content' => $content,
            'image' => $imageName,
        ]);

        return redirect()->route('dashboard')->with('success', 'Idea was created successfully!');
    }

    public function destroy(Idea $id)
    {
        $id->delete();

        return redirect()->route('dashboard')->with('success', 'Deleted Idea');
    }
}
