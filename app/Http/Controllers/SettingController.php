<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(){

        return view('pengaturan.index');
    }

    public function show(){

        return Setting::first();
    }

    public function update(Request $request){

        $setting = Setting::first();

        $setting->nama_perusahaan = $request->nama_perusahaan;
        $setting->telepon = $request->telepon;
        $setting->alamat = $request->alamat;
        $setting->diskon = $request->diskon;
        $setting->tipe_nota = $request->tipe_nota;

        //path file
        if ($request->hasFile('path_logo')) {
            
            $file = $request->file('path_logo');
            $nama = 'logo-'. date('Y-m-dHis') . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('/img'), $nama); // simpan ke public directory

            $setting->path_logo = "/img/$nama"; // simpan ke database
        }

        if ($request->hasFile('path_kartu_member')) {
            
            $file = $request->file('path_kartu_member');
            $nama = 'kartu-member-'. date('Y-m-dHis') . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('/img'), $nama); // simpan ke public directory

            $setting->path_kartu_member = "/img/$nama"; // simpan ke database
        }

        $setting->update();

        return response()->json('Data Berhasil Update', 200);
    }
}
