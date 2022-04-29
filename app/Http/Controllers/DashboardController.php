<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Member;
use App\Models\Pembelian;
use App\Models\Pengeluaran;
use App\Models\Penjualan;
use App\Models\Produk;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        
        //Admin
        $kategori = Kategori::count();
        $member = Member::count();
        $supplier = Supplier::count();
        $produk = Produk::count();

        $tanggal_awal = date('Y-m-01');
        $tanggal_akhir = date('Y-m-d');
        $waktu_sekarang = Carbon::now();
        
        $data_pendapatan = array();
        $data_tanggal = array();

        while (strtotime($tanggal_awal) <= strtotime($tanggal_akhir)) {
            
            $data_tanggal[] = (int) substr($tanggal_awal, 8, 2);

            $total_penjualan = Penjualan::where('created_at', 'LIKE', "%$tanggal_awal%")->sum('bayar');
            $total_pembelian = Pembelian::where('created_at', 'LIKE', "%$tanggal_awal%")->sum('bayar');;
            $total_pengeluaran = Pengeluaran::where('created_at', 'LIKE', "%$tanggal_awal%")->sum('nominal');

            $pendapatan = $total_penjualan - $total_pembelian - $total_pengeluaran;
            $data_pendapatan[] += $pendapatan;

            $tanggal_awal = date('Y-m-d', strtotime("+1 day", strtotime($tanggal_awal)));
        }

        //Kasir
        $jumlah_penjualan = Penjualan::count();

        if(auth()->user()->level == 1){

            return view('admin.dashboard', compact('kategori','member', 'supplier', 'produk', 'tanggal_awal', 'tanggal_akhir', 'data_tanggal', 'data_pendapatan'));
        } else {

            return view('kasir.dashboard', compact('waktu_sekarang', 'produk', 'jumlah_penjualan'));
        }
    }

    public function kasirDataPenjualan(){
        
        $penjualan = Penjualan::orderBy('id_penjualan', 'desc')->get();

            return DataTables()
            ->of($penjualan)
            ->addIndexColumn()
            ->addColumn('total_item',function($penjualan){
    
                return format_uang($penjualan->total_item);
            })
            ->addColumn('total_harga',function($penjualan){
                
                return 'Rp. '. format_uang($penjualan->total_harga);
            })
            ->addColumn('bayar',function($penjualan){
                
                return 'Rp. '. format_uang($penjualan->bayar);
            })
            ->addColumn('tanggal', function($penjualan){
    
                return tanggal_indonesia($penjualan->created_at, false);
            })
            ->addColumn('jam', function($penjualan){
    
                return $penjualan->created_at->format('H:i');
            })
            ->addColumn('kode_member', function ($penjualan) {
                $member = $penjualan->member->kode_member ?? '';
                return '<span class="label label-success">'. $member .'</spa>';
            })
            ->editColumn('diskon', function($penjualan){
    
                return $penjualan->diskon. ' %';
            })
            ->editColumn('kasir', function($penjualan){
    
                return $penjualan->user->name ?? '';
            })
            ->rawColumns(['kode_member'])
            ->make(true);
    }

    public function kasirDataProduk(){

        $produk = Produk::leftJoin('kategori', 'kategori.id_kategori', 'produk.id_kategori')
                    ->select('produk.*', 'nama_kategori')
                    // ->orderBy('id_produk', 'desc')->get();// berdasarkan id produk
                    ->orderBy('kode_produk', 'asc')->get();

        return DataTables()
        ->of($produk)
        ->addIndexColumn()
        ->addColumn('kode_produk', function($produk){
            return '<span class="label label-success">'.$produk->kode_produk.'</span>';
        })
        ->addColumn('harga_jual', function($produk){
            return format_uang($produk->harga_jual);
        })
        ->addColumn('stok', function($produk){
            return format_uang($produk->stok);
        })
        ->rawColumns(['kode_produk'])
        ->make(true);
    }

    public function kasirPenjualan(){

        return view('kasir.riwayatpenjualan');
    }

    public function kasirDaftarProduk(){

        return view('kasir.daftarproduk');
    }

}
