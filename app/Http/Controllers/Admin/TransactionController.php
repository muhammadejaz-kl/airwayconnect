<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\TransactionsDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class TransactionController extends Controller
{
    public function index(TransactionsDataTable $dataTable){
        return $dataTable->render("admin.transactions.index");
    }
}