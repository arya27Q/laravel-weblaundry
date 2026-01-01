@extends('layouts.dashboard')

@section('title', 'Pelanggan')

@section('content')


<style>
    .modal-overlay {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0,0,0,0.5); z-index: 1100;
        display: none; justify-content: center; align-items: center;
    }
    .modal-content {
        background: #fff; padding: 30px; border-radius: 15px;
        width: 100%; max-width: 500px; position: relative;
        animation: animate__animated animate__fadeInDown animate__faster;
    }
    #btnCloseForm {
        position: absolute; top: 15px; right: 15px; background: none;
        border: none; font-size: 20px; cursor: pointer; color: #999;
    }
    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; margin-bottom: 5px; font-weight: 600; color: #374151; }
    .form-control {
        width: 100%; padding: 10px; border-radius: 8px;
        border: 1px solid #d1d5db; font-size: 14px;
    }
    .btn-save {
        width: 100%; background: #f97316; color: #fff; border: none;
        padding: 12px; border-radius: 8px; font-weight: 600; cursor: pointer; margin-top: 10px;
    }
</style>

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
    <h2 style="font-size:24px; font-weight:700; color: #1f2937;">Data Pelanggan</h2>

    <button id="btnShowForm" onclick="openModal('add')" style="
        background:#f97316;
        color:#fff;
        border:none;
        padding:15px 20px;
        border-radius:10px;
        cursor:pointer;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    ">
        <span>+</span> Tambah Pelanggan
    </button>
</div>

<div id="modalOverlay" class="modal-overlay">
    <div class="modal-content">
        <button type="button" id="btnCloseForm" onclick="closeModal()">✕</button>
        <h3 id="modalTitle" style="margin-bottom: 24px; font-size: 20px; font-weight: 700;">Tambah Pelanggan Baru</h3>

        @if ($errors->any())
            <div style="background: #fee2e2; color: #dc2626; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; border: 1px solid #fecaca;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    document.getElementById('modalOverlay').style.display = 'flex';
                });
            </script>
        @endif

        <form id="mainForm" action="{{ route('pelanggan.store') }}" method="POST">
            @csrf
            <div id="methodField"></div> 
            
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" id="inputName" class="form-control" placeholder="Contoh: Budi Santoso" value="{{ old('name') }}" required>
            </div>

            <div class="form-group">
                <label>No. WhatsApp / HP</label>
                <input type="text" name="phone" id="inputPhone" class="form-control" placeholder="0812xxxx" value="{{ old('phone') }}" required>
            </div>

            <div class="form-group">
                <label>Alamat Lengkap</label>
                <textarea name="address" id="inputAddress" class="form-control" rows="3" placeholder="Jl. Raya No. 123..." required>{{ old('address') }}</textarea>
            </div>

            <button type="submit" id="btnSubmit" class="btn-save">Simpan Data Pelanggan</button>
        </form>
    </div>
</div>

<div class="card" style="margin-bottom:24px;">
    <input id="searchInput" type="text" placeholder="Cari nama atau nomor HP pelanggan..." style="width:100%; padding:12px 16px; border-radius:10px; border:1px solid #e5e7eb; background: #f9fafb;">
</div>

<h3 style="font-weight:650; color:#1f2937; margin-left:7px; margin-bottom: 15px;">Daftar Pelanggan</h3>
<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>No. HP</th>
                <th>Alamat</th>
                <th style="text-align: center;">Aksi</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            @forelse($customers as $index => $customer)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td><strong>{{ $customer->name }}</strong></td>
                <td>{{ $customer->phone }}</td>
                <td>{{ $customer->address }}</td>
                <td style="text-align: center; display: flex; justify-content: center; gap: 5px;">
                    <button 
                        type="button"
                        class="btn-edit-trigger"
                        data-id="{{ $customer->id }}"
                        data-name="{{ $customer->name }}"
                        data-phone="{{ $customer->phone }}"
                        data-address="{{ $customer->address }}"
                        style="background:#fef3c7; color:#d97706; border:none; padding:6px 12px; border-radius:6px; cursor:pointer; font-size:12px;">
                        Edit
                    </button>

                    
                    <form id="delete-form-{{ $customer->id }}" action="{{ route('pelanggan.destroy', $customer->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                    <button type="button" onclick="confirmDelete({{ $customer->id }})" style="background:#fee2e2; color:#dc2626; border:none; padding:6px 12px; border-radius:6px; cursor:pointer; font-size:12px;">
                        Hapus
                    </button>
                </td>
            </tr>
            @empty
            <tr id="emptyRow">
                <td colspan="5" style="text-align:center; padding:40px; color:#9ca3af;">Belum ada data pelanggan</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
    const modalOverlay = document.getElementById('modalOverlay');
    const mainForm = document.getElementById('mainForm');
    const modalTitle = document.getElementById('modalTitle');
    const methodField = document.getElementById('methodField');
    const btnSubmit = document.getElementById('btnSubmit');

    const hasAnyErrors = Boolean("{{ $errors->any() }}");

    function openModal(mode, data = {}) {
        modalOverlay.style.display = 'flex';
        
        if (mode === 'edit') {
            modalTitle.innerText = 'Edit Data Pelanggan';
            btnSubmit.innerText = 'Perbarui Data Pelanggan';
            mainForm.action = "{{ url('pelanggan') }}/" + data.id; 
            methodField.innerHTML = '@method("PUT")';
            
            document.getElementById('inputName').value = data.name;
            document.getElementById('inputPhone').value = data.phone;
            document.getElementById('inputAddress').value = data.address;
        } else {
            modalTitle.innerText = 'Tambah Pelanggan Baru';
            btnSubmit.innerText = 'Simpan Data Pelanggan';
            mainForm.action = "{{ route('pelanggan.store') }}";
            methodField.innerHTML = '';
            
            if (!hasAnyErrors) {
                mainForm.reset();
            }
        }
    }

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('btn-edit-trigger')) {
            const btn = e.target;
            openModal('edit', {
                id: btn.dataset.id,
                name: btn.dataset.name,
                phone: btn.dataset.phone,
                address: btn.dataset.address
            });
        }
    });

    function closeModal() {
        modalOverlay.style.display = 'none';
    }

    function confirmDelete(id) {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data pelanggan akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#f97316',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            showClass: {
                popup: 'animate__animated animate__zoomIn'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }

    window.onclick = function(event) {
        if (event.target == modalOverlay) closeModal();
    }

    document.getElementById('searchInput').addEventListener('input', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('#tableBody tr');
        rows.forEach(row => {
            if(row.id !== 'emptyRow') {
                row.style.display = row.innerText.toLowerCase().includes(filter) ? '' : 'none';
            }
        });
    });
</script>

@endsection