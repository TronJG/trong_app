<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Quản lý tài khoản</title>
  <style>
    :root{
      --bg:#f6f7fb;
      --card:#ffffff;
      --text:#0f172a;
      --muted:#64748b;
      --line:#e6eaf2;
      --shadow: 0 10px 24px rgba(15, 23, 42, .08);
      --shadow2: 0 6px 16px rgba(15, 23, 42, .08);
      --radius:18px;
      --radius2:14px;

      --primary:#111827;
      --primary2:#0b1220;

      --okBg:#ecfdf3;
      --okLine:#b7f5c3;
      --okText:#0c6b2a;

      --dangerBg:#fff1f2;
      --dangerLine:#fecdd3;
      --dangerText:#9f1239;

      --warnBg:#fff7ed;
      --warnLine:#fed7aa;
      --warnText:#9a3412;
    }

    *{box-sizing:border-box}
    body{
      margin:0;
      background:
        radial-gradient(1200px 500px at 20% -10%, rgba(17,24,39,.08), transparent 60%),
        radial-gradient(900px 450px at 90% 0%, rgba(2,132,199,.10), transparent 55%),
        var(--bg);
      color:var(--text);
      font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial;
    }

    .wrap{max-width:1120px;margin:0 auto;padding:26px 18px 40px}
    .top{display:flex;gap:14px;align-items:flex-start;justify-content:space-between;flex-wrap:wrap}
    h1,h2{margin:0}
    .title{
      display:flex;flex-direction:column;gap:6px
    }
    .title h2{font-size:20px;letter-spacing:-.2px}
    .meta{color:var(--muted);font-size:13px;line-height:1.5}

    .toolbar{display:flex;gap:10px;flex-wrap:wrap;align-items:center}
    a{color:inherit}
    .btn{
      display:inline-flex;align-items:center;gap:8px;
      padding:10px 12px;border-radius:999px;
      border:1px solid var(--line);
      background:rgba(255,255,255,.75);
      backdrop-filter: blur(6px);
      text-decoration:none;
      color:var(--text);
      box-shadow: 0 1px 0 rgba(15,23,42,.04);
      transition:.15s ease;
      font-size:13px;
    }
    .btn:hover{transform:translateY(-1px);box-shadow:var(--shadow2)}
    .btnPrimary{
      background:linear-gradient(180deg, var(--primary), var(--primary2));
      color:#fff;border-color:transparent;
    }
    .btnGhost{
      background:#fff;
    }

    .msg{
      margin-top:14px;
      padding:12px 14px;
      border-radius:var(--radius2);
      border:1px solid var(--okLine);
      background:var(--okBg);
      color:var(--okText);
      box-shadow: 0 6px 18px rgba(16,185,129,.08);
      font-size:14px;
    }

    .card{
      background:rgba(255,255,255,.82);
      border:1px solid var(--line);
      border-radius:var(--radius);
      box-shadow: var(--shadow);
      padding:14px;
      margin-top:14px;
      backdrop-filter: blur(8px);
    }

    /* Filter bar */
    .filter{
      display:flex;gap:10px;flex-wrap:wrap;align-items:center;
      padding:12px;
      border-radius:16px;
      border:1px solid var(--line);
      background:#fff;
    }
    .field{display:flex;flex-direction:column;gap:6px;min-width:220px;flex:1}
    .label{font-size:12px;color:var(--muted)}
    input,select{
      width:100%;
      padding:11px 12px;
      border:1px solid var(--line);
      border-radius:14px;
      outline:none;
      background:#fff;
      color:var(--text);
      transition:.15s ease;
      font-size:14px;
    }
    input:focus,select:focus{
      border-color:rgba(2,132,199,.45);
      box-shadow: 0 0 0 4px rgba(2,132,199,.12);
    }

    button{
      padding:11px 14px;
      border-radius:999px;
      border:1px solid var(--line);
      background:#fff;
      cursor:pointer;
      transition:.15s ease;
      font-size:13px;
      display:inline-flex;align-items:center;gap:8px;
    }
    button:hover{transform:translateY(-1px);box-shadow:var(--shadow2)}
    button.primary{
      background:linear-gradient(180deg, var(--primary), var(--primary2));
      color:#fff;border-color:transparent;
    }
    .small{font-size:12px}

    /* List */
    .list{display:grid;grid-template-columns:1fr;gap:12px;margin-top:14px}
    .item{
      background:#fff;
      border:1px solid var(--line);
      border-radius:20px;
      padding:14px 14px 12px;
      display:flex;gap:14px;
      align-items:flex-start;justify-content:space-between;
      flex-wrap:wrap;
      box-shadow: 0 6px 18px rgba(15,23,42,.06);
      transition:.15s ease;
    }
    .item:hover{transform:translateY(-1px);box-shadow:var(--shadow2)}
    .left{min-width:260px;flex:1}
    .headline{display:flex;gap:10px;align-items:center;flex-wrap:wrap}
    .acc{font-size:15px;font-weight:700;letter-spacing:-.2px}
    .sub{
      margin-top:8px;
      color:var(--muted);
      font-size:13px;
      line-height:1.6;
    }
    .sub b{color:var(--text);font-weight:600}

    .badges{display:flex;gap:8px;flex-wrap:wrap}
    .badge{
      display:inline-flex;align-items:center;gap:6px;
      font-size:12px;
      padding:6px 10px;
      border-radius:999px;
      border:1px solid var(--line);
      background:#f8fafc;
      color:#0f172a;
      white-space:nowrap;
    }
    .badge.ok{background:var(--okBg);border-color:var(--okLine);color:var(--okText)}
    .badge.danger{background:var(--dangerBg);border-color:var(--dangerLine);color:var(--dangerText)}
    .badge.warn{background:var(--warnBg);border-color:var(--warnLine);color:var(--warnText)}
    .badge.gray{background:#f1f5f9;border-color:#e2e8f0;color:#334155}

    .rightActions{display:flex;gap:10px;flex-wrap:wrap;align-items:center}
    .rightActions form{margin:0}

    .btnLite{
      padding:10px 12px;border-radius:999px;border:1px solid var(--line);
      background:#fff;text-decoration:none;
      display:inline-flex;align-items:center;gap:8px;font-size:13px;
      transition:.15s ease;
    }
    .btnLite:hover{transform:translateY(-1px);box-shadow:var(--shadow2)}
    .btnDanger{
      border-color:var(--dangerLine);
      background:linear-gradient(180deg, #fff1f2, #ffe4e6);
      color:var(--dangerText);
    }

    /* Responsive */
    @media (min-width: 980px){
      .field{min-width:260px}
    }
    @media (max-width: 640px){
      .wrap{padding:18px 14px 34px}
      .card{padding:12px}
      .filter{padding:10px}
      .field{min-width:100%}
      .rightActions{width:100%}
    }
  </style>
</head>

<body>
<div class="wrap">
  <div class="top">
    <div class="title">
      <h2>🔐 Quản lý tài khoản</h2>
      <div class="meta">Quản lý acc / mật khẩu / ghi chú / ngày đến hạn đổi số / trạng thái đổi số</div>
    </div>
    <div class="toolbar">
      <a class="btn btnGhost" href="{{ route('home') }}">← Main</a>
      <a class="btn btnGhost" href="{{ route('apps.accounts.due') }}">⚠️ Đến hạn chưa đổi</a>
      <a class="btn btnPrimary" href="{{ route('apps.accounts.create') }}">+ Thêm acc</a>
    </div>
  </div>

  @if(session('success'))
    <div class="msg">{{ session('success') }}</div>
  @endif

  <div class="card">
    <form class="filter" method="get" action="{{ route('apps.accounts.index') }}">
      <div class="field">
        <div class="label">Tìm kiếm</div>
        <input name="s" value="{{ request('s') }}" placeholder="Nhập acc hoặc ghi chú...">
      </div>

      <div class="field" style="min-width:210px;flex:0.7">
        <div class="label">Trạng thái</div>
        <select name="changed">
          <option value="">Tất cả</option>
          <option value="0" @selected(request('changed')==='0')>Chưa đổi số</option>
          <option value="1" @selected(request('changed')==='1')>Đã đổi số</option>
        </select>
      </div>

      <div class="field" style="min-width:230px;flex:0.9">
        <div class="label">Lọc theo hạn</div>
        <select name="due">
          <option value="">Tất cả</option>
          <option value="1" @selected(request('due')==='1')>Đến hạn & chưa đổi</option>
        </select>
      </div>

      <div style="display:flex;gap:10px;align-items:flex-end;flex-wrap:wrap">
        <button class="primary" type="submit">🔎 Lọc</button>
        <a class="btn small" href="{{ route('apps.accounts.index') }}">Reset</a>
      </div>
    </form>

    <div class="list">
      @foreach($items as $it)
        @php
          $due = $it->change_due_date ? $it->change_due_date->format('d/m/Y') : null;
          $isDue = (!$it->is_changed) && $it->change_due_date && $it->change_due_date->lte($today);
        @endphp

        <div class="item">
          <div class="left">
            <div class="headline">
              <div class="acc">{{ $it->account }}</div>

              <div class="badges">
                @if($it->is_changed)
                  <span class="badge ok">✅ Đã đổi số</span>
                @else
                  <span class="badge {{ $isDue ? 'danger' : 'warn' }}">
                    {{ $isDue ? '⏰ Đến hạn chưa đổi' : '🕒 Chưa đổi số' }}
                  </span>
                @endif

                @if($due)
                  <span class="badge {{ $isDue ? 'danger' : 'gray' }}">📅 Hạn: {{ $due }}</span>
                @else
                  <span class="badge gray">📅 Chưa đặt hạn</span>
                @endif
              </div>
            </div>

            <div class="sub">
              <div><b>Mật khẩu:</b> {{ $it->password }}</div>
              @if($it->note)<div><b>Ghi chú:</b> {{ $it->note }}</div>@endif
              @if($it->changed_at)<div><b>Đổi lúc:</b> {{ $it->changed_at->format('d/m/Y H:i') }}</div>@endif
            </div>
          </div>

          <div class="rightActions">
            <a class="btnLite" href="{{ route('apps.accounts.edit', $it->id) }}">✏️ Sửa</a>

            <form method="post" action="{{ route('apps.accounts.toggle', $it->id) }}">
              @csrf
              <button type="submit">
                {{ $it->is_changed ? '↩️ Đánh dấu CHƯA đổi' : '✅ Đánh dấu ĐÃ đổi' }}
              </button>
            </form>

            <form method="post" action="{{ route('apps.accounts.delete', $it->id) }}" onsubmit="return confirm('Xoá acc này?')">
              @csrf
              <button class="btnDanger" type="submit">🗑️ Xoá</button>
            </form>
          </div>
        </div>
      @endforeach
    </div>

    <div style="margin-top:14px">
      {{ $items->links() }}
    </div>
  </div>
</div>
</body>
</html>
