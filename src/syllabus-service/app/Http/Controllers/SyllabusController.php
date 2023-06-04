<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Syllabus;
use App\Http\Requests\StoreSyllabusRequest;
use App\Http\Requests\UpdateSyllabusRequest;
use App\Http\Resources\SyllabusResource;
use App\Http\Resources\SyllabusCollection;


class SyllabusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): SyllabusCollection
    {
        $syllabus = Syllabus::latest()->paginate(10);
        return new SyllabusCollection($syllabus->appends(request()->query()));
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
    public function store(StoreSyllabusRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Syllabus $syllabus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Syllabus $syllabus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSyllabusRequest $request, Syllabus $syllabus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Syllabus $syllabus)
    {
        //
    }
}
