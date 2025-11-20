
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Corrective Action Report (CAR)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form wire:submit.prevent="update">
                        {{-- CAR Details --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            <div>
                                <x-input-label for="number" :value="__('Nomor CAR')" />
                                <x-text-input wire:model="number" id="number" class="block mt-1 w-full" type="text" name="number" required />
                                @error('number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <x-input-label for="issued_date" :value="__('Tanggal Terbit')" />
                                <x-text-input wire:model="issued_date" id="issued_date" class="block mt-1 w-full" type="date" name="issued_date" required />
                                @error('issued_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <x-input-label for="source_of_information" :value="__('Sumber Informasi')" />
                                <select wire:model="source_of_information" id="source_of_information" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                    <option value="internal">Internal</option>
                                    <option value="external">Eksternal (Klaim / Komplain Customer)</option>
                                </select>
                            </div>
                             <div>
                                <x-input-label for="status" :value="__('Status')" />
                                <select wire:model="status" id="status" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                    <option value="open">Open</option>
                                    <option value="closed">Closed</option>
                                    <option value="continued">Continued</option>
                                </select>
                            </div>
                        </div>

                        {{-- Dynamic Actions Section --}}
                        <div class="mt-6">
                            <h3 class="font-semibold text-lg mb-2">Tindakan Perbaikan</h3>
                            @error('actions') <span class="text-red-500 text-sm mb-2 block">{{ $message }}</span> @enderror

                            <div class="space-y-4">
                                @foreach ($actions as $index => $action)
                                    <div class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg relative">
                                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                                            {{-- Description --}}
                                            <div class="md:col-span-6">
                                                <x-input-label for="action_description_{{ $index }}" :value="__('Uraian Tindakan Perbaikan')" />
                                                <textarea wire:model="actions.{{ $index }}.description" id="action_description_{{ $index }}" rows="3" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></textarea>
                                                @error('actions.'.$index.'.description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                            </div>
                                            {{-- Target Date --}}
                                            <div class="md:col-span-3">
                                                <x-input-label for="action_target_date_{{ $index }}" :value="__('Target')" />
                                                <x-text-input wire:model="actions.{{ $index }}.target_date" id="action_target_date_{{ $index }}" class="block mt-1 w-full" type="date" />
                                                @error('actions.'.$index.'.target_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                            </div>
                                            {{-- PIC --}}
                                            <div class="md:col-span-3">
                                                <x-input-label for="action_pic_id_{{ $index }}" :value="__('P.I.C.')" />
                                                <select wire:model="actions.{{ $index }}.pic_id" id="action_pic_id_{{ $index }}" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                                    <option value="">Pilih P.I.C.</option>
                                                    @foreach($users as $id => $name)
                                                        <option value="{{ $id }}">{{ $name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('actions.'.$index.'.pic_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                        <button type="button" wire:click="removeAction({{ $index }})" class="absolute top-2 right-2 text-red-500 hover:text-red-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" /></svg>
                                        </button>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-4">
                                <button type="button" wire:click="addAction" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-500">
                                    + Tambah Tindakan
                                </button>
                            </div>
                        </div>

                        {{-- Management Notes --}}
                        <div class="mt-6">
                            <x-input-label for="management_notes" :value="__('Catatan Manajemen')" />
                            <textarea wire:model="management_notes" id="management_notes" rows="4" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></textarea>
                            @error('management_notes') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>


                        {{-- Form Actions --}}
                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('cars.show', $car) }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
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