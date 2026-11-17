@extends('layouts.app')
@section('content')
@php $pesan = session('pesan'); @endphp
<div class="page-wrap" style="padding-top: 40px;">
  <h1 class="page-title">Kelola Pengguna</h1>
  <p class="page-subtitle">Halaman khusus Admin untuk mengatur akun pengguna sistem.</p>

  @if($pesan)
    <div class="alert alert-success">{{ $pesan }}</div>
  @endif

  <div class="table-wrap" style="background: #fff; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); overflow: hidden;">
    <table>
      <thead>
        <tr>
          <th>Nama</th>
          <th>Email</th>
          <th>Role Saat Ini</th>
          <th>Ubah Role</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($users as $u)
          <tr>
            <td><strong>{{ $u->name }}</strong></td>
            <td>{{ $u->email }}</td>
            <td>
              <span class="badge-status" style="background: #E5E7EB; color: #111827;">{{ $u->role }}</span>
            </td>
            <td>
              <!-- Form ubah role -->
              <form method="POST" action="{{ route('admin-users.role') }}" style="display: flex; gap: 8px;">
                @csrf
                <input type="hidden" name="user_id" value="{{ $u->id }}">
                <select name="role" style="padding: 6px; border-radius: 6px; border: 1px solid #ddd;">
                  <option value="MAHASISWA" {{ $u->role === 'MAHASISWA' ? 'selected' : '' }}>Mahasiswa</option>
                  <option value="PANITIA" {{ $u->role === 'PANITIA' ? 'selected' : '' }}>Panitia</option>
                  <option value="ADMIN" {{ $u->role === 'ADMIN' ? 'selected' : '' }}>Admin</option>
                </select>
                <button type="submit" class="btn-sm btn-view" style="padding: 6px 12px;">Simpan</button>
              </form>
            </td>
            <td>
              @if($u->id !== Auth::id())
                <a href="#" class="btn-sm btn-reject" style="text-decoration:none;" onclick="if (confirm('Yakin hapus user ini?')) { document.getElementById('hapus-user-{{ $u->id }}').submit(); } return false;">Hapus</a>
                <form id="hapus-user-{{ $u->id }}" method="POST" action="{{ route('admin-users.hapus', $u->id) }}" style="display:none;">
                  @csrf
                  @method('DELETE')
                </form>
              @else
                <span style="font-size: 12px; color: var(--gray);">(Anda)</span>
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
