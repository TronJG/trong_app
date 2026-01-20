<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Treo hộ</title>
  <style>
    body{font-family:Arial;background:#f6f7fb;margin:0}
    .wrap{max-width:1100px;margin:0 auto;padding:22px}
    .top{display:flex;gap:10px;flex-wrap:wrap;justify-content:space-between;align-items:center}
    .btn{display:inline-flex;gap:8px;align-items:center;padding:10px 12px;border-radius:999px;border:1px solid #e6eaf2;background:#fff;text-decoration:none;color:#111}
    .btnDark{background:#111;color:#fff;border-color:#111}
    .card{background:#fff;border:1px solid #e6eaf2;border-radius:16px;padding:14px;margin-top:12px}
    input,select{padding:10px;border:1px solid #ddd;border-radius:12px}
    table{width:100%;border-collapse:separate;border-spacing:0 10px;margin-top:12px}
    th{font-size:12px;color:#64748b;text-align:left;padding:0 8px 6px}
    td{background:#fff;border:1px solid #e6eaf2;padding:10px}
    tr td:first-child{border-top-left-radius:14px;border-bottom-left-radius:14px}
    tr td:last-child{border-top-right-radius:14px;border-bottom-right-radius:14px}
    .imgs{display:flex;gap:8px;flex-wrap:wrap}
    .imgs img{width:46px;height:46px;object-fit:cover;border-radius:10px;border:1px solid #e6eaf2}
    .thumbZoom{cursor:zoom-in}
    .right{text-align:right}
    .msg{background:#ecfdf3;border:1px solid #b7f5c3;color:#0c6b2a;padding:10px;border-radius:12px;margin-top:10px}
    .small{font-size:12px;color:#64748b}
    .actions{display:flex;gap:8px;justify-content:flex-end;flex-wrap:wrap}
    button{padding:10px 12px;border-radius:999px;border:1px solid #e6eaf2;background:#fff;cursor:pointer}
    .danger{background:#fff1f2;border-color:#fecdd3;color:#9f1239}

    .sliderBox{display:flex;gap:10px;flex-wrap:wrap;align-items:center;margin-top:10px}
    .range{width:220px}
    .pill{display:inline-flex;align-items:center;gap:6px;padding:7px 10px;border:1px solid #e6eaf2;border-radius:999px;background:#fff;font-size:12px}

    .modal{position:fixed;inset:0;display:none;align-items:center;justify-content:center;background:rgba(2,6,23,.72);z-index:9999;padding:20px}
    .modalClose{position:absolute;top:-14px;right:-14px;width:40px;height:40px;border-radius:999px;border:1px solid rgba(255,255,255,.25);background:rgba(15,23,42,.85);color:#fff;cursor:pointer;font-size:18px}
  </style>
</head>
<body>
<div class="wrap">

  <div class="top">
    <div>
      <h2 style="margin:0 0 4px">🧷 Treo hộ tài khoản</h2>
      <div class="small">Tìm theo mã/ghi chú hoặc nhập số để tìm theo số skin.</div>
    </div>
    <div style="display:flex;gap:10px;flex-wrap:wrap">
      <a class="btn" href="{{ route('home') }}">← Main</a>
      <a class="btn btnDark" href="{{ route('apps.consignment.create') }}">+ Thêm</a>
    </div>
  </div>

  @if(session('success'))
    <div class="msg">{{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="msg" style="background:#fff7ed;border-color:#fed7aa;color:#9a3412">{{ session('error') }}</div>
  @endif

  {{-- ✅ FORM GET LỌC (tách riêng - KHÔNG lồng vào form export) --}}
  <div class="card">
    <form method="get" id="filterForm" style="display:flex;gap:10px;flex-wrap:wrap;align-items:center;justify-content:space-between">
      <div style="display:flex;gap:10px;flex-wrap:wrap;align-items:center">
        <input name="s" value="{{ request('s') }}" placeholder="Tìm mã acc / ghi chú / nhập số skin...">

        <select name="segment">
          <option value="">Tất cả phân khúc</option>
          @foreach($segments as $seg)
            <option value="{{ $seg }}" @selected(request('segment')===$seg)>{{ $seg }}</option>
          @endforeach
        </select>

        <button type="submit">🔎 Lọc</button>
        <a class="btn" href="{{ route('apps.consignment.index') }}">Reset</a>
      </div>

      @php
        $minK = (int)request('min_k', 0);
        $maxK = (int)request('max_k', $sliderMax); // sliderMax=25000
      @endphp

      <div class="sliderBox">
        <span class="pill">Giá min: <b id="minText"></b></span>
        <input class="range" type="range" id="minRange" min="0" max="{{ $sliderMax }}" step="10" value="{{ $minK }}">
        <input type="hidden" name="min_k" id="min_k" value="{{ $minK }}">

        <span class="pill">Giá max: <b id="maxText"></b></span>
        <input class="range" type="range" id="maxRange" min="0" max="{{ $sliderMax }}" step="10" value="{{ $maxK }}">
        <input type="hidden" name="max_k" id="max_k" value="{{ $maxK }}">
      </div>
    </form>
  </div>

  {{-- ✅ FORM POST EXPORT (bao TRỌN bảng checkbox + nút export) --}}
  <form method="post" id="exportForm">
    @csrf

    <div class="card">
      <div style="display:flex;gap:10px;flex-wrap:wrap;align-items:center;justify-content:space-between">
        <div class="small">Chọn tick nhiều dòng rồi xuất.</div>

        <div style="display:flex;gap:10px;flex-wrap:wrap;align-items:center">
          <input name="filename" placeholder="Tên file xuất (tuỳ chọn)" value="treoho_{{ date('Ymd') }}">
          <button type="submit" formaction="{{ route('apps.consignment.export.txt') }}">⬇️ Xuất TXT</button>
          <button type="submit" formaction="{{ route('apps.consignment.export.images') }}">🖼️ Xuất Ảnh</button>
        </div>
      </div>

      <table>
        <thead>
        <tr>
          <th style="width:44px">
            <input type="checkbox" id="ckAll">
          </th>
          <th>Mã acc</th>
          <th style="width:160px">Giá</th>
          <th style="width:140px">Tướng / Skin</th>
          <th style="width:160px">Phân khúc</th>
          <th>Ảnh</th>
          <th style="width:220px" class="right">Hành động</th>
        </tr>
        </thead>

        <tbody>
        @foreach($items as $it)
          <tr>
            <td><input class="ck" type="checkbox" name="ids[]" value="{{ $it->id }}"></td>

            <td>
              <b>{{ $it->code }}</b>
              @if($it->note)<div class="small">{{ $it->note }}</div>@endif
            </td>

            <td>
              <div><b>{{ number_format($it->price_vnd) }} đ</b></div>
              <div class="small">Nhập: {{ $it->price_k }} (nghìn)</div>
            </td>

            <td>
              <div><b>{{ $it->heroes }}</b> tướng</div>
              <div class="small"><b>{{ $it->skins }}</b> skin</div>
            </td>

            <td>{{ $it->segment }}</td>

            <td>
              <div class="imgs">
                @foreach($it->images->take(6) as $img)
                  <img class="thumbZoom"
                       src="{{ asset($img->path) }}"
                       data-full="{{ asset($img->path) }}"
                       alt="image">
                @endforeach
              </div>
            </td>

            <td class="right">
              <div class="actions">
                <a class="btn" href="{{ route('apps.consignment.edit', $it->id) }}">✏️ Sửa</a>
                <button class="danger" type="submit" formaction="{{ route('apps.consignment.delete', $it->id) }}"
                        onclick="return confirm('Xoá tài khoản này?')">🗑️ Xoá</button>
              </div>
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>

      <div style="margin-top:12px">
        {{ $items->links() }}
      </div>
    </div>
  </form>

</div>

{{-- modal phóng to --}}
<div id="imgModal" class="modal">
  <div style="position:relative;max-width:92vw;max-height:92vh;">
    <button id="imgClose" type="button" class="modalClose">✕</button>
    <img id="imgModalImg" src="" alt="" style="max-width:92vw;max-height:92vh;border-radius:16px;box-shadow:0 18px 50px rgba(0,0,0,.35);background:#fff">
  </div>
</div>

<script>
  // check all
  const ckAll = document.getElementById('ckAll');
  ckAll?.addEventListener('change', ()=>{
    document.querySelectorAll('.ck').forEach(x=>x.checked = ckAll.checked);
  });

  // modal ảnh
  const modal = document.getElementById('imgModal');
  const modalImg = document.getElementById('imgModalImg');
  const btnClose = document.getElementById('imgClose');
  function openImg(src){ modalImg.src = src; modal.style.display = 'flex'; }
  function closeImg(){ modal.style.display = 'none'; modalImg.src = ''; }
  document.querySelectorAll('.thumbZoom').forEach(img=>{
    img.addEventListener('click', ()=> openImg(img.dataset.full || img.src));
  });
  btnClose.addEventListener('click', closeImg);
  modal.addEventListener('click', (e)=>{ if(e.target===modal) closeImg(); });
  document.addEventListener('keydown', (e)=>{ if(e.key==='Escape') closeImg(); });

  // slider
  const minRange = document.getElementById('minRange');
  const maxRange = document.getElementById('maxRange');
  const minK = document.getElementById('min_k');
  const maxK = document.getElementById('max_k');
  const minText = document.getElementById('minText');
  const maxText = document.getElementById('maxText');

  function fmtVndK(k){
    const v = Number(k||0) * 1000;
    return v.toLocaleString('vi-VN') + ' đ';
  }
  function syncSlider(){
    let a = parseInt(minRange.value||'0',10);
    let b = parseInt(maxRange.value||'0',10);
    if (a > b) { const t=a; a=b; b=t; }
    minK.value = a; maxK.value = b;
    minText.textContent = fmtVndK(a);
    maxText.textContent = fmtVndK(b);
  }
  syncSlider();
  minRange.addEventListener('input', syncSlider);
  maxRange.addEventListener('input', syncSlider);

  let timer=null;
  function delayedSubmit(){
    clearTimeout(timer);
    timer=setTimeout(()=>document.getElementById('filterForm').submit(), 600);
  }
  minRange.addEventListener('change', delayedSubmit);
  maxRange.addEventListener('change', delayedSubmit);
</script>
</body>
</html>
