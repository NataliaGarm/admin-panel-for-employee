<?php

namespace App\DataTables;

use App\Models\Employee;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class EmployeesDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('photo', function(Employee $employee) {
                return "<img src='".$employee->img."' class='img img-rounded img-fluid img-thumbnail'>";
            })
            ->addColumn('actions', function(Employee $employee){
                return view('admin.employees.datatables_actions', compact('employee'));
            })
            ->rawColumns(['photo', 'actions']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Employee $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Employee $model)
    {
        return $model->newQuery()->with('positionEmployee')->select('employees.*');;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('employees-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1)
                    ->selectStyleSingle();
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('photo')->orderable(false),
            Column::make('name'),
            Column::make('positionEmployee.name')->title('Position')->data('position_employee.name'),
            Column::make('employment_date'),
            Column::make('phone'),
            Column::make('email'),
            Column::make('salary'),
            Column::computed('actions')
                ->exportable(false)
                ->printable(false),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Employees_' . date('YmdHis');
    }
}
