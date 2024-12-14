<body>
    <div class="container">
        <h1 class="text-center text-primary">Produk Perawatan</h1>

        <!-- Search Bar -->
        <div class="row mt-4">
            <div class="col-md-6">
                <form action="" method="post">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Cari perawatan..." name="keyword" value="<?= isset($keyword) ? $keyword : ''; ?>">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Cari</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- List Perawatan -->
        <div class="row mt-4">
            <?php if (empty($perawatan)): ?>
                <div class="col-12">
                    <p class="text-center text-muted">Tidak ada perawatan yang ditemukan.</p>
                </div>
            <?php else: ?>
                <?php foreach ($perawatan as $P): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card bg-light" style="width: 100%;">
                            <img src="<?= base_url('assets/images/' . $P['poto']); ?>" class="card-img-top" alt="<?= htmlspecialchars($P['nama'], ENT_QUOTES, 'UTF-8'); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($P['nama'], ENT_QUOTES, 'UTF-8'); ?></h5>
                                <h6 class="card-text">Rp <?= number_format((float)$P['harga'], 0, ',', '.'); ?></h6>
								<form action="<?= base_url('keranjang/tambah/'.$P['id']); ?>" method="POST">
                                <div class="form-group">
                                    <label for="jumlah">Jumlah</label>
                                    <input type="number" class="form-control" id="jumlah" name="jumlah" value="1" min="1" required>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">Tambah ke Keranjang</button>
                            </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
