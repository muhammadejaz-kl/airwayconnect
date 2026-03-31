<?php

namespace App\DataTables;

use App\Models\JobPost;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class JobsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<JobPost> $query
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->editColumn('status', function ($job) {
                return $job->status == 1
                    ? '<span class="badge bg-success">Active</span>'
                    : '<span class="badge bg-danger">Inactive</span>';
            })
            ->editColumn('last_date', function ($job) {
                return \Carbon\Carbon::parse($job->last_date)->format('d M Y');
            })
            ->editColumn('created_at', function ($faq) {
                return $faq->created_at ? $faq->created_at->format('d M Y H:i') : 'N/A';
            })
            ->addColumn('action', function ($job) {
                return view('admin.jobs.action', compact('job'))->render();
            })
            ->rawColumns(['status', 'action', 'created_at']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<JobPost>
     */
    public function query(JobPost $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('jobs-table')
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
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex')
                ->title('Sr No')
                ->width(50)
                ->addClass('text-center'),
            Column::make('title'),
            Column::make('type'),
            Column::make('location'),
            Column::make('experience')->title('Experience Req(YRS)'),
            Column::make('last_date'),
            Column::make('status'),
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
        return 'Jobs_' . date('YmdHis');
    }
}
