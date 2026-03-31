<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<User> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->editColumn('phone_number', function ($user) {
                return $user->phone_code && $user->phone_number
                    ? $user->phone_code . ' ' . $user->phone_number
                    : 'N/A';
            })
            ->editColumn('status', function ($user) {
                $checked = $user->status == 1 ? 'checked' : '';
                return '
                <label class="switch">
                    <input type="checkbox" class="toggle-status" data-id="' . $user->id . '" ' . $checked . '>
                    <span class="slider round"></span>
                </label>
            ';
            })
            ->editColumn('created_at', function ($user) {
                return $user->created_at ? $user->created_at->format('d M Y H:i') : 'N/A';
            })
            ->addColumn('action', function ($user) {
                $hideEdit = request()->routeIs('admin.dashboard'); // hide edit on dashboard
                return view('admin.users.action', compact('user', 'hideEdit'))->render();
            })
            ->rawColumns(['status', 'action']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<User>
     */
    public function query(User $model): QueryBuilder
    {
        $query = $model->role('user');

        if (request()->routeIs('admin.dashboard')) {
            return $query->latest()->limit(5);
        }

        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $builder = $this->builder()
            ->setTableId('users-table')
            ->columns($this->getColumns())
            ->orderBy(5);

        if (request()->routeIs('admin.dashboard')) {
            return $builder->minifiedAjax()->parameters([
                'paging' => false,
                'searching' => false,
                'info' => false,
                'lengthChange' => false,
            ]);
        }

        return $builder->minifiedAjax()->buttons([
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
            Column::make('name'),
            Column::make('email'),
            Column::make('phone_number'),
            Column::make('status'),
            Column::make('created_at')->title('Joined On'),
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
        return 'Users_' . date('YmdHis');
    }
}
