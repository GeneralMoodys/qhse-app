<div>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detail RCA #' . $rca->id) }}
            </h2>
            <div>
                <a href="{{ route('rca.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    {{ __('Kembali ke Daftar') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Left Column -->
                        <div class="md:col-span-2 space-y-6">
                            <div>
                                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200">Ringkasan Penyebab Kecelakaan</h3>
                                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">{{ $rca->root_cause_summary ?: '-' }}</p>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200">Faktor Penyebab Dasar</h3>
                                <div class="mt-2 space-y-1 text-sm text-gray-600 dark:text-gray-400">
                                    @if($rca->is_human_factor) <div>- Manusia</div> @endif
                                    @if($rca->is_equipment_factor) <div>- Alat</div> @endif
                                    @if($rca->is_material_factor) <div>- Material</div> @endif
                                    @if($rca->is_method_factor) <div>- Metode</div> @endif
                                    @if($rca->is_environment_factor) <div>- Lingkungan</div> @endif
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-4">
                            <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <h4 class="font-semibold">Detail Analisis</h4>
                                <dl class="mt-2 space-y-2 text-sm">
                                    <div class="flex justify-between"><dt class="text-gray-500">Terkait Accident:</dt><dd><a href="{{ route('accidents.show', $rca->accident) }}" class="text-indigo-600 hover:underline">#{{ $rca->accident->id }}</a></dd></div>
                                    <div class="flex justify-between"><dt class="text-gray-500">Metode:</dt><dd>{{ $rca->analysis_method ?: '-' }}</dd></div>
                                    <div class="flex justify-between"><dt class="text-gray-500">Kategori:</dt><dd>{{ $rca->root_cause_category ?: '-' }}</dd></div>
                                    <div class="flex justify-between"><dt class="text-gray-500">Dibuat pada:</dt><dd>{{ $rca->created_at->format('d F Y') }}</dd></div>
                                </dl>
                            </div>
                            <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <h4 class="font-semibold">Tindak Lanjut</h4>
                                <div class="mt-4">
                                    {{-- This will be the button to create CAR --}}
                                    <a href="{{ route('cars.create', $rca) }}" class="w-full text-center inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                        Buat Corrective Action (CAR)
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
