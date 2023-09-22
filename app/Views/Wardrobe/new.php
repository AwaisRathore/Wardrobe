<?= $this->extend('Layouts/default') ?>
<?= $this->section('pageTitle'); ?>
New Wardrobe
<?= $this->endSection(); ?>
<?= $this->section('pageCSS'); ?>
<style>
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
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title fw-bold">New Virtual Wardrobe</h4>
                <form action="" class="formvalidate row pt-4 align-items-end" method="post">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="Title" class="form-label">Virtual Wardrobe Title</label>
                            <input type="text" name="Title" id="Title" class="form-control" placeholder="Wardrobe title" required="required">
                            <span class="invalid-feedback text-danger">
                                <?= dispalyErrorMessage('errors', 'Title') ?>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
<?= $this->section('pageJS'); ?>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script>
    $(document).ready(function() {
        $('form').validate();
    });
</script>
<?= $this->endSection(); ?>