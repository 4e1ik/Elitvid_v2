<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StaticImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaticImagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(StaticImages $staticImages)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StaticImages $staticImages)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StaticImages $static_image)
    {
        return DB::transaction(function () use ($request, $static_image) {
            $data = $request->all();
            $static_image->update($data);
            return redirect()->back();
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StaticImages $staticImages)
    {
        //
    }
}
