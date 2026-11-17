@extends('layouts.app')
@section('content')
<div class="page-wrap">
  <h1 class="page-title">Kurasi Karya</h1>
  <p class="page-subtitle">Review karya yang masuk sebelum menentukan statusnya.</p>

  <form method="GET" action="{{ route('kurasi') }}" class="toolbar">
    <select name="status" onchange="this.form.submit()">
      <option value="">Semua Status</option>
      <option value="SUBMITTED" {{ $filter === 'SUBMITTED' ? 'selected' : '' }}>Menunggu Review (Submitted)</option>
      <option value="ACCEPTED" {{ $filter === 'ACCEPTED' ? 'selected' : '' }}>Diterima (Accepted)</option>
      <option value="REJECTED" {{ $filter === 'REJECTED' ? 'selected' : '' }}>Ditolak (Rejected)</option>
    </select>
  </form>

  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>Gambar</th>
          <th>Judul & Peserta</th>
          <th>Event</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @if($result->isEmpty())
          <tr><td colspan="5" style="text-align:center;color:var(--gray);padding:32px;">Tidak ada karya.</td></tr>
        @endif

        @foreach($result as $k)
          @php
            $badge = $k->status === 'ACCEPTED' ? 'badge-accepted'
                   : ($k->status === 'REJECTED' ? 'badge-rejected' : 'badge-pending');
          @endphp
          <tr>
            <td>
              @if($k->gambar)
                <img src="{{ asset('uploads/' . $k->gambar) }}" style="width: 80px; height: 60px; object-fit: cover; border-radius: 8px;">
              @else
                <div style="width: 80px; height: 60px; background: #eee; border-radius: 8px; display: flex; align-items: center; justify-content: center;">🖼️</div>
              @endif
            </td>
            <td>
              <strong style="color: var(--primary);">{{ $k->judul }}</strong><br>
              <span style="font-size: 12px; color: var(--gray);">Oleh: {{ $k->peserta_name }}</span>
            </td>
            <td>{{ $k->event_nama ?? '-' }}</td>
            <td><span class="badge-status {{ $badge }}">{{ $k->status }}</span></td>
            <td>
              <!-- Tombol untuk buka halaman detail kurasi -->
              <a href="{{ route('review-kurasi', $k->id) }}" class="btn-sm btn-view" style="text-decoration:none; display:inline-block;">
                🔍 Review Karya
              </a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
