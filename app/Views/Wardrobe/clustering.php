<?= $this->extend('Layouts/default') ?>
<?= $this->section('pageTitle'); ?>
Clusters
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

    .bx {
        font-size: 24px !important;
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
<h5 class=" mb-3">Size search for <b class="fw-bold"><?= $selectedBrand->Name ?></b> by <b class="fw-bold"><?= current_user()->username ?></b></h5>


<div class="row">
    <div class="col-lg-12 mb-3">
        <div class="card">
            <div class="card-header mb-1">
                <p class="text-secondary"><span class="fw-bold">Search Results: </span>You have possible matches in following wardrobes based on the articles in your own Virtual Wardrobe. You can see each wardrobes detail by clicking on the given link:</p>

            </div>

            <div class="card-body">
                <?php if (count($clustering['all_wardrobes']) != 0) : ?>
                    <div class="row">
                        <?php foreach ($clustering['all_wardrobes'] as $wardrobe) : ?>
                            <div class="col-lg-6 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title fw-bold"><?= $wardrobe->Title ?></h4>
                                        <p class="mb-1">Cluster size match probability <span class="float-end fw-bold text-muted"><?= $wardrobe->MatchPercentage ?>%</span></p>
                                        <div class="progress mt-2" style="height: 6px;">
                                            <div class="progress-bar progress-bar-striped bg-primary" role="progressbar" style="width: <?= $wardrobe->MatchPercentage ?>%" aria-valuenow="<?= $wardrobe->MatchPercentage ?>" aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                        <div class="table-responsive mt-3">
                                            <table class="table table-success">
                                                <thead>
                                                    <tr>
                                                        <th class="fw-bold text-center">Article</th>
                                                        <th class="fw-bold text-center"><small>Size (You)</small></th>
                                                        <th class="fw-bold text-center"><small>Size (<?= $wardrobe->Title ?>)</small></th>
                                                        <th class="fw-bold text-center">Match</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php $uWardrobe = $clustering['user_wardrobes'][0];
                                                    foreach ($uWardrobe->Articles as $uArticle) : ?>
                                                        <tr class="">
                                                            <td scope="row" class="text-center"><?= $uArticle->BrandName ?></td>
                                                            <td class="text-center"><?= $uArticle->Size ?></td>
                                                            <td class="text-center">
                                                                <?php $found = false;
                                                                foreach ($wardrobe->Articles as $ar) : ?>
                                                                    <?php if ($ar->Brand == $uArticle->Brand) : ?>
                                                                        <?php echo $ar->Size;
                                                                        $found = true;
                                                                        ?>
                                                                        <?php if ($ar->Size == $uArticle->Size) {
                                                                            $uArticle->Match = true;
                                                                        } ?>
                                                                    <?php endif ?>
                                                                <?php endforeach ?>
                                                                <?php if (!$found) : ?>
                                                                    <span class="text-muted">Not available</span>
                                                                <?php endif ?>
                                                            </td>
                                                            <td class="text-center">
                                                                <?php if (isset($uArticle->Match)) : ?>
                                                                    <span class="text-success"><i class='bx bx-check'></i></span>
                                                                <?php else : ?>
                                                                    <span class="text-danger"><i class='bx bx-x'></i></span>
                                                                <?php endif ?>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach ?>

                                                </tbody>
                                            </table>
                                        </div>
                                        As per this wardrobe data your suggested size for <span class="fw-bold"><?= $selectedBrand->Name ?></span> is <span class="fw-bold">
                                            <?php foreach ($wardrobe->Articles as $w_art) : ?>
                                                <?php if ($w_art->Brand == $selectedBrand->Id) : ?>
                                                    <?= $w_art->Size ?>.
                                                <?php endif ?>
                                            <?php endforeach ?>
                                        </span>
                                        <p class="my-2">

                                            <a type="button" class="btn btn-sm btn-primary me-1 waves-effect waves-light" href="<?= site_url('article/index/' . $wardrobe->UserId) ?>"><i class=" ri-arrow-right-line"></i> View Wardrobe</a>
                                        </p>


                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                    <?php else: ?>
                        <p>No possible cluster found.</p>
                <?php endif ?>
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
                                    text: "Wardrobe record has been deleted.",
                                    confirmButtonClass: "btn btn-primary w-xs mt-2",
                                    icon: "success",
                                    buttonsStyling: !1
                                }).then(function(r) {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: "Failed!",
                                    text: "Wardrobe record cannot be deleted.",
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