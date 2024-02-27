<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class DataTableController extends Controller
{
    public function dashboard()
    {
        return view('dashboard');
    }
    public function clientSide(Request $request)
    {
        $data = new User;
        if($request->get('search')) {
            $data = $data->where('name', 'like', '%' . $request->get('search') . '%')->orWhere('email', 'like', '%' . $request->get('search') . '%');
        }
        $data = $data->get();
        return view('datatable.clientside', compact('data', 'request'));
    }
}
