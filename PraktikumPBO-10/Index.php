<?php
require_once __DIR__ . '/Product.php';

$pesan = "";
$error = "";

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $aksi = $_POST['aksi'] ?? '';
        $id   = (int) ($_POST['id'] ?? 0);

        if ($aksi === 'hapus') {
            Product::delete($id);
            $pesan = "Produk berhasil dihapus.";
        } else {
            $nama  = trim($_POST['nama'] ?? '');
            $harga = (float) ($_POST['harga'] ?? 0);
            $stok  = (int) ($_POST['stok'] ?? 0);

            if ($nama === '' || $harga < 0 || $stok < 0) {
                $error = "Data tidak valid. Nama wajib diisi, harga dan stok tidak boleh negatif.";
            } else {
                $produk = new Product($nama, $harga, $stok);
                if ($aksi === 'simpan') {
                    $produk->save();
                    $pesan = "Produk berhasil ditambahkan.";
                } elseif ($aksi === 'ubah') {
                    $produk->update($id);
                    $pesan = "Produk berhasil diubah.";
                }
            }
        }
    }

    $edit  = isset($_GET['edit']) ? Product::findById((int) $_GET['edit']) : null;
    $daftar = Product::findAll();
} catch (PDOException $e) {
    $error = "Terjadi kesalahan database: " . $e->getMessage();
    $edit = null;
    $daftar = [];
}

function e($v) { return htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Manajemen Produk</title>
<style>
    body { font-family: system-ui, sans-serif; max-width: 800px; margin: 2rem auto; padding: 0 1rem; color: #222; }
    h1 { font-size: 1.5rem; }
    form.input { display: grid; gap: .6rem; background: #f5f5f5; padding: 1rem; border-radius: 8px; }
    label { display: grid; gap: .2rem; font-size: .9rem; }
    input { padding: .5rem; border: 1px solid #bbb; border-radius: 4px; }
    button, .btn { padding: .45rem .9rem; border: 0; border-radius: 4px; background: #2563eb; color: #fff; cursor: pointer; text-decoration: none; font-size: .9rem; }
    .btn-gray { background: #6b7280; } .btn-red { background: #dc2626; }
    table { width: 100%; border-collapse: collapse; margin-top: 1.5rem; }
    th, td { padding: .5rem; border-bottom: 1px solid #ddd; text-align: left; }
    td.aksi { display: flex; gap: .4rem; }
    .ok { background: #dcfce7; padding: .6rem; border-radius: 4px; }
    .err { background: #fee2e2; padding: .6rem; border-radius: 4px; }
</style>
</head>
<body>
<h1>Manajemen Produk</h1>

<?php if ($pesan): ?><p class="ok"><?= e($pesan) ?></p><?php endif; ?>
<?php if ($error): ?><p class="err"><?= e($error) ?></p><?php endif; ?>

<h2><?= $edit ? 'Edit Produk' : 'Tambah Produk' ?></h2>
<form class="input" method="post" action="index.php">
    <input type="hidden" name="aksi" value="<?= $edit ? 'ubah' : 'simpan' ?>">
    <input type="hidden" name="id" value="<?= e($edit['id'] ?? '') ?>">
    <label>Nama Produk
        <input type="text" name="nama" required value="<?= e($edit['nama'] ?? '') ?>">
    </label>
    <label>Harga
        <input type="number" name="harga" min="0" step="0.01" required value="<?= e($edit['harga'] ?? '') ?>">
    </label>
    <label>Stok
        <input type="number" name="stok" min="0" required value="<?= e($edit['stok'] ?? '') ?>">
    </label>
    <div>
        <button type="submit"><?= $edit ? 'Simpan Perubahan' : 'Tambah' ?></button>
        <?php if ($edit): ?><a class="btn btn-gray" href="index.php">Batal</a><?php endif; ?>
    </div>
</form>

<h2>Daftar Produk</h2>
<table>
    <tr><th>ID</th><th>Nama</th><th>Harga</th><th>Stok</th><th>Aksi</th></tr>
    <?php if (!$daftar): ?>
        <tr><td colspan="5">Belum ada data.</td></tr>
    <?php endif; ?>
    <?php foreach ($daftar as $p): ?>
    <tr>
        <td><?= e($p['id']) ?></td>
        <td><?= e($p['nama']) ?></td>
        <td>Rp <?= number_format((float) $p['harga'], 0, ',', '.') ?></td>
        <td><?= e($p['stok']) ?></td>
        <td class="aksi">
            <a class="btn" href="index.php?edit=<?= e($p['id']) ?>">Edit</a>
            <form method="post" action="index.php" onsubmit="return confirm('Hapus produk ini?')">
                <input type="hidden" name="aksi" value="hapus">
                <input type="hidden" name="id" value="<?= e($p['id']) ?>">
                <button class="btn-red" type="submit">Hapus</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
</body>
</html>