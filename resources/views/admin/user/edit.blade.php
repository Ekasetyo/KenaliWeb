@extends('admin.dashboard-admin')

@section('content')
<div class="container">
    <h2>Edit Data User</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form id="editUserForm" action="{{ route('admin.user.update', $user->_id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="name" value="{{ $user->name }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ $user->email }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Jenis Kelamin</label>
            <select name="jenis_kelamin" class="form-control" required>
                <option value="Laki-laki" {{ $user->jenis_kelamin === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ $user->jenis_kelamin === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>

        <div class="form-group">
            <label>Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" value="{{ $user->tanggal_lahir->toDate()->format('Y-m-d') }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label>No Telepon</label>
            <input type="text" name="no_telepon" value="{{ $user->no_telepon }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control" required>{{ $user->alamat }}</textarea>
        </div>

        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="admin" {{ $user->status === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="user" {{ $user->status === 'user' ? 'selected' : '' }}>User</option>
            </select>
        </div>

        <div class="form-group text-right">
            <a href="{{ route('admin.user.index') }}" class="btn btn-secondary mr-2">
                <i class="fas fa-times"></i> Batal
            </a>
            <button type="submit" class="btn btn-primary" onclick="confirmEdit(event)">
                <i class="fas fa-save"></i> Update User
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmEdit(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Konfirmasi Edit',
            text: "Apakah Anda yakin ingin memperbarui data user ini?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Update!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('editUserForm').submit();
            }
        });
    }
</script>
@endpush