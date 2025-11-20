
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detail Corrective Action Report') }}
            </h2>
            <div>
                <a href="{{ route('cars.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 active:bg-gray-700">
                    {{ __('Kembali ke Daftar') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">

                    {{-- Document Header --}}
                    <div class="border border-gray-400 dark:border-gray-600">
                        <div class="flex justify-between items-center">
                            <div class="p-4">
                                <img src="https://bcs-logistics.co.id/assets/images/logoo.png" alt="BCS Logistics" class="h-10">
                            </div>
                            <div class="text-center p-4">
                                <h3 class="font-bold text-lg">Corrective Action Report</h3>
                                <p class="text-sm">Nomor : {{ $car->number }}</p>
                            </div>
                            <div class="p-4 text-sm">
                                <p><strong>Sumber informasi:</strong></p>
                                <p class="mt-1">
                                    <input type="radio" {{ $car->source_of_information == 'external' ? 'checked' : '' }} disabled> Eksternal
                                </p>
                                <p>
                                    <input type="radio" {{ $car->source_of_information == 'internal' ? 'checked' : '' }} disabled> Internal
                                </p>
                            </div>
                        </div>

                        {{-- Problem Finding Section --}}
                        <div class="border-t border-gray-400 dark:border-gray-600 grid grid-cols-1 md:grid-cols-2">
                            <div class="p-4 border-b md:border-b-0 md:border-r border-gray-400 dark:border-gray-600 text-sm space-y-2">
                                <h4 class="font-bold mb-2">TEMUAN MASALAH</h4>
                                <p><strong>Dilaporkan oleh:</strong> {{ $car->rootCauseAnalysis->accident->user->name ?? 'N/A' }}</p>
                                <p><strong>Nama Jabatan & Divisi/Perusahaan:</strong> -</p>
                                <p><strong>Hari, Tanggal & Jam:</strong> {{ $car->rootCauseAnalysis->accident->accident_date->format('l, d F Y') }}</p>
                                <hr class="dark:border-gray-600">
                                <p><strong>Didaftarkan oleh:</strong> {{ $car->issuer->name ?? 'N/A' }}</p>
                                <p><strong>Nama Jabatan & Perusahaan:</strong> -</p>
                                <p><strong>Hari, Tanggal & Jam:</strong> {{ $car->issued_date->format('l, d F Y') }}</p>
                            </div>
                            <div class="p-4">
                                <h4 class="font-bold mb-2 text-center">URAIAN MASALAH</h4>
                                <p class="text-sm">{{ $car->rootCauseAnalysis->accident->description }}</p>
                            </div>
                        </div>

                        {{-- Actions Table --}}
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead class="text-center font-bold bg-gray-100 dark:bg-gray-700">
                                    <tr>
                                        <td class="border border-gray-400 dark:border-gray-600 p-2" rowspan="2">NO</td>
                                        <td class="border border-gray-400 dark:border-gray-600 p-2" colspan="2">AKAR PERMASALAHAN</td>
                                        <td class="border border-gray-400 dark:border-gray-600 p-2" rowspan="2">TINDAKAN PERBAIKAN</td>
                                        <td class="border border-gray-400 dark:border-gray-600 p-2" rowspan="2">TARGET</td>
                                        <td class="border border-gray-400 dark:border-gray-600 p-2" rowspan="2">P.I.C.</td>
                                        <td class="border border-gray-400 dark:border-gray-600 p-2" rowspan="2">PARAF</td>
                                        <td class="border border-gray-400 dark:border-gray-600 p-2" rowspan="2">HASIL VERIFIKASI</td>
                                        <td class="border border-gray-400 dark:border-gray-600 p-2" colspan="2">AUDITOR</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-400 dark:border-gray-600 p-2">URAIAN</td>
                                        <td class="border border-gray-400 dark:border-gray-600 p-2">KATEGORI</td>
                                        <td class="border border-gray-400 dark:border-gray-600 p-2">NAMA</td>
                                        <td class="border border-gray-400 dark:border-gray-600 p-2">PARAF</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($car->actions as $index => $action)
                                        <tr>
                                            <td class="border border-gray-400 dark:border-gray-600 p-2 text-center">{{ $index + 1 }}</td>
                                            <td class="border border-gray-400 dark:border-gray-600 p-2">{{ $car->rootCauseAnalysis->summary }}</td>
                                            <td class="border border-gray-400 dark:border-gray-600 p-2">{{ $car->rootCauseAnalysis->root_cause_category }}</td>
                                            <td class="border border-gray-400 dark:border-gray-600 p-2">{{ $action->description }}</td>
                                            <td class="border border-gray-400 dark:border-gray-600 p-2 text-center">{{ $action->due_date->format('d/m/Y') }}</td>
                                            <td class="border border-gray-400 dark:border-gray-600 p-2 text-center">{{ $action->pic->name ?? 'N/A' }}</td>
                                            <td class="border border-gray-400 dark:border-gray-600 p-2"></td>
                                            <td class="border border-gray-400 dark:border-gray-600 p-2">{{ $action->verification_notes }}</td>
                                            <td class="border border-gray-400 dark:border-gray-600 p-2 text-center">{{ $action->verifier->name ?? '' }}</td>
                                            <td class="border border-gray-400 dark:border-gray-600 p-2"></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="11" class="border border-gray-400 dark:border-gray-600 p-4 text-center">Tidak ada tindakan perbaikan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- Footer Section --}}
                        <div class="border-t border-gray-400 dark:border-gray-600 grid grid-cols-1 md:grid-cols-3 text-sm">
                            <div class="p-4 space-y-2">
                                <p><strong>Status Tindak Lanjut:</strong></p>
                                <p><input type="radio" {{ $car->status == 'continued' ? 'checked' : '' }} disabled> Dilanjutkan (CAR Baru)</p>
                                <p><input type="radio" {{ $car->status == 'open' ? 'checked' : '' }} disabled> Tidak Selesai / Open</p>
                                <p><input type="radio" {{ $car->status == 'closed' ? 'checked' : '' }} disabled> Selesai (Tuntas)</p>
                            </div>
                            <div class="p-4 md:col-span-2 border-t md:border-t-0 md:border-l border-gray-400 dark:border-gray-600">
                                <p><strong>Catatan Manajemen:</strong></p>
                                <p class="mt-2">{{ $car->management_notes ?: '-' }}</p>
                            </div>
                        </div>

                        <div class="border-t border-gray-400 dark:border-gray-600 grid grid-cols-1 md:grid-cols-2">
                            <div class="p-4">
                                <h4 class="font-bold text-center mb-2">LEMBAR DISTRIBUSI</h4>
                                <table class="w-full text-sm">
                                    <thead><tr class="text-center font-bold"><td class="border p-1">Area</td><td class="border p-1">Paraf</td><td class="border p-1">Tanggal</td></tr></thead>
                                    <tbody>
                                        <tr><td class="border p-1">Operational</td><td class="border p-1 h-12"></td><td class="border p-1"></td></tr>
                                        <tr><td class="border p-1">QA & HSE</td><td class="border p-1 h-12"></td><td class="border p-1"></td></tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="p-4 border-t md:border-t-0 md:border-l border-gray-400 dark:border-gray-600">
                                <h4 class="font-bold text-center mb-2">PENGESAHAN</h4>
                                <div class="flex justify-around items-end">
                                    <div class="text-center">
                                        <div class="border-2 rounded-md h-24 w-32 flex flex-col justify-between items-center p-1">
                                            @if($car->mr_approved_at)
                                                <span class="text-green-500 font-bold">APPROVED</span>
                                                <span class="text-xs">{{ $car->mrApprover->name ?? '' }}</span>
                                                <span class="text-xs">{{ $car->mr_approved_at->format('d/m/Y') }}</span>
                                            @endif
                                        </div>
                                        <p class="mt-1 font-bold">MR</p>
                                    </div>
                                    <div class="text-center">
                                        <div class="border-2 rounded-md h-24 w-32 flex flex-col justify-between items-center p-1">
                                            @if($car->director_approved_at)
                                                <span class="text-green-500 font-bold">APPROVED</span>
                                                <span class="text-xs">{{ $car->directorApprover->name ?? '' }}</span>
                                                <span class="text-xs">{{ $car->director_approved_at->format('d/m/Y') }}</span>
                                            @endif
                                        </div>
                                        <p class="mt-1 font-bold">DIREKTUR</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
