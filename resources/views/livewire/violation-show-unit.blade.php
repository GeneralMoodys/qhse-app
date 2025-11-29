<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detail Laporan Unit: {{ $unit->no_unit }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto space-y-6">

            <!-- Unit Info Card -->
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Informasi Unit</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                    <div>
                        <label class="text-sm font-semibold text-gray-600 dark:text-gray-300">No Unit:</label>
                        <p class="mt-1 text-gray-800 dark:text-gray-100">{{ $unit->no_unit }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600 dark:text-gray-300">Jenis Unit:</label>
                        <p class="mt-1 text-gray-800 dark:text-gray-100">{{ $unit->jenis_unit }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600 dark:text-gray-300">Total Kilometer:</label>
                        <p class="mt-1 text-gray-800 dark:text-gray-100">{{ number_format($totalKilometer, 0, ',', '.') }} km</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600 dark:text-gray-300">Total Storing:</label>
                        <p class="mt-1 text-gray-800 dark:text-gray-100">{{ $storingEventCount }} kali</p>
                    </div>
                </div>
            </div>

            <!-- Accident History Card -->
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Riwayat Kecelakaan</h3>
                <div class="space-y-4">
                    @forelse ($accidents as $accident)
                        <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $accident->accident_date->format('d F Y') }}
                                    </p>
                                    <p class="mt-1 text-gray-800 dark:text-gray-200">
                                        {{ Str::limit($accident->description, 150) }}
                                    </p>
                                </div>
                                <a href="{{ route('accidents.show', $accident) }}" class="ms-4 px-3 py-1 text-sm text-indigo-700 dark:text-indigo-300 bg-indigo-100 dark:bg-indigo-900/50 rounded-full hover:bg-indigo-200 dark:hover:bg-indigo-900 transition-colors whitespace-nowrap">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400">Tidak ada riwayat kecelakaan untuk unit ini.</p>
                    @endforelse
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end">
                <a href="{{ route('violations.index') }}"
                    class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 
                           bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 
                           rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    Kembali
                </a>
            </div>
        </div>
    </div>
</div>
