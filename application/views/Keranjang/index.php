<?php if (empty($keranjang)): ?>
    <div class="alert alert-warning">
        Keranjang Anda kosong. Silakan tambah produk ke keranjang.
    </div>
<?php else: ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Perawatan</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($keranjang as $item): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($item['nama']); ?></td>
                    <td>Rp <?= number_format($item['harga'], 0, ',', '.'); ?></td>
                    <td>
                        <form action="<?= base_url('keranjang/tambah/' . $item['perawatan_id']); ?>" method="POST">
                            <input type="number" name="jumlah" value="<?= $item['jumlah']; ?>" min="1" class="form-control" style="width: 80px;">
                            <button type="submit" class="btn btn-primary mt-2">Update Jumlah</button>
                        </form>
                    </td>
                    <td>Rp <?= number_format($item['harga'] * $item['jumlah'], 0, ',', '.'); ?></td>
                    <td>
                        <a href="<?= base_url('keranjang/hapus/' . $item['perawatan_id']); ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus item ini?');">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="<?= base_url('keranjang/checkout'); ?>" class="btn btn-success">Checkout</a>
<?php endif; ?>