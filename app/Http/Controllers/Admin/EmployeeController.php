<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ImageTrait;
use App\Models\Employee;
use App\Models\Position;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use Illuminate\Support\Facades\Auth;
use App\DataTables\EmployeesDataTable;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    use ImageTrait;

    public function index(EmployeesDataTable $dataTable)
    {
        return $dataTable->render('admin.employees.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $positions = Position::all('id', 'name')->keyBy('id')->toArray();
        $positions = Position::getPositionsArray($positions);
        $employees = Employee::getEmployeesArray(Employee::all());
        return view('admin.employees.create', [
            'positions' => $positions,
            'employees' => $employees,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEmployeeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEmployeeRequest $request)
    {
        $userId = $this->getUserId();
        $employee = new Employee();

        $imageName = $this->storeImageFile($request->input('base64image'), 'public/images/employees/');

        $employee->name = $request->input('name');
        $employee->img = 'storage/images/employees/'.$imageName;
        $employee->email = $request->input('email');
        $employee->phone = $request->input('phone');
        $employee->position = $request->input('position');
        $employee->employment_date = \Carbon\Carbon::parse($request->input('employment_date'))->format('Y-m-d');
        $employee->salary = $request->input('salary');
        $employee->head = $request->input('head');
        $employee->admin_created_id = $userId;
        $employee->admin_updated_id = $userId;

        $employee->save();

        return redirect('employees')->withSuccess('Employee added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        return view('admin.employees.show', [
            'employee' => $employee,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        $positions = Position::all('id', 'name')->keyBy('id')->toArray();
        $positions = Position::getPositionsArray($positions);
        $employees = Employee::getEmployeesArray(Employee::where([
            ['id', '!=', $employee->id],
            ['head', '!=', $employee->id]
        ])->get());
        return view('admin.employees.edit', [
            'employee' => $employee,
            'employees' => $employees,
            'positions' => $positions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEmployeeRequest  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        $userId = $this->getUserId();
        $imageName = $employee->img;
        if (!is_null($request->img)) {
            $this->deleteImageFile(preg_replace('#storage#', 'public', $employee->img));
            $imageName = $this->storeImageFile($request->input('base64image'), 'public/images/employees/');
            $imageName = 'storage/images/employees/'.$imageName;
        }
        $employee->name = $request->input('name');
        $employee->img = $imageName;
        $employee->email = $request->input('email');
        $employee->phone = $request->input('phone');
        $employee->position = $request->input('position');
        $employee->employment_date = \Carbon\Carbon::parse($request->input('employment_date'))->format('Y-m-d');
        $employee->salary = $request->input('salary');
        $employee->head = $request->input('head');
        $employee->admin_created_id = $request->input('admin_created_id');
        $employee->admin_updated_id = $userId;

        $employee->save();

        return redirect('employees')->withSuccess('Employee updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $siblings = $employee->siblings()->first();
        if (is_null($siblings)) {
            
        }
        dd($siblings);
        $employee->delete();

        return redirect()->back()->withSuccess('Employee deleted successfully');
    }

    private function getUserId()
    {
        if (Auth::check()) {
            return Auth::id();
        }

        return redirect("login")->withErrors(trans('auth.failed'));
    }
}
