<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

//GENERAL
function is_able($action)
{
    $role = [
        'Admin' => [
            'home',
            'user.index', 'user.create', 'user.store', 'user.edit', 'user.update', 'user.destroy', 'user.cetak',
            'user.password', 'user.password.update', 'user.logout', 'user.profil', 'user.profil.update',
            'produk.index', 'produk.create', 'produk.store', 'produk.edit', 'produk.update', 'produk.destroy', 'produk.cetak',
            'penjualan.index', 'penjualan.create', 'penjualan.store', 'penjualan.edit', 'penjualan.update', 'penjualan.destroy', 'penjualan.cetak',
            'rel_produk.index', 'rel_produk.simpan',
            'rel_penjualan.index', 'rel_penjualan.simpan',
            'periode.index', 'periode.create', 'periode.store', 'periode.edit', 'periode.update', 'periode.destroy', 'periode.cetak',
            'penjualan.index', 'penjualan.edit', 'penjualan.update',
            'hitung.index', 'hitung.detail', 'hitung.hasil', 'hitung.hasil.cetak', 'hitung.cetak',
        ],
        'Manager' => [
            'home',
            'user.password', 'user.password.update', 'user.logout', 'user.profil', 'user.profil.update',
            'hitung.index', 'hitung.detail', 'hitung.hasil', 'hitung.hasil.cetak', 'hitung.cetak',
        ],
    ];
    $user = Auth::user();
    if ($user) {
        if (in_array(strtolower($user->level), array_keys($role))) {
            return in_array($action, $role[strtolower($user->level)]);
        }
    }
}

function is_hidden($action)
{
    return is_able($action) ? '' : 'hidden';
}

function is_admin()
{
    return Auth::user()->level == 'admin';
}

function is_user()
{
    return Auth::user()->level == 'user';
}

function get_produk_option($selected = '')
{
    $arr = get_produk();
    $a = '';
    foreach ($arr as $key => $val) {
        if ($key == $selected)
            $a .= '<option value="' . $key . '" selected>' . $val->nama_produk . '</option>';
        else
            $a .= '<option value="' . $key . '">' . $val->nama_produk . '</option>';
    }
    return $a;
}

function get_produk()
{
    $rows = get_results("SELECT * FROM tb_produk ORDER BY kode_produk");
    $arr = array();
    foreach ($rows as $row) {
        $arr[$row->kode_produk] = $row;
    }
    return $arr;
}

function get_periode()
{
    $rows = get_results("SELECT * FROM tb_periode ORDER BY kode_periode");
    $arr = array();
    foreach ($rows as $row) {
        $arr[$row->kode_periode] = $row;
    }
    return $arr;
}


function format_date($data, $format = 'd-M-Y')
{
    return date($format, strtotime($data));
}

function current_user()
{
    return User::find(Auth::id());
}

function get_level_option($selected = '')
{
    $arr = [
        'Admin' => 'Admin',
        'Manager' => 'Manager'
    ];
    $a = '';
    foreach ($arr as $key => $value) {
        if ($selected == $key)
            $a .= "<option value='$key' selected>$value</option>";
        else
            $a .= "<option value='$key'>$value</option>";
    }
    return $a;
}

function get_status_user_option($selected = '')
{
    $arr = [
        1 => 'Aktif',
        0 => 'NonAktif'
    ];
    $a = '';
    foreach ($arr as $key => $value) {
        if ($selected == $key)
            $a .= "<option value='$key' selected>$value</option>";
        else
            $a .= "<option value='$key'>$value</option>";
    }
    return $a;
}

function print_msg($msg, $type = 'danger')
{
    echo ('<div class="alert alert-' . $type . ' alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $msg . '</div>');
}

function show_error($errors)
{
    if ($errors->any()) {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <ul class="m-0">';
        foreach ($errors->all() as $error) {
            echo '<li>' . $error . '</li>';
        }
        echo '</ul><button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button></div>';
    }
}
function show_msg()
{
    if ($messsage = session()->get('message')) {
        echo '<div class="alert alert-info alert-dismissible fade show" role="alert">'
            . $messsage . '
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
        </div>';
    }
}

function rp($number)
{
    return 'Rp ' . number_format($number);
}

function kode_oto($field, $table, $prefix, $length)
{
    $var = get_var("SELECT $field FROM $table WHERE $field REGEXP '{$prefix}[0-9]{{$length}}' ORDER BY $field DESC");
    if ($var) {
        return $prefix . substr(str_repeat('0', $length) . ((int)substr($var, -$length) + 1), -$length);
    } else {
        return $prefix . str_repeat('0', $length - 1) . 1;
    }
}

function get_row($sql = '')
{
    $rows =  DB::select($sql);
    if ($rows)
        return $rows[0];
}

function get_results($sql = '')
{
    return DB::select($sql);
}

function get_var($sql = '')
{
    $row = DB::select($sql);
    if ($row) {
        return current(current($row));
    }
}

function query($sql, $params = [])
{
    return DB::statement($sql, $params);
}
