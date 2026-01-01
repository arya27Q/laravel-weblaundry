@extends('layouts.dashboard')

@section('title', 'Pengaturan')

@section('content')

<div style="display: grid; grid-template-columns: 1fr 3fr; gap: 24px;">
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
                <form action="{{ route('pengaturan.updateProfil') }}" method="POST">
                    @csrf
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="form-group">
                            <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px;">Nama Laundry</label>
                            <input type="text" name="nama_laundry" class="form-control" value="{{ $setting->nama_laundry }}" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ddd;">
                        </div>
                        <div class="form-group">
                            <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px;">Nomor WhatsApp</label>
                            <input type="text" name="whatsapp" class="form-control" value="{{ $setting->whatsapp }}" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ddd;">
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 20px;">
                        <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px;">Alamat Lengkap</label>
                        <textarea name="alamat" class="form-control" rows="3" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ddd;">{{ $setting->alamat }}</textarea>
                    </div>
                    <div style="margin-top: 20px; text-align: right;">
                        <button type="submit" style="background: #f97316; color: white; border: none; padding: 10px 25px; border-radius: 8px; font-weight: 600; cursor: pointer;">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="harga" class="tab-content" style="display: none;">
            <div class="card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h3 style="font-weight: 700; color: #1f2937;">
                        <i class="fa-solid fa-tags" style="color: #f97316; margin-right: 8px;"></i> Daftar Layanan & Harga
                    </h3>
                    <button onclick="openModalLayanan('add')" style="background: #f97316; color: white; border: none; padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer;">
                        + Tambah Layanan
                    </button>
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
                        @foreach($services as $s)
                        <tr style="border-bottom: 1px solid #f3f4f6;">
                            <td style="padding: 12px; font-weight: 500;">{{ $s->service_name }}</td>
                            <td>{{ $s->unit }}</td>
                            <td>Rp {{ number_format($s->price, 0, ',', '.') }}</td>
                            <td>{{ $s->estimation }}</td>
                            <td style="text-align: center;">
                                <button onclick="openModalLayanan('edit', {{ json_encode($s) }})" style="border:none; background:none; cursor:pointer;">
                                    <i class="fa-solid fa-pen-to-square" style="color: #f97316; margin-right: 10px;"></i>
                                </button>
                                <button onclick="confirmDeleteService({{ $s->id }})" style="border:none; background:none; cursor:pointer;">
                                    <i class="fa-solid fa-trash" style="color: #ef4444;"></i>
                                </button>
                                <form id="delete-service-{{ $s->id }}" action="{{ route('service.destroy', $s->id) }}" method="POST" style="display:none;">
                                    @csrf @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div id="keamanan" class="tab-content" style="display: none;">
            <div class="card">
                <h3 style="font-weight: 700; margin-bottom: 20px; color: #1f2937;">
                    <i class="fa-solid fa-lock" style="color: #f97316; margin-right: 8px;"></i> Keamanan Akun
                </h3>
                <form action="{{ route('pengaturan.updatePassword') }}" method="POST">
                    @csrf
                    <div style="display: flex; flex-direction: column; gap: 15px;">
                        <div class="form-group">
                            <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px;">Password Saat Ini</label>
                            <input type="password" name="current_password" class="form-control" placeholder="********" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ddd;">
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            <div class="form-group">
                                <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px;">Password Baru</label>
                                <input type="password" name="new_password" class="form-control" placeholder="Minimal 8 karakter" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ddd;">
                            </div>
                            <div class="form-group">
                                <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px;">Ulangi Password Baru</label>
                                <input type="password" name="new_password_confirmation" class="form-control" placeholder="********" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ddd;">
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

