<?= $this->extend('Layouts/default') ?>
<?= $this->section('pageTitle'); ?>
New Article
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
                <h4 class="card-title fw-bold">New Article</h4>
                <form action="" class="formvalidate row pt-4 align-items-end" method="post">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="Brand" class="form-label">Brand</label>
                            <select class="form-control" name="Brand" id="Brand" required>
                                <option disabled selected>Select brand </option>
                                <?php foreach (get_all_brands() as $brand) : ?>
                                    <option value="<?= $brand->Id ?>"><?= $brand->Name ?></option>
                                <?php endforeach ?>

                            </select>
                            <span class="invalid-feedback text-danger">
                                <?= dispalyErrorMessage('errors', 'Brand') ?>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="Model" class="form-label">Model</label>
                            <input type="text" name="Model" id="Model" class="form-control" placeholder="Air Jordan" required>
                            <span class="invalid-feedback text-danger">
                                <?= dispalyErrorMessage('errors', 'Model') ?>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="Size" class="form-label">Size (US)</label>
                            <select class="form-control" name="Size" id="Size" required>
                                <option>8</option>
                                <option>9</option>
                                <option>10</option>
                                <option>11</option>
                            </select>
                            <span class="invalid-feedback text-danger">
                                <?= dispalyErrorMessage('errors', 'Size') ?>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="Wardrobe" class="form-label">Wardrobe</label>
                            <select class="form-control" name="WardrobeId" id="Wardrobe" required>
                                <?php foreach ($wardrobes as $wardrobe) : ?>
                                    <option value="<?= $wardrobe->Id ?>"> <?= $wardrobe->Title ?></option>
                                <?php endforeach ?>
                            </select>
                            <span class="invalid-feedback text-danger">
                                <?= dispalyErrorMessage('errors', 'WardrobeId') ?>
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