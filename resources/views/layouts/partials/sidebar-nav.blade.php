<ul class="space-y-2 font-medium">

    <!-- Dashboard (Semua Role) -->
    <li>
        <a href="{{ route('dashboard') }}" class="flex items-center p-2 rounded-lg transition-all duration-200 group {{ request()->routeIs('dashboard') ? 'bg-brand-blue text-white shadow' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
            <svg class="w-5 h-5 transition duration-75 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
            </svg>
            <span class="ms-3">Dashboard</span>
        </a>
    </li>

    <!-- MENU PEGAWAI & KEPALA BPS -->
    @role('Pegawai|Kepala BPS')
    <li>
        <a href="{{ route('voting.index') }}" class="flex items-center p-2 rounded-lg transition-all duration-200 group {{ request()->routeIs('voting.index') || request()->routeIs('voting.show') ? 'bg-brand-blue text-white shadow' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
            <svg class="w-5 h-5 transition duration-75 {{ request()->routeIs('voting.index') || request()->routeIs('voting.show') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
            </svg>
            <span class="ms-3">Penilaian Saya</span>
        </a>
    </li>
    @endrole

    <!-- MENU KEPALA BPS -->
    @role('Kepala BPS')
    <li>
        <a href="{{ route('leader.evaluation.index') }}" class="flex items-center p-2 rounded-lg transition-all duration-200 group {{ request()->routeIs('kepala-bps.evaluation.*') ? 'bg-brand-blue text-white shadow' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
            <svg class="w-5 h-5 transition duration-75 {{ request()->routeIs('kepala-bps.evaluation.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="ms-3">Evaluasi Kepala BPS</span>
        </a>
    </li>
    @endrole

    <!-- MENU REKAP & HASIL (BANYAK ROLE) -->
    @role('Admin|Kepala BPS')
    <li>
        <a href="{{ route('recap.select_period') }}" class="flex items-center p-2 rounded-lg transition-all duration-200 group {{ request()->routeIs('recap.*') ? 'bg-brand-blue text-white shadow' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
            <svg class="w-5 h-5 transition duration-75 {{ request()->routeIs('recap.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
            </svg>
            <span class="ms-3">Rekapitulasi</span>
        </a>
    </li>
    @endrole

    @role('Pegawai|Kepala BPS')
    <li>
        <a href="{{ route('voting.results.list') }}" class="flex items-center p-2 rounded-lg transition-all duration-200 group {{ request()->routeIs('voting.results.*') ? 'bg-brand-blue text-white shadow' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
            <svg class="w-5 h-5 transition duration-75 {{ request()->routeIs('voting.results.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9a9 9 0 009 0zM19.5 12a7.5 7.5 0 11-15 0 7.5 7.5 0 0115 0z" />
            </svg>
            <span class="ms-3">Lihat Hasil</span>
        </a>
    </li>
    @endrole

    <!-- MENU KHUSUS ADMIN & BAGIAN UMUM (DIKELOMPOKKAN BERSAMA) -->
    <!-- MENU KHUSUS ADMIN -->
    @role('Admin')
    <li class="pt-4 mt-4 border-t border-gray-700"><span class="px-2 text-xs font-semibold text-gray-500 uppercase">Administrasi Sistem</span></li>
    <li>
        <a href="{{ route('admin.users.index') }}" class="flex items-center p-2 rounded-lg transition-all duration-200 group {{ request()->routeIs('admin.users.*') ? 'bg-brand-blue text-white shadow' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
            <svg class="w-5 h-5 transition duration-75 {{ request()->routeIs('admin.users.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493m15-19.128v-.003c0-1.113-.285-2.16-.786-3.071m-15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-4.67c.12-.241.253-.477.398-.702a4.125 4.125 0 00-7.533-2.493c-2.331 0-4.512.645-6.374 1.766l-.001.109a6.375 6.375 0 0111.964 4.67c.12.241.253-.477.398-.702a4.125 4.125 0 00-7.533-2.493" />
            </svg>
            <span class="ms-3">Manajemen User</span>
        </a>
    </li>
    <li>
        <a href="{{ route('admin.periods.index') }}" class="flex items-center p-2 rounded-lg transition-all duration-200 group {{ request()->routeIs('admin.periods.*') ? 'bg-brand-blue text-white shadow' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
            <svg class="w-5 h-5 transition duration-75 {{ request()->routeIs('admin.periods.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
            </svg>
            <span class="ms-3">Manajemen Periode</span>
        </a>
    </li>
    <li>
        <a href="{{ route('admin.questions.index') }}" class="flex items-center p-2 rounded-lg transition-all duration-200 group {{ request()->routeIs('admin.questions.*') ? 'bg-brand-blue text-white shadow' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
            <svg class="w-5 h-5 transition duration-75 {{ request()->routeIs('admin.questions.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
            </svg>
            <span class="ms-3">Pertanyaan Pegawai</span>
        </a>
    </li>
    <li>
        <a href="{{ route('admin.leader-criteria.index') }}" class="flex items-center p-2 rounded-lg transition-all duration-200 group {{ request()->routeIs('admin.leader-criteria.*') ? 'bg-brand-blue text-white shadow' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
            <svg class="w-5 h-5 transition duration-75 {{ request()->routeIs('admin.leader-criteria.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
            </svg>
            <span class="ms-3">Kriteria Evaluasi</span>
        </a>
    </li>
    @endrole

    <!-- MENU INPUT DATA (ADMIN & BAGIAN UMUM) -->
    @role('Admin|Bagian Umum')
    @if(Auth::user()->hasRole('Bagian Umum') && !Auth::user()->hasRole('Admin'))
    <li class="pt-4 mt-4 border-t border-gray-700"><span class="px-2 text-xs font-semibold text-gray-500 uppercase">Input Data</span></li>
    @endif
    <li>
        <a href="{{ route('discipline.criteria.index') }}" class="flex items-center p-2 rounded-lg transition-all duration-200 group {{ request()->routeIs('discipline.criteria.*') ? 'bg-brand-blue text-white shadow' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
            <svg class="w-5 h-5 transition duration-75 {{ request()->routeIs('discipline.criteria.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.286zm0 13.036h.008v.008h-.008v-.008z" />
            </svg>
            <span class="ms-3">Kriteria Disiplin</span>
        </a>
    </li>
    <li>
        <a href="{{ route('discipline.scores.index') }}" class="flex items-center p-2 rounded-lg transition-all duration-200 group {{ request()->routeIs('discipline.scores.*') ? 'bg-brand-blue text-white shadow' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
            <svg class="w-5 h-5 transition duration-75 {{ request()->routeIs('discipline.scores.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
            </svg>
            <span class="ms-3">Input Nilai Disiplin</span>
        </a>
    </li>
    <li>
        <a href="{{ route('skp.index') }}" class="flex items-center p-2 rounded-lg transition-all duration-200 group {{ request()->routeIs('skp.*') ? 'bg-brand-blue text-white shadow' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
            <svg class="w-5 h-5 transition duration-75 {{ request()->routeIs('skp.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 019 9v.375M10.125 2.25A3.375 3.375 0 0113.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 013.375 3.375M9 15l2.25 2.25L15 12" />
            </svg>
            <span class="ms-3">Input SKP</span>
        </a>
    </li>
    @endrole
</ul>

<!-- Bagian Profil & Logout -->
<div class="pt-4 mt-4 space-y-2 font-medium border-t border-gray-700">
    <li>
        <a href="{{ route('profile.edit') }}" class="flex items-center p-2 rounded-lg transition-all duration-200 group {{ request()->routeIs('profile.edit') ? 'bg-brand-blue text-white shadow' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
            <svg class="w-5 h-5 transition duration-75 {{ request()->routeIs('profile.edit') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span class="ms-3">Profil Saya</span>
        </a>
    </li>
</div>