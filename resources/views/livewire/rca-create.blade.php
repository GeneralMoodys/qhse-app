<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Buat RCA untuk Laporan Kecelakaan #' . $accident->id) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form wire:submit.prevent="save">
                        <div class="space-y-6">
                            <!-- Analysis Method -->
                            <div>
                                <x-input-label for="analysis_method" :value="__('Metode Analisis')" />
                                <x-text-input wire:model="analysis_method" id="analysis_method" class="block mt-1 w-full" type="text" name="analysis_method" placeholder="Contoh: 5 Whys, Fishbone" />
                                @error('analysis_method') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Root Cause Summary -->
                            <div>
                                <x-input-label for="root_cause_summary" :value="__('Ringkasan Penyebab Kecelakaan (Penyebab Langsung)')" />
                                <textarea wire:model="root_cause_summary" id="root_cause_summary" rows="4" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required></textarea>
                                @error('root_cause_summary') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Root Cause Category -->
                            <div>
                                <x-input-label for="root_cause_category" :value="__('Kategori Penyebab Dasar')" />
                                <x-text-input wire:model="root_cause_category" id="root_cause_category" class="block mt-1 w-full" type="text" name="root_cause_category" placeholder="Contoh: Manusia dan Metode, Lingkungan" />
                                @error('root_cause_category') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Root Cause Factors -->
                            <div>
                                <h3 class="text-md font-medium text-gray-900 dark:text-gray-100">Faktor Penyebab Dasar</h3>
                                <div class="mt-4 space-y-2">
                                    <label for="is_human_factor" class="flex items-center">
                                        <input wire:model="is_human_factor" id="is_human_factor" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                        <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Manusia') }}</span>
                                    </label>
                                    <label for="is_equipment_factor" class="flex items-center">
                                        <input wire:model="is_equipment_factor" id="is_equipment_factor" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                        <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Alat') }}</span>
                                    </label>
                                    <label for="is_material_factor" class="flex items-center">
                                        <input wire:model="is_material_factor" id="is_material_factor" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                        <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Material') }}</span>
                                    </label>
                                    <label for="is_method_factor" class="flex items-center">
                                        <input wire:model="is_method_factor" id="is_method_factor" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                        <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Metode') }}</span>
                                    </label>
                                    <label for="is_environment_factor" class="flex items-center">
                                        <input wire:model="is_environment_factor" id="is_environment_factor" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                        <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Lingkungan') }}</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('accidents.show', $accident) }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                {{ __('Batal') }}
                            </a>

                            <x-primary-button class="ms-4">
                                {{ __('Simpan RCA') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
