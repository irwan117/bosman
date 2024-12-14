<body>
    <div class="container">
        <h1 class="text-center text-primary">Daftar Pesanan Masuk</h1>

        <?php if ($this->session->flashdata('message')): ?>
            <div class="alert alert-success" role="alert">
                <?= $this->session->flashdata('message'); ?>
            </div>
        <?php endif; ?>

        <?php if (empty($orders)): ?>
            <div class="alert alert-warning">
                Anda belum memiliki pesanan. Silakan lakukan checkout terlebih dahulu.
            </div>
        <?php else: ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Perawatan</th>
                        <th>Jumlah</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Tanggal Pesanan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($orders as $O): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $O['nama']; ?></td>
                            <td><?= $O['jumlah']; ?></td>
                            <td>Rp <?= number_format($O['total_harga'], 0, ',', '.'); ?></td>
                            <td>
                                <form action="<?= base_url('order/update_status/' . $O['id']); ?>" method="post" style="display: inline;">
                                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit();">
                                        <option value="pending" <?= $O['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                        <option value="selesai" <?= $O['status'] == 'selesai' ? 'selected' : ''; ?>>Selesai</option>
                                    </select>
                                </form>
                            </td>
                            <td><?= date('d-m-Y H:i:s', strtotime($O['order_date'])); ?></td>
                            <td>
                                <?php if (isset($O['id'])): ?>
                                    <a href="<?= base_url('order/hapus/' . $O['id']); ?>" 
                                       class="btn btn-danger btn-sm" 
                                       onclick="return confirm('Apakah Anda yakin ingin menghapus pesanan ini?');">
                                       Hapus
                                    </a>
                                <?php else: ?>
                                    <span class="text-danger">ID tidak ditemukan</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
