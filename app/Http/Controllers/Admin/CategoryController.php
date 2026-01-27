<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\PageNamesHelper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(
        public PageNamesHelper $pageNamesHelper
    ){}

    /**
     * Список всех категорий
     */
    public function index()
    {
        $categories = Category::all();
        $pageNames = $this->pageNamesHelper->getPageNames();

        return view('elitvid.admin.categories.index', compact('categories', 'pageNames'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Страница редактирования категории
     */
    public function edit(Category $category)
    {
        $pageNames = $this->pageNamesHelper->getPageNames();
        $pageName = $pageNames[$category->page] ?? $category->page;

        return view('elitvid.admin.categories.edit', compact('category', 'pageName'));
    }

    /**
     * Обновление категории
     */
    public function update(Request $request, Category $category)
    {
        $data = $request->all();
        $category->fill($data)->save();

        return redirect()->route('categories.index')
            ->with('success', 'Описание категории успешно обновлено');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
