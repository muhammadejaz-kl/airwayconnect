<?php

namespace App\DataTables;

use App\Models\InterviewQuestionAnswer;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Str;

class InterviewQADataTable extends DataTable
{
    /**
     * Build the DataTable class.
     */
    public function dataTable($query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('topic', function ($qa) {
                return $qa->topic ? $qa->topic->topic : 'N/A';
            })
            ->editColumn('type', function ($qa) {
                return $qa->type === 'QA' ? 'Question & Answer' : 'Multiple Choice';
            })
            ->editColumn('question', function ($qa) {
                return e(Str::limit($qa->question, 50));
            })
            ->editColumn('status', function ($qa) {
                return $qa->status == 1
                    ? '<span class="badge bg-success">Active</span>'
                    : '<span class="badge bg-danger">Inactive</span>';
            })
            ->editColumn('created_at', function ($qa) {
                return $qa->created_at ? $qa->created_at->format('d M Y H:i') : 'N/A';
            })
            ->addColumn('action', function ($qa) {
                return view('admin.interviews.action', compact('qa'))->render();
            })
            ->editColumn('status', function ($qa) {
                return $qa->status == 1
                    ? '<span class="badge bg-success">Active</span>'
                    : '<span class="badge bg-danger">Inactive</span>';
            })
            ->rawColumns(['status', 'action']);
    }

    /**
     * Get query source.
     */
    public function query(InterviewQuestionAnswer $model)
    {
        $query = $model->newQuery()->with('topic');

        if (request()->has('topic_id')) {
            $query->where('topic_id', request()->get('topic_id'));
        }

        return $query;
    }


    /**
     * Configure HTML builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('interview-qa-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(5)
            ->responsive(true)
            ->parameters([
                'dom' => 'Bfrtip',
                'buttons' => ['excel', 'csv', 'pdf', 'print', 'reload'],
            ]);
    }

    /**
     * Define columns.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex')->title('Sr No')->width(50)->addClass('text-center'),
            Column::make('topic'),
            Column::make('question'),
            Column::make('type'),
            Column::make('status'),
            Column::make('created_at')->title('Added On')->width(120),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(100)
                ->addClass('text-center')
                ->title('Actions'),
        ];
    }

    protected function filename(): string
    {
        return 'InterviewQA_' . date('YmdHis');
    }
}
