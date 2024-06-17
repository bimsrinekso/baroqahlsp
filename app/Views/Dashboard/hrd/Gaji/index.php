<?php $this->extend('inc/main'); ?>
<?php $this->section('css'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
<?php $this->endSection(); ?>

<?php $this->section('body'); ?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Pengelola Gaji</h1>
    </div>
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-lg-4 mb-3">
                <label class="form-label">Date Range</label>
                <input type="text" id="date-range" name="dateRange" class="form-control" placeholder="Select Date Range">
            </div>
            <div class="col-lg-4 mb-3">
                <label for="pickKaryawan" class="form-label">Karyawan</label>
                <select id="pickKaryawan" name="karyawanID" class="form-select" required>
                   
                </select>
            </div>
            <div class="col-lg-12 mb-3 d-flex justify-content-between">
                <button id="filter-button" class="btn btn-primary">Filter</button>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#bayarModal">Hitung Gaji</button>
            </div>
        </div>
        <table id="table-gaji" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th class="text-center">Nama Karyawan</th>
                    <th class="text-center">Golongan</th>
                    <th class="text-center">Nip</th>
                    <th class="text-center">Bulan</th>
                    <th class="text-center">Gaji Pokok</th>
                    <th class="text-center">Bonus</th>
                    <th class="text-center">Pajak</th>
                    <th class="text-center">Total Gaji</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>
        <!-- Delete Modal -->
    <div class="modal fade" id="bayarModal" tabindex="-1" aria-labelledby="bayarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bayarModalLabel">Perhitungan Gaji</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"> 
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <label class="form-label">Pick Month</label>
                            <input type="text" id="month-date" name="month" class="form-control" placeholder="Month">
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label for="pickKaryawanDD" class="form-label">Karyawan</label>
                            <select id="pickKaryawanDD" name="karyawanIDdd" class="form-select" required>
                                
                            </select>
                        </div>
                        <div id="salaryDetails" class="row">
                            
                        </div>
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="save-salary-btn">Simpan</button>
                </div>
            </div>
        </div>
    </div>
<?php $this->endSection(); ?>

<?php $this->section('javascript'); ?>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
    async function getKaryawan() {
        $.ajax({
            url: '<?= base_url('dashboard/karyawan/list') ?>',
            method: 'GET',
            dataType: 'json',
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

    async function getKaryawanDropdown() {
        $.ajax({
            url: '<?= base_url('dashboard/karyawan/list') ?>',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#pickKaryawanDD').empty();
                if (response) {
                    $('#pickKaryawanDD').append($('<option>', {
                        value: '',
                        text: 'Pilih Karyawan'
                    }));
                    response.forEach(function(kar) {
                        $('#pickKaryawanDD').append($('<option>', {
                            value: kar.id,
                            text: kar.namaKaryawan,
                            'data-gaji': kar.gajiPokok,
                            'data-bonus': kar.bonus,
                            'data-golongan': kar.namaGolongan
                        }));
                    });
                } else {
                    $('#pickKaryawanDD').append($('<option>', {
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
    function formatCurrency(value) {
        if (!value) return 'Rp 0.000';
        value = parseFloat(value).toFixed(3); 
        return 'Rp ' + value.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }


    $(document).ready(function() {
        $("#pickKaryawan").select2({
            placeholder: {
                id: '',
                text: 'Pilih Karyawan'
            },
        });
        getKaryawan();
        getKaryawanDropdown();
        createMonthYearPicker('#month-date');
        
        $('#date-range').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear',
                format: 'YYYY-MM'
            }
        });

        $('#date-range').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM') + ' - ' + picker.endDate.format('YYYY-MM'));
        });
        $('#date-range').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

        var tablelist = $('#table-gaji').DataTable({
            scrollX: true,
            ajax: {
                url: '<?= base_url('dashboard/gaji/list'); ?>',
                method: "POST",
                data: function(d) {
                    console.log(d)
                    var dateRange = $('#date-range').val().split(' - ');
                    d.startDate = dateRange[0];
                    d.endDate = dateRange[1];
                    d.karyawanID = $('#pickKaryawan').val();
                },
                dataSrc: 'data',
                // success: function (response) {
                //     console.log(response)
                // },
                error: function(xhr, status, error) {
                    console.log(error);
                    alert('Gagal memuat data gaji. Silakan coba lagi nanti.');
                }
            },
            columns: [
                { data: 'namaKaryawan', className: 'text-center' },
                { data: 'namaGolongan', className: 'text-center' },
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
                            return formatCurrency(data);
                        }
                    }
                },
                { data: 'totalBonus', 
                    className: 'text-center',
                    render: function(data, type, row) {
                        if(data == null) {
                            return '-';
                        } else {
                            return formatCurrency(data);
                        }
                    }
                },
                { data: 'totalPotongan', 
                    className: 'text-center',
                    render: function(data, type, row) {
                        if(data == null) {
                            return '-';
                        } else {
                            return formatCurrency(data);
                        }
                    }
                },
                { data: 'totalGaji', 
                    className: 'text-center',
                    render: function(data, type, row) {
                        if(data == null) {
                            return '-';
                        } else {
                            return formatCurrency(data);
                        }
                    }
                },
            ],
            dom: 'Bfrtip',
            buttons: [
                { extend: 'excelHtml5' },
                { extend: 'pdfHtml5' },
                { extend: 'print' }
            ],
        });

        $('#filter-button').click(function() {
            tablelist.ajax.reload();
        });
        $('#pickKaryawanDD').change(function() {
            var gajiPokok = $(this).find(':selected').data('gaji');
            gajiPokok = parseFloat(gajiPokok)
            var bonus = $(this).find(':selected').data('bonus');
            bonus = gajiPokok * bonus;
            bonus = parseFloat(bonus)
            var totalPotongan = gajiPokok * 0.05;
            totalPotongan = parseFloat(totalPotongan)
            var totalGaji = gajiPokok + bonus - totalPotongan;
            totalGaji = parseFloat(totalGaji)
            var golongan = $(this).find(':selected').data('golongan');
            $('#salaryDetails').html(`
                <div class="col-lg-12 mb-3">
                    <label class="form-label">Nama Golongan</label>
                    <input type="text" id="gologan" name="gologan" class="form-control" value="${golongan}" readonly>
                </div>
                <div class="col-lg-12 mb-3">
                    <label class="form-label">Gaji Pokok</label>
                    <input type="text" id="gajiPokok" name="gajiPokok" class="form-control" value="${formatCurrency(gajiPokok)}" readonly>
                </div>
                <div class="col-lg-12 mb-3">
                    <label class="form-label">Total Bonus</label>
                    <input type="text" id="totalBonus" name="totalBonus" class="form-control" value="${formatCurrency(bonus)}" readonly>
                </div>
                <div class="col-lg-12 mb-3">
                    <label class="form-label">Pajak</label>
                    <input type="text" id="totalPotongan" name="totalPotongan" class="form-control" value="${formatCurrency(totalPotongan)}" readonly>
                </div>
                <div class="col-lg-12 mb-3">
                    <label class="form-label">Total Gaji</label>
                    <input type="text" id="totalGaji" name="totalGaji" class="form-control" value="${formatCurrency(totalGaji)}" readonly>
                </div>
            `);
        });
        $('#save-salary-btn').click(function() {
            var formData = {
                karyawanIDdd: $('#pickKaryawanDD').val(),
                month: $('#month-date').val(),
                gajiPokok: $('#gajiPokok').val(),
                totalBonus: $('#totalBonus').val(),
                totalPotongan: $('#totalPotongan').val(),
                totalGaji: $('#totalGaji').val()
            };
            
            $.ajax({
                url: '<?= base_url('dashboard/gaji/create') ?>',
                method: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    console.log(formData)
                    console.log(response)
                    if (response.success == 200) {
                        toastr.success(response.message);
                        $('#bayarModal').modal('hide');
                        tablelist.ajax.reload();
                    } else {
                        toastr.error(response.message);
                        $('#bayarModal').modal('hide');
                        tablelist.ajax.reload();
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr)
                    alert('Gagal menyimpan data. Silakan coba lagi nanti.');
                }
            });
        });
    });
</script>
<?php $this->endSection(); ?>
