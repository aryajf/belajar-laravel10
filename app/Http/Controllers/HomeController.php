<?php

namespace App\Http\Controllers;

use App\Imports\UserImport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use Excel;

class HomeController extends Controller
{
    // Middleware satu controller
    // public function __construct()
    // {
    //     $this->middleware(['can:view_dashboard']);
    // }

    public function dashboard()
    {
        return view('dashboard');
    }
    public function assets(Request $request)
    {
        $data = new User;
        if ($request->get('search')) {
            $data = $data->where('name', 'like', '%' . $request->get('search') . '%')->orWhere('email', 'like', '%' . $request->get('search') . '%');
        }
        $data = $data->get();

        if ($request->get('export') == 'pdf') {
            $pdf = Pdf::loadView('pdf.assets', compact('data'));
            return $pdf->stream('Data Assets.pdf');
        }

        return view('assets', compact('data', 'request'));
    }
    public function index(Request $request)
    {
        $data = new User;
        if ($request->get('search')) {
            $data = $data->where('name', 'like', '%' . $request->get('search') . '%')->orWhere('email', 'like', '%' . $request->get('search') . '%');
        }
        $data = $data->get();
        return view('index', compact('data', 'request'));
    }
    public function create()
    {
        return view('create');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|mimes:png,jpg,jpeg|max:2048',
            'email' => 'required|email',
            'name' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);


        $image = $request->file('image');
        $filename = date('Y-m-d') . $image->hashName();
        $path = 'photo-user/' . $filename;

        Storage::disk('public')->put($path, file_get_contents($image));

        $data['email']      = $request->email;
        $data['name']       = $request->name;
        $data['password']   = Hash::make($request->password);
        $data['image']      = $filename;

        User::create($data);

        return redirect()->route('admin.user.index');
    }

    public function edit(Request $request, $id)
    {
        $data = User::find($id);
        return view('edit', compact('data'));
    }

    public function detail(Request $request, $id)
    {
        $data = User::find($id);
        return view('detail', compact('data'));
    }

    public function import()
    {
        return view('import');
    }
    public function import_proses(Request $request)
    {
        Excel::import(new UserImport(), $request->file('file'));

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $validator = Validator::make($request->all(), [
            'image' => 'nullable|mimes:png,jpg,jpeg|max:2048',
            'email' => 'required|email',
            'name' => 'required',
            'password' => 'nullable',
        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        if ($request->file('image')) {
            $image = $request->file('image');
            $filename = date('Y-m-d') . $image->hashName();
            $path = 'photo-user/' . $filename;
            $data['image'] = $filename;
            Storage::disk('public')->put($path, file_get_contents($image));
            if ($user->image) {
                if (Storage::exists('public/photo-user/' . $user->image)) {
                    Storage::delete('public/photo-user/' . $user->image);
                }
            }
        }

        $data['email'] = $request->email;
        $data['name']  = $request->name;
        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.user.index');
    }

    public function delete(Request $request, $id)
    {
        $user = User::without('image')->find($id);
        $user->disableImageAccessor();
        if ($user) {
            $user->delete();
            if ($user->image) {
                // if (Storage::exists('public/photo-user/' . $user->image)) {
                //     Storage::delete('public/photo-user/' . $user->image);
                // }
            }
        }
        return redirect()->route('admin.user.index');
    }
}