<div id="modalLayanan" class="modal-overlay" style="display: none;">
    <div class="modal-box">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 id="modalLayananTitle" style="font-weight:700; color: #1f2937;">Tambah Layanan Baru</h3>
            <i class="fa-solid fa-xmark" onclick="closeModalLayanan()" style="cursor:pointer; color: #9ca3af; font-size: 20px;"></i>
        </div>

        <form id="formLayanan" action="{{ route('service.store') }}" method="POST">
            @csrf
            <div id="serviceMethod"></div>
            <div class="form-group" style="margin-bottom: 15px;">
                <label style="display:block; font-size: 14px; font-weight:600; margin-bottom: 5px;">Nama Layanan</label>
                <input type="text" name="service_name" id="service_name" class="form-control" required style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ddd;">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div class="form-group">
                    <label style="display:block; font-size: 14px; font-weight:600; margin-bottom: 5px;">Satuan</label>
                    <select name="unit" id="service_unit" class="form-control" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ddd;">
                        <option value="Kg">Kg</option>
                        <option value="Pcs">Pcs</option>
                    </select>
                </div>
                <div class="form-group">
                    <label style="display:block; font-size: 14px; font-weight:600; margin-bottom: 5px;">Harga (Rp)</label>
                    <input type="number" name="price" id="service_price" class="form-control" required style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ddd;">
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display:block; font-size: 14px; font-weight:600; margin-bottom: 5px;">Estimasi Selesai</label>
                <input type="text" name="estimation" id="service_estimation" class="form-control" placeholder="Contoh: 1 Hari" required style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ddd;">
            </div>

            <button type="submit" id="btnSubmitLayanan" style="width: 100%; background: #f97316; color: white; border: none; padding: 12px; border-radius: 8px; font-weight: 700; cursor: pointer;">
                Simpan Layanan
            </button>
        </form>
    </div>
</div>

<style>
    .nav-setting.active {
        background: #fff7ed !important;
        color: #f97316 !important;
    }
    .modal-overlay {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0,0,0,0.5); display: flex; justify-content: center; align-items: center; z-index: 9999;
    }
    .modal-box {
        background: white; padding: 30px; border-radius: 16px; width: 450px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
        animation: animate__animated animate__fadeInDown animate__faster;
    }
</style>

<script>
    function openSetting(tabName, elmnt) {
        var tabcontent = document.getElementsByClassName("tab-content");
        for (var i = 0; i < tabcontent.length; i++) { tabcontent[i].style.display = "none"; }
        
        var navlinks = document.getElementsByClassName("nav-setting");
        for (var i = 0; i < navlinks.length; i++) {
            navlinks[i].classList.remove("active");
            navlinks[i].style.color = "#64748b";
            navlinks[i].style.background = "transparent";
        }
        
        document.getElementById(tabName).style.display = "block";
        elmnt.classList.add("active");
        elmnt.style.color = "#f97316";
        elmnt.style.background = "#fff7ed";
    }

    const modalLayanan = document.getElementById('modalLayanan');
    const formLayanan = document.getElementById('formLayanan');
    
    function openModalLayanan(mode, data = null) {
        modalLayanan.style.display = 'flex';
        if(mode === 'edit' && data) {
            document.getElementById('modalLayananTitle').innerText = 'Edit Layanan';
            document.getElementById('btnSubmitLayanan').innerText = 'Update Layanan';
            formLayanan.action = "{{ url('service') }}/" + data.id;
            document.getElementById('serviceMethod').innerHTML = '<input type="hidden" name="_method" value="PUT">';
            
            document.getElementById('service_name').value = data.service_name;
            document.getElementById('service_unit').value = data.unit;
            document.getElementById('service_price').value = data.price;
            document.getElementById('service_estimation').value = data.estimation;
        } else {
            document.getElementById('modalLayananTitle').innerText = 'Tambah Layanan Baru';
            document.getElementById('btnSubmitLayanan').innerText = 'Simpan Layanan';
            formLayanan.action = "{{ route('service.store') }}";
            document.getElementById('serviceMethod').innerHTML = '';
            formLayanan.reset();
        }
    }

    function closeModalLayanan() { modalLayanan.style.display = 'none'; }
    function confirmDeleteService(id) {
        Swal.fire({
            title: 'Hapus Layanan?',
            text: "Layanan ini akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-service-' + id).submit();
            }
        });
    }

    window.onclick = function(event) {
        if (event.target == modalLayanan) { closeModalLayanan(); }
    }
</script>

@endsection