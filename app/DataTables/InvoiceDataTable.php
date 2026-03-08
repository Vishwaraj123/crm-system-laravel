<?php

namespace App\DataTables;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class InvoiceDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('client_name', function($invoice) {
                return $invoice->client->name;
            })
            ->addColumn('status_display', function($invoice) {
                $statusClass = [
                    'draft' => 'bg-secondary',
                    'pending' => 'bg-warning text-dark',
                    'sent' => 'bg-info',
                    'paid' => 'bg-success',
                    'unpaid' => 'bg-danger',
                    'partially' => 'bg-primary',
                    'overdue' => 'bg-dark',
                ][$invoice->status] ?? 'bg-primary';
                return '<span class="badge '.$statusClass.' text-capitalize">'.$invoice->status.'</span>';
            })
            ->addColumn('total_display', function($invoice) {
                return number_format($invoice->total, 2) . ' ' . $invoice->currency;
            })
            ->addColumn('action', function($invoice) {
                return view('invoices.partials.action', ['id' => $invoice->id]);
            })
            ->rawColumns(['status_display', 'action'])
            ->setRowId('id');
    }

    public function query(Invoice $model): QueryBuilder
    {
        return $model->with('client')->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('invoice-table')
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
        return 'Invoice_' . date('YmdHis');
    }
}
