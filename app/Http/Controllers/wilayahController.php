<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use carbon\carbon;
use Session;
use Illuminate\Support\Facades\Crypt;
use Exception;
use Response;
class wilayahController extends Controller
{
    public function index()
    {
    	return view('welcome');
    }

    public function save_wilayah(Request $req)
    {
    	DB::beginTransaction();
    	try {
    		$id = DB::table('kota')->max('id')+1;

    		$key = array_keys($req->all());
    		$value = $req->all();

    		for ($i=0; $i < count($key); $i++) { 
    			$save['id'] = $id;
    			if ($key[$i] == 'wilayah' or $key[$i] == 'wilayah1') {
    			}else{
                    $save[$key[$i]] = $value[$key[$i]];
                }
    		}
    		$lat = '';
    		$lng = '';
    		for ($i=0; $i < count($req->wilayah); $i++) { 
    			if ($i == 0) {
    				$lat = $lat.$req->wilayah[$i]['lat'];
    				$lng = $lng.$req->wilayah[$i]['lng'];
    			}else{
    				$lat = $lat.','.$req->wilayah[$i]['lat'];
	    			$lng = $lng.','.$req->wilayah[$i]['lng'];
    			}
	    			
    			
    		}

            $save['wilayah_latitude'] = $lat;
            $save['wilayah_longitude'] = $lng;
            $lat = '';
            $lng = '';
            for ($i=0; $i < count($req->wilayah1); $i++) { 
                if ($i == 0) {
                    $lat = $lat.$req->wilayah1[$i]['lat'];
                    $lng = $lng.$req->wilayah1[$i]['lng'];
                }else{
                    $lat = $lat.','.$req->wilayah1[$i]['lat'];
                    $lng = $lng.','.$req->wilayah1[$i]['lng'];
                }
                    
                
            }

            $save['wilayah1_latitude'] = $lat;
            $save['wilayah1_longitude'] = $lng;
			DB::table('kota')->insert($save);
    		DB::commit();

    		return Response::json(['status'=>1,'pesan'=>'data berhasil disimpan']);
    	} catch (Exception $e) {
    		DB::rollBack();
    		dd($e);
    	}
    }

    public function show_wilayah()
    {
        $data = DB::table('kota')
                  ->get();


        return view('modal',compact('data'));
    }

    public function load_wilayah(Request $req)
    {
        $data = DB::table('kota')->where('id',$req->id)->first();

        $data->wilayah_latitude = explode(',', $data->wilayah_latitude);
        $data->wilayah_longitude = explode(',', $data->wilayah_longitude);

        $data->wilayah1_latitude = explode(',', $data->wilayah1_latitude);
        $data->wilayah1_longitude = explode(',', $data->wilayah1_longitude);
        return view('edit',compact('data'));
    }

    public function update_wilayah(Request $req)
    {
        DB::beginTransaction();
        try {
            $id = $req->id;

            $key = array_keys($req->all());
            $value = $req->all();

            for ($i=0; $i < count($key); $i++) { 
                $save['id'] = $id;
                if ($key[$i] != 'wilayah') {
                    $save[$key[$i]] = $value[$key[$i]];
                }
            }
            $lat = '';
            $lng = '';

            if (isset($req->wilayah)) {
                for ($i=0; $i < count($req->wilayah); $i++) { 
                    if ($i == 0) {
                        $lat = $lat.$req->wilayah[$i]['lat'];
                        $lng = $lng.$req->wilayah[$i]['lng'];
                    }else{
                        $lat = $lat.','.$req->wilayah[$i]['lat'];
                        $lng = $lng.','.$req->wilayah[$i]['lng'];
                    }
                }
                $save['wilayah_latitude'] = $lat;
                $save['wilayah_longitude'] = $lng;
            }
                
            

            DB::table('kota')->where('id',$id)->update($save);
            DB::commit();

            return Response::json(['status'=>1,'pesan'=>'data berhasil diupdate']);
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }

    public function hapus_wilayah(Request $req)
    {
        DB::beginTransaction();
        try {
            DB::table('kota')->where('id',$req->id)->delete();
            DB::commit();
            return Response::json(['status'=>1,'pesan'=>'data berhasil dihapus']);
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }

    public function load_all(Request $req)
    {
        if (!isset($req->id)) {
            $id = DB::table('kota')->first()->id;
        }else{
            $id = $req->id;
        }

        $init = DB::table('kota')->where('id',$id)->first(); 
            
        $data = DB::table('kota')->get();
        foreach ($data as $i => $d) {
           $data[$i]->wilayah_latitude = explode(',', $data[$i]->wilayah_latitude);
           $data[$i]->wilayah_longitude = explode(',', $data[$i]->wilayah_longitude);
        }
        
        return view('load_all',compact('data','init'));
    }
}
