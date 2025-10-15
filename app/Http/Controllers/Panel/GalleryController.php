<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryAlbum;
use App\Models\Professional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;




class GalleryController extends Controller
{
    protected $professionalId;
    public function __construct()
    {
        $this->professionalId = auth()->user()->id;
    }

    public function index(Request $request)
    {
        $albumId = $request->get('album_id');

        $albums = GalleryAlbum::where('professional_id', $this->professionalId)
            ->orderBy('order')
            ->orderBy('name')
            ->get();

        $gallery = Gallery::where('professional_id', $this->professionalId)
            ->when($albumId, function ($q) use ($albumId) {
                $q->where('album_id', $albumId);
            })
            ->orderBy('order')
            ->get();

        return view('panel.galeria', compact('gallery', 'albums', 'albumId'));
    }

    public function create()
    {
        $albums = GalleryAlbum::where('professional_id', $this->professionalId)
            ->orderBy('order')
            ->orderBy('name')
            ->get();
        return view('panel.galeria-create', compact('albums'));
    }

    public function store(Request $request)
    {
        $professionalId = $this->professionalId;

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|max:5120', // 5MB
            'order' => 'nullable|integer',
            'album_id' => 'nullable|exists:gallery_albums,id',
            'new_album_name' => 'nullable|string|max:255',
        ]);

        // Criar álbum novo se informado
        $albumId = $validated['album_id'] ?? null;
        if (empty($albumId) && !empty($validated['new_album_name'])) {
            $album = GalleryAlbum::create([
                'professional_id' => $professionalId,
                'name' => $validated['new_album_name'],
                'order' => (int) (GalleryAlbum::where('professional_id', $professionalId)->max('order') + 1),
            ]);
            $albumId = $album->id;
        }

        // Upload da imagem
        $imagePath = $request->file('image')->store('gallery', 'public');

        // Determinar ordem
        $order = $validated['order'] ?? (int) (Gallery::where('professional_id', $professionalId)->when($albumId, fn($q)=>$q->where('album_id', $albumId))->max('order') + 1);

        Gallery::create([
            'professional_id' => $professionalId,
            'album_id' => $albumId,
            'image_path' => Storage::url($imagePath),
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'order' => $order,
        ]);

        return redirect()->route('panel.galeria.index', ['album_id' => $albumId])
            ->with('success', 'Foto adicionada à galeria com sucesso!');
    }

    public function edit($id)
    {
        $photo = Gallery::findOrFail($id);
        $albums = GalleryAlbum::where('professional_id', $this->professionalId)->orderBy('name')->get();
        return view('panel.galeria-edit', compact('photo', 'albums'));
    }

    public function update(Request $request, $id)
    {
        $photo = Gallery::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
            'order' => 'nullable|integer',
            'album_id' => 'nullable|exists:gallery_albums,id',
            'new_album_name' => 'nullable|string|max:255',
        ]);

        // Resolver álbum
        $albumId = $validated['album_id'] ?? $photo->album_id;
        if (empty($albumId) && !empty($validated['new_album_name'])) {
            $album = GalleryAlbum::create([
                'professional_id' => $this->professionalId,
                'name' => $validated['new_album_name'],
                'order' => (int) (GalleryAlbum::where('professional_id', $this->professionalId)->max('order') + 1),
            ]);
            $albumId = $album->id;
        }

        $data = [
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'order' => $validated['order'] ?? $photo->order,
            'album_id' => $albumId,
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

        return redirect()->route('panel.galeria.index', ['album_id' => $albumId])
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

        $albumId = $photo->album_id;
        $photo->delete();

        return redirect()->route('panel.galeria.index', ['album_id' => $albumId])
            ->with('success', 'Foto removida da galeria com sucesso!');
    }
}
