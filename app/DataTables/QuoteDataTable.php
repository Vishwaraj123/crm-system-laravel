<?php

namespace App\DataTables;

use App\Models\Offer;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class QuoteDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('client_name', function($offer) {
                return $offer->client->name;
            })
            ->addColumn('total_display', function($offer) {
                return number_format($offer->total, 2) . ' ' . $offer->currency;
            })
            ->addColumn('status_display', function($offer) {
                $statusClass = [
                    'draft' => 'bg-secondary',
                    'pending' => 'bg-warning text-dark',
                    'sent' => 'bg-info',
                    'accepted' => 'bg-success',
                    'declined' => 'bg-danger',
                    'cancelled' => 'bg-dark',
                ][$offer->status] ?? 'bg-primary';
                return '<span class="badge '.$statusClass.' text-capitalize">'.$offer->status.'</span>';
            })
            ->addColumn('action', function($offer) {
                return view('offers.partials.action', ['id' => $offer->id]);
            })
            ->rawColumns(['status_display', 'action'])
            ->setRowId('id');
    }

    public function query(Offer $model): QueryBuilder
    {
        return $model->with('client')->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('quote-table')
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
            Column::make('date')->title(__('Date')),
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
        return 'Quote_' . date('YmdHis');
    }
}
