const API = '/api';
let token = localStorage.getItem('token');

function showAdmin() {
  document.getElementById('loginSection').style.display = token ? 'none' : 'block';
  document.getElementById('adminSection').style.display = token ? 'block' : 'none';
  if (token) { loadKonser(); loadPemesanan(); }
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
    showAdmin();
  } else {
    document.getElementById('authError').textContent = data.message;
  }
}

function logout() {
  localStorage.removeItem('token');
  token = null;
  showAdmin();
}

function resetForm() {
  document.getElementById('konserId').value = '';
  document.getElementById('nama_konser').value = '';
  document.getElementById('artis').value = '';
  document.getElementById('tanggal').value = '';
  document.getElementById('lokasi').value = '';
  document.getElementById('harga_tiket').value = '';
  document.getElementById('kuota').value = '';
}

async function loadKonser() {
  const res = await fetch(`${API}/konser`);
  const data = await res.json();
  const tbody = document.querySelector('#tabelKonser tbody');
  tbody.innerHTML = '';
  data.konser.forEach(k => {
    tbody.innerHTML += `
      <tr>
        <td>${k.nama_konser}</td>
        <td>${k.artis}</td>
        <td>${k.tanggal}</td>
        <td>Rp${k.harga_tiket}</td>
        <td>${k.kuota}</td>
        <td>
          <button onclick='editKonser(${JSON.stringify(k)})'>Edit</button>
          <button class="danger" onclick="hapusKonser(${k.id})">Hapus</button>
        </td>
      </tr>
    `;
  });
}

function editKonser(k) {
  document.getElementById('konserId').value = k.id;
  document.getElementById('nama_konser').value = k.nama_konser;
  document.getElementById('artis').value = k.artis;
  document.getElementById('tanggal').value = k.tanggal;
  document.getElementById('lokasi').value = k.lokasi;
  document.getElementById('harga_tiket').value = k.harga_tiket;
  document.getElementById('kuota').value = k.kuota;
}

async function simpanKonser() {
  const id = document.getElementById('konserId').value;
  const payload = {
    nama_konser: document.getElementById('nama_konser').value,
    artis: document.getElementById('artis').value,
    tanggal: document.getElementById('tanggal').value,
    lokasi: document.getElementById('lokasi').value,
    harga_tiket: parseInt(document.getElementById('harga_tiket').value),
    kuota: parseInt(document.getElementById('kuota').value),
  };

  const url = id ? `${API}/konser/${id}` : `${API}/konser`;
  const res = await fetch(url, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
      'Authorization': `Bearer ${token}`,
    },
    body: JSON.stringify(payload),
  });
  const data = await res.json();
  alert(data.message);
  resetForm();
  loadKonser();
}

async function hapusKonser(id) {
  if (!confirm('Yakin hapus konser ini?')) return;
  const res = await fetch(`${API}/konser/${id}`, {
    method: 'DELETE',
    headers: { 'Accept': 'application/json', 'Authorization': `Bearer ${token}` },
  });
  const data = await res.json();
  alert(data.message);
  loadKonser();
}

async function loadPemesanan() {
  const res = await fetch(`${API}/admin/pemesanan`, {
    headers: { 'Accept': 'application/json', 'Authorization': `Bearer ${token}` },
  });
  const data = await res.json();
  const tbody = document.querySelector('#tabelPemesanan tbody');
  tbody.innerHTML = '';
  data.pemesanan.forEach(p => {
    tbody.innerHTML += `
      <tr>
        <td>${p.nama_user}</td>
        <td>${p.nama_konser}</td>
        <td>${p.jumlah_tiket}</td>
        <td>${p.status}</td>
        <td>
          <button onclick="ubahStatus(${p.id}, 'dikonfirmasi')">Konfirmasi</button>
          <button class="danger" onclick="ubahStatus(${p.id}, 'dibatalkan')">Batalkan</button>
        </td>
      </tr>
    `;
  });
}

async function ubahStatus(id, status) {
  const res = await fetch(`${API}/admin/pemesanan/${id}/status`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
      'Authorization': `Bearer ${token}`,
    },
    body: JSON.stringify({ status }),
  });
  const data = await res.json();
  alert(data.message);
  loadPemesanan();
}

showAdmin();