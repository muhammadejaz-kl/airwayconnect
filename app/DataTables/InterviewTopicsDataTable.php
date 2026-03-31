<?php

namespace App\DataTables;

use App\Models\InterviewTopic;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Str;

class InterviewTopicsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<InterviewTopic> $query
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('questions_count', function ($topic) {
                return $topic->questions_count ?? 0;
            })
            ->editColumn('status', function ($topic) {
                return $topic->status == 1
                    ? '<span class="badge bg-success">Active</span>'
                    : '<span class="badge bg-danger">Inactive</span>';
            })
            ->editColumn('created_at', function ($topic) {
                return $topic->created_at ? $topic->created_at->format('d M Y H:i') : 'N/A';
            })
            ->editColumn('description', function ($topic) {
                return e(Str::limit($topic->description, 50));
            })
            ->addColumn('question', function ($topic) {
                return '
                    <a href="' . route('admin.interview.interviewIndex', ['topic_id' => $topic->id]) . '" 
                    class="btn btn-sm">
                        <i class="fas fa-eye"></i>
                    </a>
                ';
            })

            ->addColumn('action', function ($topic) {
                return view('admin.interviews.topics.action', compact('topic'))->render();
            })
            ->rawColumns(['status', 'question', 'action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(InterviewTopic $model): QueryBuilder
    {
        return $model->newQuery()->withCount('questions');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('interviewtopics-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(5)
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload'),
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex')->title('Sr No')->width(50)->addClass('text-center'),
            Column::make('topic'),
            Column::make('description'),
            Column::computed('questions_count'),
            Column::make('status'),
            Column::make('created_at')->title('Added On'),
            Column::computed('question')->title('Questions')->exportable(false)->printable(false)->width(100)->addClass('text-center'),
            Column::computed('action')->exportable(false)->printable(false)->width(120)->addClass('text-center')->title('Actions'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'InterviewTopics_' . date('YmdHis');
    }
}
