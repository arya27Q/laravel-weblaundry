<div class="sidebar">
    <h1><i class="fa-solid fa-shirt"></i> LAUNDRY</h1>

    <nav>
        <a href="/"
           class="{{ request()->is('/') ? 'active' : '' }}">
            <i class="fa-solid fa-gauge"></i>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('pelanggan') }}"
           class="{{ request()->is('pelanggan') ? 'active' : '' }}">
            <i class="fa-solid fa-users"></i>
            <span>Pelanggan</span>
        </a>

        <a href="/transaksi"
           class="{{ request()->is('transaksi*') ? 'active' : '' }}">
            <i class="fa-solid fa-receipt"></i>
            <span>Transaksi</span>
        </a>

        <a href="/cucian"
           class="{{ request()->is('cucian*') ? 'active' : '' }}">
            <i class="fa-solid fa-soap"></i>
            <span>Cucian</span>
        </a>

        <a href="/pembayaran"
           class="{{ request()->is('pembayaran*') ? 'active' : '' }}">
            <i class="fa-solid fa-wallet"></i>
            <span>Pembayaran</span>
        </a>

        <a href="/laporan"
           class="{{ request()->is('laporan*') ? 'active' : '' }}">
            <i class="fa-solid fa-chart-line"></i>
            <span>Laporan</span>
        </a>

        <a href="/pengaturan"
           class="{{ request()->is('pengaturan*') ? 'active' : '' }}">
            <i class="fa-solid fa-gear"></i>
            <span>Pengaturan</span>
        </a>
    </nav>

   <div class="account">
    <button class="account-btn" onclick="toggleAccountMenu()">
        <i class="fa-solid fa-user"></i>
        Account
    </button>

    <div class="account-menu" id="accountMenu">
       <a href="/login" class="{{ request()->is('login*') ? 'active' : '' }}">
            <i class="fa-solid fa-right-to-bracket"></i>
         <span>Login</span>
    </a>
        <a href="/signup" class="{{ request()->is('signup*') ? 'active' : '' }}">
            <i class="fa-solid fa-user-plus"></i>
            Sign Up
        </a>
        <a href="/forgot-password" class="{{ request()->is('forgot-password*') ? 'active' : '' }}">
            <i class="fa-solid fa-key"></i>
            Forgot Password
        </a>
    </div>
</div>
</div>
