<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Chi tiêu - {{ $ym }}</title>
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

    .wrap{max-width:1100px;margin:0 auto;padding:26px 16px 44px}

    .topbar{
      display:flex;gap:10px;flex-wrap:wrap;align-items:center;justify-content:space-between;
      margin-bottom:12px;
    }
    .title{display:flex;flex-direction:column;gap:6px}
    .title h2{margin:0;font-size:22px;letter-spacing:-.2px;display:flex;gap:10px;align-items:center}
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

    .msg{
      padding:12px 14px;border-radius:16px;margin:10px 0 12px;
      font-size:14px;line-height:1.6;
      background:var(--okBg);
      border:1px solid var(--okLine);
      color:var(--okText);
    }

    .row{display:flex;gap:10px;flex-wrap:wrap;align-items:center}

    input,select{
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

    .pill{
      display:inline-flex;align-items:center;gap:8px;
      font-size:12px;
      padding:8px 12px;
      border-radius:999px;
      border:1px solid var(--line);
      background:#fff;
      white-space:nowrap;
      font-weight:700;
    }
    .pillMonth{background:#f8fafc}
    .pillIncome{background:var(--okBg);border-color:var(--okLine);color:var(--okText)}
    .pillExpense{background:var(--dangerBg);border-color:var(--dangerLine);color:var(--dangerText)}

    .stats{
      display:flex;justify-content:space-between;gap:12px;flex-wrap:wrap;align-items:flex-start;
      position:relative;
      padding:10px 10px 12px;
      border:1px solid var(--line);
      border-radius:18px;
      background:rgba(255,255,255,.7);
    }

    .filters{
      margin-top:14px;
      padding:12px;
      border:1px solid var(--line);
      border-radius:18px;
      background:rgba(255,255,255,.7);
      display:flex;gap:10px;flex-wrap:wrap;align-items:center;justify-content:space-between;
    }
    .filtersLeft{flex:1;min-width:260px}
    .filtersRight{display:flex;gap:10px;flex-wrap:wrap;align-items:center}
    .search{width:100%;max-width:520px}

    table{width:100%;border-collapse:separate;border-spacing:0 10px;margin-top:14px}
    th{font-size:12px;color:var(--muted);text-align:left;padding:0 10px 6px}
    td{
      background:#fff;border:1px solid var(--line);
      padding:12px 12px;
    }
    tr td:first-child{border-top-left-radius:16px;border-bottom-left-radius:16px}
    tr td:last-child{border-top-right-radius:16px;border-bottom-right-radius:16px}

    .tag{
      display:inline-flex;align-items:center;gap:6px;
      padding:6px 10px;border-radius:999px;
      border:1px solid var(--line);
      font-size:12px;font-weight:800;
      white-space:nowrap;
    }
    .tagIncome{background:var(--okBg);border-color:var(--okLine);color:var(--okText)}
    .tagExpense{background:var(--dangerBg);border-color:var(--dangerLine);color:var(--dangerText)}

    .money{text-align:right;font-weight:900}
    .actions{display:flex;gap:10px;justify-content:flex-end;flex-wrap:wrap}
    .btnMini{
      display:inline-flex;align-items:center;gap:8px;
      padding:9px 12px;border-radius:999px;
      border:1px solid var(--line);
      background:#fff;
      cursor:pointer;
      text-decoration:none;color:var(--text);
      font-size:13px;
      transition:.15s ease;
    }
    .btnMini:hover{transform:translateY(-1px);box-shadow:var(--shadow2)}
    .btnDanger{background:var(--dangerBg);border-color:var(--dangerLine);color:var(--dangerText)}
    .btnDark{background:linear-gradient(180deg, var(--primary), var(--primary2)); color:#fff;border-color:transparent}

    .pager{margin-top:14px}

    /* =========================
       WIDGET CHÊNH LỆCH NỔI + KÉO THẢ
       ========================= */
    .netBox{
      position:fixed;
      right:20px;
      bottom:20px;
      z-index:9999;

      padding:12px 14px;
      border-radius:18px;
      border:1px solid var(--line);
      background:rgba(255,255,255,.92);
      backdrop-filter: blur(8px);
      box-shadow: 0 14px 32px rgba(15,23,42,.18);

      min-width:260px;
      text-align:right;

      cursor:grab;
      user-select:none;
      touch-action:none; /* quan trọng cho mobile drag */
    }
    .netBox:active{cursor:grabbing}

    .netHead{
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:10px;
      margin-bottom:6px;
    }
    .netLabel{font-size:12px;color:var(--muted);font-weight:800}
    .netHint{
      font-size:12px;
      color:var(--muted);
      opacity:.9;
      display:inline-flex;
      align-items:center;
      gap:6px;
      padding:6px 10px;
      border-radius:999px;
      border:1px solid var(--line);
      background:#fff;
      box-shadow: 0 1px 0 rgba(15,23,42,.04);
    }

    .netValue{font-size:26px;font-weight:900;letter-spacing:-.4px;margin-top:2px}
    .netPos{color:var(--okText)}
    .netNeg{color:var(--dangerText)}

    .netActions{
      display:flex;
      gap:8px;
      justify-content:flex-end;
      margin-top:10px;
    }
    .netBtn{
      border:1px solid var(--line);
      background:#fff;
      border-radius:999px;
      padding:8px 10px;
      font-size:12px;
      font-weight:800;
      cursor:pointer;
      box-shadow: 0 1px 0 rgba(15,23,42,.04);
      transition:.15s ease;
    }
    .netBtn:hover{transform:translateY(-1px);box-shadow:var(--shadow2)}
    .netBtnDanger{background:var(--dangerBg);border-color:var(--dangerLine);color:var(--dangerText)}
  </style>
</head>
<body>
<div class="wrap">

  <div class="topbar">
    <div class="title">
      <h2>🧾 Quản lý thu/chi</h2>
      <div class="meta">Tổng kết theo tháng + xem lại tháng cũ</div>
    </div>
    <div class="toolbar">
      <a class="btn" href="{{ route('home') }}">← Main</a>
      <a class="btn btnPrimary" href="{{ route('apps.finance.create') }}">+ Thêm thu/chi</a>
    </div>
  </div>

  @if(session('success'))
    <div class="msg">{{ session('success') }}</div>
  @endif

  <div class="card">

    {{-- ====== STATS BAR ====== --}}
    <div class="stats">

      <div class="row" style="gap:10px;flex-wrap:wrap">
        <span class="pill pillMonth">Tháng: <b>{{ $ym }}</b></span>
        <span class="pill pillIncome">Tổng thu: <b>{{ number_format($incomeTotal) }} đ</b></span>
        <span class="pill pillExpense">Tổng chi: <b>{{ number_format($expenseTotal) }} đ</b></span>
      </div>

      <div class="row" style="gap:10px;align-items:center">
        <span style="font-size:12px;color:var(--muted);font-weight:700">Xem tháng:</span>
        <select onchange="if(this.value) location.href='{{ url('/apps/finance/month') }}/'+this.value;">
          <option value="">-- Chọn --</option>
          @foreach($months as $m)
            <option value="{{ $m }}" @selected($m===$ym)>{{ $m }}</option>
          @endforeach
        </select>
      </div>

    </div>

    {{-- ====== FILTERS ====== --}}
    <form class="filters" method="get" action="{{ route('apps.finance.month', ['ym'=>$ym]) }}">
      <div class="filtersLeft">
        <input class="search" name="s" value="{{ request('s') }}" placeholder="Tìm theo ghi chú...">
      </div>

      <div class="filtersRight">
        <select name="type">
          <option value="">Tất cả (Thu/Chi)</option>
          <option value="income" @selected(request('type')==='income')>Thu</option>
          <option value="expense" @selected(request('type')==='expense')>Chi</option>
        </select>

        <button class="btn btnDark" type="submit">🔎 Lọc</button>
        <a class="btn" href="{{ route('apps.finance.month', ['ym'=>$ym]) }}">Reset</a>
      </div>
    </form>

    {{-- ====== TABLE ====== --}}
    <table>
      <thead>
      <tr>
        <th style="width:120px">Ngày</th>
        <th style="width:110px">Loại</th>
        <th>Ghi chú</th>
        <th style="width:170px;text-align:right">Số tiền</th>
        <th style="width:230px;text-align:right">Hành động</th>
      </tr>
      </thead>

      <tbody>
      @foreach($items as $it)
        <tr>
          <td>{{ $it->trans_date ? $it->trans_date->format('d/m/Y') : '' }}</td>

          <td>
            @if($it->type === 'income')
              <span class="tag tagIncome">⬆️ Thu</span>
            @else
              <span class="tag tagExpense">⬇️ Chi</span>
            @endif
          </td>

          <td>{{ $it->note }}</td>

          <td class="money">{{ number_format($it->amount) }} đ</td>

          <td>
            <div class="actions">
              <a class="btnMini" href="{{ route('apps.finance.edit', $it->id) }}">✏️ Sửa</a>

              <form method="post" action="{{ route('apps.finance.delete', $it->id) }}" onsubmit="return confirm('Xoá giao dịch này?')">
                @csrf
                <button class="btnMini btnDanger" type="submit">🗑️ Xoá</button>
              </form>
            </div>
          </td>
        </tr>
      @endforeach
      </tbody>
    </table>

    <div class="pager">
      {{ $items->links() }}
    </div>

  </div>
</div>

{{-- =========================
     WIDGET NỔI (KÉO THẢ) - ĐẶT NGOÀI WRAP ĐỂ NÓ LUÔN NỔI
     ========================= --}}
@php $isPos = $net >= 0; @endphp
<div id="netWidget" class="netBox" aria-label="Chênh lệch thu chi">
  <div class="netHead">
    <div class="netLabel">Chênh lệch (thu - chi)</div>
    <div class="netHint" title="Kéo để di chuyển">↔ Kéo</div>
  </div>
  <div class="netValue {{ $isPos ? 'netPos' : 'netNeg' }}">
    {{ $isPos ? '+' : '' }}{{ number_format($net) }} đ
  </div>

  <div class="netActions">
    <button type="button" class="netBtn" id="netReset">Reset vị trí</button>
    <button type="button" class="netBtn netBtnDanger" id="netHide">Ẩn</button>
  </div>
</div>

<script>
(function(){
  const el = document.getElementById('netWidget');
  const btnReset = document.getElementById('netReset');
  const btnHide = document.getElementById('netHide');
  const KEY = 'finance_net_widget_pos_v1';
  const KEY_HIDE = 'finance_net_widget_hide_v1';

  // Ẩn/hiện theo lưu
  const hidden = localStorage.getItem(KEY_HIDE);
  if(hidden === '1') el.style.display = 'none';

  // Khôi phục vị trí
  const saved = localStorage.getItem(KEY);
  if(saved){
    try{
      const p = JSON.parse(saved);
      if(typeof p.left === 'number' && typeof p.top === 'number'){
        el.style.left = p.left + 'px';
        el.style.top = p.top + 'px';
        el.style.right = 'auto';
        el.style.bottom = 'auto';
      }
    }catch(e){}
  }

  let isDown = false;
  let startX = 0, startY = 0;
  let startLeft = 0, startTop = 0;

  function clamp(val, min, max){ return Math.min(Math.max(val, min), max); }

  function pointerDown(e){
    // Nếu bấm vào nút thì không kéo
    if(e.target.closest('button')) return;

    isDown = true;
    el.setPointerCapture(e.pointerId);
    el.style.cursor = 'grabbing';

    const rect = el.getBoundingClientRect();
    startX = e.clientX;
    startY = e.clientY;
    startLeft = rect.left;
    startTop = rect.top;

    // Chuyển sang dùng top/left để kéo
    el.style.left = rect.left + 'px';
    el.style.top = rect.top + 'px';
    el.style.right = 'auto';
    el.style.bottom = 'auto';
  }

  function pointerMove(e){
    if(!isDown) return;
    const dx = e.clientX - startX;
    const dy = e.clientY - startY;

    const rect = el.getBoundingClientRect();
    const maxLeft = window.innerWidth - rect.width - 8;
    const maxTop = window.innerHeight - rect.height - 8;

    const newLeft = clamp(startLeft + dx, 8, maxLeft);
    const newTop  = clamp(startTop + dy, 8, maxTop);

    el.style.left = newLeft + 'px';
    el.style.top  = newTop + 'px';
  }

  function pointerUp(e){
    if(!isDown) return;
    isDown = false;
    el.style.cursor = 'grab';

    const rect = el.getBoundingClientRect();
    localStorage.setItem(KEY, JSON.stringify({left: rect.left, top: rect.top}));
  }

  // Drag bằng pointer events (hỗ trợ cả mobile)
  el.addEventListener('pointerdown', pointerDown);
  window.addEventListener('pointermove', pointerMove);
  window.addEventListener('pointerup', pointerUp);

  // Reset vị trí
  btnReset.addEventListener('click', function(){
    localStorage.removeItem(KEY);
    localStorage.removeItem(KEY_HIDE);
    el.style.display = '';
    el.style.left = 'auto';
    el.style.top = 'auto';
    el.style.right = '20px';
    el.style.bottom = '20px';
  });

  // Ẩn widget
  btnHide.addEventListener('click', function(){
    el.style.display = 'none';
    localStorage.setItem(KEY_HIDE, '1');
  });

  // Khi resize, giữ widget trong màn hình
  window.addEventListener('resize', function(){
    if(el.style.left === 'auto' || el.style.right !== 'auto') return;
    const rect = el.getBoundingClientRect();
    const maxLeft = window.innerWidth - rect.width - 8;
    const maxTop = window.innerHeight - rect.height - 8;

    const left = clamp(rect.left, 8, maxLeft);
    const top  = clamp(rect.top, 8, maxTop);

    el.style.left = left + 'px';
    el.style.top = top + 'px';
    localStorage.setItem(KEY, JSON.stringify({left, top}));
  });
})();
</script>

</body>
</html>
