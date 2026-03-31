<?php

namespace App\DataTables;

use App\Models\AirlineDirectory;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class AirlineDirectoryDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<AirlineDirectory> $query
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
 
            ->editColumn('name', function ($airline) {
                $logo = $airline->logo
                    ? asset('storage/' . $airline->logo)
                    : asset('images/no-logo.png');

                return '
                    <div class="d-flex align-items-center">
                        <img src="' . $logo . '"
                             alt="Logo"
                             class="rounded-circle border shadow-sm me-2"
                             style="width:45px;height:45px;object-fit:cover;">
                        <span class="fw-semibold text-dark">' . e($airline->name) . '</span>
                    </div>
                ';
            })

            ->editColumn('created_at', function ($airline) {
                return $airline->created_at
                    ? $airline->created_at->format('d M Y H:i')
                    : 'N/A';
            })

            ->addColumn('action', function ($airline) {
                return view('admin.airlinesDirectory.action', compact('airline'))->render();
            })

            ->rawColumns(['action', 'name']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<AirlineDirectory>
     */
    public function query(AirlineDirectory $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('airline-directory-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(2)
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
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex')
                ->title('Sr No')
                ->width(50)
                ->addClass('text-center'),

            Column::make('name')->title('Airline')->orderable(true)->searchable(true),

            Column::make('created_at')->title('Added On'),

            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(120)
                ->addClass('text-center')
                ->title('Actions'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'AirlineDirectory_' . date('YmdHis');
    }
}
