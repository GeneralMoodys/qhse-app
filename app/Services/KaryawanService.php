<?php

namespace App\Services;

use App\Models\Master\Karyawan;
use Illuminate\Support\Facades\Cache;

class KaryawanService
{
    /**
     * Get all karyawan data.
     * Caches the result.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        return Cache::remember('all_karyawan', now()->addMinutes(60), function () {
            return Karyawan::orderBy('nama_karyawan')->get();
        });
    }

    /**
     * Find a karyawan by their NIK.
     * Caches the result.
     *
     * @param string|null $nik
     * @return \App\Models\Master\Karyawan|null
     */
    public function findByNik($nik)
    {
        if (!$nik) {
            return null;
        }

        return Cache::remember("karyawan_{$nik}", now()->addMinutes(60), function () use ($nik) {
            return Karyawan::where('nik', $nik)->first();
        });
    }

    /**
     * Find a karyawan by their ID.
     * Caches the result.
     *
     * @param int|null $id
     * @return \App\Models\Master\Karyawan|null
     */
    public function findById($id)
    {
        if (!$id) {
            return null;
        }

        return Cache::remember("karyawan_id_{$id}", now()->addMinutes(60), function () use ($id) {
            return Karyawan::find($id);
        });
    }

    /**
     * Get a map of NIK => nama_karyawan.
     * Useful for populating dropdowns.
     * Caches the result.
     *
     * @return array
     */
    public function getNikNameMap()
    {
        return Cache::remember('karyawan_nik_name_map', now()->addMinutes(60), function () {
            return Karyawan::pluck('nama_karyawan', 'nik')->all();
        });
    }
}
