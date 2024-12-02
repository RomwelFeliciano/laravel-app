<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use Illuminate\Http\Request;

class IdeaController extends Controller
{
    //
    public function show(Idea $idea)
    {
        return view('ideas.show', compact('idea'));
    }

    public function store()
    {
        request()->validate([
            'content' => 'required|min:3|max:240',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $content = request()->get('content', '');

        $imageName = '';

        if (request()->hasFile('image')) {
            $imageName = time() . '.' . request()->image->getClientOriginalExtension();
            request()->image->move(public_path('images'), $imageName);
        }

        Idea::create([
            'content' => $content,
            'image' => $imageName,
        ]);

        return redirect()->route('dashboard')->with('success', 'Idea was created successfully!');
    }

    public function destroy(Idea $idea)
    {
        if ($idea->image) {
            $imagePath = public_path('images/' . $idea->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $idea->delete();

        return redirect()->route('dashboard')->with('success', 'Idea was deleted successfully!');
    }

    public function edit(Idea $idea)
    {
        $editing = true;

        return view('ideas.show', compact('idea', 'editing'));
    }

    public function update(Idea $idea)
    {
        request()->validate([
            'content' => 'required|min:3|max:240',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = $idea->image;

        if (request()->hasFile('image')) {
            if ($idea->image) {
                $imagePath = public_path('images/' . $idea->image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            $imageName = time() . '.' . request()->image->getClientOriginalExtension();
            request()->image->move(public_path('images'), $imageName);
        }

        $idea->content = request()->get('content', '');
        $idea->image = $imageName;

        $idea->save();

        return redirect()
            ->route('ideas.show', $idea->id)
            ->with('success', 'Idea was updated successfully!');
    }
}
