<body>
    <div class="container">
        <h1 class="text-center text-primary">Daftar Pesanan Anda</h1>

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
                        <th>Nama Produk Perawatan</th>
                        <th>Jumlah</th>
                        <th>Total Harga</th>
                        <th>Alamat Pesanan</th>
                        <th>Status</th>
                        <th>Tanggal Pesanan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($orders as $order): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($order['nama'] ?? 'Nama tidak tersedia'); ?></td>
                            <td><?= htmlspecialchars($order['jumlah'] ?? 'Jumlah tidak tersedia'); ?></td>
                            <td>Rp <?= number_format($order['total_harga'], 0, ',', '.'); ?></td>
                            <td><?= htmlspecialchars($order['alamat'] ?? 'Alamat tidak tersedia'); ?></td>
                            <td>
                                <?= $order['status'] == 'pending' ? '<span class="badge bg-warning">Pending</span>' : '<span class="badge bg-success">Selesai</span>'; ?>
                            </td>
                            <td>
                                <?php
                                // Pastikan 'order_date' ada dan valid
                                $order_date = isset($order['order_date']) ? date('d-m-Y H:i:s', strtotime($order['order_date'])) : 'Tanggal tidak tersedia';
                                echo htmlspecialchars($order_date);
                                ?>
                            </td>
                            <td>
                                <?php if (isset($order['id'])): ?>
                                <a href="<?= base_url('order/hapus/' . $order['id']); ?>" 
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
