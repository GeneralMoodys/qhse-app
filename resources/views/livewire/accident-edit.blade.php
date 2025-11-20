    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Laporan Kecelakaan #' . $accident->id) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form wire:submit.prevent="update">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- NIK -->
                            <div>
                                <x-input-label for="nik" :value="__('NIK Karyawan')" />
                                <x-text-input wire:model.lazy="nik" id="nik" class="block mt-1 w-full" type="text" name="nik" required autofocus />
                                @error('nik') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Employee Name (Read-only) -->
                            <div>
                                <x-input-label for="employee_name" :value="__('Nama Karyawan')" />
                                <x-text-input wire:model="employee_name" id="employee_name" class="block mt-1 w-full bg-gray-100 dark:bg-gray-700" type="text" name="employee_name" readonly />
                                @error('employee_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Division -->
                            <div>
                                <x-input-label for="division" :value="__('Divisi')" />
                                <x-text-input wire:model="division" id="division" class="block mt-1 w-full" type="text" name="division" required />
                                @error('division') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Location -->
                            <div>
                                <x-input-label for="location" :value="__('Lokasi Kejadian')" />
                                <x-text-input wire:model="location" id="location" class="block mt-1 w-full" type="text" name="location" required />
                                @error('location') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Accident Date -->
                            <div>
                                <x-input-label for="accident_date" :value="__('Tanggal Kejadian')" />
                                <x-text-input wire:model="accident_date" id="accident_date" class="block mt-1 w-full" type="date" name="accident_date" required />
                                @error('accident_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Employee Age Group -->
                            <div>
                                <x-input-label for="employee_age_group" :value="__('Kelompok Usia (Th)')" />
                                <x-text-input wire:model="employee_age_group" id="employee_age_group" class="block mt-1 w-full" type="text" name="employee_age_group" placeholder="Contoh: 21 - 25" />
                                @error('employee_age_group') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Equipment Type -->
                            <div>
                                <x-input-label for="equipment_type" :value="__('Jenis Alat / Unit')" />
                                <x-text-input wire:model="equipment_type" id="equipment_type" class="block mt-1 w-full" type="text" name="equipment_type" />
                                @error('equipment_type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Accident Time Range -->
                            <div>
                                <x-input-label for="accident_time_range" :value="__('Waktu Terjadi (WIB)')" />
                                <x-text-input wire:model="accident_time_range" id="accident_time_range" class="block mt-1 w-full" type="text" name="accident_time_range" placeholder="Contoh: 06.01 - 12.00" />
                                @error('accident_time_range') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Financial Loss -->
                            <div>
                                <x-input-label for="financial_loss" :value="__('Jumlah Kerugian (Rp)')" />
                                <x-text-input wire:model="financial_loss" id="financial_loss" class="block mt-1 w-full" type="number" step="0.01" name="financial_loss" />
                                @error('financial_loss') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Lost Work Days -->
                            <div>
                                <x-input-label for="lost_work_days" :value="__('Jumlah Hari Kerja Hilang (Hari)')" />
                                <x-text-input wire:model="lost_work_days" id="lost_work_days" class="block mt-1 w-full" type="number" name="lost_work_days" />
                                @error('lost_work_days') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Photo Upload -->
                            <div>
                                <x-input-label for="photo_path" :value="__('Foto Kejadian')" />
                                <input type="file" wire:model="photo_path" id="photo_path" class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"/>
                                @error('photo_path') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                @if ($photo_path)
                                    <img src="{{ $photo_path->temporaryUrl() }}" class="mt-2 h-20 w-20 object-cover rounded-md">
                                @elseif ($current_photo_path)
                                    <img src="{{ Storage::url($current_photo_path) }}" class="mt-2 h-20 w-20 object-cover rounded-md">
                                @endif
                            </div>

                            <!-- Description -->
                            <div class="md:col-span-2">
                                <x-input-label for="description" :value="__('Deskripsi Kejadian')" />
                                <textarea wire:model="description" id="description" rows="4" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></textarea>
                                @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Initial Action -->
                            <div class="md:col-span-2">
                                <x-input-label for="initial_action" :value="__('Tindakan Awal yang Dilakukan')" />
                                <textarea wire:model="initial_action" id="initial_action" rows="3" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></textarea>
                                @error('initial_action') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Consequence -->
                            <div class="md:col-span-2">
                                <x-input-label for="consequence" :value="__('Akibat / Konsekuensi dari Kejadian')" />
                                <textarea wire:model="consequence" id="consequence" rows="3" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></textarea>
                                @error('consequence') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Injured Body Parts Checkboxes -->
                            <div class="md:col-span-2">
                                <x-input-label :value="__('Bagian Organ Tubuh Cedera')" />
                                <div class="mt-2 grid grid-cols-2 md:grid-cols-3 gap-2">
                                    @php
                                        $bodyParts = ['Kepala', 'Mata', 'Telinga', 'Lengan', 'Tangan', 'Jari Tangan', 'Paha', 'Kaki', 'Jari Kaki', 'Organ Tubuh Bagian Dalam'];
                                    @endphp
                                    @foreach($bodyParts as $part)
                                        <label for="injured_body_parts_{{ Str::slug($part) }}" class="flex items-center">
                                            <input type="checkbox" wire:model="injured_body_parts" id="injured_body_parts_{{ Str::slug($part) }}" value="{{ $part }}" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                            <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ $part }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                @error('injured_body_parts') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Accident Types Checkboxes -->
                            <div class="md:col-span-2">
                                <x-input-label :value="__('Jenis Kecelakaan')" />
                                <div class="mt-2 grid grid-cols-2 md:grid-cols-3 gap-2">
                                    @php
                                        $accidentTypes = ['Fatality', 'LTI', 'MTI', 'WI', 'PD', 'Fire Case'];
                                    @endphp
                                    @foreach($accidentTypes as $type)
                                        <label for="accident_types_{{ Str::slug($type) }}" class="flex items-center">
                                            <input type="checkbox" wire:model="accident_types" id="accident_types_{{ Str::slug($type) }}" value="{{ $type }}" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                            <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ $type }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                @error('accident_types') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('accidents.show', $accident) }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                {{ __('Batal') }}
                            </a>

                            <x-primary-button class="ms-4">
                                {{ __('Simpan Perubahan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>