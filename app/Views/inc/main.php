
<!doctype html>
<html lang="en">

    
<head>
        
        <meta charset="utf-8" />
        <title>Baroqah</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.dataTables.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="/assets/css/plugins/toastr/toastr.min.css" >
        <style>
            body {
                min-height: 100vh;
                display: flex;
                flex-direction: column;
            }
            #sidebar {
                min-height: 100vh;
            }
            #content {
                flex: 1;
            }
        </style>
        <?php $this->renderSection('css');?>

    </head>

    <body>
        <?php include 'header.php'?>
            <div class="container-fluid">
                <div class="row">
                    <?php include 'sidebar.php'?>
                    <main id="content" class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    <?php $this->renderSection('body');?>
                    </main>
                </div>
            </div>
        <?php include 'footer.php'?> 
        <script src="/assets/js/plugins/jquery/jquery.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.dataTables.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="/assets/js/plugins/toastr/toastr.min.js"></script>
        <script src="/assets/js/plugins/toastr/toastr.init.js"></script>
        <?php if(session()->getFlashdata('sukses')):?>
        <script>
              toastr.success("<?= session()->getFlashData("sukses"); ?>");
        </script>
        <?php elseif(session()->getFlashdata('error')):?>
            <script>
                toastr.error("<?= session()->getFlashData("error"); ?>");
            </script>
        <?php elseif(session()->getFlashdata('validation')):?>
            <script>
                toastr.error('<?= session()->getFlashData("validation"); ?>', '', {
                    "timeOut": "5000",
                    "escapeHtml": false,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });
            </script>
        <?php endif?>

        <?php $this->renderSection('javascript');?>
    </body>

</html>
