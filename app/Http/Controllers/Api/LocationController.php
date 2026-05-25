<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Village;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Return list of villages (desa/kelurahan) for a given kecamatan.
     */
    public function getVillages(Request $request)
    {
        $kecamatan = strtoupper(trim($request->query('kecamatan', '')));

        if (empty($kecamatan)) {
            return response()->json([]);
        }

        $villages = Village::where('kecamatan', $kecamatan)
            ->orderBy('name')
            ->get(['id', 'name', 'status']);

        return response()->json($villages);
    }
}
