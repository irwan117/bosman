<body>
	<div class="container">
		<h1 class="text-center text-primary">Contoh Styling</h1>
		
		<!-- Search Bar -->
		<div class="row mt-4">
			<div class="col-md-6">
				<form action="" method="post">
					<div class="input-group">
						<input type="text" class="form-control" placeholder="cari Styling Rambut..." name="keyword">
						<div class="input-group-append">
							<button class="btn btn-primary" type="submit">Cari</button>
						</div>
					</div> 
				</form>
			</div>
		</div>

		<div class="row mt-4">
			<?php foreach($styling as $S): ?>
				<div class="col-md-4 mb-4">
					<div class="card bg-secondary text-white" style="width: 100%;">
						<img src="assets/images/<?php echo $S['poto']; ?>" class="card-img-top" alt="<?= $S['nama']; ?>">
						<div class="card-body">
							<h5 class="card-title"><?= $S['nama']; ?></h5>
							<h6 class="card-text">Rp. <?= number_format((float) $S['harga'], 0, ',', '.'); ?></h6>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>						
	</div>
</body>
