<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    // GET - tampilkan semua menu (view)
    public function index()
    {
        $menu = MenuItem::all();
        return view('menu.index', ['menus' => $menu]);
    }

    // GET - Admin: tampilkan daftar menu untuk manajemen
    public function adminIndex()
    {
        $menus = MenuItem::paginate(10);
        return view('admin.menu.index', ['menus' => $menus]);
    }

    // GET - Tampilkan form create menu
    public function create()
    {
        return view('menu.create');
    }

    // GET - API semua menu
    public function api()
    {
        return response()->json(MenuItem::all());
    }

    // GET - API detail menu
    public function show(MenuItem $menu)
    {
        return response()->json($menu);
    }

    // GET - Filter berdasarkan kategori
    public function filterByCategory($category)
    {
        $menu = MenuItem::where('category', $category)->get();
        return response()->json($menu);
    }

    // POST - Tambah menu baru (Web Form)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255|unique:menu_items',
            'description' => 'nullable|string',
            'category'    => 'required|string|in:sushi,ramen,wagyu,drinks',
            'price'       => 'required|integer|min:0',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_available' => 'nullable|boolean',
        ]);

        $imagePath = null;

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('img'), $imageName);
            $imagePath = $imageName;
        }

        $menu = MenuItem::create([
            'name'         => $validated['name'],
            'description'  => $validated['description'] ?? null,
            'category'     => $validated['category'],
            'price'        => $validated['price'],
            'image'        => $imagePath,
            'is_available' => $validated['is_available'] ?? true,
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Menu item created successfully',
                'data' => $menu
            ], 201);
        }

        return redirect()->route('admin.menu.index')
            ->with('success', 'Menu item created successfully!');
    }

    // POST - API Tambah menu baru (API)
    public function storeApi(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255|unique:menu_items',
            'description' => 'nullable|string',
            'category'    => 'required|string|in:sushi,ramen,wagyu,drinks',
            'price'       => 'required|integer|min:0',
            'image'       => 'nullable|string',
            'is_available' => 'nullable|boolean',
        ]);

        $menu = MenuItem::create([
            'name'         => $validated['name'],
            'description'  => $validated['description'] ?? null,
            'category'     => $validated['category'],
            'price'        => $validated['price'],
            'image'        => $validated['image'] ?? null,
            'is_available' => $validated['is_available'] ?? true,
        ]);

        return response()->json([
            'message' => 'Menu created successfully',
            'data'    => $menu
        ], 201);
    }

    // DELETE - Hapus menu
    public function destroy(MenuItem $menu)
    {
        if ($menu->image) {
            $imagePath = public_path('img/' . $menu->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $menu->delete();

        // Jika permintaan API (JSON) kembalikan JSON
        if (request()->wantsJson()) {
            return response()->json([
                'message' => 'Menu deleted successfully'
            ]);
        }

        // Untuk request web biasa, redirect kembali ke admin menu index
        return redirect()->route('admin.menu.index')
            ->with('success', 'Menu item deleted successfully!');
    }

    // PUT/PATCH - Update menu
    public function update(Request $request, MenuItem $menu)
    {
        $validated = $request->validate([
            'name'        => 'sometimes|string|max:255|unique:menu_items,name,' . $menu->id,
            'description' => 'nullable|string',
            'category'    => 'sometimes|string|in:sushi,ramen,wagyu,drinks',
            'price'       => 'sometimes|integer|min:0',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_available' => 'nullable|boolean',
        ]);

        // Handle image update
        if ($request->hasFile('image')) {
            // Delete old image
            if ($menu->image) {
                $oldPath = public_path('img/' . $menu->image);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            // Upload new image
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('img'), $imageName);
            $validated['image'] = $imageName;
        }

        $menu->update($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Menu updated successfully',
                'data'    => $menu
            ]);
        }

        return redirect()->route('admin.menu.index')
            ->with('success', 'Menu item updated successfully!');
    }

    // GET - Tampilkan form edit menu (web)
    public function edit(MenuItem $menu)
    {
        return view('menu.edit', ['menu' => $menu]);
    }
}
