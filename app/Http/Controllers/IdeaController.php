<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use Illuminate\Http\Request;

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

        $imageName = '';

        if ($request->file('image')) {
            $imageName = $this->handleImageUpload($request);
        }

        Idea::create([
            'content' => $validated['content'],
            'user_id' => $validated['user_id'],
            'image' => $imageName,
        ]);

        return redirect()->route('dashboard')->with('success', 'Idea was created successfully!');
    }

    public function destroy(Idea $idea)
    {
        if (auth()->id() !== $idea->user_id) {
            abort(404, 'Error Page');
        }

        $this->deleteImage($idea->image);

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

        if ($request->hasFile('image')) {
            $this->deleteImage($idea->image);
            $idea->update(['image' => $this->handleImageUpload($request)]);
        }

        $idea->update(['content' => $validated['content']]);

        return redirect()
            ->route('ideas.show', $idea->id)
            ->with('success', 'Idea was updated successfully!');
    }

    private function rules(): array
    {
        return [
            'content' => 'required|min:3|max:240',
        ];
    }

    private function handleImageUpload(Request $request): ?string
    {
        $validated = $request->validate(['image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048']);

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $validated['image']->getClientOriginalExtension();
            $validated['image']->move(public_path('images'), $imageName);

            return $imageName;
        }

        return null;
    }

    private function deleteImage(?string $imageName): void
    {
        if ($imageName) {
            $imagePath = public_path('images/' . $imageName);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
    }
}
