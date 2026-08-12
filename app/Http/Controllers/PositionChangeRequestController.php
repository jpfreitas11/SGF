<?php

namespace App\Http\Controllers;

use App\Http\Requests\DecideRequest;
use App\Http\Requests\StorePositionChangeRequest;
use App\Models\Employee;
use App\Models\Position;
use App\Models\PositionChangeRequest;
use App\Services\PositionChangeService;

class PositionChangeRequestController extends Controller
{
    public function __construct(private PositionChangeService $service)
    {
    }

    public function index()
    {
        $query = PositionChangeRequest::with(['employee.department', 'oldPosition', 'newPosition'])->latest();

        if (! auth()->user()->isSuperAdmin()) {
            $query->whereHas('employee', function ($q) {
                $q->where('department_id', auth()->user()->department_id);
            });
        }

        return view('position-changes.index', [
            'requests' => $query->paginate(10),
        ]);
    }

    public function store(StorePositionChangeRequest $request, Employee $employee)
    {
        $this->authorize('view', $employee);

        $newPosition = Position::findOrFail($request->integer('new_position_id'));

        $this->service->request(
            $employee,
            $newPosition,
            $request->string('reason'),
            $request->user()
        );

        return back()->with('success', 'Promocao solicitada.');
    }

    public function approve(DecideRequest $request, PositionChangeRequest $positionChangeRequest)
    {
        $this->authorize('decide', $positionChangeRequest);

        $this->service->approve(
            $positionChangeRequest,
            $request->user(),
            $request->string('decision_reason')
        );

        return back()->with('success', 'Promocao aprovada.');
    }

    public function reject(DecideRequest $request, PositionChangeRequest $positionChangeRequest)
    {
        $this->authorize('decide', $positionChangeRequest);

        $this->service->reject(
            $positionChangeRequest,
            $request->user(),
            $request->string('decision_reason')
        );

        return back()->with('success', 'Promocao reprovada.');
    }
}