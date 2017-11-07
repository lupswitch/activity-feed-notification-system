<!doctype html>
    <html lang="en">
        <head>
            <title>Activity Feed Notification System</title>
            <!-- Required meta tags -->
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

            <!-- Bootstrap CSS -->
            <link rel="stylesheet" href="<?php echo base_url('resources/css/bootstrap.min.css'); ?>">
            <link rel="stylesheet" href="<?php echo base_url('resources/css/jquery.mCustomScrollbar.min.css'); ?>">
            <link rel="stylesheet" href="<?php echo base_url('resources/css/style.css'); ?>">
            
            <!-- set global javascript vars -->
            <script>
                var GLOBAL = {};
                GLOBAL.site_url = "<?php echo site_url(); ?>"; // set project site url for use in ajax / get / post calls
            </script>
        </head>
        <body>
            <header>
                <div class="navbar navbar-dark navbar-expand bg-dark">
                    <div class="container d-flex justify-content-between">
                        <a href="<?php echo site_url(); ?>" class="navbar-brand">Activity Feed Notification System</a>
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a id="notification-btn" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width: 40px;">
                                    <img class="notification-ico" src="<?php echo base_url('resources/img/notification.svg'); ?>">
                                    <?php if($unread_activities_count > 0): ?>
                                        <span class="badge badge-danger unread-count"><?php echo ($unread_activities_count > NOTIFICATION_MAX_BADGE_COUNT) ? NOTIFICATION_MAX_BADGE_COUNT . "+" : $unread_activities_count; ?></span>
                                    <?php endif; ?>
                                </a>
                                <!-- Load separate view for notification box -->
                                <?php $this->load->view('activity/_notification_box'); ?>
                            </li>
                        </ul>
                    </div>
                    <a href="<?php echo site_url('activity/manage'); ?>" class="btn btn-primary">Manage</a>
                </div>
            </header>
            <main role="main">