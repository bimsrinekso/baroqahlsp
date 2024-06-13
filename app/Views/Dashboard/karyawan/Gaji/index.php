<?php $this->extend('inc/main'); ?>
<?php $this->section('css'); ?>
<!-- Include necessary CSS here -->
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
                </tr>
            </thead>
            <tbody>
                <!-- Data will be populated here -->
            </tbody>
        </table>
    </div>
<?php $this->endSection(); ?>

<?php $this->section('javascript'); ?>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
    let idKar = '<?=$dataKar->id?>';
    console.log(idKar);
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
        value = parseFloat(value).toFixed(3); // Ensure value has three decimal places
        return 'Rp ' + value.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    
    $(document).ready(function() {
        createMonthYearPicker('#month-date');
        
        // Initialize date range picker without setting initial value
        $('#date-range').daterangepicker({
            autoUpdateInput: false, // Disable automatic input update
            locale: {
                cancelLabel: 'Clear',
                format: 'YYYY-MM'
            }
        });

        // Event listener for applying the date range
        $('#date-range').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM') + ' - ' + picker.endDate.format('YYYY-MM'));
        });

        // Event listener for clearing the date range
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
                    d.karyawanID = idKar;
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
    });
</script>
<?php $this->endSection(); ?>
