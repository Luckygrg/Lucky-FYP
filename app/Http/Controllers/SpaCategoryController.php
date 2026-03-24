<?php

namespace App\Http\Controllers;

use App\Models\SpaCategory;
use Illuminate\Http\Request;

class SpaCategoryController extends Controller
{
    public function index()
    {
        $categories = SpaCategory::latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100|unique:spa_categories,name',
        
        ]);


        SpaCategory::create($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function edit(SpaCategory $spaCategory)
    {
        return view('admin.categories.edit', ['category' => $spaCategory]);
    }

    public function update(Request $request, SpaCategory $spaCategory)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100|unique:spa_categories,name,' . $spaCategory->id,
            
        ]);


        $spaCategory->update($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(SpaCategory $spaCategory)
    {
        $spaCategory->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
