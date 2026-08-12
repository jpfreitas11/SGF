<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePositionRequest;
use App\Models\Position;

class PositionController extends Controller
{
    public function index()
    {
        return view('positions.index', [
            'positions' => Position::orderByDesc('level')->paginate(10),
        ]);
    }

    public function create()
    {
        return view('positions.create', [
            'positions' => Position::orderByDesc('level')->get(),
        ]);
    }

    public function store(StorePositionRequest $request)
    {
        Position::create($request->validated());

        return redirect()
            ->route('positions.index')
            ->with('success', 'Cargo criado.');
    }
}