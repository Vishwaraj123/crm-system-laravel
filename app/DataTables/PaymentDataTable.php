<?php

namespace App\DataTables;

use App\Models\Payment;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PaymentDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('client_name', function($payment) {
                return $payment->client->name;
            })
            ->addColumn('invoice_number', function($payment) {
                return $payment->invoice->number;
            })
            ->addColumn('date_display', function($payment) {
                $fmt = Setting::get('date_format', 'd/m/Y');
                return Carbon::parse($payment->date)->format($fmt);
            })
            ->addColumn('amount_display', function($payment) {
                return number_format($payment->amount, 2);
            })
            ->addColumn('action', function($payment) {
                return view('payments.partials.action', ['id' => $payment->id]);
            })
            ->rawColumns(['action'])
            ->setRowId('id');
    }

    public function query(Payment $model): QueryBuilder
    {
        return $model->with(['client', 'invoice'])->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('payment-table')
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
            Column::make('invoice_number')->title(__('Invoice')),
            Column::make('client_name')->title(__('Client')),
            Column::make('date_display')->title(__('Date')),
            Column::make('amount_display')->title(__('Amount')),
            Column::make('payment_mode')->title(__('Mode')),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(100)
                  ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Payment_' . date('YmdHis');
    }
}
