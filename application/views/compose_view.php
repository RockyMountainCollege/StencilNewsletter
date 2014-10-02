<div class="container">
    <div class="alert alert-warning fade in <?php if (!validation_errors()) { echo 'hidden'; } ?>">
        <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
        <strong>Holy guacamole!</strong>
        <p><?php if (validation_errors()) { echo 'Please fix the errors marked in red'; } ?></p>
    </div>
    <div class="well">
        <h1>Compose New Email</h1>
        <?= form_open('compose', array('role' => 'form')); ?>
            <input id="recipientList" name="recipientList" type="hidden" value="">
            <div class="form-group <?=  form_error('recipientList') ? 'has-error':''; ?>">
                <a data-toggle="modal" href="#recipients" class="btn btn-primary">Select Recipients</a>
                <p class="help-block">Select the recipients that you would like the email to go to</p>
            </div>
            <!-- Load Modal View -->
            <?php $this->load->view('compose_modal_view'); ?>
            <!-- End Modal View -->
            <div class="form-group <?=  form_error('campaign') ? 'has-error':''; ?>">
                <label for="campaign">Campaign ID</label>
                <input type="text" class="form-control" id="campaign" name="campaign" placeholder="Campaign ID" value="<?= set_value('campaign'); ?>">
                <p class="help-block">The campaign ID must be unique to allow for tracking. Can only contain letters, numbers and underscores.</p>
            </div>
            <div class="form-group">
                <label for="from">From E-Mail</label>
                <input type="text" class="form-control" id="from" name="from" placeholder="<?php echo $this->config->item('default_send_from');?>">
                <p class="help-block">The address that e-mail comes from.</p>
            </div>
            <div class="form-group <?php if(form_error('subject')){echo 'has-error';}?>">
                <label for="subject">E-Mail Subject</label>
                <input type="text" class="form-control" id="subject" placeholder="E-Mail Subject" name="subject" value="<?= set_value('subject'); ?>">
                <?php if(form_error('subject')){echo '<p class="help-block">You must enter a Subject.</p>';} ?>
            </div>
            <div class="form-group <?php if(form_error('emailBody')){echo 'has-error';}?>">
                <label for="emailBody">E-Mail Body</label>
                <?php if(form_error('emailBody')){echo '<p class="help-block">Must not be blank</p>';} ?>
                <textarea class="ckeditor form-control" id='emailBody' name='emailBody' rows="10"><?= set_value('emailBody'); ?></textarea>
            </div>
            <button type="submit" class="btn btn-default">Send</button>
        </form>
    </div>
    <p>For help with the newsletter creator please contact <a href="<?php echo 'mailto:'.$this->config->item('support_email');?>"><?php echo $this->config->item("support_email");?></a>. &copy; Andrew Niemantsverdriet 2013</p>
</div> <!-- /container -->
