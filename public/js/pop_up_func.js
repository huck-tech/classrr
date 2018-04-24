 $(window).load(function() {
                new $.popup({                
                    title       : '',
                    content         : '<a href="'+base_url+'/register"><img src="'+base_url+'/img/popup_img.jpg" alt="Classrr" class="pop_img"><h3 id="pop_msg">This month special offer <strong>FREE CLASS</strong> on your 2nd booking</h3></a><small>classes with same or lower price</small>', 
					html: true,
					autoclose   : true,
					closeOverlay:true,
					closeEsc: true,
					buttons     : false,
                    timeout     : 5000 
                });
            });