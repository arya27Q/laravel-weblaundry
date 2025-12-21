@extends('layouts.dashboard')

@section('title', 'Pengaturan')

@section('content')

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 24px;">
    
    <div style="display: flex; flex-direction: column; gap: 12px;">
        <div class="card" style="padding: 10px;">
            <a href="javascript:void(0)" onclick="openSetting('profil', this)" class="nav-setting active" style="display: block; padding: 12px; border-radius: 8px; font-weight: 600; text-decoration: none; margin-bottom: 5px;">
                <i class="fa-solid fa-store" style="margin-right: 10px;"></i> Profil Laundry
            </a>
            <a href="javascript:void(0)" onclick="openSetting('harga', this)" class="nav-setting" style="display: block; padding: 12px; color: #64748b; text-decoration: none; border-radius: 8px; margin-bottom: 5px;">
                <i class="fa-solid fa-tags" style="margin-right: 10px;"></i> Harga & Layanan
            </a>
            <a href="javascript:void(0)" onclick="openSetting('keamanan', this)" class="nav-setting" style="display: block; padding: 12px; color: #64748b; text-decoration: none; border-radius: 8px;">
                <i class="fa-solid fa-lock" style="margin-right: 10px;"></i> Keamanan Akun
            </a>
        </div>
    </div>

    <div id="settings-container">
        
        <div id="profil" class="tab-content">
            <div class="card">
                <h3 style="font-weight: 700; margin-bottom: 20px; color: #1f2937;">
                    <i class="fa-solid fa-store" style="color: #f97316; margin-right: 8px;"></i> Profil Laundry
                </h3>
                <form action="#" method="POST">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="form-group">
                            <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px;">Nama Laundry</label>
                            <input type="text" class="form-control" value="Laundry Jaya" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ddd;">
                        </div>
                        <div class="form-group">
                            <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px;">Nomor WhatsApp</label>
                            <input type="text" class="form-control" value="08123456789" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ddd;">
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 20px;">
                        <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px;">Alamat Lengkap</label>
                        <textarea class="form-control" rows="3" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ddd;">Jl. Raya No. 123, Surabaya</textarea>
                    </div>
                    <div style="margin-top: 20px; text-align: right;">
                        <button type="submit" style="background: #f97316; color: white; border: none; padding: 10px 25px; border-radius: 8px; font-weight: 600; cursor: pointer;">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
            
            <div class="card" style="margin-top: 24px;">
                <h3 style="font-weight: 700; margin-bottom: 20px; color: #1f2937;">
                    <i class="fa-solid fa-tags" style="color: #f97316; margin-right: 8px;"></i> Pengaturan Harga Utama
                </h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div style="background: #f8fafc; padding: 15px; border-radius: 12px; border: 1px dashed #cbd5e1;">
                        <span style="display: block; font-size: 12px; color: #64748b;">Harga Cuci Kiloan (per Kg)</span>
                        <div style="display: flex; align-items: center; gap: 8px; margin-top: 5px;">
                            <span style="font-weight: 700; font-size: 18px;">Rp 7.000</span>
                            <button style="background: none; border: none; color: #f97316; cursor: pointer;"><i class="fa-solid fa-pen-to-square"></i></button>
                        </div>
                    </div>
                    <div style="background: #f8fafc; padding: 15px; border-radius: 12px; border: 1px dashed #cbd5e1;">
                        <span style="display: block; font-size: 12px; color: #64748b;">Harga Cuci Setrika (per Kg)</span>
                        <div style="display: flex; align-items: center; gap: 8px; margin-top: 5px;">
                            <span style="font-weight: 700; font-size: 18px;">Rp 10.000</span>
                            <button style="background: none; border: none; color: #f97316; cursor: pointer;"><i class="fa-solid fa-pen-to-square"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="harga" class="tab-content" style="display: none;">
            <div class="card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h3 style="font-weight: 700; color: #1f2937;">
                        <i class="fa-solid fa-tags" style="color: #f97316; margin-right: 8px;"></i> Daftar Layanan & Harga
                    </h3>
                    <button style="background: #f97316; color: white; border: none; padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer;">+ Tambah Layanan</button>
                </div>
                <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                    <thead>
                        <tr style="text-align: left; background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                            <th style="padding: 12px;">Nama Layanan</th>
                            <th>Satuan</th>
                            <th>Harga</th>
                            <th>Estimasi</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="border-bottom: 1px solid #f3f4f6;">
                            <td style="padding: 12px; font-weight: 500;">Cuci Kiloan Reguler</td>
                            <td>Kg</td>
                            <td>Rp 7.000</td>
                            <td>2-3 Hari</td>
                            <td style="text-align: center;">
                                <i class="fa-solid fa-pen-to-square" style="color: #f97316; cursor: pointer; margin-right: 10px;"></i>
                                <i class="fa-solid fa-trash" style="color: #ef4444; cursor: pointer;"></i>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div id="keamanan" class="tab-content" style="display: none;">
            <div class="card">
                <h3 style="font-weight: 700; margin-bottom: 20px; color: #1f2937;">
                    <i class="fa-solid fa-lock" style="color: #f97316; margin-right: 8px;"></i> Keamanan Akun
                </h3>
                <form action="#" method="POST">
                    <div style="display: flex; flex-direction: column; gap: 15px;">
                        <div class="form-group">
                            <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px;">Password Saat Ini</label>
                            <input type="password" class="form-control" placeholder="********" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ddd;">
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            <div class="form-group">
                                <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px;">Password Baru</label>
                                <input type="password" class="form-control" placeholder="Minimal 8 karakter" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ddd;">
                            </div>
                            <div class="form-group">
                                <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px;">Ulangi Password Baru</label>
                                <input type="password" class="form-control" placeholder="********" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ddd;">
                            </div>
                        </div>
                    </div>
                    <div style="margin-top: 25px; display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #f3f4f6; padding-top: 20px;">
                        <p style="font-size: 12px; color: #6b7280; max-width: 300px;">Gunakan minimal 8 karakter dengan kombinasi huruf dan angka.</p>
                        <button type="submit" style="background: #1f2937; color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer;">Update Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .nav-setting.active {
        background: #fff7ed !important;
        color: #f97316 !important;
    }
    .nav-setting:hover:not(.active) {
        background: #f9fafb;
        color: #f97316;
    }
</style>

<script>
    function openSetting(tabName, elmnt) {
        // Sembunyikan semua tab
        var i, tabcontent, navlinks;
        tabcontent = document.getElementsByClassName("tab-content");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }

        // Hapus class 'active' dan reset warna semua menu
        navlinks = document.getElementsByClassName("nav-setting");
        for (i = 0; i < navlinks.length; i++) {
            navlinks[i].classList.remove("active");
            navlinks[i].style.color = "#64748b";
            navlinks[i].style.background = "transparent";
        }

        // Tampilkan tab yang dipilih & tambahkan class active
        document.getElementById(tabName).style.display = "block";
        elmnt.classList.add("active");
        elmnt.style.color = "#f97316";
        elmnt.style.background = "#fff7ed";
    }
</script>

@endsection