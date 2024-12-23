<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateIdeaRequest;
use App\Models\Idea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IdeaController extends Controller
{
    public function show(Idea $idea)
    {
        return view('ideas.show', compact('idea'));
    }

    public function store(Request $request, CreateIdeaRequest $ideaRequest)
    {
        $validated = $ideaRequest->validated();

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
        $this->authorize('delete', $idea);

        if ($idea->image) {
            Storage::disk('public')->delete($idea->image);
        }

        $idea->delete();

        return redirect()->route('dashboard')->with('success', 'Idea was deleted successfully!');
    }

    public function edit(Idea $idea)
    {
        $this->authorize('update', $idea);

        $editing = true;

        return view('ideas.show', compact('idea', 'editing'));
    }

    public function update(Request $request, Idea $idea, CreateIdeaRequest $ideaRequest)
    {
        $this->authorize('update', $idea);

        $validated = $ideaRequest->validated();

        if ($ideaRequest->has('image')) {
            $imagePath = $ideaRequest->file('image')->store('ideas', 'public');
            $validated['image'] = $imagePath;

            Storage::disk('public')->delete($idea->image);
        }

        $idea->update($validated);

        return redirect()
            ->route('ideas.show', $idea->id)
            ->with('success', 'Idea was updated successfully!');
    }
}
