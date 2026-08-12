<?php

namespace App\Http\Controllers;

use App\Enums\RequestStatus;
use App\Models\Employee;
use App\Models\PositionChangeRequest;
use App\Models\SalaryChangeRequest;
use App\Models\TransferRequest;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $employeeQuery = Employee::query();
        $transferQuery = TransferRequest::query();
        $salaryQuery = SalaryChangeRequest::query();
        $positionQuery = PositionChangeRequest::query();

        if (! $request->user()->isSuperAdmin()) {
            $departmentId = $request->user()->department_id;

            $employeeQuery->where('department_id', $departmentId);
            $transferQuery->where('to_department_id', $departmentId);
            $salaryQuery->whereHas('employee', function ($query) use ($departmentId) {
                $query->where('department_id', $departmentId);
            });
            $positionQuery->whereHas('employee', function ($query) use ($departmentId) {
                $query->where('department_id', $departmentId);
            });
        }

        return view('dashboard', [
            'employeesCount' => $employeeQuery->count(),
            'pendingTransfers' => $transferQuery->where('status', RequestStatus::Pending)->count(),
            'pendingSalaryChanges' => $salaryQuery->where('status', RequestStatus::Pending)->count(),
            'pendingPositionChanges' => $positionQuery->where('status', RequestStatus::Pending)->count(),
        ]);
    }
}