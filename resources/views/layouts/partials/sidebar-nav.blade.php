<!-- resources/views/layouts/partials/sidebar-nav.blade.php -->
<ul class="space-y-2 font-medium">
    <li>
        <a href="{{ route('dashboard') }}"
            class="flex items-center p-2 rounded-lg transition-colors duration-200 
                  {{ request()->routeIs('dashboard') 
                     ? 'bg-brand-blue text-white shadow-sm' 
                     : 'text-gray-900 hover:bg-gray-100' }}">
            <svg class="w-5 h-5 transition duration-75 
                        {{ request()->routeIs('dashboard') 
                           ? 'text-white' 
                           : 'text-gray-500 group-hover:text-gray-900' }}"
                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.026V10h8.975a1 1 0 0 0 1-.934A8.5 8.5 0 0 0 12.5 0Z" />
            </svg>
            <span class="ms-3">Dashboard</span>
        </a>
    </li>

    @role('Admin')
    <li>
        <a href="{{ route('admin.users.index') }}" 
           class="flex items-center p-2 rounded-lg transition-colors duration-200 
                  {{ request()->routeIs('admin.users.*') 
                     ? 'bg-brand-blue text-white shadow-sm' 
                     : 'text-gray-900 hover:bg-gray-100' }}">
            
            <!-- tambahkan icon user -->
            <svg class="w-5 h-5 transition duration-75 
                        {{ request()->routeIs('admin.users.*') 
                           ? 'text-white' 
                           : 'text-gray-500 group-hover:text-gray-900' }}"
                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 0a5 5 0 1 1 0 10A5 5 0 0 1 10 0Zm0 12c-6.075 0-10 3.037-10 5.5V20h20v-2.5c0-2.463-3.925-5.5-10-5.5Z"/>
            </svg>
            <span class="ms-3">Manajemen User</span>
        </a>
    </li> 
    <!-- terapkan style kemenu lainnya -->
    <li>
        <a href="{{ route('admin.periods.index') }}" 
           class="flex items-center p-2 rounded-lg transition-colors duration-200 
                  {{ request()->routeIs('admin.periods.*') 
                     ? 'bg-brand-blue text-white shadow-sm' 
                     : 'text-gray-900 hover:bg-gray-100' }}">
            <!-- tambahkan icon periode -->
            <svg class="w-5 h-5 transition duration-75 
                        {{ request()->routeIs('admin.periods.*') 
                           ? 'text-white' 
                           : 'text-gray-500 group-hover:text-gray-900' }}"
                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M17.5 3h-1V1.5a1.5 1.5 0 0 0-3 0V3h-8V1.5a1.5 1.5 0 0 0-3 0V3h-1A2.5 2.5 0 0 0 0 5.5v11A2.5 2.5 0 0 0 2.5 19h15a2.5 2.5 0 0 0 2.5-2.5v-11A2.5 2.5 0 0 0 17.5 3ZM18 16.5a1.5 1.5 0 0 1-1.5 1.5h-15a1.5 1.5 0 0 1-1.5-1.5v-8h18v8Zm0-9h-18v-3A1.5 1.5 0 0 1 .5 3h1v1.5a1.5 1.5 0 0 0 3 0V3h8v1.5a1.5 1.5 0 0 0 3 0V3h1A1.5 1.5 0 0 1 18 .5v3Z"/>
            </svg>
            <span class="ms-3">Manajemen Periode</span>
        </a>
    </li>
    <li>
        <a href="{{ route('admin.questions.index') }}" 
           class="flex items-center p-2 rounded-lg transition-colors duration-200 
                  {{ request()->routeIs('admin.questions.*') 
                     ? 'bg-brand-blue text-white shadow-sm' 
                     : 'text-gray-900 hover:bg-gray-100' }}">
            <!-- tambahkan icon tanda tanya -->
            <svg class="w-5 h-5 transition duration-75 
                        {{ request()->routeIs('admin.questions.*') 
                           ? 'text-white' 
                           : 'text-gray-500 group-hover:text-gray-900' }}"
                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm1 15a1 1 0 1 1-2 0 1 1 0 0 1 2 0Zm2.07-7.75-.9.92A3.005 3.005 0 0 0 11 11H9a5.002 5.002 0 0 1 .93-3.25l1.2-1.22A2.01 2.01 0 1 0 11.07 7.25Z"/>
            </svg>            
            <span class="ms-3">Pertanyaan Pegawai</span>
        </a>
    </li>
    <li>
        <a href="{{ route('admin.leader-criteria.index') }}" 
           class="flex items-center p-2 rounded-lg transition-colors duration-200 
                  {{ request()->routeIs('admin.leader-criteria.*') 
                     ? 'bg-brand-blue text-white shadow-sm' 
                     : 'text-gray-900 hover:bg-gray-100' }}">
            <!-- tambahkan icon bintang -->
            <svg class="w-5 h-5 transition duration-75 
                        {{ request()->routeIs('admin.leader-criteria.*') 
                           ? 'text-white' 
                           : 'text-gray-500 group-hover:text-gray-900' }}"
                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.612 15.443-3.612-1.9-3.612 1.9 1-4.034-3.112-2.7 4.195-.364L10 5l1.517 3.345 4.195.364-3.112 2.7 1 4.034Z"/>
            </svg>
            <span class="ms-3">Kriteria Pimpinan</span>
        </a>
    </li>
    @endrole

    <!-- MENU KHUSUS ADMIN -->
    <!-- @role('Admin')
    <li><a href="{{ route('admin.users.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group {{ request()->routeIs('admin.users.*') ? 'bg-gray-100' : '' }}"><span class="ms-3">Manajemen User</span></a></li>
    <li><a href="{{ route('admin.periods.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group {{ request()->routeIs('admin.periods.*') ? 'bg-gray-100' : '' }}"><span class="ms-3">Manajemen Periode</span></a></li>
    <li><a href="{{ route('admin.questions.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group {{ request()->routeIs('admin.questions.*') ? 'bg-gray-100' : '' }}"><span class="ms-3">Pertanyaan Pegawai</span></a></li>
    <li><a href="{{ route('admin.leader-criteria.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group {{ request()->routeIs('admin.leader-criteria.*') ? 'bg-gray-100' : '' }}"><span class="ms-3">Kriteria Pimpinan</span></a></li>
    @endrole -->

    @role('Admin|Bagian Umum')
    <li>
        <a href="{{ route('discipline.criteria.index') }}" 
           class="flex items-center p-2 rounded-lg transition-colors duration-200 
                  {{ request()->routeIs('discipline.criteria.*') 
                     ? 'bg-brand-blue text-white shadow-sm' 
                     : 'text-gray-900 hover:bg-gray-100' }}">
            <!-- tambahkan icon disipline -->
            <svg class="w-5 h-5 transition duration-75 
                        {{ request()->routeIs('discipline.criteria.*') 
                           ? 'text-white' 
                           : 'text-gray-500 group-hover:text-gray-900' }}"
                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.612 15.443-3.612-1.9-3.612 1.9 1-4.034-3.112-2.7 4.195-.364L10 5l1.517 3.345 4.195.364-3.112 2.7 1 4.034Z"/>
            </svg>
            <span class="ms-3">Kriteria Disiplin</span>
        </a>
    </li>
    <li>
        <a href="{{ route('discipline.scores.index') }}" 
           class="flex items-center p-2 rounded-lg transition-colors duration-200 
                  {{ request()->routeIs('discipline.scores.*') 
                     ? 'bg-brand-blue text-white shadow-sm' 
                     : 'text-gray-900 hover:bg-gray-100' }}">
            <!-- tambahkan icon ketelitian -->
            <svg class="w-5 h-5 transition duration-75 
                        {{ request()->routeIs('discipline.scores.*') 
                           ? 'text-white' 
                           : 'text-gray-500 group-hover:text-gray-900' }}"
                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.612 15.443-3.612-1.9-3.612 1.9 1-4.034-3.112-2.7 4.195-.364L10 5l1.517 3.345 4.195.364-3.112 2.7 1 4.034Z"/>
            </svg>
            <span class="ms-3">Input Nilai Disiplin</span>
        </a>
    </li>
    <li>
        <a href="{{ route('skp.index') }}" 
           class="flex items-center p-2 rounded-lg transition-colors duration-200 
                  {{ request()->routeIs('skp.*') 
                     ? 'bg-brand-blue text-white shadow-sm' 
                     : 'text-gray-900 hover:bg-gray-100' }}">
            <!-- tambahkan icon skp -->
            <svg class="w-5 h-5 transition duration-75 
                        {{ request()->routeIs('skp.*') 
                           ? 'text-white' 
                           : 'text-gray-500 group-hover:text-gray-900' }}"
                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.612 15.443-3.612-1.9-3.612 1.9 1-4.034-3.112-2.7 4.195-.364L10 5l1.517 3.345 4.195.364-3.112 2.7 1 4.034Z"/>
            </svg> 
            <span class="ms-3">Input SKP</span>
        </a>
    </li>
    @endrole
    <!-- MENU KHUSUS BAGIAN UMUM (DAN ADMIN) -->
    <!-- @role('Admin|Bagian Umum')
    <li><a href="{{ route('discipline.criteria.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group {{ request()->routeIs('discipline.criteria.*') ? 'bg-gray-100' : '' }}"><span class="ms-3">Kriteria Disiplin</span></a></li>
    <li><a href="{{ route('discipline.scores.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group {{ request()->routeIs('discipline.scores.*') ? 'bg-gray-100' : '' }}"><span class="ms-3">Input Nilai Disiplin</span></a></li>
    <li><a href="{{ route('skp.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group {{ request()->routeIs('skp.*') ? 'bg-gray-100' : '' }}"><span class="ms-3">Input SKP</span></a></li>
    @endrole -->

    @role('Pimpinan')
    <li>
        <a href="{{ route('leader.evaluation.index') }}" 
           class="flex items-center p-2 rounded-lg transition-colors duration-200 
                  {{ request()->routeIs('leader.evaluation.*') 
                     ? 'bg-brand-blue text-white shadow-sm' 
                     : 'text-gray-900 hover:bg-gray-100' }}">
            <!-- tambahkan icon evaluasi -->
            <svg class="w-5 h-5 transition duration-75 
                        {{ request()->routeIs('leader.evaluation.*') 
                           ? 'text-white' 
                           : 'text-gray-500 group-hover:text-gray-900' }}"
                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.612 15.443-3.612-1.9-3.612 1.9 1-4.034-3.112-2.7 4.195-.364L10 5l1.517 3.345 4.195.364-3.112 2.7 1 4.034Z"/>
            </svg>
            <span class="ms-3">Evaluasi Pimpinan</span>
        </a>
    </li>
    @endrole
    <!-- MENU KHUSUS PIMPINAN -->
    <!-- @role('Pimpinan')
    <li><a href="{{ route('leader.evaluation.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group {{ request()->routeIs('leader.evaluation.*') ? 'bg-gray-100' : '' }}"><span class="ms-3">Evaluasi Pimpinan</span></a></li>
    @endrole -->

    <!-- MENU REKAP (ADMIN & PIMPINAN) -->

    @role('Admin|Pimpinan')
    <li>
        <a href="{{ route('recap.select_period') }}" 
           class="flex items-center p-2 rounded-lg transition-colors duration-200 
                  {{ request()->routeIs('recap.*') 
                     ? 'bg-brand-blue text-white shadow-sm' 
                     : 'text-gray-900 hover:bg-gray-100' }}">
            <!-- tambahkan icon rekap -->
            <svg class="w-5 h-5 transition duration-75 
                        {{ request()->routeIs('recap.*') 
                           ? 'text-white' 
                           : 'text-gray-500 group-hover:text-gray-900' }}"
                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.612 15.443-3.612-1.9-3.612 1.9 1-4.034-3.112-2.7 4.195-.364L10 5l1.517 3.345 4.195.364-3.112 2.7 1 4.034Z"/>
            </svg>
            <span class="ms-3">Rekapitulasi</span>
        </a>
    </li>
    @endrole
    <!-- @role('Admin|Pimpinan')
    <li><a href="{{ route('recap.select_period') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group {{ request()->routeIs('recap.*') ? 'bg-gray-100' : '' }}"><span class="ms-3">Rekapitulasi</span></a></li>
    @endrole -->

    <!-- MENU PEGAWAI & PIMPINAN -->
    @role('Pegawai|Pimpinan')
    <li>
        <a href="{{ route('voting.index') }}" 
           class="flex items-center p-2 rounded-lg transition-colors duration-200 
                  {{ request()->routeIs('voting.index') || request()->routeIs('voting.show') 
                     ? 'bg-brand-blue text-white shadow-sm' 
                     : 'text-gray-900 hover:bg-gray-100' }}">
            <!-- tambahkan icon penilaian -->
            <svg class="w-5 h-5 transition duration-75 
                        {{ request()->routeIs('voting.index') || request()->routeIs('voting.show') 
                           ? 'text-white' 
                           : 'text-gray-500 group-hover:text-gray-900' }}"
                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.612 15.443-3.612-1.9-3.612 1.9 1-4.034-3.112-2.7 4.195-.364L10 5l1.517 3.345 4.195.364-3.112 2.7 1 4.034Z"/>
            </svg>
            <span class="ms-3">Penilaian Saya</span>
        </a>
    </li>
    @endrole
    <!-- @role('Pegawai|Pimpinan')
    <li><a href="{{ route('voting.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group {{ request()->routeIs('voting.index') || request()->routeIs('voting.show') ? 'bg-gray-100' : '' }}"><span class="ms-3">Penilaian Saya</span></a></li>
    <li><a href="{{ route('voting.results.list') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group {{ request()->routeIs('voting.results.*') ? 'bg-gray-100' : '' }}"><span class="ms-3">Lihat Hasil</span></a></li>
    @endrole -->
</ul>