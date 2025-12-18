<li>
    <a class="has-arrow waves-effect waves-dark" href="{{ route('dashboard') }}" aria-expanded="false">
        <i class="mdi mdi-view-dashboard"></i>
        <span class="hide-menu">Dashboard</span>
    </a>
</li>
<li>
    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
        <i class="mdi mdi-account-multiple"></i>
        <span class="hide-menu">Pegawai</span>
    </a>
    <ul aria-expanded="false" class="collapse">
        <li><a href="{{ route('manajer.manajemen-pegawai.index') }}">Manajemen Pegawai</a></li>
    </ul>
</li>
<li>
    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
        <i class="mdi mdi-cash-multiple"></i>
        <span class="hide-menu">Produk Pinjaman</span>
    </a>
    <ul aria-expanded="false" class="collapse">
        <li><a href="{{ route('manajer.jenis-pinjaman.index') }}">Jenis Pinjaman</a></li>
        <li><a href="{{ route('manajer.pinjaman.index') }}">Produk Pinjaman</a></li>
    </ul>
</li>