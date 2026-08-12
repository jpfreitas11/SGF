<?php

namespace App\Http\Controllers;

use App\Http\Requests\DecideRequest;
use App\Http\Requests\StoreTransferRequest;
use App\Models\Employee;
use App\Models\TransferRequest;
use App\Services\TransferService;

class TransferRequestController extends Controller
{

    public function index()
{
    $query = TransferRequest::with([
    'employee' => fn ($q) => $q->withTrashed(),
    'fromDepartment',
    'toDepartment',
])->latest();

    if (! auth()->user()->isSuperAdmin()) {
        $departmentId = auth()->user()->department_id;

        $query->where(function ($q) use ($departmentId) {
            $q->where('from_department_id', $departmentId)
                ->orWhere('to_department_id', $departmentId);
        });
    }

    return view('transfers.index', [
        'requests' => $query->paginate(10),
    ]);
}
    public function __construct(private TransferService $service)
    {
    }

    public function store(StoreTransferRequest $request, Employee $employee)
    {
        $this->authorize('view', $employee);

        $this->service->request(
            $employee,
            $request->integer('to_department_id'),
            $request->string('reason'),
            $request->user()
        );

        return back()->with('success', 'Transferencia solicitada.');
    }

    public function approve(DecideRequest $request, TransferRequest $transferRequest)
    {
        $this->authorize('decide', $transferRequest);

        $this->service->approve(
            $transferRequest,
            $request->user(),
            $request->string('decision_reason')
        );

        return back()->with('success', 'Transferencia aprovada.');
    }

    public function reject(DecideRequest $request, TransferRequest $transferRequest)
    {
        $this->authorize('decide', $transferRequest);

        $this->service->reject(
            $transferRequest,
            $request->user(),
            $request->string('decision_reason')
        );

        return back()->with('success', 'Transferencia reprovada.');
    }
}