<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>{{ $mode==='create'?'Thêm thu/chi':'Sửa thu/chi' }}</title>

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
    .title{display:flex;flex-direction:column;gap:6px}
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
    input,select{
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
    input:focus,select:focus{
      border-color:rgba(2,132,199,.45);
      box-shadow: 0 0 0 4px rgba(2,132,199,.12);
    }

    .section{
      margin-top:12px;
      padding-top:12px;
      border-top:1px dashed rgba(148,163,184,.55);
    }

    .typePreview{
      display:flex;align-items:center;gap:10px;
      padding:10px 12px;
      border:1px solid var(--line);
      border-radius:14px;
      background:#fff;
    }
    .badge{
      display:inline-flex;align-items:center;gap:6px;
      font-size:12px;
      padding:6px 10px;
      border-radius:999px;
      border:1px solid var(--line);
      white-space:nowrap;
      font-weight:700;
    }
    .badgeIncome{background:var(--okBg);border-color:var(--okLine);color:var(--okText)}
    .badgeExpense{background:var(--dangerBg);border-color:var(--dangerLine);color:var(--dangerText)}
    .hint{font-size:12px;color:var(--muted)}

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
      <h2>{{ $mode==='create'?'➕ Thêm thu/chi':'✏️ Sửa thu/chi' }}</h2>
      <div class="meta">Chỉ chọn loại, nhập số tiền và ghi chú. Ngày mặc định là hôm nay.</div>
    </div>

    <div class="toolbar">
      <a class="btn" href="{{ route('apps.finance.index') }}">← Quay lại</a>
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

    @php
      // Ngày mặc định hiển thị
      $displayDate = old('trans_date', $item->trans_date ? $item->trans_date->format('d/m/Y') : now()->format('d/m/Y'));
      $type = old('type', $item->type ?: 'income');
    @endphp

    <form method="post" action="{{ $mode==='create' ? route('apps.finance.store') : route('apps.finance.update', $item->id) }}">
      @csrf

      {{-- KHÔNG cho nhập ngày: gửi hidden luôn là hôm nay (dd/mm/yyyy) --}}
      <input type="hidden" name="trans_date" value="{{ $displayDate }}">

      {{-- Nếu bạn muốn HIỂN THỊ ngày (readonly) thì bỏ comment block này:
      <div class="field" style="margin-bottom:12px">
        <label>Ngày</label>
        <input value="{{ $displayDate }}" readonly>
        <div class="hint">Ngày tự động là hôm nay.</div>
      </div>
      --}}

      <div class="grid">
        <div class="field">
          <label>Loại</label>
          <select name="type" required>
            <option value="income" @selected($type==='income')>Thu</option>
            <option value="expense" @selected($type==='expense')>Chi</option>
          </select>

          <div class="typePreview" style="margin-top:8px">
            @if($type === 'income')
              <span class="badge badgeIncome">⬆️ Thu</span>
              <span class="hint">Tiền vào (bán acc, hoàn tiền, lời...)</span>
            @else
              <span class="badge badgeExpense">⬇️ Chi</span>
              <span class="hint">Tiền ra (mua reg, quảng cáo, tool...)</span>
            @endif
          </div>
        </div>

        <div class="field">
          <label>Số tiền (VND)</label>
          <input name="amount" type="number" min="0" step="1000"
                 value="{{ old('amount', $item->amount) }}" required
                 placeholder="vd: 250000">
          <div class="hint">Gợi ý: nhập theo VND, có thể dùng bội số 1.000.</div>
        </div>
      </div>

      <div class="section">
        <div class="field">
          <label>Ghi chú</label>
          <input name="note"
                 value="{{ old('note', $item->note) }}"
                 placeholder="vd: bán acc, mua reg, quảng cáo...">
          <div class="hint">Ghi rõ để dễ tìm lại sau này.</div>
        </div>
      </div>

      <div class="actions">
        <button type="submit">💾 Lưu</button>
        <a class="btn" href="{{ route('apps.finance.index') }}">Huỷ</a>
      </div>
    </form>

  </div>
</div>
</body>
</html>
