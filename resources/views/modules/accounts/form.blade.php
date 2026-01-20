<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>{{ $mode === 'create' ? 'Thêm acc' : 'Sửa acc' }}</title>

  <style>
    :root{
      --bg:#f6f7fb;
      --card:#fff;
      --text:#0f172a;
      --muted:#64748b;
      --line:#e6eaf2;
      --shadow:0 10px 24px rgba(15,23,42,.10);
      --shadow2:0 6px 16px rgba(15,23,42,.08);
      --radius:20px;

      --primary:#111827;
      --primary2:#0b1220;

      --dangerBg:#fff1f2;
      --dangerLine:#fecdd3;
      --dangerText:#9f1239;
    }

    *{box-sizing:border-box}
    body{
      margin:0;
      background:
        radial-gradient(1100px 520px at 20% -10%, rgba(17,24,39,.08), transparent 60%),
        radial-gradient(900px 420px at 92% 0%, rgba(2,132,199,.10), transparent 55%),
        var(--bg);
      color:var(--text);
      font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial;
    }

    .wrap{max-width:760px;margin:0 auto;padding:26px 16px 44px}

    .topbar{
      display:flex;gap:10px;flex-wrap:wrap;align-items:center;justify-content:space-between;
      margin-bottom:12px;
    }
    .title{
      display:flex;flex-direction:column;gap:6px;
    }
    .title h2{margin:0;font-size:20px;letter-spacing:-.2px}
    .meta{color:var(--muted);font-size:13px;line-height:1.5}

    .toolbar{display:flex;gap:10px;flex-wrap:wrap}
    .btn{
      display:inline-flex;align-items:center;gap:8px;
      padding:10px 12px;border-radius:999px;
      border:1px solid var(--line);
      background:rgba(255,255,255,.78);
      backdrop-filter: blur(6px);
      text-decoration:none;color:var(--text);
      box-shadow: 0 1px 0 rgba(15,23,42,.04);
      transition:.15s ease;
      font-size:13px;
      cursor:pointer;
    }
    .btn:hover{transform:translateY(-1px);box-shadow:var(--shadow2)}
    .btnPrimary{
      background:linear-gradient(180deg, var(--primary), var(--primary2));
      color:#fff;border-color:transparent;
    }

    .card{
      background:rgba(255,255,255,.86);
      border:1px solid var(--line);
      border-radius:var(--radius);
      box-shadow:var(--shadow);
      padding:16px;
      backdrop-filter: blur(8px);
    }

    .err{
      background:var(--dangerBg);
      border:1px solid var(--dangerLine);
      color:var(--dangerText);
      padding:12px 14px;
      border-radius:16px;
      margin:10px 0 12px;
      font-size:14px;
      line-height:1.6;
    }

    .grid{
      display:grid;
      grid-template-columns:1fr 1fr;
      gap:12px;
    }
    @media (max-width:720px){ .grid{grid-template-columns:1fr} }

    .field{display:flex;flex-direction:column;gap:6px}
    label{font-size:12px;color:var(--muted)}
    input,textarea{
      width:100%;
      padding:12px 12px;
      border:1px solid var(--line);
      border-radius:14px;
      outline:none;
      background:#fff;
      color:var(--text);
      transition:.15s ease;
      font-size:14px;
    }
    textarea{min-height:110px;resize:vertical}
    input:focus,textarea:focus{
      border-color:rgba(2,132,199,.45);
      box-shadow: 0 0 0 4px rgba(2,132,199,.12);
    }

    .section{
      margin-top:12px;
      padding-top:12px;
      border-top:1px dashed rgba(148,163,184,.55);
    }

    /* switch */
    .switchRow{
      display:flex;align-items:flex-end;gap:12px;
      padding:10px 12px;
      border:1px solid var(--line);
      border-radius:14px;
      background:#fff;
      height:100%;
    }
    .switchWrap{display:flex;align-items:center;gap:10px}
    .switch{
      position:relative;width:46px;height:26px;flex:0 0 auto;
    }
    .switch input{display:none}
    .slider{
      position:absolute;inset:0;
      background:#e2e8f0;border:1px solid #dbe3ee;
      border-radius:999px;
      transition:.15s ease;
    }
    .slider:before{
      content:"";
      position:absolute;top:50%;left:3px;
      width:20px;height:20px;border-radius:999px;
      background:#fff;
      transform:translateY(-50%);
      box-shadow:0 4px 10px rgba(15,23,42,.18);
      transition:.15s ease;
    }
    .switch input:checked + .slider{
      background:rgba(16,185,129,.18);
      border-color:rgba(16,185,129,.35);
    }
    .switch input:checked + .slider:before{
      left:22px;
    }
    .switchText{font-size:13px;color:var(--text);font-weight:600}
    .hint{font-size:12px;color:var(--muted);margin-top:2px}

    .actions{
      display:flex;gap:10px;flex-wrap:wrap;
      margin-top:14px;
    }
    button{
      padding:11px 14px;border-radius:999px;
      border:1px solid transparent;
      background:linear-gradient(180deg, var(--primary), var(--primary2));
      color:#fff;
      cursor:pointer;
      transition:.15s ease;
      font-size:13px;
      display:inline-flex;align-items:center;gap:8px;
    }
    button:hover{transform:translateY(-1px);box-shadow:var(--shadow2)}
  </style>
