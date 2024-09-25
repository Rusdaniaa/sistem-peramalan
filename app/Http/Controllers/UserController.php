<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function loginForm()
    {
        return view('user.login');
    }
    public function loginAction(Request $request)
    {
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Salah kombinasi username dan password',
        ]);
    }
    public function password()
    {
        $data['title'] = 'Ubah Password';
        $data['user'] = Auth::user();
        return view('user.password', $data);
    }
    public function setting()
    {
        $data['title'] = 'Ubah Profil';
        return view('user.setting', $data);
    }

    public function settingUpdate(Request $request)
    {
        $request->validate([
            'nama_user' => 'required',
            'username' => 'required',
        ], [
            'nama_user.required' => 'Nama user harus diisi',
            'username.required' => 'Username harus diisi',
        ]);
        $user = current_user();
        if (get_row("SELECT * FROM tb_user WHERE username='{$request->username}' AND id_user<>'$user->id_user'"))
            return back()->withErrors([
                'username' => 'Username sudah terdaftar!',
            ]);

        $user->nama_user = $request->nama_user;
        $user->username = $request->username;

        $user->save();
        $request->session()->regenerate();
        return back()->with('message', 'Data berhasil diubah!');
    }
    public function passwordUpdate(Request $request)
    {
        $request->validate([
            'pass1' => 'required',
            'pass2' => 'required|confirmed',
        ], [
            'pass1.required' => 'Password lama harus diisi',
            'pass2.required' => 'Password baru harus diisi',
            'pass2.confirmed' => 'Password baru dan konfirmasi password baru harus sama',
        ]);
        $user = current_user();
        if (!Hash::check($request->pass1, $request->user()->password))
            return back()->withErrors([
                'username' => 'Password lama salah!',
            ]);

        $user->password = Hash::make($request->pass2);
        $user->save();
        $request->session()->regenerate();
        return back()->with('message', 'Data berhasil diubah!');
    }
     public function cetak()
     {
        $data['title'] = 'Laporan Data User';
        $data['no'] = 1;
        $data['rows'] = User::orderBy('id_user')->get();
        return view('user.cetak', $data);
     }

    public function index(Request $request)
    {
        $data['q'] = $request->input('q');
        $data['title'] = 'Data User';
        $data['limit'] = 10;
        $data['rows'] = User::where('nama', 'like', '%' . $data['q'] . '%')
            ->orderBy('id_user')
            ->paginate($data['limit'])->withQueryString();
        return view('user.index', $data);


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['title'] = 'Tambah User';
        return view('user.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'username' => 'required|unique:user',
            'password' => 'required',
            'level' => 'required',
        ], [
            'nama.required' => 'Nama user harus diisi',
            'username.required' => 'Username harus diisi',
            'username.unique' => 'Username harus unik',
            'password.required' => 'Password harus diisi',
            'level.required' => 'Level harus diisi',

        ]);
        $user = new User($request->all());
        $user->save();
        return redirect('user')->with('message', 'Data berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $data['row'] = $user;
        $data['title'] = 'Ubah User';
        return view('user.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'nama' => 'required',
            'username' => 'required',
            'password' => 'required',
            'level' => 'required',
        ], [
            'nama.required' => 'Nama user harus diisi',
            'username.required' => 'Username harus diisi',
            'username.unique' => 'Username harus unik',
            'password.required' => 'Password harus diisi',
            'level.required' => 'Level harus diisi',
        ]);

        if (get_row("SELECT * FROM user WHERE username='{$request->username}' AND id_user<>'$user->id_user'"))
            return back()->withErrors([
                'username' => 'Username sudah terdaftar!',
            ]);

        $user->nama = $request->nama;
        $user->username = $request->username;
        $user->password = $request->password;
        $user->level = $request->level;
        $user->save();
        return redirect('user')->with('message', 'Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect('user')->with('message', 'Data berhasil dihapus!');
    }
}
