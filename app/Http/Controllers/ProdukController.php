<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Menampilkan kategori di index produk
        $kategori = Kategori::all()->pluck('nama_kategori','id_kategori');

        return view('produk.index', compact('kategori'));
    }

    public function data(){

        $produk = Produk::leftJoin('kategori', 'kategori.id_kategori', 'produk.id_kategori')
                    ->select('produk.*', 'nama_kategori')
                    // ->orderBy('id_produk', 'desc')->get();// berdasarkan id produk
                    ->orderBy('kode_produk', 'asc')->get();

        return DataTables()
        ->of($produk)
        ->addIndexColumn()
        ->addColumn('select_all', function($produk){
            return '
                <input type="checkbox" name="id_produk[]" value="'. $produk->id_produk .'"/>
            ';
        })
        ->addColumn('kode_produk', function($produk){
            return '<span class="label label-success">'.$produk->kode_produk.'</span>';
        })
        ->addColumn('harga_beli', function($produk){
            return format_uang($produk->harga_beli);
        })
        ->addColumn('harga_jual', function($produk){
            return format_uang($produk->harga_jual);
        })
        ->addColumn('stok', function($produk){
            return format_uang($produk->stok);
        })
        ->addColumn('aksi', function ($produk) {
            return '
                <div class="btn-group">
                    <button type="button" onclick="editForm(`'. route('produk.update', $produk->id_produk) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                    <button type="button" onClick="deleteData(`'. route('produk.destroy', $produk->id_produk) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
            ';
        })
        ->rawColumns(['aksi', 'kode_produk', 'select_all'])
        ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   // ?? New Product() digunakan jika id_produk sama sekali belum ada/ belum pernah disi didalam table produk
        // Untuk menambahkan id_produk baru dengan id dimulai dari 1 jika diset auto increment
        $produk = Produk::latest()->first() ?? new Produk(); // Ambil produk paling terakhir ditambahkan atau dibaris pertama, lalu ambil ID nya (first()).
        // Menggunakan fungsi helper
        $request['kode_produk'] = 'P'. tambah_nol_didepan((int)$produk->id_produk +1, 6);
        $produk = Produk::create($request->all());


        // $kategori = new Kategori();
        // $kategori->nama_kategori = $request->nama_kategori;
        // $kategori->save();

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
        $produk = Produk::find($id);

        return response()->json($produk);
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
        $produk = Produk::find($id); // Ambil produk paling terakhir ditambahkan atau dibaris pertama, lalu ambil ID nya (first()).
        
        // Menggunakan fungsi helper
        // $request['kode_produk'] = 'P'. tambah_nol_didepan((int)$produk->id_produk +1, 6);
        
        $produk->update($request->all());

        // $produk = produk::find($id);
        // $produk->nama_produk = $request->nama_produk;
        // $produk->update();

        return response()->json('Data Berhasil disimpan', 200); // tidak terakai memakai yang dibagian ajax
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produk = Produk::find($id);
        $produk->delete();

        return response(null, 204);
    }

    public function deleteSelected(Request $request){

        foreach ($request->id_produk as $id) {
            
            $produk = Produk::find($id);
            $produk->delete();
        }

        return response(null, 204);
    }

    public function cetakBarcode(Request $request){

        $dataproduk = array();

        foreach($request->id_produk as $id){
            $produk = Produk::find($id);
            $dataproduk[] = $produk;
        }
        
        $no = 1;
        $pdf = PDF::loadView('produk.barcode', compact('dataproduk', 'no'));
        $pdf->setPaper('a4','potrait');
        return $pdf->stream('produk-toko-damar.pdf');
    }
}