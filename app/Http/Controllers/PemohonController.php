<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Pemohon;
use App\Models\Pemohonan;
use App\Models\Rincian_layanan;
use App\Models\Rincian_Permohonan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PemohonController extends Controller
{

    public function getinfopemohon($id)
    {
        $product = Pemohon::findOrFail($id);
        return response()->json($product, 200);
    }

    // set index page view
    public function index()
    {
        $layanan = Layanan::all();
        return view('pemohon.index2', compact('layanan'));
    }

    public function get(Request $request)
    {

        $rincian_layanan = Rincian_layanan::with('layanan', 'persyaratan')->where('id_layanan', $request->id)->get();
        $first = Rincian_layanan::with('layanan', 'persyaratan')->where('id_layanan', $request->id)->first();
        $datadata = [
            $request->session()->put('nik', $request->nik),
            $request->session()->put('no_kk', $request->no_kk),
            $request->session()->put('nama_pemohon', $request->nama_pemohon),
            $request->session()->put('alamat', $request->alamat),
            $request->session()->put('no_hp', $request->no_hp),
            $request->session()->put('email', $request->email),
            $request->session()->put('id_user', Auth::user()->id),
        ];

        $nik =  $request->session()->get('nik');
        $no_kk =  $request->session()->get('no_kk');
        $nama_pemohon =  $request->session()->get('nama_pemohon');
        $alamat =  $request->session()->get('alamat');
        $no_hp =  $request->session()->get('no_hp');
        $email =  $request->session()->get('email');
        $id_user =  $request->session()->get('id_user');

        // dd($request->all());
        return view('pemohon.rincian_layanan', compact('rincian_layanan', 'first', 'nik', 'no_kk', 'nama_pemohon', 'alamat', 'no_hp', 'email', 'id_user'));
    }



    // handle fetch all eamployees ajax request
    public function all()
    {
        $emps = Pemohon::all();
        $output = '';
        $p = 1;
        if ($emps->count() > 0) {
            $output .= '<table class="table table-striped table-sm text-center align-middle">
            <thead>
              <tr>
                <th>No</th>
                <th>Nik</th>
                <th>No KK</th>
                <th>Nama Pemohon</th>
                <th>Alamat</th>
                <th>No HP</th>
                <th>Email</th>
                <th>User Name</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>';
            foreach ($emps as $emp) {
                $output .= '<tr>
                <td>' . $p++ . '</td>
                <td>' . $emp->nik . '</td>
                <td>' . $emp->no_kk . '</td>
                <td>' . $emp->nama_pemohon . '</td>
                <td>' . $emp->alamat . '</td>
                <td>' . $emp->no_hp . '</td>
                <td>' . $emp->email . '</td>
                <td>' . $emp->user->name . '</td>
                <td>
                  <a href="#" id="' . $emp->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editTUModal"><i class="bi-pencil-square h4"></i></a>

                  <a href="#" id="' . $emp->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
                </td>
              </tr>';
            }
            $output .= '</tbody></table>';
            echo $output;
        } else {
            echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
        }
    }

    // handle insert a new Tu ajax request


    public function store(Request $request)
    {
        dd($request->all());

        // dd($request->session()->all());
        $datadata = [
            $request->session()->put('nik', $request->nik),
            $request->session()->put('no_kk', $request->no_kk),
            $request->session()->put('nama_pemohon', $request->nama_pemohon),
            $request->session()->put('alamat', $request->alamat),
            $request->session()->put('no_hp', $request->no_hp),
            $request->session()->put('email', $request->email),
            $request->session()->put('id_user', Auth::user()->id),
        ];




        $p = 1;

        $create = [
            $request->session()->put('id_permohonan', 1),
            $request->session()->put('id_user', Auth::user()->id),
            $request->session()->put('id_layanan', $request->id_layanan),
            $request->session()->put('tanggal', $request->tanggal),
        ];



        // $pemohonan = Pemohonan::create($create);
        // $data = $request->all();

        $cities = Rincian_layanan::with('layanan', 'persyaratan')->where('id_layanan', $request->id)->get();
        // dd(count($cities));

        // foreach ($cities as $p) {
        //     $data2 = [
        //         'id_permohonan' => $pemohonan->id,
        //         'id_persyaratan' => $p->id_persyaratan,
        //         'entry_data' => $request['entry_data'],
        //         'upload_data' => $request['upload_data']x    x   x
        //     ];
        // }

        // $k = count($request->entry_data0);

        if ($request->upload_data0) {
            $k = count($request->entry_data0);
        }
        if ($request->upload_data0) {
            $p = count($request->upload_data0);
        }
        $entry_dataarray = array();
        $upload_dataarray = array();

        if ($request->entry_data0) {
            for (
                $y = 0;
                $y < count($request->entry_data0);
                $y++
            ) {
                array_push($entry_dataarray, $request->entry_data0[$y]);
            }
        }




        if ($request->upload_data0) {


            for (
                $n = 0;
                $n < count($cities);
                $n++
            ) {

                $name = time() . '.' . $request->upload_data0[$n]->getClientOriginalExtension();
                $request->upload_data0[$n]->storeAs('public/images', $name);
                array_push($upload_dataarray, $name);

                // array_push($upload_dataarray, $request->upload_data0[$n]);
            }
        }

        $nik =  $request->session()->get('nik');
        $no_kk =  $request->session()->get('no_kk');
        $nama_pemohon =  $request->session()->get('nama_pemohon');
        $alamat =  $request->session()->get('alamat');
        $no_hp =  $request->session()->get('no_hp');
        $email =  $request->session()->get('email');
        $id_user =  $request->session()->get('id_user');

        $id_permohonan =  $request->session()->get('id_permohonan');
        $id_user =  $request->session()->get('id_user');
        $id_layanan =  $request->session()->get('id_layanan');
        $tanggal =  $request->session()->get('tanggal');

        $request->session()->put('id_persyaratan', $request->id_persyaratan);
        $request->session()->put('entry_data', $entry_dataarray);
        $request->session()->put('upload_data', $upload_dataarray);

        $id_persyaratan =  $request->session()->get('id_persyaratan');
        $entry_data =  $request->session()->get('entry_data');
        $upload_data =  $request->session()->get('upload_data');

        // dd($entry_data);


        // dd($storge);
        // dd($request->session()->all());
        // $permohonan = Pemohonan::where('id', $rincian->id_permohonan)->first();

        return view('pemohon.review', compact(
            'nik',
            'no_kk',
            'nama_pemohon',
            'alamat',
            'no_hp',
            'email',
            'id_user',
            'id_permohonan',
            'id_user',
            'id_layanan',
            'tanggal',
            'id_persyaratan',
            'entry_data',
            'upload_data'
        ));
    }

    public function storeakhir(Request $request)
    {

        // dd($request->all());
        $empData = [
            'nik' => $request->nik,
            'no_kk' => $request->no_kk,
            'nama_pemohon' => $request->nama_pemohon,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'id_user' => Auth::user()->id,
        ];
        $pemohon = Pemohon::create($empData);

        //dd($pemohon);
        $p = 1;
        $create = [
            'id_permohonan' => '1',
            'id_pemohon' => $pemohon->id,
            'id_user' => $pemohon->id_user,
            'id_layanan' => $request->id_layanan,
            'tanggal' => null
        ];
        $pemohonan = Pemohonan::create($create);
        $data = $request->all();

        $cities = Rincian_layanan::with('layanan', 'persyaratan')->where('id_layanan', $request->id_layanan)->get();
        // dd($cities);
        $pe = [];
        foreach ($cities as $p) {
            $data2 = [
                'id_permohonan' => $pemohonan->id,
                'id_persyaratan' => $p->id_persyaratan,
                'entry_data' => $request['entry_data'],
                'upload_data' => $request['upload_data']
            ];
            $yaha =  $p->id_persyaratan;
            array_push($pe, $yaha);
        }
        // dd($pe);



        $anjing = [];
        foreach ($request['entry_data0'] as $item => $value) {

            $akuu = array(
                'entry_data' => $request['entry_data0'][$item],
                'id_permohonan' => $pemohonan->id,
                'id_persyaratan' => $pe[$item],
                // 'upload_data' => $request['upload_data0'][$item]
            );
            // array_push($jsonNilai2, $aa);
            $haha = Rincian_Permohonan::create($akuu);
            array_push($anjing, $haha);
        }
        // dd($anjing);

        if (isset($request['upload_data0'])) {
            foreach ($anjing as $item => $value) {
                if (isset($request['upload_data0'][$item]) == 0) {
                    $aa = array(
                        'upload_data' => null
                        // 'upload_data' => $request['upload_data0'][$item]
                    );
                    Rincian_Permohonan::where('id', $value->id)->update($aa);
                }
                if (isset($request['upload_data0'][$item])) {
                    $aa = array(
                        'upload_data' => $request['upload_data0'][$item]
                        // 'upload_data' => $request['upload_data0'][$item]
                    );
                    Rincian_Permohonan::where('id', $value->id)->update($aa);
                }


                }
        }
        return redirect('/pemohonan');
    }

    // dd($akuu);

    // dd($haha);

    // return back();

    // $permohonan = Pemohonan::where('id', $rincian->id_permohonan)->first();



    public function step(Request $request)
    {
        $create = [
            'id_layanan' => $request->id_layanan
        ];

        $pemohonan = Pemohonan::create($create);
        return response()->json([
            'status' => 200,
        ]);
    }


    // handle edit an Tu ajax request
    public function edit(Request $request)
    {
        $id = $request->id;
        $emp = Pemohon::find($id);
        return response()->json($emp);
    }

    // handle update an Tu ajax request
    public function update(Request $request)
    {
        $emp = Pemohon::find($request->emp_id);

        $empData = [
            'nik' => $request->nik,
            'no_kk' => $request->no_kk,
            'nama_pemohon' => $request->nama_pemohon,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
        ];
        $emp->update($empData);
        return response()->json([
            'status' => 200,
        ]);
    }

    // handle delete an Tu ajax request
    public function delete(Request $request)
    {
        $id = $request->id;
        $emp = Pemohon::find($id);
        Pemohon::destroy($id);
    }
}
