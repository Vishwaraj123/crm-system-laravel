<?php

namespace App\DataTables;

use App\Models\Proposal;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ProposalDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('client_name', function($proposal) {
                return $proposal->client->name;
            })
            ->addColumn('date_display', function($proposal) {
                $fmt = Setting::get('date_format', 'd/m/Y');
                return Carbon::parse($proposal->date)->format($fmt);
            })
            ->addColumn('total_display', function($proposal) {
                return number_format($proposal->total, 2) . ' ' . $proposal->currency;
            })
            ->addColumn('status_display', function($proposal) {
                return view('proposals.partials.status', [
                    'status' => $proposal->status,
                    'id'     => $proposal->id,
                ])->render();
            })
            ->addColumn('action', function($proposal) {
                return view('proposals.partials.action', ['id' => $proposal->id]);
            })
            ->rawColumns(['status_display', 'action'])
            ->setRowId('id');
    }

    public function query(Proposal $model): QueryBuilder
    {
        return $model->with('client')->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('proposal-table')
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
            Column::computed('DT_RowIndex')->title('#')->width(30)->addClass('text-center'),
            Column::make('number')->title(__('Number')),
            Column::make('client_name')->title(__('Client')),
            Column::make('date_display')->title(__('Date')),
            Column::make('total_display')->title(__('Total')),
            Column::make('status_display')->title(__('Status')),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(120)
                  ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Proposal_' . date('YmdHis');
    }
}
