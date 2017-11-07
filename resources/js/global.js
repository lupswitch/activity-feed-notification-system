$(document).ready(function() {

	// initialize scrollbar for notification box
	$("#notification-box .list-group").mCustomScrollbar({
	    theme:"minimal-dark", // set mCustomScrollBar theme
	});

	// mark unread notifications as read
	// and remove the unread badge count from header
	$("#notification-btn").on("click", function() {
		if($("#notification-btn .unread-count").text() > 0) {
		    $.get(GLOBAL.site_url+"activity/mark_notifications_as_read", function(data) {
				$("#notification-btn .unread-count").fadeOut(function() {
					$(this).remove();
				});
			});
		}
	});

})