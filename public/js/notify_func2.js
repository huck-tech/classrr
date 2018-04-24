 $(function() {
setTimeout(function() {
$.notify({
	// options
	icon: 'https://api.adorable.io/avatars/68/airuser'+classroom_id,
	title: "<h4>is looking for a classmate</h4> ",
	message: "<p>Just booked this class ("+finder+" min. ago).</p>"
},{
	// settings
	icon_type: 'image',
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