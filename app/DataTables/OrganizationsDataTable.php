<?php

namespace App\DataTables;

use App\Models\Organization;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class OrganizationsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Organization> $query
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()

            ->editColumn('name', function ($organization) {
                $logo = $organization->logo
                    ? asset('storage/' . $organization->logo)
                    : asset('images/no-logo.png');

                return '
                    <div class="d-flex align-items-center">
                        <img src="' . $logo . ' "alt="Logo" class="rounded-circle border shadow-sm me-2" style="width:45px;height:45px;object-fit:cover;">
                        <span class="fw-semibold text-dark">' . e($organization->name) . '</span>
                    </div>
                ';
            })

            ->editColumn('established', function ($organization) {
                return $organization->established
                    ? date('d M Y', strtotime($organization->established))
                    : 'N/A';
            })

            ->editColumn('created_at', function ($organization) {
                return $organization->created_at
                    ? $organization->created_at->format('d M Y H:i')
                    : 'N/A';
            })

            ->addColumn('action', function ($organization) {
                return view('admin.organizations.action', compact('organization'))->render();
            })

            ->rawColumns(['action', 'name']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Organization>
     */
    public function query(Organization $model): QueryBuilder
    {
        return $model->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('organizations-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
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
            Column::computed('DT_RowIndex')
                ->title('Sr No')
                ->width(50)
                ->addClass('text-center'),

            Column::make('name')->title('Organization')->orderable(true)->searchable(true),

            Column::make('type')->title('Type'),
            Column::make('sector')->title('Sector'),
            Column::make('purpose')->title('Purpose'),
            Column::make('established')->title('Established'),

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
        return 'Organizations_' . date('YmdHis');
    }
}
