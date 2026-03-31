<?php

namespace App\DataTables;

use App\Models\Forum;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ForumDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()

            ->editColumn('banner', function ($forum) {
                if ($forum->banner) {
                    return '<img src="' . asset('storage/' . $forum->banner) . '" width="50" height="50" class="rounded">';
                }
                return 'N/A';
            })

            ->editColumn('topic_ids', function ($forum) {
                $topicNames = '';
                if (!empty($forum->topic_ids)) {
                    $topicIds = is_array($forum->topic_ids) ? $forum->topic_ids : json_decode($forum->topic_ids, true);
                    if ($topicIds) {
                        $topics = \App\Models\ForumTopic::whereIn('id', $topicIds)->pluck('topic')->toArray();
                        $topicNames = implode(', ', $topics);
                    }
                }
                return $topicNames ?: 'No Topics';
            })

            ->editColumn('status', function ($forum) {
                return $forum->status == 1
                    ? '<span class="badge bg-success">Active</span>'
                    : '<span class="badge bg-danger">Inactive</span>';
            })

            ->editColumn('created_at', function ($forum) {
                return $forum->created_at ? $forum->created_at->format('d M Y H:i') : 'N/A';
            })

            ->addColumn('action', function ($forum) {
                return view('admin.forums.forums.action', compact('forum'))->render();
            })

            ->rawColumns(['banner', 'status', 'action']);
    }

    public function query(Forum $model): QueryBuilder
    {
        return $model->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('forums-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(4)
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ]);
    }

    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex')
                ->title('Sr No')
                ->width(50)
                ->addClass('text-center'),
            Column::make('name'),
            Column::make('topic_ids')->title('Topics'),
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

    protected function filename(): string
    {
        return 'Forums_' . date('YmdHis');
    }
}
