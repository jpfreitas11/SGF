<?php

namespace App\Http\Controllers;

use App\Http\Requests\DecideRequest;
use App\Http\Requests\StoreSalaryChangeRequest;
use App\Models\Employee;
use App\Models\SalaryChangeRequest;
use App\Services\SalaryChangeService;

class SalaryChangeRequestController extends Controller
{
    public function __construct(private SalaryChangeService $service)
    {
    }

    public function index()
    {
        $query = SalaryChangeRequest::with('employee.department')->latest();

        if (! auth()->user()->isSuperAdmin()) {
            $query->whereHas('employee', function ($q) {
                $q->where('department_id', auth()->user()->department_id);
            });
        }

        return view('salary-changes.index', [
            'requests' => $query->paginate(10),
        ]);
    }

    public function store(StoreSalaryChangeRequest $request, Employee $employee)
    {
        $this->authorize('view', $employee);

        $this->service->request(
            $employee,
            (float) $request->input('new_salary'),
            $request->string('reason'),
            $request->user()
        );

        return back()->with('success', 'Aumento solicitado.');
    }

    public function approve(DecideRequest $request, SalaryChangeRequest $salaryChangeRequest)
    {
        $this->authorize('decide', $salaryChangeRequest);

        $this->service->approve(
            $salaryChangeRequest,
            $request->user(),
            $request->string('decision_reason')
        );

        return back()->with('success', 'Aumento aprovado.');
    }

    public function reject(DecideRequest $request, SalaryChangeRequest $salaryChangeRequest)
    {
        $this->authorize('decide', $salaryChangeRequest);

        $this->service->reject(
            $salaryChangeRequest,
            $request->user(),
            $request->string('decision_reason')
        );

        return back()->with('success', 'Aumento reprovado.');
    }
}