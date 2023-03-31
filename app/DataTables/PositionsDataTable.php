<?php
/**
 * Created by PhpStorm.
 * User: Nata
 * Date: 24.02.2023
 * Time: 21:43
 */

namespace App\DataTables;

use App\Models\Position;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;


class PositionsDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('actions', function($position){
                return view('admin.positions.datatables_actions', compact('position'));
            })
            ->rawColumns(['actions']);
    }

    public function query(Position $model)
    {
        return $model->newQuery();
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('positions-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->selectStyleSingle();
    }

    public function getColumns()
    {
        return [
            Column::make('name'),
            Column::make('updated_at'),
            Column::computed('actions')
                ->exportable(false)
                ->printable(false),
        ];
    }

    protected function filename()
    {
        return 'Users_'.date('YmdHis');
    }
}