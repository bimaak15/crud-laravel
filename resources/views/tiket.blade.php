<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tiket Konser</title>
<style>
  body { font-family: Arial, sans-serif; max-width: 700px; margin: 40px auto; padding: 0 20px; }
  .card { border: 1px solid #ccc; border-radius: 8px; padding: 15px; margin-bottom: 15px; }
  input, select, button { padding: 8px; margin: 5px 0; width: 100%; box-sizing: border-box; }
  button { background: #4CAF50; color: white; border: none; cursor: pointer; }
  #authSection, #appSection { display: none; }
  .error { color: red; }
</style>
</head>
<body>

<h1>Tiket Konser</h1>

<div id="authSection">
  <h2>Login / Register</h2>
  <input type="text" id="name" placeholder="Nama (buat register)">
  <input type="email" id="email" placeholder="Email">
  <input type="password" id="password" placeholder="Password">
  <button onclick="register()">Register</button>
  <button onclick="login()">Login</button>
  <p class="error" id="authError"></p>
</div>

<div id="appSection">
  <button onclick="logout()">Logout</button>
  <h2>Daftar Konser</h2>
  <div id="listKonser"></div>

  <h2>Pemesanan Saya</h2>
  <div id="listPemesanan"></div>
</div>

<script src="{{ asset('js/app-tiket.js') }}"></script>
</body>
</html>