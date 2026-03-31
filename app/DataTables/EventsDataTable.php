<?php

namespace App\DataTables;

use App\Models\Event;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class EventsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Event> $query
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->editColumn('date', function ($event) {
                return $event->date ? date('d M Y', strtotime($event->date)) : 'N/A';
            })
            ->editColumn('created_at', function ($event) {
                return $event->created_at ? $event->created_at->format('d M Y H:i') : 'N/A';
            })
            ->addColumn('action', function ($event) {
                return view('admin.events.action', compact('event'))->render();
            })
            ->rawColumns(['action']);  
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Event>
     */
    public function query(Event $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the HTML builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('events-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(5)
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
     * Get the DataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex')
                ->title('Sr No')
                ->width(50)
                ->addClass('text-center'),
            Column::make('title')->title('Event Title'),
            Column::make('location'),
            Column::make('date'),
            Column::make('timing'),
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
        return 'Events_' . date('YmdHis');
    }
}
