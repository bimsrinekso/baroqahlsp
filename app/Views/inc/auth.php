
<!doctype html>
<html lang="en">

    
<head>
        
        <meta charset="utf-8" />
        <title>Baroqah</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="/assets/css/plugins/toastr/toastr.min.css" >
        <?php $this->renderSection('css');?>

    </head>

    <body>
        <?php $this->renderSection('body');?>
        <script src="/assets/js/plugins/jquery/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
