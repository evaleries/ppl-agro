<?php

namespace App\Http\Controllers\User;

use App\DataTables\User\UserOrderDataTable;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function orders(UserOrderDataTable $dataTable)
    {
        return $dataTable->render('frontpages.account.orders');
    }
}
