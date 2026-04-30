<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
    <h3 style="margin:0; color: #444;">Data Penulis</h3>
    <button class="btn-tambah-hijau" onclick="tampilFormTambah()">+ Tambah Penulis</button>
</div>

<div class="card-putih">
    <table class="tabel-custom">
        <thead>
            <tr>
                <th>FOTO</th>
                <th>NAMA</th>
                <th>USERNAME</th>
                <th>PASSWORD</th>
                <th>AKSI</th>
            </tr>
        </thead>
        <tbody id="isiTabelPenulis">
            </tbody>
    </table>
</div>

<div id="modalPenulis" class="modal-overlay">
    <div class="modal-box">
        <h3 id="judulModal" style="margin-top:0;">Tambah Penulis</h3>
        <hr>
        <form id="formPenulis" enctype="multipart/form-data">
            <input type="hidden" name="id" id="id_penulis">
            
            <div class="row-flex">
                <div class="col">
                    <label>Nama Depan</label>
                    <input type="text" name="nama_depan" id="nama_depan" placeholder="Nama Depan" required>
                </div>
                <div class="col">
                    <label>Nama Belakang</label>
                    <input type="text" name="nama_belakang" id="nama_belakang" placeholder="Nama Belakang" required>
                </div>
            </div>

            <label>Username</label>
            <input type="text" name="user_name" id="user_name" placeholder="Username" required>

            <label>Password</label>
            <input type="password" name="password" id="password" placeholder="Password">
            <p style="font-size: 11px; color: #e74c3c; margin-top:-10px; margin-bottom:15px;">* Kosongkan jika tidak ingin diubah (saat edit)</p>
            
            <label>Foto Profil</label>
            <input type="file" name="foto" id="foto">
            
            <div style="text-align: right; margin-top: 20px;">
                <button type="button" class="btn-abu" onclick="tutupModal()">Batal</button>
                <button type="submit" class="btn-hijau-simpan">Simpan Data</button>
            </div>
        </form>
    </div>
</div>

<style>
    /* Layout Utama */
    .card-putih { background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
    .tabel-custom { width: 100%; border-collapse: collapse; }
    .tabel-custom th { text-align: left; padding: 15px; color: #999; font-size: 12px; border-bottom: 2px solid #f8f9fa; text-transform: uppercase; }
    .tabel-custom td { padding: 15px; border-bottom: 1px solid #f8f9fa; vertical-align: middle; font-size: 14px; color: #555; }

    /* Badge Username & Password */
    .badge-user { background: #e3f2fd; color: #2196f3; padding: 4px 10px; border-radius: 4px; font-size: 12px; }
    .text-pass { color: #ccc; letter-spacing: 2px; }

    /* Tombol Sesuai Gambar */
    .btn-tambah-hijau { background: #2ecc71; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: bold; }
    .btn-edit-biru { background: #007bff; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; margin-right: 5px; }
    .btn-hapus-merah { background: #ff4757; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; }

    /* Modal */
    .modal-overlay { display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); }
    .modal-box { background: white; margin: 5% auto; padding: 25px; width: 450px; border-radius: 10px; }
    .row-flex { display: flex; gap: 15px; }
    .col { flex: 1; }
    label { font-size: 12px; font-weight: bold; color: #777; display: block; margin-bottom: 5px; }
    input { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
    .btn-abu { background: #bdc3c7; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; }
    .btn-hijau-simpan { background: #2ecc71; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; }
</style>

<script>
function muatData() {
    fetch('ambil_penulis.php')
    .then(res => res.json())
    .then(data => {
        let html = '';
        data.forEach(p => {
            html += `<tr>
                <td><img src="uploads_penulis/${p.foto}" width="40" height="40" style="border-radius:5px; object-fit:cover; background:#f0f0f0;"></td>
                <td style="font-weight:600;">${p.nama_depan} ${p.nama_belakang}</td>
                <td><span class="badge-user">${p.user_name}</span></td>
                <td><span class="text-pass">$2y$10$abc...</span></td>
                <td>
                    <button class="btn-edit-biru" onclick='tampilFormEdit(${JSON.stringify(p)})'>Edit</button>
                    <button class="btn-hapus-merah" onclick="konfirmasiHapus(${p.id})">Hapus</button>
                </td>
            </tr>`;
        });
        document.getElementById('isiTabelPenulis').innerHTML = html;
    });
}

muatData();

function tampilFormTambah() {
    document.getElementById('judulModal').innerText = "Tambah Penulis";
    document.getElementById('formPenulis').reset();
    document.getElementById('id_penulis').value = "";
    document.getElementById('modalPenulis').style.display = "block";
}

function tampilFormEdit(data) {
    document.getElementById('judulModal').innerText = "Edit Penulis";
    document.getElementById('id_penulis').value = data.id;
    document.getElementById('nama_depan').value = data.nama_depan;
    document.getElementById('nama_belakang').value = data.nama_belakang;
    document.getElementById('user_name').value = data.user_name;
    document.getElementById('password').value = ""; 
    document.getElementById('modalPenulis').style.display = "block";
}

function tutupModal() { document.getElementById('modalPenulis').style.display = "none"; }

document.getElementById('formPenulis').onsubmit = function(e) {
    e.preventDefault();
    let formData = new FormData(this);
    let url = document.getElementById('id_penulis').value === "" ? 'simpan_penulis.php' : 'update_penulis.php';
    
    fetch(url, { method: 'POST', body: formData })
    .then(res => res.text())
    .then(hasil => {
        alert(hasil);
        tutupModal();
        muatData();
    });
};

function konfirmasiHapus(id) {
    if(confirm('Hapus data penulis ini?')) {
        fetch('hapus_penulis.php?id=' + id)
        .then(res => res.text())
        .then(hasil => {
            alert(hasil);
            muatData();
        });
    }
}
</script>