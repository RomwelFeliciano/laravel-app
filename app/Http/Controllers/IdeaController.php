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

        $imageName = '';

        if($request->file('image')){
            $imageName = $this->handleImageUpload($request);
        }

        Idea::create([
            'content' => $validated['content'],
            'image' => $imageName,
        ]);

        return redirect()->route('dashboard')->with('success', 'Idea was created successfully!');
    }

    public function destroy(Idea $idea)
    {
        $this->deleteImage($idea->image);

        $idea->delete();

        return redirect()->route('dashboard')->with('success', 'Idea was deleted successfully!');
    }

    /**
     * Show the edit form for an idea.
     */
    public function edit(Idea $idea)
    {
        $editing = true;

        return view('ideas.show', compact('idea', 'editing'));
    }

    public function update(Request $request, Idea $idea)
    {
        $validated = $request->validate($this->rules());

        if ($request->hasFile('image')) {
            $this->deleteImage($idea->image);
            $idea->image = $this->handleImageUpload($request);
        }

        $idea->content = $validated['content'];
        $idea->save();

        return redirect()->route('ideas.show', $idea->id)
            ->with('success', 'Idea was updated successfully!');
    }

    private function rules(): array
    {
        return [
            'content' => 'required|min:3|max:240',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    private function handleImageUpload(Request $request): ?string
    {
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('images'), $imageName);

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
