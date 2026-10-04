const API = '/api';
let token = localStorage.getItem('token');

function showApp() {
  document.getElementById('authSection').style.display = token ? 'none' : 'block';
  document.getElementById('appSection').style.display = token ? 'block' : 'none';
  if (token) { loadKonser(); loadPemesanan(); }
}

async function register() {
  const res = await fetch(`${API}/auth/register`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
    body: JSON.stringify({
      name: document.getElementById('name').value,
      email: document.getElementById('email').value,
      password: document.getElementById('password').value,
    }),
  });
  const data = await res.json();
  if (res.ok) {
    token = data.token;
    localStorage.setItem('token', token);
    showApp();
  } else {
    document.getElementById('authError').textContent = data.message;
  }
}

async function login() {
  const res = await fetch(`${API}/auth/login`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
    body: JSON.stringify({
      email: document.getElementById('email').value,
      password: document.getElementById('password').value,
    }),
  });
  const data = await res.json();
  if (res.ok) {
    token = data.token;
    localStorage.setItem('token', token);
    showApp();
  } else {
    document.getElementById('authError').textContent = data.message;
  }
}

function logout() {
  localStorage.removeItem('token');
  token = null;
  showApp();
}

async function loadKonser() {
  const res = await fetch(`${API}/konser`);
  const data = await res.json();
  const container = document.getElementById('listKonser');
  container.innerHTML = '';
  data.konser.forEach(k => {
    container.innerHTML += `
      <div class="card">
        <strong>${k.nama_konser}</strong> — ${k.artis}<br>
        ${k.lokasi}, ${k.tanggal}<br>
        Harga: Rp${k.harga_tiket} | Kuota: ${k.kuota}<br>
        <input type="number" id="jumlah-${k.id}" placeholder="Jumlah tiket" min="1" value="1">
        <button onclick="pesan(${k.id})">Pesan</button>
      </div>
    `;
  });
}

async function pesan(konserId) {
  const jumlah = document.getElementById(`jumlah-${konserId}`).value;
  const res = await fetch(`${API}/pemesanan`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
      'Authorization': `Bearer ${token}`,
    },
    body: JSON.stringify({ konser_id: konserId, jumlah_tiket: parseInt(jumlah) }),
  });
  const data = await res.json();
  alert(data.message);
  loadKonser();
  loadPemesanan();
}

async function loadPemesanan() {
  const res = await fetch(`${API}/pemesanan`, {
    headers: { 'Accept': 'application/json', 'Authorization': `Bearer ${token}` },
  });
  const data = await res.json();
  const container = document.getElementById('listPemesanan');
  container.innerHTML = '';
  data.pemesanan.forEach(p => {
    container.innerHTML += `
      <div class="card">
        ${p.nama_konser} — ${p.jumlah_tiket} tiket — Status: ${p.status}
        <button onclick="batalkan(${p.id})">Batalkan</button>
      </div>
    `;
  });
}

async function batalkan(id) {
  const res = await fetch(`${API}/pemesanan/${id}`, {
    method: 'DELETE',
    headers: { 'Accept': 'application/json', 'Authorization': `Bearer ${token}` },
  });
  const data = await res.json();
  alert(data.message);
  loadPemesanan();
}

showApp();