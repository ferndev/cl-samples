<!-- About -->
<section class="content-section bg-light" id="about">
    <div class="container text-center">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <h2>New Contact Form</h2>
                <?= isset($feedback) ? $feedback : '' ?>
                <form method="post" action="index.php" enctype="multipart/form-data">
                    <h5>Contact details</h5>
                    <div class="input-group mb-3">
                        <input type="text" name="cname" value="<?= isset($cname) ? $cname : '' ?>" class="form-control" placeholder="contact name" required="">
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" name="email" value="<?= isset($email) ? $email : '' ?>" class="form-control" placeholder="email address" required="">
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" name="cell" value="<?= isset($email) ? $email : '' ?>" class="form-control" placeholder="cell number" required="">
                    </div>
                    <input type="hidden" name="clkey" value="rest">
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <a href="index.php?clkey=rest">View your contacts</a>
            </div>
        </div>
    </div>
</section>
