<x-guest-layout>
    <div class="w-full">
        <h2 class="text-3xl font-bold text-white mb-2">Selamat Datang</h2>
        <p class="text-blue-100 mb-8">Sistem Penilaian Pegawai Teladan</p>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <!-- Username -->
            <div>
                <label for="username" class="block font-medium text-sm text-blue-100">{{ __('Username') }}</label>
                <x-text-input id="username" class="block mt-1 w-full bg-blue-900/50 border-blue-500 text-white placeholder-blue-300" type="text" name="username" :value="old('username')" required autofocus />
                <x-input-error :messages="$errors->get('username')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <div class="flex justify-between">
                    <label for="password" class="block font-medium text-sm text-blue-100">{{ __('Password') }}</label>
                    @if (Route::has('password.request'))
                        <!-- <a class="underline text-sm text-blue-200 hover:text-white" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a> -->
                    @endif
                </div>
                <x-text-input id="password" class="block mt-1 w-full bg-blue-900/50 border-blue-500 text-white placeholder-blue-300" type="password" name="password" required />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <!-- <div class="block">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-blue-400 text-yellow-400 shadow-sm focus:ring-yellow-500 bg-blue-900/50" name="remember">
                    <span class="ms-2 text-sm text-blue-100">{{ __('Remember me') }}</span>
                </label>
            </div> -->
            
            <!-- Tombol Login -->
            <div class="pt-4">
                <button type="submit" 
                        class="w-full inline-flex items-center justify-center px-4 py-3 bg-white border border-transparent rounded-lg font-semibold text-sm text-brand-blue uppercase tracking-widest hover:bg-gray-200 transition">
                    {{ __('Log In') }}
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>