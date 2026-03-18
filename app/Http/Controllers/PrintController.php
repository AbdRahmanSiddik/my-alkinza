<?php

namespace App\Http\Controllers;


class PrintController extends Controller
{
 public function json($id)
    {
        $trx = Transaksi::with('produkPivot.produk')->where('id', $id)->first();
    
        $data = [];
    
        $data[] = [
            "type"=>0,
            "content"=>session('toko.name'),
            "bold"=>1,
            "align"=>1,
            "format"=>2
        ];
    
        $data[] = [
            "type"=>0,
            "content"=>"Invoice: ".$trx->kode_transaksi,
            "bold"=>0,
            "align"=>0
        ];
    
        foreach($trx->produkPivot as $item){
            $data[] = [
                "type"=>0,
                "content"=>$item->produk->name." x".$item->kuantitas." = ".$item->subtotal,
                "bold"=>0,
                "align"=>0
            ];
        }
    
        $data[]=[
            "type"=>0,
            "content"=>"Total : ".$trx->subtotal,
            "bold"=>1,
            "align"=>2
        ];
    
        return response()->json($data);
    }
   
}