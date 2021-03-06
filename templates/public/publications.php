<?php
Template::loadChild('public/header');
?>


<section id="fmr-projects" style="padding-top: 2em;">
    <div class="container">
        <div class="row text-center row-bottom-padded-md">
            <div class="col-md-8 col-md-offset-2">
                <h2 class="fmr-lead animate-box">Publications</h2>
                <p class="fmr-sub-lead animate-box">Publications using data collected with the formr.org software</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-info">
                    <p>

                        <i class="fa fa-info-circle"></i> &nbsp; If you are publishing research conducted using formr, <strong>please cite</strong> both the preprint and the version of the software that was active when you ran your study.
                    </p>

                    <blockquote>
                        Arslan, R. C., Walther, M., & Tata, C. (2018, September 4). formr: A study framework allowing for automated feedback generation and complex longitudinal experience sampling studies using R. <a href="https://doi.org/10.31234/osf.io/pjasu">https://doi.org/10.31234/osf.io/pjasu</a>
                    </blockquote>

                    <blockquote>
                        Arslan, R.C., Tata, C.S. &amp; Walther, M.P. (2018). formr: A study framework allowing for automated feedback generation and complex longitudinal experience sampling studies using R. (version <?php echo Config::get('version'); ?>). <a href="https://zenodo.org/badge/latestdoi/11849439"><img src="https://zenodo.org/badge/11849439.svg" alt="DOI"></a>
                    </blockquote>
                    <p>
                        Once your research is published, 
                        you can send to us by email to <a href="mailto:rubenarslan@gmail.com">rubenarslan@gmail.com</a> or <a href="mailto:cyril.tata@gmail.com">cyril.tata@gmail.com</a> 
                        and it will be added to the list of publications.
                    </p>
                </div>
                <p>&nbsp;</p>
            </div>
            <div class="col-md-12">
                <?php
                /**
                 * For now publications are manually read from a pre-configured file as whole-text
                 * @TODO implement a more reasonable storage for publication
                 */
                $file = Config::get('publications_file', APPLICATION_ROOT . 'webroot/assets/publications.html');
                if (file_exists($file)) {
                    echo file_get_contents($file);
                }
                ?>
            </div>
            <p>&nbsp;</p>

        </div>
    </div>
</section>

<?php Template::loadChild('public/footer'); ?>
