<?= $this->extend('Layouts/default') ?>
<?= $this->section('pageTitle'); ?>
Articles
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
                <h5 class="card-title mb-0">All Articles</h5>
            </div>
            <div class="card-body table-responsive">
                <table id="example" class="table table-bordered wrap table-striped align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">Brand</th>
                            <th class="text-center">Model</th>
                            <th class="text-center">Size</th>
                            <th class="text-center">Wardrobe</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($articles as $article) : ?>
                            <tr>
                                <td class="text-center"><?= $article->Brand ?></td>
                                <td class="text-center"><?= $article->Model ?></td>
                                <td class="text-center"><?= $article->Size ?></td>
                                <td class="text-center"><?= $article->Wardrobe ?></td>
                                <td class="text-center">
                                    <div class="dropdown d-inline-block">
                                        <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ri-more-2-fill align-middle"></i>

                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item edit-item-btn" href="<?= site_url('wardrobe/view/' . $article->Id) ?>">
                                                    <i class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                    View
                                                </a>
                                            </li>
                                            <!-- <li>
                                                <a class="dropdown-item edit-item-btn" href="<?= site_url('wardrobe/edit/' . $article->Id) ?>">
                                                    <i class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                    Edit
                                                </a>
                                            </li> -->
                                            <li>
                                                <a class="dropdown-item remove-item-btn" data-href="<?= site_url('article/delete/' . $article->Id) ?>">
                                                    <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                    Delete
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach ?>


                    </tbody>
                </table>
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
                            data = JSON.parse(data);
                            
                            if (data) {
                                Swal.fire({
                                    title: "Deleted!",
                                    text: "Article record has been deleted.",
                                    confirmButtonClass: "btn btn-primary w-xs mt-2",
                                    icon: "success",
                                    buttonsStyling: !1
                                }).then(function(r) {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: "Failed!",
                                    text: "Article record cannot be deleted.",
                                    confirmButtonClass: "btn btn-primary w-xs mt-2",
                                    icon: "error",
                                    buttonsStyling: !1
                                });
                            }

                        }
                    })

                }
            });
        });

    });
</script>
<?= $this->endSection(); ?>