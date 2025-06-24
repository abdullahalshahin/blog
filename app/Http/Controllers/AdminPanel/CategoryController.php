<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $categories = Category::query()
            ->latest()
            ->get();

        return view('admin_panel.categories.index', compact('categories'));
    }

    private function data(Category $category) {
        return [
            'category' => $category
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('admin_panel.categories.create', $this->data(new Category()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $validated_data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        DB::beginTransaction();

        try {
            Category::create([
                'name' => $validated_data['name'],
                'slug' => Str::slug($validated_data['name']),
                'description' => $validated_data['description'],
            ]);

            DB::commit();

            return redirect()->to('admin-panel/categories')
                ->with('success', 'Created Successfully.');
        }
        catch (\Exception $e) {
            DB::rollback();

            return back()
                ->with('error', 'An error occurred while createing the data. ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category) {
        return view('admin_panel.categories.show', $this->data($category));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category) {
        return view('admin_panel.categories.edit', $this->data($category));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category) {
        $validated_data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        DB::beginTransaction();

        try {
            $category->update([
                'name' => $validated_data['name'],
                'slug' => Str::slug($validated_data['name']),
                'description' => $validated_data['description'],
            ]);

            DB::commit();

            return redirect()->to('admin-panel/categories')
                ->with('success', 'Created Successfully.');
        }
        catch (\Exception $e) {
            DB::rollback();

            return back()
                ->with('error', 'An error occurred while updating the data. ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category) {
        DB::beginTransaction();

        try {
            $category->delete();

            DB::commit();

            return redirect()->to('admin-panel/categories')
                ->with('success', 'Deleted Successfully.');
        } 
        catch (\Exception $e) {
            DB::rollback();

            return back()
                ->with('error', 'An error occurred while deleting the record. ' . $e->getMessage());
        }
    }
}
