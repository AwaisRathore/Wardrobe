<?= $this->extend('Layouts/default') ?>
<?= $this->section('pageTitle'); ?>
Dashboard
<?= $this->endSection(); ?>
<?= $this->section('pageCSS'); ?>
<!--datatable css-->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
<!--datatable responsive css-->
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
<!-- Sweet Alert css-->
<link href="<?= site_url('public/assets/libs/sweetalert2/sweetalert2.min.css') ?>" rel="stylesheet" type="text/css" />
<style>
    .badge {
        font-size: unset !important;
    }

    .error {
        color: red;
    }
</style>
<?= $this->endSection(); ?>

<?= $this->section('content') ?>
<!-- start page title -->
<!-- <div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Dashboard</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>

        </div>
    </div>
</div> -->

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Dashboard</h5>
            </div>
            
        </div>
    </div><!--end col-->
</div><!--end row-->

<?= $this->endSection() ?>
<?= $this->section('pageJS'); ?>
<!--datatable js-->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<!-- Sweet Alerts js -->
<script src="<?= site_url('public/assets/libs/sweetalert2/sweetalert2.min.js') ?>"></script>

<!-- Sweet alert init js-->
<script src="<?= site_url('public/assets/js/pages/datatables.init.js') ?>"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

<script>
    $(document).ready(function() {
        var SELECTED_WORKERS = [];
        
        $('body').on('click', '.remove-item-btn', function(e) {
            var path = $(this).data('href');
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonClass: "btn btn-primary w-xs me-2 mt-2",
                cancelButtonClass: "btn btn-danger w-xs mt-2",

                confirmButtonText: "Yes, delete it!",
                buttonsStyling: !1,
                showCloseButton: !0,
            }).then(function(t) {
                if (t.value) {
                    $.ajax({
                        url: path,
                        method: 'get',
                        success: function(data) {
                            Swal.fire({
                                title: "Deleted!",
                                text: "Worker record has been deleted.",
                                confirmButtonClass: "btn btn-primary w-xs mt-2",
                                icon: "success",
                                buttonsStyling: !1
                            }).then(function(r) {
                                window.location.reload();
                            });

                        }
                    })

                }
            });
        });
        $('body').on('click', '.displayStatusBtn', function(e) {
            e.preventDefault();
            var worker_id = $(this).data('worker-id');
            var status = $(this).data('status');
            Swal.fire({
                title: "Are you sure?",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonClass: "btn btn-primary w-xs me-2 mt-2",
                cancelButtonClass: "btn btn-danger w-xs mt-2",
                confirmButtonText: "Yes!",
                buttonsStyling: !1,
                showCloseButton: !0,
            }).then(function(t) {
                if (t.value) {
                    $.ajax({
                        url: "<?= site_url('worker/changeDisplayStatus/') ?>" + worker_id + "/" + status,
                        method: 'get',
                        success: function(data) {
                            Swal.fire({
                                title: "Successfull!",
                                text: "Worker display status has been changed.",
                                confirmButtonClass: "btn btn-primary w-xs mt-2",
                                icon: "success",
                                buttonsStyling: !1
                            }).then(function(r) {
                                window.location.reload();
                            });

                        }
                    })

                }
            });
        });
    });
</script>
<?= $this->endSection(); ?>