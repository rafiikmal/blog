<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
    <h3 style="margin:0; color: #444;">Data Artikel</h3>
    <button class="btn-tambah-hijau" onclick="tampilFormTambahArtikel()">+ Tambah Artikel</button>
</div>

<div class="card-putih">
    <table class="tabel-artikel">
        <thead>
            <tr>
                <th>GAMBAR</th>
                <th>JUDUL</th>
                <th>KATEGORI</th>
                <th>PENULIS</th>
                <th>TANGGAL</th>
                <th>AKSI</th>
            </tr>
        </thead>
        <tbody id="isiTabelArtikel">
            </tbody>
    </table>
</div>

<div id="modalArtikel" class="modal-overlay">
    <div class="modal-konten">
        <h3 id="judulModalArtikel">Tambah Artikel</h3>
        <hr>
        <form id="formArtikel" enctype="multipart/form-data">
            <input type="hidden" name="id" id="id_artikel">
            
            <div class="input-group">
                <label>Judul Artikel</label>
                <input type="text" name="judul" id="judul" placeholder="Judul artikel..." required>
            </div>
            
            <div class="row-flex">
                <div class="col">
                    <label>Penulis</label>
                    <select name="id_penulis" id="select_penulis" required></select>
                </div>
                <div class="col">
                    <label>Kategori</label>
                    <select name="id_kategori" id="select_kategori" required></select>
                </div>
            </div>

            <div class="input-group">
                <label>Isi Artikel</label>
                <textarea name="isi_artikel" id="isi_artikel" placeholder="Tulis isi artikel..."></textarea>
            </div>
            
            <div class="input-group">
                <label>Upload Gambar</label>
                <input type="file" name="cover" id="cover">
                <small style="color: #999;">* Biarkan kosong jika tidak ingin mengubah gambar (saat edit)</small>
            </div>
            
            <div class="footer-modal">
                <button type="button" class="btn-abu" onclick="tutupModalArtikel()">Batal</button>
                <button type="submit" class="btn-hijau">Simpan Artikel</button>
            </div>
        </form>
    </div>
</div>

<style>
    .card-putih { background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
    .tabel-artikel { width: 100%; border-collapse: collapse; }
    .tabel-artikel th { text-align: left; padding: 15px; color: #999; font-size: 12px; border-bottom: 2px solid #f8f9fa; text-transform: uppercase; }
    .tabel-artikel td { padding: 15px; border-bottom: 1px solid #f8f9fa; vertical-align: middle; font-size: 14px; color: #555; }
    
    .badge-kategori { background: #e3f2fd; color: #2196f3; padding: 4px 12px; border-radius: 6px; font-size: 12px; font-weight: bold; }
    
    .btn-tambah-hijau { background: #2ecc71; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: bold; }
    .btn-edit-biru { background: #007bff; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; margin-right: 5px; }
    .btn-hapus-merah { background: #ff4757; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; }

    .modal-overlay { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); }
    .modal-konten { background: white; margin: 5% auto; padding: 25px; width: 500px; border-radius: 10px; }
    .input-group { margin-bottom: 15px; }
    .row-flex { display: flex; gap: 15px; margin-bottom: 15px; }
    .col { flex: 1; }
    label { font-size: 12px; font-weight: bold; color: #777; display: block; margin-bottom: 5px; }
    input, select, textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
    textarea { height: 100px; }
    .footer-modal { text-align: right; margin-top: 20px; }
    .btn-abu { background: #bdc3c7; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; }
    .btn-hijau { background: #2ecc71; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; margin-left: 5px; }
</style>

<script>
// 1. Memuat Data dari Database ke Tabel
function muatDataArtikel() {
    fetch('ambil_artikel.php')
    .then(res => res.json())
    .then(data => {
        let html = '';
        data.forEach(a => {
            html += `<tr>
                <td><img src="uploads_artikel/${a.gambar}" width="45" height="45" style="border-radius:6px; object-fit:cover; background:#eee;"></td>
                <td style="font-weight:600;">${a.judul}</td>
                <td><span class="badge-kategori">${a.nama_kategori}</span></td>
                <td>${a.nama_depan}</td>
                <td style="color:#aaa; font-size:11px;">${a.hari_tanggal}</td>
                <td>
                    <button class="btn-edit-biru" onclick='tampilFormEditArtikel(${JSON.stringify(a)})'>Edit</button>
                    <button class="btn-hapus-merah" onclick="konfirmasiHapusArtikel(${a.id})">Hapus</button>
                </td>
            </tr>`;
        });
        document.getElementById('isiTabelArtikel').innerHTML = html;
    });
}

// 2. Memuat Pilihan Penulis dan Kategori untuk Dropdown
function muatDropdown() {
    fetch('ambil_penulis.php').then(res => res.json()).then(data => {
        let opt = '<option value="">-- Pilih Penulis --</option>';
        data.forEach(p => opt += `<option value="${p.id}">${p.nama_depan} ${p.nama_belakang}</option>`);
        document.getElementById('select_penulis').innerHTML = opt;
    });
    fetch('ambil_kategori.php').then(res => res.json()).then(data => {
        let opt = '<option value="">-- Pilih Kategori --</option>';
        data.forEach(k => opt += `<option value="${k.id}">${k.nama_kategori}</option>`);
        document.getElementById('select_kategori').innerHTML = opt;
    });
}

// Jalankan fungsi saat halaman dibuka
muatDataArtikel();
muatDropdown();

// 3. Logika Modal
function tampilFormTambahArtikel() {
    document.getElementById('judulModalArtikel').innerText = "Tambah Artikel";
    document.getElementById('formArtikel').reset();
    document.getElementById('id_artikel').value = ""; // Pastikan ID kosong untuk Tambah
    document.getElementById('modalArtikel').style.display = "block";
}

function tampilFormEditArtikel(data) {
    document.getElementById('judulModalArtikel').innerText = "Edit Artikel";
    document.getElementById('id_artikel').value = data.id; // Isi ID untuk Update
    document.getElementById('judul').value = data.judul;
    document.getElementById('select_penulis').value = data.id_penulis;
    document.getElementById('select_kategori').value = data.id_kategori;
    document.getElementById('isi_artikel').value = data.isi; 
    document.getElementById('modalArtikel').style.display = "block";
}

function tutupModalArtikel() { document.getElementById('modalArtikel').style.display = "none"; }

// 4. Proses Simpan / Update (AJAX)
document.getElementById('formArtikel').onsubmit = function(e) {
    e.preventDefault();
    let formData = new FormData(this);
    let idVal = document.getElementById('id_artikel').value;
    
    // Tentukan URL berdasarkan aksi (Tambah atau Edit)
    let url = (idVal === "" || idVal === null) ? 'simpan_artikel.php' : 'update_artikel.php';
    
    fetch(url, { method: 'POST', body: formData })
    .then(res => res.text())
    .then(hasil => {
        if(hasil.trim() !== "") {
            alert(hasil); // Menampilkan pesan dari PHP
            tutupModalArtikel();
            muatDataArtikel();
        } else {
            alert("Terjadi kesalahan: Respon server kosong.");
        }
    })
    .catch(err => alert("Error: " + err));
};

// 5. Proses Hapus
function konfirmasiHapusArtikel(id) {
    if (confirm('Apakah Anda yakin ingin menghapus artikel ini?')) {
        fetch('hapus_artikel.php?id=' + id)
        .then(res => res.text())
        .then(hasil => {
            alert(hasil);
            muatDataArtikel();
        });
    }
}
</script>