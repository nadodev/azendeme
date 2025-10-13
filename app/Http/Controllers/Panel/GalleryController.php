<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Professional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $professionalId = 1;
        $gallery = Gallery::where('professional_id', $professionalId)
            ->orderBy('order')
            ->get();

        return view('panel.galeria', compact('gallery'));
    }

    public function create()
    {
        return view('panel.galeria-create');
    }

    public function store(Request $request)
    {
        $professionalId = 1;

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|max:5120', // 5MB
            'order' => 'nullable|integer',
        ]);

        // Upload da imagem
        $imagePath = $request->file('image')->store('gallery', 'public');

        // Determinar ordem
        $order = $validated['order'] ?? Gallery::where('professional_id', $professionalId)->max('order') + 1;

        Gallery::create([
            'professional_id' => $professionalId,
            'image_path' => Storage::url($imagePath),
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'order' => $order,
        ]);

        return redirect()->route('panel.galeria.index')
            ->with('success', 'Foto adicionada à galeria com sucesso!');
    }

    public function edit($id)
    {
        $photo = Gallery::findOrFail($id);
        return view('panel.galeria-edit', compact('photo'));
    }

    public function update(Request $request, $id)
    {
        $photo = Gallery::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
            'order' => 'nullable|integer',
        ]);

        $data = [
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'order' => $validated['order'] ?? $photo->order,
        ];

        // Se houver nova imagem
        if ($request->hasFile('image')) {
            // Deletar imagem antiga
            if ($photo->image_path) {
                $oldPath = str_replace('/storage/', '', $photo->image_path);
                Storage::disk('public')->delete($oldPath);
            }

            $imagePath = $request->file('image')->store('gallery', 'public');
            $data['image_path'] = Storage::url($imagePath);
        }

        $photo->update($data);

        return redirect()->route('panel.galeria.index')
            ->with('success', 'Foto atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $photo = Gallery::findOrFail($id);

        // Deletar imagem
        if ($photo->image_path) {
            $imagePath = str_replace('/storage/', '', $photo->image_path);
            Storage::disk('public')->delete($imagePath);
        }

        $photo->delete();

        return redirect()->route('panel.galeria.index')
            ->with('success', 'Foto removida da galeria com sucesso!');
    }
}
