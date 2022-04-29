<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){

        return view('user.index');
    }

    public function data(){

        $user = User::IsNotAdmin()->orderBy('id', 'desc')->get(); // secara default Asc

        return DataTables()
        ->of($user)
        ->addIndexColumn()
        ->addColumn('aksi', function ($user) {
            return '
                <div class="btn-group">
                    <button type="button" onclick="editForm(`'. route('user.update', $user->id) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                    <button type="button" onClick="deleteData(`'. route('user.destroy', $user->id) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
            ';
        })
        ->rawColumns(['aksi'])
        ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $this->attributes['password'] = bcrypt($request->password);
        $user->level = 2;
        $user->foto = '/img/default_avatar.jpg';
        $user->save();

        return response()->json('Data Berhasil disimpan', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        // Check apakah user memiliki password?
        if ($request->has('password') && $request->password != "") 
            $user->password = $this->attributes['password'] = bcrypt($request->password);
        $user->update();

        return response()->json('Data Berhasil diupdate', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return response(null, 204);
    }

    public function profil(){

        $profil = auth()->user();

        return view('user.profil', compact('profil'));
    }

    public function updateProfil(Request $request){

        $user = User::find(auth()->user()->id);
        $user->name = $request->name;

        if ($request->has('password') && $request->password != "") {
            
            if(Hash::check($request->password_lama, $user->password)){
                
                if ($request->password == $request->password_confirmation) {
                    
                    $user->password = bcrypt($request->password);
                } else {

                    return response()->json("Konfirmasi password baru tidak sesuai", 422);
                }
            } else {

                return response()->json("Password tama tidak sesuai", 422);
            }
        }

        if ($request->hasFile('foto')) {
            
            $file = $request->file('foto');
            $nama = 'Foto-'. date('Y-m-dHis') . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('/img'), $nama); // simpan ke public directory

            $user->foto = "/img/$nama"; // simpan ke database
        }

        $user->update();

        return response()->json($user, 200);
    }
}
