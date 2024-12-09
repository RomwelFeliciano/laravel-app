<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IdeaController extends Controller
{
    public function show(Idea $idea)
    {
        return view('ideas.show', compact('idea'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $validated['user_id'] = auth()->id();

        $validated['image'] = '';

        if ($request->has('image')) {
            $imagePath = $request->file('image')->store('ideas', 'public');
            $validated['image'] = $imagePath;
        }

        Idea::create($validated);

        return redirect()->route('dashboard')->with('success', 'Idea was created successfully!');
    }

    public function destroy(Idea $idea)
    {
        if (auth()->id() !== $idea->user_id) {
            abort(404, 'Error Page');
        }

        if ($idea->image) {
            Storage::disk('public')->delete($idea->image);
        }

        $idea->delete();

        return redirect()->route('dashboard')->with('success', 'Idea was deleted successfully!');
    }

    public function edit(Idea $idea)
    {
        if (auth()->id() !== $idea->user_id) {
            abort(404, 'Error Page');
        }

        $editing = true;

        return view('ideas.show', compact('idea', 'editing'));
    }

    public function update(Request $request, Idea $idea)
    {
        if (auth()->id() !== $idea->user_id) {
            abort(404, 'Error Page');
        }

        $validated = $request->validate($this->rules());

        if ($request->has('image')) {
            $imagePath = $request->file('image')->store('ideas', 'public');
            $validated['image'] = $imagePath;

            Storage::disk('public')->delete($idea->image);
        }

        $idea->update($validated);

        return redirect()
            ->route('ideas.show', $idea->id)
            ->with('success', 'Idea was updated successfully!');
    }

    private function rules(): array
    {
        return [
            'content' => 'required|min:3|max:240',
            'image' => 'nullable|image|max:2048',
        ];
    }
}
