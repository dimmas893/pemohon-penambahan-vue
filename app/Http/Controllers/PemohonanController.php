<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Pemohon;
use App\Models\Pemohonan;
use App\Models\Rincian_Permohonan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PemohonanController extends Controller
{

    // set index page view
    public function index()
    {
        // $persyaratan = Persyaratan::all();
        // $layanan = Layanan::all();
        return view('pemohonan.index');
    }

    public function layanan(Request $request)
    {
        $create = [
            'id_layanan' => $request->id_layanan
        ];

        Pemohonan::where('id', $request->id)->update($create);
        return back();
    }

    public function details($id)
    {
        $layanan = Layanan::all();
        $permohonans = Pemohonan::Find($id);
        $pemohon = Pemohon::with('user')->where('id', $permohonans->id_pemohon)->get();
        $rincian_permohonan = Rincian_Permohonan::with('persyaratan', 'pemohonan')->where('id_permohonan', $permohonans->id)->get();

        return view('pemohonan.details', compact('permohonans', 'rincian_permohonan', 'pemohon'));
    }

    // handle fetch all eamployees ajax request
    public function all()
    {
        $emps = Pemohonan::with('layanan', 'pemohon', 'user')->get();
        $output = '';
        $p = 1;
        if ($emps->count() > 0) {
            $output .=
                '<table class="table table-striped table-sm text-center align-middle">
            <thead>
              <tr>
                <th>No</th>
                <th>Pemohon</th>
                <th>User</th>
                <th>Tanggal</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>';
            foreach ($emps as $emp) {
                $output .= '<tr>
                <td>' . $p++ .
                    '</td>
                <td>' . $emp->pemohon->nama_pemohon . '</td>
                <td>' . $emp->user->name . '</td>
                <td>' . $emp->created_at->format('Y-m-d') .
                    '</td>
                <td>
                <a href="/pemohonan/details/' . $emp->id . '"><i class="fa-solid fa-eye h4"></i></a>
                </td>
              </tr>';
            }
            $output .= '</tbody></table>';
            echo $output;
        } else {
            echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
        }
    }

    public function permohonan_details($id)
    {
        $emps = Pemohonan::with('layanan', 'pemohon', 'user')->where('id', $id)->where('id_user', Auth::user()->id)->get();
        $output = '';
        $p = 1;
        if ($emps->count() > 0) {
            $output .= '<table class="table table-striped table-sm text-center align-middle">
            <thead>
              <tr>
                <th>No</th>
                <th>Pemohon</th>
                <th>User</th>
                <th>Tanggal</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>';
            foreach ($emps as $emp) {
                $output .= '<tr>
                <td>' . $p++ . '</td>
                <td>' . $emp->pemohon->nama_pemohon . '</td>
                <td>' . $emp->user->name . '</td>
                <td>' . $emp->tanggal . '</td>
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

        $empData = [
            'id_permohonan' => $request->id_permohonan,
            'id_layanan' => $request->id_layanan,
            'id_pemohon' => $request->id_pemohon,
            'id_user' => $request->id_user,
            'tanggal' => $request->tanggal,
        ];
        Pemohonan::create($empData);
        return response()->json([
            'status' => 200,
        ]);
    }

    // handle edit an Tu ajax request
    // public function edit(Request $request)
    // {
    //     $id = $request->id;
    //     $emp = Pemohonan::find($id);
    //     return response()->json($emp);
    // }

    // // handle update an Tu ajax request
    // public function update(Request $request)
    // {
    //     $emp = Pemohonan::find($request->emp_id);

    //     $empData = [
    //         'id_permohonan' => $request->id_permohonan,
    //         'id_layanan' => $request->id_layanan,
    //         'id_pemohon' => $request->id_pemohon,
    //         // 'id_user' => $request->id_user,
    //         'tanggal' => $request->tanggal
    //     ];
    //     $emp->update($empData);
    //     return response()->json([
    //         'status' => 200,
    //     ]);
    // }

    // handle delete an Tu ajax request
    public function delete(Request $request)
    {
        $id = $request->id;
        $emp = Pemohonan::find($id);
        Pemohonan::destroy($id);
    }
}
