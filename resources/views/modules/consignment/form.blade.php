<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>{{ $mode==='create'?'Thêm treo hộ':'Sửa treo hộ' }}</title>

  <style>
    :root{
      --bg:#f6f7fb;
      --card:#ffffff;
      --text:#0f172a;
      --muted:#64748b;
      --line:#e6eaf2;
      --shadow: 0 10px 24px rgba(15,23,42,.10);
      --shadow2: 0 6px 16px rgba(15,23,42,.10);
      --radius:22px;

      --primary:#111827;
      --primary2:#0b1220;

      --okBg:#ecfdf3;
      --okLine:#b7f5c3;
      --okText:#0c6b2a;

      --dangerBg:#fff1f2;
      --dangerLine:#fecdd3;
      --dangerText:#9f1239;

      --chipBg:#f8fafc;
    }

    *{box-sizing:border-box}
    body{
      margin:0;
      background:
        radial-gradient(1200px 520px at 20% -10%, rgba(17,24,39,.08), transparent 60%),
        radial-gradient(900px 420px at 92% 0%, rgba(2,132,199,.10), transparent 55%),
        var(--bg);
      color:var(--text);
      font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial;
    }

    .wrap{max-width:920px;margin:0 auto;padding:26px 16px 44px}

    .top{
      display:flex;gap:14px;flex-wrap:wrap;
      justify-content:space-between;align-items:flex-start;
      margin-bottom:12px;
    }
    h2{margin:0;font-size:20px;letter-spacing:-.2px}
    .hint{font-size:13px;color:var(--muted);line-height:1.5}

    .toolbar{display:flex;gap:10px;flex-wrap:wrap;align-items:center}
    .btn{
      display:inline-flex;gap:8px;align-items:center;
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
    .btnDark{
      background:linear-gradient(180deg, var(--primary), var(--primary2));
      color:#fff;border-color:transparent;
    }

    .card{
      background:rgba(255,255,255,.86);
      border:1px solid var(--line);
      border-radius:var(--radius);
      padding:16px;
      margin-top:12px;
      box-shadow:var(--shadow);
      backdrop-filter: blur(8px);
    }

    .err{
      background:var(--dangerBg);
      border:1px solid var(--dangerLine);
      color:var(--dangerText);
      padding:12px 14px;
      border-radius:16px;
      margin-bottom:12px;
      font-size:14px;
      line-height:1.6;
    }

    label{font-size:12px;color:var(--muted)}
    .field{display:flex;flex-direction:column;gap:6px}

    input,select,textarea{
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
    input:focus,select:focus,textarea:focus{
      border-color:rgba(2,132,199,.45);
      box-shadow: 0 0 0 4px rgba(2,132,199,.12);
    }

    .grid{display:grid;grid-template-columns:1fr 1fr;gap:12px}
    @media(max-width:820px){.grid{grid-template-columns:1fr}}

    .subhint{font-size:12px;color:var(--muted);margin-top:2px}

    .section{
      margin-top:12px;
      padding-top:12px;
      border-top:1px dashed rgba(148,163,184,.55);
    }

    .pricePreview{
      padding:12px 14px;
      border:1px dashed rgba(148,163,184,.7);
      border-radius:16px;
      background:var(--chipBg);
      font-weight:900;
      font-size:18px;
      letter-spacing:-.4px;
    }
    .chip{
      display:inline-flex;align-items:center;gap:8px;
      font-size:12px;
      padding:7px 10px;
      border-radius:999px;
      border:1px solid var(--line);
      background:var(--chipBg);
      white-space:nowrap;
      color:var(--text);
    }

    .actions{display:flex;gap:10px;flex-wrap:wrap;margin-top:14px}
    button{
      padding:11px 14px;border-radius:999px;
      border:1px solid transparent;
      background:linear-gradient(180deg, var(--primary), var(--primary2));
      color:#fff;cursor:pointer;
      transition:.15s ease;
      font-size:13px;
      display:inline-flex;align-items:center;gap:8px;
    }
    button:hover{transform:translateY(-1px);box-shadow:var(--shadow2)}

    /* Image area */
    .imgs{
      display:grid;
      grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
      gap:12px;
      margin-top:12px;
    }
    .imgCard{
      background:#fff;
      border:1px solid var(--line);
      border-radius:18px;
      padding:10px;
      box-shadow: 0 6px 16px rgba(15,23,42,.06);
      transition:.15s ease;
    }
    .imgCard:hover{transform:translateY(-1px);box-shadow:var(--shadow2)}
    .thumb{
      width:100%;
      aspect-ratio: 1 / 1;
      height:auto;
      object-fit:cover;
      border-radius:14px;
      border:1px solid var(--line);
      cursor:zoom-in;
      background:#f1f5f9;
    }
    .imgTools{
      display:flex;align-items:center;justify-content:space-between;
      gap:10px;margin-top:8px;flex-wrap:wrap;
    }
    .imgTools label{
      display:flex;gap:8px;align-items:center;
      font-size:12px;color:var(--muted);
      user-select:none;
    }

    /* Modal */
    .modal{
      position:fixed;inset:0;
      display:none;align-items:center;justify-content:center;
      background:rgba(2,6,23,.72);
      z-index:9999;padding:20px;
    }
    .modalInner{position:relative;max-width:92vw;max-height:92vh}
    .modalClose{
      position:absolute;top:-14px;right:-14px;
      width:40px;height:40px;border-radius:999px;
      border:1px solid rgba(255,255,255,.25);
      background:rgba(15,23,42,.85);
      color:#fff;cursor:pointer;font-size:18px;
    }
  </style>
</head>

<body>
<div class="wrap">

  <div class="top">
    <div>
      <h2>🧷 {{ $mode==='create'?'Thêm treo hộ':'Sửa treo hộ' }}</h2>
      <div class="hint">Giá nhập theo nghìn: <b>1000 = 1,000,000đ</b> • Ví dụ: 2500 = 2.5 triệu</div>
    </div>
    <div class="toolbar">
      <a class="btn" href="{{ route('apps.consignment.index') }}">← Quay lại</a>
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
      $pk = (int)old('price_k', $item->price_k ?? 0);
      $preview = number_format($pk * 1000) . ' đ';
      $heroes = (int)old('heroes', $item->heroes ?? 0);
      $skins  = (int)old('skins',  $item->skins ?? 0);
    @endphp

    <form method="post" enctype="multipart/form-data"
          action="{{ $mode==='create' ? route('apps.consignment.store') : route('apps.consignment.update', $item->id) }}">
      @csrf

      <div class="grid">
        <div class="field">
          <label>Mã tài khoản</label>
          <input name="code" value="{{ old('code', $item->code) }}" placeholder="vd: LQ-0001" required>
          <div class="subhint">Nên đặt mã ngắn gọn để tìm nhanh.</div>
        </div>

        <div class="field">
          <label>Phân khúc (tuỳ chọn)</label>
          <select name="segment">
            <option value="">-- Tự do --</option>
            @foreach($segments as $seg)
              <option value="{{ $seg }}" @selected(old('segment', $item->segment)===$seg)>{{ $seg }}</option>
            @endforeach
          </select>
          <div class="subhint">Ví dụ: 200k, 500k, 1tr, 3tr…</div>
        </div>
      </div>

      <div class="grid section">
        <div class="field">
          <label>Giá (nhập theo nghìn)</label>
          <input id="price_k" name="price_k" type="number" min="0" step="1" value="{{ $pk }}" required>
          <div class="subhint">VD: 1000 = 1 triệu • 2500 = 2.5 triệu</div>
        </div>

        <div class="field">
          <label>Hiển thị</label>
          <div id="price_preview" class="pricePreview">{{ $preview }}</div>
          <div class="subhint">Tự đổi theo giá nghìn.</div>
        </div>
      </div>

      <div class="grid section">
        <div class="field">
          <label>Số tướng</label>
          <input name="heroes" type="number" min="0" step="1" value="{{ $heroes }}" required>
        </div>
        <div class="field">
          <label>Số skin</label>
          <input name="skins" type="number" min="0" step="1" value="{{ $skins }}" required>
        </div>
      </div>

      <div class="field section">
        <label>Ghi chú</label>
        <textarea name="note" placeholder="vd: acc nhiều skin hiếm, đổi số ok, rank...">{{ old('note', $item->note) }}</textarea>
      </div>

      <div class="field section">
        <label>Ảnh tài khoản (có thể chọn nhiều)</label>
        <input type="file" name="images[]" accept="image/*" multiple>
        <div class="subhint">Mỗi ảnh tối đa 4MB.</div>

        {{-- ✅ dùng asset($img->path) --}}
        @if($mode==='edit' && $item->images && $item->images->count())
          <div class="imgs">
            @foreach($item->images as $img)
              <div class="imgCard">
                <img class="thumb thumbZoom" src="{{ asset($img->path) }}" data-full="{{ asset($img->path) }}" alt="">
                <div class="imgTools">
                  <span class="chip">Ảnh #{{ $loop->iteration }}</span>
                  <label><input type="checkbox" name="delete_images[]" value="{{ $img->id }}"> xoá</label>
                </div>
              </div>
            @endforeach
          </div>
        @endif
      </div>

      <div class="actions">
        <button type="submit">💾 Lưu</button>
        <a class="btn" href="{{ route('apps.consignment.index') }}">Huỷ</a>
      </div>
    </form>
  </div>
</div>

{{-- modal phóng to --}}
<div id="imgModal" class="modal">
  <div class="modalInner">
    <button id="imgClose" type="button" class="modalClose">✕</button>
    <img id="imgModalImg" src="" alt=""
         style="max-width:92vw;max-height:92vh;border-radius:18px;box-shadow:0 18px 50px rgba(0,0,0,.35);background:#fff">
  </div>
</div>

<script>
  // preview giá
  const inp = document.getElementById('price_k');
  const out = document.getElementById('price_preview');

  function fmt(n){
    n = Number(n || 0);
    const v = n * 1000;
    return v.toLocaleString('vi-VN') + ' đ';
  }
  function sync(){ out.textContent = fmt(inp.value); }
  inp?.addEventListener('input', sync);
  sync();

  // phóng to ảnh
  const modal = document.getElementById('imgModal');
  const modalImg = document.getElementById('imgModalImg');
  const btnClose = document.getElementById('imgClose');

  function openImg(src){ modalImg.src = src; modal.style.display = 'flex'; }
  function closeImg(){ modal.style.display = 'none'; modalImg.src = ''; }

  document.querySelectorAll('.thumbZoom').forEach(img=>{
    img.addEventListener('click', ()=> openImg(img.dataset.full || img.src));
  });

  btnClose?.addEventListener('click', closeImg);
  modal?.addEventListener('click', (e)=>{ if(e.target === modal) closeImg(); });
  document.addEventListener('keydown', (e)=>{ if(e.key === 'Escape') closeImg(); });
</script>
</body>
</html>
