<!-- About -->
<section class="content-section bg-light" id="about">
    <div class="container text-center">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <h2>Your contact list</h2>
                <?php if($contacts != null) {
                    echo('<ul class="list-group">');
                    foreach($contacts as $contact) {
                        echo('<li class="list-group-item">Contact name: '.$contact['cname'].' email: '.$contact['email'].' cell: '.$contact['cell'].'</li>');
                    }
                    echo('</ul>');
                }?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <a href="index.php">Add another contact</a>
            </div>
        </div>
    </div>
</section>
