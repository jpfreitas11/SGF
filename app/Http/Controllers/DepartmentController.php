<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepartmentRequest;
use App\Models\Department;
use App\Services\DepartmentService;

class DepartmentController extends Controller
{
    public function __construct(private DepartmentService $service)
    {
    }

    public function index()
    {
        return view('departments.index', [
            'departments' => Department::with('admin')->latest()->paginate(10),
        ]);
    }

    public function create()
    {
        return view('departments.create');
    }

    public function store(StoreDepartmentRequest $request)
    {
        $this->service->createWithAdmin($request->validated());

        return redirect()
            ->route('departments.index')
            ->with('success', 'Setor criado com admin automaticamente.');
    }
}