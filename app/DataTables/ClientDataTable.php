<?php

namespace App\DataTables;

use App\Models\Client;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ClientDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('checkbox', function ($client) {
                return '<input type="checkbox" class="form-check-input client-checkbox" value="' . $client->id . '">';
            })
            ->addColumn('action', function ($client) {
                return view('clients.partials.action', ['id' => $client->id]);
            })
            ->rawColumns(['checkbox', 'action'])
            ->setRowId('id');
    }

    public function query(Client $model): QueryBuilder
    {
        return $model->where('removed', false)->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('Client-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->selectStyleSingle()
            ->setTableAttribute('class', 'table table-hover table-bordered w-100')
            ->parameters([
                'dom' => 'Blfrtip',
                'buttons' => ['excel', 'csv', 'pdf', 'print', 'reload'],
            ]);
    }

    public function getColumns(): array
    {
        return [
            Column::computed('checkbox')
                ->title('<input type="checkbox" class="form-check-input" id="check-all">')
                ->exportable(false)
                ->printable(false)
                ->width(30)
                ->addClass('text-center'),
            Column::computed('DT_RowIndex')->title('#')->width(30)->addClass('text-center'),
            Column::make('name')->title(__('Name')),
            Column::make('email')->title(__('Email')),
            Column::make('phone')->title(__('Phone')),
            Column::make('country')->title(__('Country')),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(120)
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Client_' . date('YmdHis');
    }
}
