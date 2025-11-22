@extends('layouts.admin')

@section('content')
<div class="page-header mb-4">
    <h1>Laporan Mitra</h1>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if ($reports->count())
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Mitra</th>
                    <th>Judul</th>
                    <th>Pesan</th>
                    <th>Status</th>
                    <th>Waktu</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reports as $r)
                    <tr>
                        <td>{{ $r->user->name ?? '-' }}</td>
                        <td>{{ $r->title }}</td>
                        <td>{{ $r->message }}</td>
                        <td>{{ ucfirst($r->status) }}</td>
                        <td>{{ $r->created_at->diffForHumans() }}</td>
                        <td>
                            <form action="{{ route('admin.reports.update', $r->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <select name="status" class="form-select" onchange="this.form.submit()">
                                    <option value="pending"  {{ $r->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="reviewed" {{ $r->status == 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                                    <option value="solved"   {{ $r->status == 'solved' ? 'selected' : '' }}>Solved</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $reports->links() }}
@else
    <p>Tidak ada laporan dari mitra.</p>
@endif
@endsection
