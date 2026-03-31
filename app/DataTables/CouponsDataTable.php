<?php

namespace App\DataTables;

use App\Models\Coupon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CouponsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Coupon> $query
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->editColumn('created_at', function ($subscription) {
                return $subscription->created_at ? $subscription->created_at->format('d M Y H:i') : 'N/A';
            })
            ->addColumn('action', function ($coupon) {
                return view('admin.coupons.action', compact('coupon'));
            })
            ->editColumn('status', function ($coupon) {
                return $coupon->status == 1
                    ? '<span class="badge bg-success">Active</span>'
                    : '<span class="badge bg-danger">Inactive</span>';
            })
            ->rawColumns(['status', 'action'])
            ->setRowId('id');
    }

    public function query(Coupon $model): QueryBuilder
    {
        return $model->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('coupons-table')
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
                Button::make('reload'),
            ]);
    }

    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex')->title('Sr No')->width(50)->addClass('text-center'),
            Column::make('name')->title('Coupon Name'),
            Column::make('code'),
            Column::make('discount')->title('Discount (%)'),
            Column::make('status'),
            Column::make('created_at')->title('Created On'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(120)
                ->title('Actions')
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Coupons_' . date('YmdHis');
    }
}
