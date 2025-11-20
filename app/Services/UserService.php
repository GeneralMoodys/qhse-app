<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Collection;

class UserService
{
    /**
     * Cari user berdasarkan ID.
     */
    public function findById(int $id): ?User
    {
        // Menggunakan koneksi master secara eksplisit
        return User::on('pgsql_master')->find($id);
    }

    /**
     * Cari banyak user berdasarkan array of IDs.
     * Ini penting untuk optimasi (menghindari N+1 query).
     */
    public function findByIds(array $ids): Collection
    {
        return User::on('pgsql_master')->whereIn('id', $ids)->get()->keyBy('id');
    }

    /**
     * Cari user berdasarkan NIK.
     */
    public function findByNik(string $nik): ?User
    {
        return User::on('pgsql_master')->where('nik', $nik)->first();
    }

    /**
     * Ambil semua user.
     */
    public function getAllUsers(): Collection
    {
        return User::on('pgsql_master')->get();
    }
}
