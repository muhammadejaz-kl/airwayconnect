<?php

namespace App\DataTables;

use App\Models\AirlineDetail;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class AirlineDetailsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     */
    public function dataTable($query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->editColumn('created_at', function ($detail) {
                return $detail->created_at
                    ? $detail->created_at->format('d M Y H:i')
                    : 'N/A';
            })

            ->addColumn('action', function ($detail) {
                return view('admin.airlinesDirectory.detailsAction', compact('detail'))->render();
            })

            ->rawColumns(['airline_id', 'action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(AirlineDetail $model)
    {
        $airlineId = request()->route('id');

        return $model->with('airline')->where('airline_id', $airlineId)->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('airlinedetails-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(7)
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
     * Columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex')
                ->title('Sr No')
                ->width(50)
                ->addClass('text-center'),
            Column::make('part'),
            Column::make('airlines_type'),
            Column::make('job_type'),
            Column::make('schedule_type'),
            Column::make('option_401k'),
            Column::make('flight_benefits'),

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
     * Filename for export.
     */
    protected function filename(): string
    {
        return 'AirlineDetails_' . date('YmdHis');
    }
}
