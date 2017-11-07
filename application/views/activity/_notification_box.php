<div class="dropdown-menu dropdown-menu-right" id="notification-box">
    <div class="list-group">
        <?php if(!empty($unread_activities)): ?>
            <?php foreach($unread_activities as $activity) { ?>
                <div class="list-group-item list-group-item-action flex-column align-items-start" data-id="<?php echo $activity['id']; ?>">
                    <p class="mb-1"><?php echo $activity['activity_text']; ?></p>
                    <small class="text-muted"><?php echo ago(strtotime($activity['added_on'])); ?></small>
                </div>
            <?php } ?>
        <?php else: ?>
            <div class="p-3">No new notifications</div>
        <?php endif; ?>
    </div>
    <a class="list-group-item list-group-item-action text-center p-2" href="<?php echo site_url('activity/notifications'); ?>">View all (<?php echo $total_activities_count; ?>)</a>
</div>