</head>

<body>
<div class="wrap">
  <div class="topbar">
    <div class="title">
      <h2>{{ $mode === 'create' ? '➕ Thêm tài khoản' : '✏️ Sửa tài khoản' }}</h2>
      <div class="meta">Nhập thông tin acc, đặt hạn đổi số và đánh dấu trạng thái.</div>
    </div>
    <div class="toolbar">
      <a class="btn" href="{{ route('apps.accounts.index') }}">← Danh sách</a>
      <a class="btn" href="{{ route('home') }}">🏠 Main</a>
    </div>
  </div>

  <div class="card">
    @if($errors->any())
      <div class="err">
        <b>Vui lòng kiểm tra lại:</b>
        <div style="margin-top:6px">
          @foreach($errors->all() as $e) <div>• {{ $e }}</div> @endforeach
        </div>
      </div>
    @endif

    <form method="post" action="{{ $mode === 'create' ? route('apps.accounts.store') : route('apps.accounts.update', $item->id) }}">
      @csrf

      <div class="grid">
        <div class="field">
          <label>Tài khoản</label>
          <input name="account" value="{{ old('account', $item->account) }}" placeholder="vd: user123" required>
        </div>

        <div class="field">
          <label>Mật khẩu</label>
          <input name="password" value="{{ old('password', $item->password) }}" placeholder="vd: ********" required>
        </div>
      </div>

      <div class="grid section">
        <div class="field">
          <label>Ngày đến hạn đổi số (dd/mm/yyyy)</label>
          <input name="change_due_date"
                 placeholder="vd: 25/01/2026"
                 value="{{ old('change_due_date', $item->change_due_date ? $item->change_due_date->format('d/m/Y') : '') }}">
          <div class="hint">Để trống nếu chưa muốn đặt hạn.</div>
        </div>

        <div class="switchRow">
          <div class="switchWrap">
            <label class="switch" style="margin:0">
              <input type="checkbox" name="is_changed" value="1" @checked(old('is_changed', $item->is_changed))>
              <span class="slider"></span>
            </label>
            <div>
              <div class="switchText">Đã đổi số</div>
              <div class="hint">Bật nếu bạn đã đổi số cho acc này.</div>
            </div>
          </div>
        </div>
      </div>

      <div class="field section">
        <label>Ghi chú</label>
        <textarea name="note" placeholder="vd: acc VIP, login mail riêng, lưu ý...">{{ old('note', $item->note) }}</textarea>
      </div>

      <div class="actions">
        <button type="submit">💾 Lưu</button>
        <a class="btn" href="{{ route('apps.accounts.index') }}">Huỷ</a>
      </div>
    </form>
  </div>
</div>
</body>
</html>
