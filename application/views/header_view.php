<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Andrew Niemantsverdriet">
    <link rel="shortcut icon" href="<?= base_url('/assets/ico/favicon.png'); ?>">

    <title><?php echo $this->config->item('application_title');?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?= base_url('/dist/css/bootstrap.css'); ?>" rel="stylesheet">

    <!-- Bootstrap editor -->
    <link href="<?= base_url('/assets/css/bootstrap-editable.css'); ?>" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?= base_url('/assets/css/custom.css'); ?>" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="<?= base_url('/assets/js/html5shiv.js'); ?>"></script>
      <script src="<?= base_url('/assets/js/respond.min.js'); ?>"></script>
    <![endif]-->
  </head>

  <body>

    <!-- Fixed navbar -->
    <div class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?= site_url() ?>"><?php $this->config->item('application_title');?></a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li <?php if($active == 'compose'){ echo 'class="active"'; } ?>><a href="<?= site_url() ?>">Compose Email</a></li>
            <li <?php if($active == 'contacts'){ echo 'class="active"'; } ?>><a href="<?= site_url('/contacts') ?>">Contacts</a></li>
            <li <?php if($active == 'reports'){ echo 'class="active"'; } ?>><a href="<?= site_url('/reports') ?>">Reports</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
