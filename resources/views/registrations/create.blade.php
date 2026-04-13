<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: sans-serif; background: #f8fafc; color: #334155; padding: 40px 20px; }
        .container { max-width: 580px; margin: 0 auto; }

        .header { margin-bottom: 28px; }
        .header h1 { font-size: 20px; font-weight: 600; color: #1e293b; }
        .header p  { font-size: 13px; color: #64748b; margin-top: 4px; }

        .card { background: white; border-radius: 10px; padding: 28px;
                box-shadow: 0 1px 3px rgba(0,0,0,0.08); }

        .form-group { margin-bottom: 18px; }
        label { display: block; font-size: 13px; font-weight: 500;
                color: #475569; margin-bottom: 6px; }
        input, select { width: 100%; padding: 9px 12px; border: 1px solid #cbd5e1;
                        border-radius: 6px; font-size: 14px; color: #334155;
                        background: white; transition: border-color 0.2s; }
        input:focus, select:focus { outline: none; border-color: #2563eb; }
        .hint { font-size: 12px; color: #94a3b8; margin-top: 4px; }
        .error { font-size: 12px; color: #dc2626; margin-top: 4px; }

        .divider { border: none; border-top: 1px solid #f1f5f9; margin: 22px 0; }

        .footer { display: flex; align-items: center; gap: 12px; margin-top: 8px; }
        .btn-submit { background: #2563eb; color: white; padding: 10px 24px;
                      border: none; border-radius: 6px; font-size: 14px;
                      cursor: pointer; font-weight: 500; }
        .btn-submit:hover { background: #1d4ed8; }
        .btn-back { font-size: 13px; color: #64748b; text-decoration: none; }
        .btn-back:hover { color: #334155; }

        .api-badge { display: inline-block; background: #eff6ff; color: #2563eb;
                     font-size: 11px; padding: 2px 8px; border-radius: 99px;
                     margin-left: 6px; font-weight: 500; }
    </style>
</head>
<body>
<div class="container">

    <div class="header">
        <h1>Form Pendaftaran Mahasiswa</h1>
        <p>Isi data diri dengan lengkap dan benar</p>
    </div>

    <div class="card">
        <form method="POST" action="{{ route('registrations.store') }}">
            @csrf

            {{-- Data Diri --}}
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="full_name"
                       value="{{ old('full_name') }}"
                       placeholder="contoh: Budi Santoso">
                @error('full_name') <p class="error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email"
                       value="{{ old('email') }}"
                       placeholder="contoh: budi@gmail.com">
                @error('email') <p class="error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label>No. Telepon</label>
                <input type="text" name="phone"
                       value="{{ old('phone') }}"
                       placeholder="contoh: 081234567890">
                @error('phone') <p class="error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label>Tanggal Lahir</label>
                <input type="date" name="birth_date" value="{{ old('birth_date') }}">
                @error('birth_date') <p class="error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label>IPK</label>
                <input type="number" name="gpa" step="0.01" min="0" max="4"
                       value="{{ old('gpa') }}" placeholder="contoh: 3.75">
                <p class="hint">Skala 0.00 – 4.00</p>
                @error('gpa') <p class="error">{{ $message }}</p> @enderror
            </div>

            <hr class="divider">

            {{-- Data Universitas dari API --}}
            <div class="form-group">
                <label>
                    Universitas Tujuan
                    <span class="api-badge">Hipolabs API</span>
                </label>
                <select name="university_name" id="uniSelect">
                    <option value="">-- Pilih Universitas --</option>
                    @foreach($universities as $uni)
                        <option
                            value="{{ $uni['name'] }}"
                            data-domain="{{ $uni['domains'][0] ?? '-' }}"
                            {{ old('university_name') == $uni['name'] ? 'selected' : '' }}>
                            {{ $uni['name'] }}
                        </option>
                    @endforeach
                </select>
                <p class="hint">Data universitas diambil dari Hipolabs Public API secara real-time</p>
                @error('university_name') <p class="error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label>Domain Universitas</label>
                <input type="text" name="university_domain"
                       id="uniDomain" readonly
                       placeholder="otomatis terisi saat memilih universitas"
                       style="background:#f8fafc; color:#64748b;">
                @error('university_domain') <p class="error">{{ $message }}</p> @enderror
            </div>

            <div class="footer">
                <button type="submit" class="btn-submit">Kirim Pendaftaran</button>
                <a href="{{ route('registrations.index') }}" class="btn-back">Kembali</a>
            </div>

        </form>
    </div>

</div>

<script>
    const sel = document.getElementById('uniSelect');
    const dom = document.getElementById('uniDomain');

    function syncDomain() {
        const opt = sel.selectedOptions[0];
        dom.value = opt ? (opt.dataset.domain ?? '') : '';
    }

    sel.addEventListener('change', syncDomain);
    syncDomain();
</script>
</body>
</html>
