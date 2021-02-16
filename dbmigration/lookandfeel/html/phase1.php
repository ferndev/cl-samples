<?php
?>
<div class="col-md-7 col-lg-8">
    <h4 class="mb-3">Article details</h4>
    <div class="alert alert-primary" role="alert"><?php echo $message??''; ?></div>
    <form class="needs-validation" novalidate method="post" action="index.php">
        <div class="row g-3">
            <div class="col-sm-6">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" class="form-control" id="title" placeholder="" value="First article" required>
                <div class="invalid-feedback">
                    Please enter a title for this article.
                </div>
            </div>

            <div class="col-sm-6">
                <label for="description" class="form-label">Description</label>
                <input type="text" name="description" class="form-control" id="description" placeholder="" value="A first article for this sample" required>
                <div class="invalid-feedback">
                    Please provide a description for the article.
                </div>
            </div>

            <div class="col-12">
                <label for="content" class="form-label">Content</label>
                <div class="input-group">
                    <textarea cols="120" rows="15" name="content" class="form-control" id="content" placeholder="Text of the article" required>
                        <p>This article describes what this sample is about. It is an "Article publisher" :-). You write
                        simple articles using this interface, and they get stored on a db.</p><p>Notice how each Plugin requires a different
                            version of the database schema.&nbsp;</p><p>If you look at the schema folder of this sample, you will
                            see 3 migration definitions, with extension <strong>.cl</strong>, one for each of the required migrations,
                            as well as 3 folders: <strong>phase1</strong>, <strong>phase2 </strong>and <strong>phase3</strong>, each
                            containing the actual .sql to run for the specific migration to complete.</p>
                        <p>Notice that a migration definition is just a json file with details reagrding the migration,
                            including the database name, whether to create the db or not, the path, relative to the <b>schema</b>
                            folder, to the files for the specific migration, the list of files to migrate, optionally,
                            the db connection details, among other fields.</p>
                    </textarea>
                    <div class="invalid-feedback">

                    </div>
                </div>
            </div>
        </div>

        <hr class="my-4">
        <input type="hidden" name="timeline" value="2weeks">
        <button class="w-100 btn btn-primary btn-lg" type="submit">Submit</button>
    </form>
    <a class="btn btn-dark btn-xl js-scroll-trigger" href="index.php">Back to introduction</a>
    <a class="btn btn-dark btn-xl js-scroll-trigger" href="index.php?timeline=4weeks">Go to next phase</a>
</div>
