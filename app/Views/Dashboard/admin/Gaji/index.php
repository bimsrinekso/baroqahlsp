<?php $this->extend('inc/main');?>
<?php $this->section('css');?>
<!-- Include necessary CSS here -->
<?php $this->endSection();?>
<?php $this->section('body');?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Pengelola Gaji</h1>
    </div>
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-lg-4 mb-3">
                <label class="form-label">Start Date</label>
                <input type="text" id="start-date" name="startDate" class="form-control" placeholder="Start Date">
            </div>
            <div class="col-lg-4 mb-3">
                <label class="form-label">End Date</label>
                <input type="text" id="end-date" name="endDate" class="form-control" placeholder="End Date">
            </div>
            <div class="col-lg-4 mb-3">
                <label for="pickKaryawan" class="form-label">Karyawan</label>
                <select id="pickKaryawan" name="karyawanID" class="form-select" required>
                    <!-- Options will be populated here -->
                </select>
            </div>
            <div class="col-lg-12 mb-3">
                <button id="filter-button" class="btn btn-primary">Filter</button>
            </div>
        </div>
        <table id="table-gaji" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th class="text-center">Nama Karyawan</th>
                    <th class="text-center">Nip</th>
                    <th class="text-center">Bulan</th>
                    <th class="text-center">Gaji Pokok</th>
                    <th class="text-center">Bonus</th>
                    <th class="text-center">Potongan</th>
                    <th class="text-center">Total Gaji</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
<?php $this->endSection();?>
<?php $this->section('javascript');?>
<script>
    async function getKaryawan() {
        $.ajax({
            url: '<?=base_url('dashboard/karyawan/list')?>',
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                $('#pickKaryawan').empty();
                if (response) {
                    $('#pickKaryawan').append($('<option>', {
                        value: '',
                        text: 'Pilih Karyawan'
                    }));
                    response.forEach(function (kar) {
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
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    }

    function createMonthYearPicker(id) {
        $(id).datepicker({
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            dateFormat: 'yy-mm',
            onClose: function(dateText, inst) {
                var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                $(this).val($.datepicker.formatDate('yy-mm', new Date(year, month, 1)));
            }
        }).focus(function() {
            $(".ui-datepicker-calendar").hide();
            $("#ui-datepicker-div").position({
                my: "center top",
                at: "center bottom",
                of: $(this)
            });
        });
    }

    $(document).ready(function() {
        $("#pickKaryawan").select2({
            placeholder: {
                id: '',
                text: 'Pilih Karyawan'
            },
        });
        getKaryawan();
        createMonthYearPicker('#start-date');
        createMonthYearPicker('#end-date');

        var tablelist = $('#table-gaji').DataTable({
            ajax: {
                url: '<?= base_url('dashboard/gaji/list'); ?>',
                method: "POST",
                data: function (d) {
                    console.log(d)
                    d.startDate = $('#start-date').val();
                    d.endDate = $('#end-date').val();
                    d.karyawanID = $('#pickKaryawan').val();
                },
                dataSrc: 'data',
                // success: function (response) {
                //     console.log(response)
                // },
                error: function (xhr, status, error) {
                    console.log(xhr);
                    alert('Gagal memuat data gaji. Silakan coba lagi nanti.');
                }
            },
            columns: [
                { data: 'namaKaryawan', className: 'text-center' },
                { data: 'NIP', className: 'text-center' },
                { data: 'bulanGaji', 
                    className: 'text-center',
                    render: function(data, type, row) {
                        if(data == null) {
                            return '-';
                        } else {
                            return data;
                        }
                    }
                },
                { data: 'gajiPokok', 
                    className: 'text-center',
                    render: function(data, type, row) {
                        if(data == null) {
                            return '-';
                        } else {
                            return data;
                        }
                    }
                },
                { data: 'bonus', 
                    className: 'text-center',
                    render: function(data, type, row) {
                        if(data == null) {
                            return '-';
                        } else {
                            return data;
                        }
                    }
                },
                { data: 'potongan', 
                    className: 'text-center',
                    render: function(data, type, row) {
                        if(data == null) {
                            return '-';
                        } else {
                            return data;
                        }
                    }
                },
                { data: 'totalGaji', 
                    className: 'text-center',
                    render: function(data, type, row) {
                        if(data == null) {
                            return '-';
                        } else {
                            return data;
                        }
                    }
                },
                {
                    data: 'gaji.id',
                    className: 'text-center',
                    render: function(data, type, row) {
                        return data;
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

        $('#filter-button').click(function() {
            tablelist.ajax.reload();
        });
    });
</script>
<?php $this->endSection();?>
