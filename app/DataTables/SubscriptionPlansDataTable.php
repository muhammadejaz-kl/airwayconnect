<?php

namespace App\DataTables;

use App\Models\Subscription;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class SubscriptionPlansDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->editColumn('amount', function ($subscription) {
                return '$ ' . number_format($subscription->amount, 2);
            })
            ->editColumn('created_at', function ($subscription) {
                return $subscription->created_at ? $subscription->created_at->format('d M Y H:i') : 'N/A';
            })
            ->editColumn('status', function ($coupon) {
                return $coupon->status == 1
                    ? '<span class="badge bg-success">Active</span>'
                    : '<span class="badge bg-danger">Inactive</span>';
            })
            ->addColumn('action', function ($subscription) {
                return view('admin.subscriptions.action', compact('subscription'))->render();
            })
            ->rawColumns(['action', 'status']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Subscription $model): QueryBuilder
    {
        return $model->newQuery()->orderBy('id', 'desc');
    }

    /**
     * Optional method for HTML builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('subscriptions-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->selectStyleSingle()
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
     * Columns for the table.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex')->title('Sr No')->width(50)->addClass('text-center'),
            Column::make('name')->title('Plan Name'),
            Column::make('validity'),
            Column::make('amount'),
            Column::make('status')->title('Status'),
            Column::make('created_at')->title('Created On'),
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
        return 'SubscriptionPlans_' . date('YmdHis');
    }
}
