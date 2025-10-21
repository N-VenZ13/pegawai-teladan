<x-guest-layout>
    <div class="w-full">
        <h2 class="text-3xl font-bold text-white mb-2">
            Selamat Datang
        </h2>
        <p class="text-blue-100 mb-8">
            Silahkan masukan akun anda.
        </p>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <!-- Username -->
            <div>
                <label for="username" class="block font-medium text-sm text-blue-100">Username</label>
                <input id="username" name="username" type="text" value="{{ old('username') }}" required autofocus
                       class="block mt-1 w-full bg-blue-900/50 border-blue-500 text-white placeholder-blue-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <x-input-error :messages="$errors->get('username')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <div class="flex justify-between items-center">
                    <label for="password" class="block font-medium text-sm text-blue-100">Password</label>
                    @if (Route::has('password.request'))
                        <!-- <a class="underline text-sm text-blue-200 hover:text-white" href="{{ route('password.request') }}">
                            Lupa password?
                        </a> -->
                    @endif
                </div>
                <input id="password" name="password" type="password" required
                       class="block mt-1 w-full bg-blue-900/50 border-blue-500 text-white placeholder-blue-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
            
            <!-- Tombol Login -->
            <div class="pt-4">
                <button type="submit" 
                        class="w-full inline-flex items-center justify-center px-4 py-3 bg-white border border-transparent rounded-lg font-semibold text-sm text-brand-blue uppercase tracking-widest hover:bg-gray-200 transition">
                    Log In
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>