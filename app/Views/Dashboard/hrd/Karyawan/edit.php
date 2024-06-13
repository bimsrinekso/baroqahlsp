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
                        <label for="namaKaryawan" class="form-label">Nama Karyawan</label>
                        <input type="text" placeholder="nama" class="form-control" value="<?=$result->namaKaryawan?>" name="namaKaryawan" required>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" placeholder="alamat" name="alamat" required><?=$result->alamat?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="tanggalLahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tglLahir" value="<?=$result->tanggalLahir?>" name="tanggalLahir" required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggalMasuk" class="form-label">Tanggal Masuk</label>
                        <input type="date" class="form-control" value="<?=$result->tanggalMasuk?>" name="tanggalMasuk" required>
                    </div>
                    <div class="mb-3">
                        <label for="pickGol" class="form-label">Golongan</label>
                        <select id="pickGol" name="golongan" class="form-select" required>

                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="gajiPokok" class="form-label">Gaji Pokok</label>
                        <input type="text" class="form-control" placeholder="Gaji Pokok" value="<?=$result->gajiPokok?>" name="gajiPokok" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>



<?php $this->endSection();?>
<?php $this->section('javascript');?>
<script>
    function getGol(selectedGol) {
        $.ajax({
            url: '<?=base_url('dashboard/golongan/list')?>',
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                $('#pickGol').empty();
                if (response) {
                    response.forEach(function (gol) {
                        $('#pickGol').append($('<option>', {
                            value: gol.id,
                            text: gol.namaGolongan
                        }));
                    });
                    if (selectedGol !== null) {
                        $('#pickGol').val(selectedGol).trigger('change');
                        
                    }
                } else {
                    $('#pickGol').append($('<option>', {
                        value: '',
                        text: 'Tidak ada data'
                    }));
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    }
    $(document).ready(function() {
        $("#pickGol").select2({
            placeholder: {
                id: '',
                text: 'Pilih Golongan'
            },
        });
        let dataGol = '<?=$result->golongan?>'
        getGol(dataGol);
    })
</script>
<?php $this->endSection();?>


