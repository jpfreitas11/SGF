<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::with(['department', 'position']);

        if (! $request->user()->isSuperAdmin()) {
            $query->where('department_id', $request->user()->department_id);
        }

        return view('employees.index', [
        'employees' => $query->latest()->paginate(10),
        'departments' => Department::orderBy('name')->get(),
        'positions' => Position::orderBy('level')->get(),
]);
    }

    public function create()
    {
        $this->authorize('create', Employee::class);

        return view('employees.create', [
            'departments' => Department::orderBy('name')->get(),
            'positions' => Position::orderBy('level')->get(),
        ]);
    }

    public function store(StoreEmployeeRequest $request)
    {
        $data = $request->validated();

        if (! $request->user()->isSuperAdmin()) {
            $data['department_id'] = $request->user()->department_id;
        }

        Employee::create($data);

        return redirect()
            ->route('employees.index')
            ->with('success', 'Funcionario cadastrado.');
    }

    public function destroy(Employee $employee)
    {
        $this->authorize('delete', $employee);

        $employee->delete();

        return redirect()
            ->route('employees.index')
            ->with('success', 'Funcionario arquivado.');
    }

    public function history(Employee $employee)
{
    $this->authorize('view', $employee);

    return view('employees.history', [
        'employee' => $employee->load([
            'salaryHistories',
            'positionHistories.oldPosition',
            'positionHistories.newPosition',
        ]),
    ]);
}
}