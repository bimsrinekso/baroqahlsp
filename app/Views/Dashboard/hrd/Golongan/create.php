<?php $this->extend('inc/main');?>
<?php $this->section('css');?>

<?php $this->endSection();?>
<?php $this->section('body');?>
<div class="row">
    <div class="col-lg-6 mt-3">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Form Input Golongan</h5>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="namaGolongan" class="form-label">Nama Golongan</label>
                        <input type="text" class="form-control" placeholder="Nama Golongan" name="namaGolongan" required>
                    </div>
                    <div class="mb-3">
                        <label for="bonus" class="form-label">Bonus (%)</label>
                        <input type="text" class="form-control" placeholder="Bonus" name="bonus" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>



<?php $this->endSection();?>
<?php $this->section('javascript');?>
<script>


</script>
<?php $this->endSection();?>



