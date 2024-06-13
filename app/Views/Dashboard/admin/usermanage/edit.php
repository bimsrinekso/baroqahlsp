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
                        <label for="username" class="form-label">Username</label>
                        <input name="username" value="<?=$result->username?>" type="text" class="form-control" placeholder="Username">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input name="email" value="<?=$result->email?>"type="email" class="form-control" placeholder="Email">
                    </div>
                    <div class="mb-3">
                        <label for="pickRole" class="form-label">Role</label>
                        <select id="pickRole" name="role" class="form-select" required>

                        </select>
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
    $(document).ready(function() {
        $("#pickRole").select2({
            placeholder: {
                id: '',
                text: 'Pilih Golongan'
            },
        });
        let dataRole = '<?=$result->role_id?>'
        console.log(dataRole)
        getRole(dataRole);
    })
</script>
<?php $this->endSection();?>



