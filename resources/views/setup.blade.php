<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Setup Database</title>
  <style>
    body{font-family:Arial;background:#f6f7fb;margin:0}
    .wrap{max-width:520px;margin:60px auto;padding:16px}
    .card{background:#fff;border:1px solid #e9e9e9;border-radius:14px;padding:18px}
    h1{margin:0 0 12px;font-size:20px}
    label{display:block;font-size:12px;color:#444;margin-top:10px}
    input{width:100%;padding:10px;border:1px solid #ddd;border-radius:10px;margin-top:6px}
    button{margin-top:14px;width:100%;padding:10px;border:0;border-radius:10px;background:#111;color:#fff;cursor:pointer}
    .err{background:#ffe9e9;border:1px solid #ffbcbc;color:#b10000;padding:10px;border-radius:10px;margin:10px 0}
    .ok{background:#e9ffef;border:1px solid #b7f5c3;color:#0c6b2a;padding:10px;border-radius:10px;margin:10px 0}
  </style>
</head>
<body>
<div class="wrap">
  <div class="card">
    <h1>Thiết lập Database (XAMPP)</h1>

    @if(session('error'))
      <div class="err">{{ session('error') }}</div>
    @endif
    @if(session('success'))
      <div class="ok">{{ session('success') }}</div>
    @endif

    <form method="post" action="{{ route('setup.connect') }}">
      @csrf

      <label>Host</label>
      <input name="host" value="{{ old('host','127.0.0.1') }}" required>

      <label>Port</label>
      <input name="port" value="{{ old('port','3306') }}" required>

      <label>Database name</label>
      <input name="database" value="{{ old('database','personal_app') }}" required>

      <label>Username</label>
      <input name="username" value="{{ old('username','root') }}" required>

      <label>Password</label>
      <input name="password" type="password" value="{{ old('password','') }}">

      <button type="submit">Kết nối / Tạo database</button>
    </form>

    <p style="margin-top:12px;font-size:12px;color:#666">
      Nếu DB chưa tồn tại, hệ thống sẽ thử tạo DB + chạy migrate tạo bảng.
    </p>
  </div>
</div>
</body>
</html>
