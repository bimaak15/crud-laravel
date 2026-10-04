<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard - Tiket Konser</title>
<style>
  body { font-family: Arial, sans-serif; max-width: 900px; margin: 40px auto; padding: 0 20px; }
  .card { border: 1px solid #ccc; border-radius: 8px; padding: 15px; margin-bottom: 15px; }
  input, select, button { padding: 8px; margin: 5px 0; box-sizing: border-box; }
  input, select { width: 100%; }
  button { background: #4CAF50; color: white; border: none; cursor: pointer; }
  button.danger { background: #e53935; }
  table { width: 100%; border-collapse: collapse; margin-top: 10px; }
  th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
  .error { color: red; }
  #loginSection { display: none; }
</style>
</head>
<body>

<h1>Admin Dashboard — Tiket Konser</h1>

<div id="loginSection">
  <h2>Login dulu</h2>
  <input type="email" id="email" placeholder="Email">
  <input type="password" id="password" placeholder="Password">
  <button onclick="login()">Login</button>
  <p class="error" id="authError"></p>
</div>

<div id="adminSection">
  <button onclick="logout()">Logout</button>

  <h2>Tambah / Edit Konser</h2>
  <div class="card">
    <input type="hidden" id="konserId">
    <input type="text" id="nama_konser" placeholder="Nama Konser">
    <input type="text" id="artis" placeholder="Artis">
    <input type="date" id="tanggal">
    <input type="text" id="lokasi" placeholder="Lokasi">
    <input type="number" id="harga_tiket" placeholder="Harga Tiket">
    <input type="number" id="kuota" placeholder="Kuota">
    <button onclick="simpanKonser()">Simpan Konser</button>
    <button onclick="resetForm()" type="button" style="background:#999;">Batal Edit</button>
  </div>

  <h2>Daftar Konser</h2>
  <table id="tabelKonser">
    <thead>
      <tr><th>Nama</th><th>Artis</th><th>Tanggal</th><th>Harga</th><th>Kuota</th><th>Aksi</th></tr>
    </thead>
    <tbody></tbody>
  </table>

  <h2>Semua Pemesanan</h2>
  <table id="tabelPemesanan">
    <thead>
      <tr><th>User</th><th>Konser</th><th>Jumlah</th><th>Status</th><th>Aksi</th></tr>
    </thead>
    <tbody></tbody>
  </table>
</div>

<script src="{{ asset('js/app-admin.js') }}"></script>
</body>
</html>