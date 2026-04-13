<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admisi Kampus</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: sans-serif; background: #f8fafc; color: #334155; padding: 40px 20px; }
        .container { max-width: 1000px; margin: 0 auto; }

        .header { margin-bottom: 24px; }
        .header h1 { font-size: 22px; font-weight: 600; color: #1e293b; }
        .header p  { font-size: 14px; color: #64748b; margin-top: 4px; }

        .alert { background: #dcfce7; color: #166534; padding: 10px 16px;
                 border-radius: 6px; margin-bottom: 20px; font-size: 14px; }

        .btn-primary { background: #2563eb; color: white; padding: 9px 18px;
                       border-radius: 6px; text-decoration: none; font-size: 14px;
                       display: inline-block; margin-bottom: 20px; }
        .btn-primary:hover { background: #1d4ed8; }

        table { width: 100%; border-collapse: collapse; background: white;
                border-radius: 8px; overflow: hidden;
                box-shadow: 0 1px 3px rgba(0,0,0,0.08); font-size: 14px; }
        thead tr { background: #f1f5f9; }
        th { padding: 12px 14px; text-align: left; font-weight: 500;
             color: #475569; border-bottom: 1px solid #e2e8f0; }
        td { padding: 12px 14px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #fafafa; }

        .badge { padding: 3px 10px; border-radius: 99px; font-size: 12px; font-weight: 500; }
        .pending  { background: #fef9c3; color: #854d0e; }
        .accepted { background: #dcfce7; color: #166534; }
        .rejected { background: #fee2e2; color: #991b1b; }

        .actions { display: flex; gap: 6px; align-items: center; }
        select { padding: 5px 8px; border: 1px solid #cbd5e1; border-radius: 5px;
                 font-size: 13px; color: #334155; background: white; }
        .btn-save { background: #2563eb; color: white; border: none; padding: 5px 12px;
                    border-radius: 5px; font-size: 13px; cursor: pointer; }
        .btn-save:hover { background: #1d4ed8; }
        .btn-del  { background: #ef4444; color: white; border: none; padding: 5px 12px;
                    border-radius: 5px; font-size: 13px; cursor: pointer; }
        .btn-del:hover { background: #dc2626; }

        .empty { text-align: center; padding: 40px; color: #94a3b8; font-size: 14px; }
    </style>
</head>
<body>
<div class="container">

    <div class="header">
        <h1>Sistem Informasi Admisi Kampus</h1>
        <p>Data pendaftaran calon mahasiswa — universitas bersumber dari Hipolabs Public API</p>
    </div>

    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    <a href="{{ route('registrations.create') }}" class="btn-primary">+ Pendaftaran Baru</a>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Lengkap</th>
                <th>Email</th>
                <th>Universitas</th>
                <th>IPK</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($registrations as $i => $reg)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $reg->full_name }}</td>
                <td style="color:#2563eb;">{{ $reg->email }}</td>
                <td>
                    {{ $reg->university_name }}<br>
                    <span style="font-size:12px; color:#94a3b8;">{{ $reg->university_domain }}</span>
                </td>
                <td>{{ number_format($reg->gpa, 2) }}</td>
                <td><span class="badge {{ $reg->status }}">{{ ucfirst($reg->status) }}</span></td>
                <td>
                    <div class="actions">
                        {{-- Update Status --}}
                        <form method="POST" action="{{ route('registrations.update', $reg->id) }}">
                            @csrf
                            @method('PUT')
                            <select name="status">
                                <option value="pending"  {{ $reg->status == 'pending'  ? 'selected' : '' }}>Pending</option>
                                <option value="accepted" {{ $reg->status == 'accepted' ? 'selected' : '' }}>Accepted</option>
                                <option value="rejected" {{ $reg->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                            <button type="submit" class="btn-save">Simpan</button>
                        </form>
                        {{-- Hapus --}}
                        <form method="POST" action="{{ route('registrations.destroy', $reg->id) }}"
                              onsubmit="return confirm('Yakin ingin membatalkan pendaftaran ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-del">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="empty">Belum ada data pendaftar.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>
</body>
</html>
