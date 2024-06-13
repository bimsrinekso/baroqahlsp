<?php $this->extend('inc/main');?>
<?php $this->section('css');?>

<?php $this->endSection();?>
<?php $this->section('body');?>
<div class="row">
    <div class="col-lg-6 mt-3">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Form Input Users</h5>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="pickRole" class="form-label">Role</label>
                        <select id="pickRole" name="role" class="form-select" required>

                        </select>
                    </div>
                    <div class="mb-3" id="karyawan-container" style="display: none;">
                        <label for="pickKaryawan" class="form-label">Karyawan</label>
                        <select id="pickKaryawan" name="karyawan" class="form-select">
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input name="username" value="<?=$result->username?>" type="text" class="form-control" placeholder="Username">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input name="email" value="<?=$result->email?>"type="email" class="form-control" placeholder="Email">
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
    function getRole(selectedRole) {
        $.ajax({
            url: '<?=base_url('dashboard/usermanage/role')?>',
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                $('#pickRole').empty();
                if (response) {
                    response.forEach(function (role) {
                        $('#pickRole').append($('<option>', {
                            value: role.id,
                            text: role.role
                        }));
                    });
                    if (selectedRole !== null) {
                        $('#pickRole').val(selectedRole).trigger('change');
                        
                    }
                } else {
                    $('#pickRole').append($('<option>', {
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
    async function getKaryawan(selectedKar) {
        $.ajax({
            url: '<?= base_url('dashboard/karyawan/listUsers') ?>',
            method: 'POST',
            dataType: 'json',
            data: {selectedKar: selectedKar },
            success: function(response) {
                console.log("dancok",selectedKar)
                console.log(response)
                $('#pickKaryawan').empty();
                if (response) {
                    response.forEach(function(kar) {
                        $('#pickKaryawan').append($('<option>', {
                            value: kar.id,
                            text: kar.namaKaryawan
                        }));
                    });
                    if (selectedKar !== null) {
                        $('#pickKaryawan').val(selectedKar).trigger('change');
                        
                    }
                } else {
                    $('#pickKaryawan').append($('<option>', {
                        value: '',
                        text: 'Tidak ada data'
                    }));
                }
            },
            error: function(xhr, status, error) {
                console.log(xhr);
            }
        });
    }
    $(document).ready(function() {
        $("#pickRole").select2({
            placeholder: {
                id: '',
                text: 'Pilih Golongan'
            },
        });
        $("#pickKaryawan").select2({
            placeholder: {
                id: '',
                text: 'Pilih Karyawan'
            },
        });
        let dataRole = '<?=$result->role_id?>'
        console.log(dataRole)
        let dataKar = '<?=$result->idKar?>'
        console.log(dataKar)
        getRole(dataRole);

        $('#pickRole').on('change', function() {
            var selectedRole = $(this).val();
            if (selectedRole == 3) {
                $('#karyawan-container').show();
                getKaryawan(dataKar);
            } else {
                $('#karyawan-container').hide();
            }
        });
        
    })
</script>
<?php $this->endSection();?>



