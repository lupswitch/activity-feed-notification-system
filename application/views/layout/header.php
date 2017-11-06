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
        </head>
        <body>
            <header>
                <div class="navbar navbar-dark navbar-expand bg-dark">
                    <div class="container d-flex justify-content-between">
                        <a href="<?php echo site_url(); ?>" class="navbar-brand">Activity Feed Notification System</a>
                        <a href="<?php echo site_url('activity/manage'); ?>" class="btn btn-primary">Manage</a>
                    </div>
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width: 40px;">
                              <img class="notification-ico" src="<?php echo base_url('resources/img/notification.svg'); ?>">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" id="notification-box">
                                <div class="list-group">
                                    <?php if(!empty($activities)): ?>
                                        <?php foreach($activities as $activity) { ?>
                                            <div class="list-group-item list-group-item-action flex-column align-items-start">
                                                <p class="mb-1"><?php echo $activity['activity_text']; ?></p>
                                                <small class="text-muted"><?php echo time_elapsed_string(strtotime($activity['added_on'])); ?></small>
                                            </div>
                                        <?php } ?>
                                    <?php else: ?>
                                        <div class="p-3">No new notifications!</div>
                                    <?php endif; ?>
                                </div>
                                <a class="list-group-item list-group-item-action text-center p-2" href="<?php echo site_url('activity/notifications'); ?>">View All (<?php echo $total_activities_count; ?>)</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </header>
            <main role="main">