<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
    <h3 style="margin:0; color: #444;">Data Kategori Artikel</h3>
    <button class="btn-tambah-hijau" onclick="tampilFormTambahKategori()">+ Tambah Kategori</button>
</div>

<div class="card-putih">
    <table class="tabel-kategori">
        <thead>
            <tr>
                <th style="width: 30%;">NAMA KATEGORI</th>
                <th style="width: 50%;">KETERANGAN</th>
                <th style="width: 20%;">AKSI</th>
            </tr>
        </thead>
        <tbody id="isiTabelKategori">
            </tbody>
    </table>
</div>

<div id="modalKategori" class="modal-overlay">
    <div class="modal-konten">
        <h3 id="judulModalKategori">Tambah Kategori</h3>
        <hr>
        <form id="formKategori">
            <input type="hidden" name="id" id="id_kategori">
            
            <div class="input-group">
                <label>Nama Kategori</label>
                <input type="text" name="nama_kategori" id="nama_kategori" placeholder="Contoh: Tutorial, Database..." required>
            </div>

            <div class="input-group">
                <label>Keterangan</label>
                <textarea name="keterangan" id="keterangan" placeholder="Jelaskan singkat tentang kategori ini..."></textarea>
            </div>
            
            <div class="footer-modal">
                <button type="button" class="btn-abu" onclick="tutupModalKategori()">Batal</button>
                <button type="submit" class="btn-hijau">Simpan Kategori</button>
            </div>
        </form>
    </div>
</div>

<style>
    .card-putih { background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
    .tabel-kategori { width: 100%; border-collapse: collapse; }
    .tabel-kategori th { text-align: left; padding: 15px; color: #999; font-size: 12px; border-bottom: 2px solid #f8f9fa; }
    .tabel-kategori td { padding: 15px; border-bottom: 1px solid #f8f9fa; vertical-align: middle; font-size: 14px; color: #555; }
    
    .badge-biru { background: #e3f2fd; color: #2196f3; padding: 4px 12px; border-radius: 6px; font-size: 12px; font-weight: bold; }
    
    .btn-tambah-hijau { background: #2ecc71; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: bold; }
    .btn-edit-biru { background: #007bff; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; margin-right: 5px; }
    .btn-hapus-merah { background: #ff4757; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; }

    .modal-overlay { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); }
    .modal-konten { background: white; margin: 10% auto; padding: 25px; width: 450px; border-radius: 10px; }
    .input-group { margin-bottom: 15px; }
    label { font-size: 12px; font-weight: bold; color: #777; display: block; margin-bottom: 5px; }
    input, textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
    textarea { height: 80px; }
    .footer-modal { text-align: right; margin-top: 20px; }
    .btn-abu { background: #bdc3c7; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; }
    .btn-hijau { background: #2ecc71; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; margin-left: 5px; }
</style>

<script>
function muatDataKategori() {
    fetch('ambil_kategori.php')
    .then(res => res.json())
    .then(data => {
        let html = '';
        data.forEach(k => {
            html += `<tr>
                <td><span class="badge-biru">${k.nama_kategori}</span></td>
                <td style="color:#777;">${k.keterangan || '-'}</td>
                <td>
                    <button class="btn-edit-biru" onclick='tampilFormEditKategori(${JSON.stringify(k)})'>Edit</button>
                    <button class="btn-hapus-merah" onclick="hapusKategori(${k.id})">Hapus</button>
                </td>
            </tr>`;
        });
        document.getElementById('isiTabelKategori').innerHTML = html;
    });
}

muatDataKategori();

function tampilFormTambahKategori() {
    document.getElementById('judulModalKategori').innerText = "Tambah Kategori";
    document.getElementById('formKategori').reset();
    document.getElementById('id_kategori').value = "";
    document.getElementById('modalKategori').style.display = "block";
}

function tampilFormEditKategori(data) {
    document.getElementById('judulModalKategori').innerText = "Edit Kategori";
    document.getElementById('id_kategori').value = data.id;
    document.getElementById('nama_kategori').value = data.nama_kategori;
    document.getElementById('keterangan').value = data.keterangan;
    document.getElementById('modalKategori').style.display = "block";
}

function tutupModalKategori() { document.getElementById('modalKategori').style.display = "none"; }

document.getElementById('formKategori').onsubmit = function(e) {
    e.preventDefault();
    let formData = new FormData(this);
    let url = document.getElementById('id_kategori').value === "" ? 'simpan_kategori.php' : 'update_kategori.php';
    
    fetch(url, { method: 'POST', body: formData })
    .then(res => res.text())
    .then(hasil => {
        alert(hasil);
        tutupModalKategori();
        muatDataKategori();
    });
};

function hapusKategori(id) {
    if(confirm('Hapus kategori ini?')) {
        fetch('hapus_kategori.php?id=' + id)
        .then(res => res.text())
        .then(hasil => {
            alert(hasil);
            muatDataKategori();
        });
    }
}
</script>