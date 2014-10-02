<div class="container">
    <div class="well">
        <h1>Success!</h1>
        <p>You have successfuly sent the newsletter.</p>
        <p>You can track its progress in the <a href="<?= site_url('/reports/campaign/'.$campaign); ?>">reports</a> page.</p>
        <p><a href="<?= $raw_email; ?>">View the raw email</a>.</p>
    </div>
    <p>For help with the newsletter creator please contact <a href="<?php echo 'mailto:'.$this->config->item('support_email');?>"><?php echo $this->config->item("support_email");?></a>. &copy; Andrew Niemantsverdriet 2013</p>
</div> <!-- /container -->
