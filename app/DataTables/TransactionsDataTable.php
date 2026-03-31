<?php

namespace App\DataTables;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class TransactionsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Transaction> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->editColumn('paid_amount', function ($transaction) {
                return '$' . number_format($transaction->paid_amount, 2);
            })
            ->editColumn('payment_status', function ($transaction) {
                $badgeClass = $transaction->payment_status === 'paid' ? 'success' : 'danger';
                return '<span class="badge bg-' . $badgeClass . '">' . ucfirst($transaction->payment_status) . '</span>';
            })
            ->editColumn('created_at', function ($transaction) {
                return $transaction->created_at ? $transaction->created_at->format('d M Y H:i') : 'N/A';
            })
            ->addColumn('action', function ($transaction) {
                return view('admin.transactions.action', compact('transaction'))->render();
            })
            ->rawColumns(['payment_status', 'action']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Transaction>
     */
    public function query(Transaction $model): QueryBuilder
    {
        return $model->newQuery()->latest();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('transactions-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ]);
    }

    /**
     * Define columns for the DataTable.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex')->title('Sr No')->width(50)->addClass('text-center'),
            Column::make('transaction_id'),
            Column::make('username'),
            Column::make('paid_amount'),
            Column::make('payment_status'),
            Column::make('created_at')->title('Date'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(120)
                ->addClass('text-center'),
        ];
    }

    /**
     * Export filename.
     */
    protected function filename(): string
    {
        return 'Transactions_' . date('YmdHis');
    }
}
