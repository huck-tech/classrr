 $(function() {
 setTimeout(function() {
$.notify({
	// options
	icon: 'icon_set_1_icon-29',
	title: "<h4>"+name+"</h4> ",
	message: "Last booked <strong>"+matcher+" hours ago</strong>"
},{
	// settings
	type: 'info',
	delay: 500,
	timer: 3000,
	z_index: 9999,
	showProgressbar: false,
	placement: {
		from: "bottom",
		align: "right"
	},
	offset: 20,
	animate: {
		enter: 'animated bounceInUp',
		exit: 'animated bounceOutDown'
	},
});
 }, 500); // change the start delay
  });