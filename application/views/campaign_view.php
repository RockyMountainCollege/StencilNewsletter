<div class="container">
    <div class="well">
        <p>
            Refresh page every <input id="expire" type="text" size="2" value="60"> seconds.
            <button type="button" id="update" class="btn btn-primary">Update</button>
            <button type="button" id="stop" class="btn btn-default">Stop</button>
        </p>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Reporting for: <?= $id; ?></h3>
            <p><a href='<?= site_url("/reports/export/".$id);?>'>Export data as CSV file</a><br>
            <a href="<?= base_url('/emails/'.$id.'.html'); ?>">View Email</a></p>
        </div>
        <div class="panel-body">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#all" data-toggle="tab">All</a></li>
                <li><a href="#clicked" data-toggle="tab">Clicked</a></li>
                <li><a href="#opened" data-toggle="tab">Opened</a></li>
                <li><a href="#unopened" data-toggle="tab">Unopened</a></li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="all">
                    <p>Nothing to see yet...</p>
                </div>
                <div class="tab-pane" id="clicked">
                    <p>Loading clicked...</p>
                </div>
                <div class="tab-pane" id="opened">
                    <p>Loading opened...</p>
                </div>
                <div class="tab-pane" id="unopened">
                    <p>Loading unopened...</p>
                </div>
            </div>
        </div>
    </div>
    <p>For help with the newsletter creator please contact <a href="<?php echo 'mailto:'.$this->config->item('support_email');?>"><?php echo $this->config->item("support_email");?></a>. &copy; Andrew Niemantsverdriet 2013</p>
</div> <!-- /container -->
<script type="text/javascript">
    function loadReport(reportID) {
        console.log('loading report: ' + reportID);
        var report = reportID.replace("#",""); 
        var siteUrl = "<?= site_url('/reports'); ?>/";
        var campaign = "<?= $id ?>/";
        $(reportID).load(siteUrl + report + '/' + campaign);
    }
</script>
