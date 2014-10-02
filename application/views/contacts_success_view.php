<div class="container">
    <div class="well">
        <h1>Success!</h1>
        <p>You have successfuly created a contacts list.</p>
        <p><a href="<?= site_url('/contacts/edit/'.$listName); ?>">View list</a></p>
    </div>
    <p>For help with the newsletter creator please contact <a href="<?php echo 'mailto:'.$this->config->item('support_email');?>"><?php echo $this->config->item("support_email");?></a>. &copy; Andrew Niemantsverdriet 2013</p>
</div> <!-- /container -->
