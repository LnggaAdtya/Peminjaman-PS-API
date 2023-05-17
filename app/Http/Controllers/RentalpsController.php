<?php

namespace App\Http\Controllers;

use App\Models\Rentalps;
use Illuminate\Http\Request;
use App\Helpers\ApiFormatter;
use Exception;

class RentalpsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->search_nama;
        $limit = $request->limit;
        $rentals = Rentalps::where('nama', 'LIKE', '%'.$search.'%')->limit($limit)->get();
        if ($rentals) {
            return ApiFormatter::createAPI(200, 'success', $rentals);
        } else {
            return ApiFormatter::createAPI(400, 'failed');
        }
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

    public function createToken()
    {
        return csrf_token();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'no' => 'required|numeric',
                'nama' => 'required|min:3',
                'jenis' => 'required',
                'date' => 'required',
            ]);

            $rentalps = Rentalps::create([
                'no' => $request->no,
                'nama' => $request->nama,
                'jenis' => $request->jenis,
                'date' => $request->date,
            ]);

            $dataRental = Rentalps::where('id', $rentalps->id)->first();

            if ($dataRental) {
                return ApiFormatter::createAPI(200, 'success', $dataRental);
            } else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'failed', $error->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rentalps  $rentalps
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $rentalDetail = Rentalps::find($id);

            if ($rentalDetail) {
                return ApiFormatter::createAPI(200, 'success', $rentalDetail);
            } else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        } catch (Exception $error) { 
            return ApiFormatter::createAPI(400, 'error ', $error->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rentalps  $rentalps
     * @return \Illuminate\Http\Response
     */
    public function edit(Rentalps $rentalps)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rentalps  $rentalps
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'no' => 'required|numeric',
                'nama' => 'required|min:3',
                'jenis' => 'required',
                'date' => 'required',
            ]);

            $rentalps = Rentalps::find($id);

            $rentalps->update([
                'no' => $request->no,
                'nama' => $request->nama,
                'jenis' => $request->jenis,
                'date' => $request->date,
            ]);

            $updatedRental = Rentalps::where('id', $rentalps->id)->first();

            if ($updatedRental) {
                return ApiFormatter::createAPI(200, 'success', $updatedRental);
            } else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'failed', $error->getMessage());
        }
    }

    public function trash()
    {
        try {
            $rentalpss = Rentalps::onlyTrashed()->get();
            if ($rentalpss) {
                return ApiFormatter::createAPI(200, 'success', $rentalpss);
            } else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

    public function restore($id)
    {
        try {
            $rentalps = Rentalps::onlyTrashed()->where('id', $id);
            $rentalps->restore();
            $dataRestore = Rentalps::where('id', $id)->first();
            if ($dataRestore) {
                return ApiFormatter::createAPI(200, 'success', $dataRestore);
            } else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rentalps  $rentalps
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $rentalps = Rentalps::find($id);  
            $proses = $rentalps->delete();

            if ($proses) {
                return ApiFormatter::createAPI(200, 'success', 'success delete data !' );
            } else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'failed', $error->getMessage());
        }
    }

    public function permanentDelete($id)
    {
        try {
            $rental = Rentalps::onlyTrashed()->where('id', $id);
            $proses = $rental->forceDelete();
            if ($proses) {
                return ApiFormatter::createAPI(200, 'success', 'Data dihapus permanen');
            } else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }
}

