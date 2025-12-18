<li>
    <a class="has-arrow waves-effect waves-dark" href="{{ route('dashboard') }}" aria-expanded="false">
        <i class="mdi mdi-view-dashboard"></i>
        <span class="hide-menu">Dashboard</span>
    </a>
</li>
<li>
    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
        <i class="mdi mdi-account-multiple"></i>
        <span class="hide-menu">Nasabah</span>
    </a>
    <ul aria-expanded="false" class="collapse">
        <li><a href="{{ route('teller.nasabah.index') }}">Manajemen Nasabah</a></li>
    </ul>
</li>
<li>
    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
        <i class="mdi mdi-cash-multiple"></i>
        <span class="hide-menu">Pinjaman</span>
    </a>
    <ul aria-expanded="false" class="collapse">
        <li><a href="{{ route('teller.pengajuan-pinjaman.index') }}">Pengajuan Pinjaman</a></li>
        <li><a href="{{ route('teller.pencairan-pinjaman.index') }}">Pencairan Pinjaman</a></li>
        <li><a href="{{ route('teller.pinjaman-aktif.index') }}">Pinjaman Aktif</a></li>
        <li><a href="{{ route('teller.tunggakan-pinjaman.index') }}">Tunggakan Pinjaman</a></li>
        <li><a href="{{ route('teller.riwayat-pinjaman.index') }}">Riwayat Pinjaman</a></li>
    </ul>
</li>