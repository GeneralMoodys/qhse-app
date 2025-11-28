<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Profile Photo -->
        <div class="flex items-center gap-4">
            <div class="flex-shrink-0">
                @if ($user->karyawan && $user->karyawan->photo)
                    <img class="h-20 w-20 rounded-full object-cover" src="{{ asset($user->karyawan->photo) }}" alt="{{ $user->karyawan->nama_karyawan }}">
                @else
                    <svg class="h-20 w-20 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4.002 4.002 0 11-8 0 4.002 4.002 0 018 0z" />
                    </svg>
                @endif
            </div>
            <p class="text-sm text-gray-600">{{ $user->karyawan->nama_karyawan ?? $user->name }}</p>
        </div>

        <!-- Nomor Induk Karyawan -->
        <div>
            <x-input-label for="payroll_id" :value="__('Nomor Induk Karyawan')" />
            <x-text-input id="payroll_id" name="payroll_id" type="text" class="mt-1 block w-full bg-gray-100" :value="$user->karyawan->payroll_id ?? $user->payroll_id" disabled />
        </div>

        <!-- Tanggal Bergabung -->
        <div>
            <x-input-label for="tgl_masuk" :value="__('Tanggal Bergabung')" />
            <x-text-input id="tgl_masuk" name="tgl_masuk" type="text" class="mt-1 block w-full bg-gray-100" :value="($user->karyawan->tgl_masuk ? \Carbon\Carbon::createFromFormat('j/n/Y', $user->karyawan->tgl_masuk)->isoFormat('D MMMM Y') : '')" disabled />
        </div>

        <div>
            <x-input-label for="title" :value="__('Jabatan')" />
            <x-text-input id="title" type="text" class="mt-1 block w-full bg-gray-100" :value="$user->karyawan?->jabatan?->title" disabled />
        </div>

        <div>
            <x-input-label for="department" :value="__('Departemen')" />
            <x-text-input id="department" type="text" class="mt-1 block w-full bg-gray-100" :value="$user->karyawan?->department?->dept_name" disabled />
        </div>

        <div>
            <x-input-label for="division" :value="__('Divisi')" />
            <x-text-input id="division" type="text" class="mt-1 block w-full bg-gray-100" :value="$user->karyawan?->division?->div_name" disabled />
        </div>
        
        <div>
            <x-input-label for="lokasi" :value="__('Lokasi')" />
            <x-text-input id="lokasi" type="text" class="mt-1 block w-full bg-gray-100" :value="$user->karyawan?->location?->loc_name" disabled />
        </div>

        <div>
            <x-input-label for="level" :value="__('Level')" />
            <x-text-input id="level" type="text" class="mt-1 block w-full bg-gray-100" :value="$user->karyawan?->levelRel?->level" disabled />
        </div>

        <!-- Original Email Field -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
