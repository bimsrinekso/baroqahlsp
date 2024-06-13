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
                        <input name="username" type="text" class="form-control" placeholder="Username">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input name="email" type="email" class="form-control" placeholder="Email">
                    </div>
                    <div class="mb-3">
                        <label for="password">Password</label>
                        <input name="password" type="password" class="form-control" placeholder="Password">
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
    async function getRole() {
        $.ajax({
            url: '<?=base_url('dashboard/usermanage/role')?>',
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                console.log(response)
                $('#pickRole').empty();
                if (response) {
                    $('#pickRole').append($('<option>', {
                        value: '',
                        text: ''
                    }));
                    response.forEach(function (role) {
                        $('#pickRole').append($('<option>', {
                            value: role.id,
                            text: role.role
                        }));
                    });
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

    async function getKaryawan() {
        $.ajax({
            url: '<?= base_url('dashboard/karyawan/listUsers') ?>',
            method: 'POST',
            dataType: 'json',
            data: {selectedKar: null },
            success: function(response) {
                $('#pickKaryawan').empty();
                if (response) {
                    $('#pickKaryawan').append($('<option>', {
                        value: '',
                        text: 'Pilih Karyawan'
                    }));
                    response.forEach(function(kar) {
                        $('#pickKaryawan').append($('<option>', {
                            value: kar.id,
                            text: kar.namaKaryawan
                        }));
                    });
                } else {
                    $('#pickKaryawan').append($('<option>', {
                        value: '',
                        text: 'Tidak ada data'
                    }));
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }
    $(document).ready(function() {
        $("#pickRole").select2({
            placeholder: {
                id: '',
                text: 'Pilih Role'
            },
        });
        $("#pickKaryawan").select2({
            placeholder: {
                id: '',
                text: 'Pilih Karyawan'
            },
        });
        getRole();
        $('#pickRole').on('change', function() {
            var selectedRole = $(this).val();
            if (selectedRole == 3) {
                $('#karyawan-container').show();
                getKaryawan();
            } else {
                $('#karyawan-container').hide();
            }
        });
    })
</script>
<?php $this->endSection();?>



