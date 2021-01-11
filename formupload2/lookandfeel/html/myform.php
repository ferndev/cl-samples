<!-- About -->
<section class="content-section bg-light" id="about">
    <div class="container text-center">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <h2><?php echo($cltitle);?></h2>
                <?= isset($feedback) ? $feedback : '' ?>
                <form method="post" action="index.php" enctype="multipart/form-data">
                    <h5>Document metadata</h5>
                    <div class="input-group mb-3">
                        <input type="text" name="metadata" value="<?= isset($metadata) ? $metadata : '' ?>" class="form-control" placeholder="enter comma separated keywords for your document" aria-label="metadata"
                               aria-describedby="metadata" required="" id="metadata">
                    </div>
                    <h5>Documents to upload</h5>
                    <div class="form-row mb-3">
                        <div class="form-group col-md-6">
                            <input type="file" name="document1" class="form-control" id="document1" title="1st document" required="">
                        </div>
                        <div class="form-group col-md-6">
                            <input type="file" name="document2" class="form-control" id="document2" title="2nd document (optional)">
                        </div>
                    </div>
                    <h5>Let's go!</h5>
                    <input type="hidden" name="<?php echo(CSRF_KEY);?>" value="<?= isset($csrf) ? $csrf : '' ?>">
                    <input type="hidden" name="clkey" value="dochandler">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</section>
