<?php $this->extend('inc/main');?>
<?php $this->section('css');?>

<?php $this->endSection();?>
<?php $this->section('body');?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Pengelola Akun</h1>
    </div>
    <div class="container-fluid mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a class="btn btn-primary" href="<?=base_url('dashboard/usermanage/create')?>" role="button">Buat Akun</a>
        </div>
        <table id="table-usermanage" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus data ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger">Hapus</button>
                </div>
            </div>
        </div>
    </div>
<?php $this->endSection();?>
<?php $this->section('javascript');?>
<script>
    $(document).ready(function() {


        var tablelist = $('#table-usermanage').DataTable({
            ajax: {
                url: '<?= base_url('dashboard/usermanage/list'); ?>',
                dataSrc: '',
            },
            columns: [
                { data: 'username', className: 'text-center' },
                { data: 'email' , className: 'text-center'},
                { data: 'role' , className: 'text-center'},
                {
                    data: 'id',
                    className: 'text-center',
                    render: function(data, type, row) {
                        return '<a href="<?=base_url('dashboard/usermanage/edit/')?>' + row.id + '" class="btn btn-warning btn-sm">Edit</a> <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="' + row.id + '">Hapus</button>';
                    }
                }
            ],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }
                },
                {
                    extend: 'print',
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }
                }
            ]
        });

        $('#deleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);
            modal.find('.btn-danger').click(function () {
                $.ajax({
                    type: 'DELETE',
                    url: '<?= base_url('dashboard/usermanage/delete/') ?>' + id,
                    success: function (response) {
                        toastr.success("Berhasil menghapus data");
                        // Optionally, remove the modal after successful deletion
                        modal.modal('hide');
                        var table = $('#table-usermanage').DataTable();
                        table.ajax.reload();
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    })
</script>
<?php $this->endSection();?>



