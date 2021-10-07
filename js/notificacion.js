$(function() {

    var notifications = new $.ttwNotificationMenu({
        notificationList:{
            anchor:'item',
            offset:'0 0'
        }
    });

    notifications.initMenu({ 
        projects:'#projects'//,
//        tasks:'#tasks',
//        messages:'#messages'
    });
	
	
	$('#test').addClass('pointer');
	$("#test").click(function(e) {
		 var options = {
                category:'projects',
                message: '<a href=\"#"\>ASDasdasd sdada s asdasdas asdasdasdas sadadas</a>'
            };
			 notifications.createNotification(options);
		  });

   
});

