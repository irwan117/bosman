<body>
	<div class="container">
		<h1 class="text-center text-primary">Perawatan</h1>	
		<!-- Button trigger modal -->
		<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
			  Tambah Data
			</button>
		<!-- Flash Message -->
		<?php if($this->session->flashdata('flash')) : ?>
			<div class="row mt-3">
				<div class="col-md-8">
					<div class="alert alert-success alert-dismissible fade show" role="alert">
						Data perawatan <strong>Berhasil</strong> <?= $this->session->flashdata('flash'); ?>
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>
				</div>
			</div>
		<?php endif; ?>
		
		<!-- Search Bar -->
		<div class="row mt-4">
			<div class="col-md-6">
				<form action="" method="post">
					<div class="input-group">
						<input type="text" class="form-control" placeholder="cari produk..." name="keyword">
						<div class="input-group-append">
							<button class="btn btn-primary" type="submit">Cari</button>	
						</div>
					</div> 
				</form>
			</div>
		</div>


					<!-- Modal -->
					<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
			        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			      </div>
			      <div class="modal-body">
				 <form action="<?= base_url('perawatan_admin') ?>" method="post" enctype="multipart/form-data">
			        <div class="form group">
			        	<label for="nama">Perawatan</label>
			        	<input type="numeric" name="nama" class="form-control" id="nama" placeholder="Masukan Nama">
				</div>

			        <div class="form group">
			        	<label for="poto">Foto</label>
			        	<input type="file" name="poto"class="form-control" id="poto" placeholder="Masukan Foto">
			        </div>

			        <div class="form group">
			        	<label for="harga">Harga</label>
			        	<input type="text" name="harga"class="form-control" id="harga" placeholder="Masukan Harga">
			        </div>

				   <div class="modal-footer">
					   <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					   <button type="submit" class="btn btn-primary">Save changes</button>
					</div>
				</div>
				 </div>
			      </form>
			    </div>
			  </div>
		
		

		<div class="row mt-4">
			<?php foreach($perawatan as $P): ?>
				<div class="col-md-4 mb-4">
					<div class="card bg-secondary text-white" style="width: 100%;">
						<img src="assets/images/<?php echo $P['poto']; ?>" class="card-img-top" alt="<?= $P['nama']; ?>">
						<div class="card-body">
							<h5 class="card-title"><?= $P['nama']; ?></h5>
							<h6 class="card-text">Rp. <?= number_format((float) $P['harga'], 0, ',', '.'); ?></h6>	
							<a href="<?= base_url(); ?>perawatan_admin/hapus/<?= $P['id']; ?>" class="badge bg-danger float-end" onclick="return confirm('Anda yakin?');">Hapus</a>
							<a type="button" class="badge bg-warning float-end" data-bs-toggle="modal" data-bs-target="#editModal<?=$P['id'];?>">
							  Ubah
							</a>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>							
	</div>


<!-- awal modal edit -->
<?php $no = 0 ; foreach ($perawatan as $P): $no++; ?>
    <div class="modal fade" id="editModal<?=$P['id'];?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="editModalLabel">form Edit Data</h5>
			        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			      </div>
			      <div class="modal-body">
				 <form action="<?= base_url('perawatan_admin/ubah') ?>" method="post" enctype="multipart/form-data">
              <input type="hidden" name="id" value="<?=$P['id']; ?>">
			        <div class="form group">
			        	<label for="nama">Perawatan</label>
			        	<input type="numeric" name="nama" class="form-control" value="<?=$P['nama']; ?>" id="nama" placeholder="Masukan Stick">
			        </div>

			        <div class="form group">
			        	<label for="poto">Foto</label>
			        	<input type="file" name="poto"class="form-control" value="<?=$P['poto']; ?>"id="poto" placeholder="Masukan Foto">
			        </div>

			        <div class="form group">
			        	<label for="harga">Harga</label>
			        	<input type="numeric" name="harga" class="form-control" value="<?=$P['harga']; ?>"id="harga" placeholder="Masukan Harga">
			        </div>

				   <div class="modal-footer">
					   <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					   <button type="submit" class="btn btn-primary">Ubah</button>
					</div>
				</div>
				 </div>
			    </form>
			    </div>
			  </div>
			</div>
		<?php endforeach;  ?>

<!-- akhir modal edit -->