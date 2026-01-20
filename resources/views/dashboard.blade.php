<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Main</title>

  <style>
    :root{
      --bg:#f6f7fb;
      --card:#ffffff;
      --text:#0f172a;
      --muted:#64748b;
      --line:#e6eaf2;
      --shadow: 0 12px 28px rgba(15,23,42,.10);
      --shadow2: 0 8px 20px rgba(15,23,42,.10);
      --radius:22px;

      --primary:#111827;
      --primary2:#0b1220;
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

    .wrap{max-width:1120px;margin:0 auto;padding:26px 18px 44px}

    /* Header */
    .header{
      display:flex;align-items:flex-end;justify-content:space-between;
      gap:14px;flex-wrap:wrap;
      margin-bottom:16px;
    }
    .titleBox{display:flex;flex-direction:column;gap:6px}
    h1{
      margin:0;
      font-size:22px;
      letter-spacing:-.2px;
    }
    .subtitle{
      color:var(--muted);
      font-size:13px;
      line-height:1.5;
    }

    .chip{
      display:inline-flex;align-items:center;gap:8px;
      padding:10px 12px;border-radius:999px;
      border:1px solid var(--line);
      background:rgba(255,255,255,.78);
      backdrop-filter: blur(6px);
      box-shadow: 0 1px 0 rgba(15,23,42,.04);
      color:var(--text);
      font-size:13px;
      user-select:none;
    }

    /* Grid */
    .grid{
      display:grid;
      gap:14px;
      grid-template-columns: repeat(3, minmax(0, 1fr));
    }
    @media (max-width: 950px){ .grid{grid-template-columns: repeat(2, 1fr);} }
    @media (max-width: 620px){ .grid{grid-template-columns: 1fr;} }

    /* Card */
    .card{
      display:block;
      background:rgba(255,255,255,.86);
      border:1px solid var(--line);
      border-radius:var(--radius);
      padding:18px;
      text-decoration:none;
      color:var(--text);
      min-height:130px;
      box-shadow: 0 6px 16px rgba(15,23,42,.06);
      backdrop-filter: blur(8px);
      transition: transform .14s ease, box-shadow .14s ease, border-color .14s ease;
      position:relative;
      overflow:hidden;
    }

    /* subtle shine */
    .card:before{
      content:"";
      position:absolute;inset:-40%;
      background: radial-gradient(closest-side, rgba(2,132,199,.10), transparent 70%);
      transform: translate(20%, -20%);
      opacity:.65;
      pointer-events:none;
    }

    .card:hover{
      transform: translateY(-2px);
      box-shadow: var(--shadow2);
      border-color: rgba(2,132,199,.22);
    }

    .top{
      display:flex;
      gap:12px;
      align-items:center;
      margin-bottom:10px;
      position:relative;
      z-index:1;
    }

    .icon{
      font-size:24px;
      width:46px;height:46px;
      display:flex;align-items:center;justify-content:center;
      border-radius:16px;
      background: linear-gradient(180deg, #ffffff, #f3f6ff);
      border:1px solid rgba(226,232,240,.9);
      box-shadow: 0 8px 18px rgba(15,23,42,.08);
      flex:0 0 auto;
    }

    .title{
      font-size:16px;
      font-weight:800;
      margin:0;
      letter-spacing:-.2px;
      line-height:1.2;
    }

    .desc{
      margin:0;
      color:var(--muted);
      font-size:13px;
      line-height:1.5;
      position:relative;
      z-index:1;
    }

    .arrow{
      margin-left:auto;
      width:34px;height:34px;
      display:flex;align-items:center;justify-content:center;
      border-radius:999px;
      border:1px solid var(--line);
      background:rgba(255,255,255,.9);
      color:#334155;
      position:relative;
      z-index:1;
      transition:.14s ease;
      flex:0 0 auto;
    }
    .card:hover .arrow{transform:translateX(2px)}
  </style>
</head>

<body>
  <div class="wrap">
    <div class="header">
      <div class="titleBox">
        <h1>Personal Apps</h1>
        <div class="subtitle">Chọn nhanh tiện ích bạn dùng thường xuyên (quản lý acc, treo hộ, thu/chi, ...)</div>
      </div>
      <div class="chip">⚡ Lối tắt • nhanh • gọn</div>
    </div>

    <div class="grid">
      @foreach($apps as $app)
        <a class="card" href="{{ $app['href'] }}">
          <div class="top">
            <div class="icon">{{ $app['icon'] ?? '🧩' }}</div>
            <p class="title">{{ $app['title'] }}</p>
            <div class="arrow">→</div>
          </div>
          <p class="desc">{{ $app['desc'] }}</p>
        </a>
      @endforeach
    </div>
  </div>
</body>
</html>
