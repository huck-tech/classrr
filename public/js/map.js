$('#collapseMap').on('shown.bs.collapse', function(e){
	(function(A) {

	if (!Array.prototype.forEach)
		A.forEach = A.forEach || function(action, that) {
			for (var i = 0, l = this.length; i < l; i++)
				if (i in this)
					action.call(that, this[i], i, this);
			};

		})(Array.prototype);
		
		var mapObject;
        var markers = [];
		if (count == 6){
        var markersData = {
			'Museums': [
			{
				name: ''+ name1 +'',
				location_latitude: + lat1, 
				location_longitude: + lng1,
				map_image_url: ''+ imgmap1 +'',
				name_point: ''+ name1 +'',
				description_point: ''+ desc1 +'',
				get_directions_start_address: '',
				phone: 'N/A',
				price: ''+ price1 +'',
				url_point: ''+ urlmap1 +''
			},
			{
				name: ''+ name2 +'',
				location_latitude: + lat2, 
				location_longitude: + lng2,
				map_image_url: ''+ imgmap2 +'',
				name_point: ''+ name2 +'',
				description_point: ''+ desc2 +'',
				get_directions_start_address: '',
				phone: 'N/A',
				price: ''+ price2 +'',
				url_point: ''+ urlmap2 +''
			},
			{
				name: ''+ name3 +'',
				location_latitude: + lat3, 
				location_longitude: + lng3,
				map_image_url: ''+ imgmap3 +'',
				name_point: ''+ name3 +'',
				description_point: ''+ desc3 +'',
				get_directions_start_address: '',
				phone: 'N/A',
				price: ''+ price3 +'',
				url_point: ''+ urlmap3 +''
			},
			{
				name: ''+ name4 +'',
				location_latitude: + lat4, 
				location_longitude: + lng4,
				map_image_url: ''+ imgmap4 +'',
				name_point: ''+ name4 +'',
				description_point: ''+ desc4 +'',
				get_directions_start_address: '',
				phone: 'N/A',
				price: ''+ price4 +'',
				url_point: ''+ urlmap4 +''
			},
			{
				name: ''+ name5 +'',
				location_latitude: + lat5, 
				location_longitude: + lng5,
				map_image_url: ''+ imgmap5 +'',
				name_point: ''+ name5 +'',
				description_point: ''+ desc5 +'',
				get_directions_start_address: '',
				phone: 'N/A',
				price: ''+ price5 +'',
				url_point: ''+ urlmap5 +''
			},
			{
				name: ''+ name6 +'',
				location_latitude: + lat6, 
				location_longitude: + lng6,
				map_image_url: ''+ imgmap6 +'',
				name_point: ''+ name6 +'',
				description_point: ''+ desc6 +'',
				get_directions_start_address: '',
				phone: 'N/A',
				price: ''+ price6 +'',
				url_point: ''+ urlmap6 +''
			}
			]
        };
		}else if (count == 5){
        var markersData = {
			'Museums': [
			{
				name: ''+ name1 +'',
				location_latitude: + lat1, 
				location_longitude: + lng1,
				map_image_url: ''+ imgmap1 +'',
				name_point: ''+ name1 +'',
				description_point: ''+ desc1 +'',
				get_directions_start_address: '',
				phone: 'N/A',
				price: ''+ price1 +'',
				url_point: ''+ urlmap1 +''
			},
			{
				name: ''+ name2 +'',
				location_latitude: + lat2, 
				location_longitude: + lng2,
				map_image_url: ''+ imgmap2 +'',
				name_point: ''+ name2 +'',
				description_point: ''+ desc2 +'',
				get_directions_start_address: '',
				phone: 'N/A',
				price: ''+ price2 +'',
				url_point: ''+ urlmap2 +''
			},
			{
				name: ''+ name3 +'',
				location_latitude: + lat3, 
				location_longitude: + lng3,
				map_image_url: ''+ imgmap3 +'',
				name_point: ''+ name3 +'',
				description_point: ''+ desc3 +'',
				get_directions_start_address: '',
				phone: 'N/A',
				price: ''+ price3 +'',
				url_point: ''+ urlmap3 +''
			},
			{
				name: ''+ name4 +'',
				location_latitude: + lat4, 
				location_longitude: + lng4,
				map_image_url: ''+ imgmap4 +'',
				name_point: ''+ name4 +'',
				description_point: ''+ desc4 +'',
				get_directions_start_address: '',
				phone: 'N/A',
				price: ''+ price4 +'',
				url_point: ''+ urlmap4 +''
			},
			{
				name: ''+ name5 +'',
				location_latitude: + lat5, 
				location_longitude: + lng5,
				map_image_url: ''+ imgmap5 +'',
				name_point: ''+ name5 +'',
				description_point: ''+ desc5 +'',
				get_directions_start_address: '',
				phone: 'N/A',
				price: ''+ price5 +'',
				url_point: ''+ urlmap5 +''
			}
			]
        };
		}else if (count == 4){
        var markersData = {
			'Museums': [
			{
				name: ''+ name1 +'',
				location_latitude: + lat1, 
				location_longitude: + lng1,
				map_image_url: ''+ imgmap1 +'',
				name_point: ''+ name1 +'',
				description_point: ''+ desc1 +'',
				get_directions_start_address: '',
				phone: 'N/A',
				price: ''+ price1 +'',
				url_point: ''+ urlmap1 +''
			},
			{
				name: ''+ name2 +'',
				location_latitude: + lat2, 
				location_longitude: + lng2,
				map_image_url: ''+ imgmap2 +'',
				name_point: ''+ name2 +'',
				description_point: ''+ desc2 +'',
				get_directions_start_address: '',
				phone: 'N/A',
				price: ''+ price2 +'',
				url_point: ''+ urlmap2 +''
			},
			{
				name: ''+ name3 +'',
				location_latitude: + lat3, 
				location_longitude: + lng3,
				map_image_url: ''+ imgmap3 +'',
				name_point: ''+ name3 +'',
				description_point: ''+ desc3 +'',
				get_directions_start_address: '',
				phone: 'N/A',
				price: ''+ price3 +'',
				url_point: ''+ urlmap3 +''
			},
			{
				name: ''+ name4 +'',
				location_latitude: + lat4, 
				location_longitude: + lng4,
				map_image_url: ''+ imgmap4 +'',
				name_point: ''+ name4 +'',
				description_point: ''+ desc4 +'',
				get_directions_start_address: '',
				phone: 'N/A',
				price: ''+ price4 +'',
				url_point: ''+ urlmap4 +''
			}
			]
        };
		}else if (count == 3){
        var markersData = {
			'Museums': [
			{
				name: ''+ name1 +'',
				location_latitude: + lat1, 
				location_longitude: + lng1,
				map_image_url: ''+ imgmap1 +'',
				name_point: ''+ name1 +'',
				description_point: ''+ desc1 +'',
				get_directions_start_address: '',
				phone: 'N/A',
				price: ''+ price1 +'',
				url_point: ''+ urlmap1 +''
			},
			{
				name: ''+ name2 +'',
				location_latitude: + lat2, 
				location_longitude: + lng2,
				map_image_url: ''+ imgmap2 +'',
				name_point: ''+ name2 +'',
				description_point: ''+ desc2 +'',
				get_directions_start_address: '',
				phone: 'N/A',
				price: ''+ price2 +'',
				url_point: ''+ urlmap2 +''
			},
			{
				name: ''+ name3 +'',
				location_latitude: + lat3, 
				location_longitude: + lng3,
				map_image_url: ''+ imgmap3 +'',
				name_point: ''+ name3 +'',
				description_point: ''+ desc3 +'',
				get_directions_start_address: '',
				phone: 'N/A',
				price: ''+ price3 +'',
				url_point: ''+ urlmap3 +''
			}
			]
        };
		}else if (count == 2){
        var markersData = {
			'Museums': [
			{
				name: ''+ name1 +'',
				location_latitude: + lat1, 
				location_longitude: + lng1,
				map_image_url: ''+ imgmap1 +'',
				name_point: ''+ name1 +'',
				description_point: ''+ desc1 +'',
				get_directions_start_address: '',
				phone: 'N/A',
				price: ''+ price1 +'',
				url_point: ''+ urlmap1 +''
			},
			{
				name: ''+ name2 +'',
				location_latitude: + lat2, 
				location_longitude: + lng2,
				map_image_url: ''+ imgmap2 +'',
				name_point: ''+ name2 +'',
				description_point: ''+ desc2 +'',
				get_directions_start_address: '',
				phone: 'N/A',
				price: ''+ price2 +'',
				url_point: ''+ urlmap2 +''
			}
			]
        };
		}else if (count == 1){
        var markersData = {
			'Museums': [
			{
				name: ''+ name1 +'',
				location_latitude: + lat1, 
				location_longitude: + lng1,
				map_image_url: ''+ imgmap1 +'',
				name_point: ''+ name1 +'',
				description_point: ''+ desc1 +'',
				get_directions_start_address: '',
				phone: 'N/A',
				price: ''+ price1 +'',
				url_point: ''+ urlmap1 +''
			}
			]
        };
		}


			var mapOptions = {
				zoom: 8,
				center: {lat: + lat1, lng: + lng1},
				mapTypeId: google.maps.MapTypeId.ROADMAP,

				mapTypeControl: false,
				mapTypeControlOptions: {
					style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
					position: google.maps.ControlPosition.LEFT_CENTER
				},
				panControl: false,
				panControlOptions: {
					position: google.maps.ControlPosition.TOP_RIGHT
				},
				zoomControl: true,
				zoomControlOptions: {
					style: google.maps.ZoomControlStyle.LARGE,
					position: google.maps.ControlPosition.TOP_LEFT
				},
				scrollwheel: false,
				scaleControl: false,
				scaleControlOptions: {
					position: google.maps.ControlPosition.TOP_LEFT
				},
				streetViewControl: true,
				streetViewControlOptions: {
					position: google.maps.ControlPosition.LEFT_TOP
				},
				styles: [
							 {
					"featureType": "landscape",
					"stylers": [
						{
							"hue": "#FFBB00"
						},
						{
							"saturation": 43.400000000000006
						},
						{
							"lightness": 37.599999999999994
						},
						{
							"gamma": 1
						}
					]
				},
				{
					"featureType": "road.highway",
					"stylers": [
						{
							"hue": "#FFC200"
						},
						{
							"saturation": -61.8
						},
						{
							"lightness": 45.599999999999994
						},
						{
							"gamma": 1
						}
					]
				},
				{
					"featureType": "road.arterial",
					"stylers": [
						{
							"hue": "#FF0300"
						},
						{
							"saturation": -100
						},
						{
							"lightness": 51.19999999999999
						},
						{
							"gamma": 1
						}
					]
				},
				{
					"featureType": "road.local",
					"stylers": [
						{
							"hue": "#FF0300"
						},
						{
							"saturation": -100
						},
						{
							"lightness": 52
						},
						{
							"gamma": 1
						}
					]
				},
				{
					"featureType": "water",
					"stylers": [
						{
							"hue": "#0078FF"
						},
						{
							"saturation": -13.200000000000003
						},
						{
							"lightness": 2.4000000000000057
						},
						{
							"gamma": 1
						}
					]
				},
				{
					"featureType": "poi",
					"stylers": [
						{
							"hue": "#00FF6A"
						},
						{
							"saturation": -1.0989010989011234
						},
						{
							"lightness": 11.200000000000017
						},
						{
							"gamma": 1
						}
					]
				}
				]
			};
			var
			marker;
			mapObject = new google.maps.Map(document.getElementById('map'), mapOptions);
			for (var key in markersData)
				markersData[key].forEach(function (item) {
					marker = new google.maps.Marker({
						position: new google.maps.LatLng(item.location_latitude, item.location_longitude),
						map: mapObject,
						icon: base_url+'/img/pins/' + key + '.png',
					});

					if ('undefined' === typeof markers[key])
						markers[key] = [];
					markers[key].push(marker);
					google.maps.event.addListener(marker, 'click', (function () {
      closeInfoBox();
      getInfoBox(item).open(mapObject, this);
      mapObject.setCenter(new google.maps.LatLng(item.location_latitude, item.location_longitude));
     }));

	});
	
		function hideAllMarkers () {
			for (var key in markers)
				markers[key].forEach(function (marker) {
					marker.setMap(null);
				});
		};

		function closeInfoBox() {
			$('div.infoBox').remove();
		};

		function getInfoBox(item) {
			return new InfoBox({
				content:
				'<div class="marker_info" id="marker_info">' +
				'<img src="' + item.map_image_url + '" alt="'+ item.name_point +'" height="140" width="280"/>' +
				'<h3>'+ item.name_point +'</h3>' +
				'<span>'+ item.description_point +'</span>' +
				'<div class="marker_tools">' +
				'<form action="https://maps.google.com/maps" method="get" target="_blank" style="display:inline-block""><input name="saddr" value="'+ item.get_directions_start_address +'" type="hidden"><input type="hidden" name="daddr" value="'+ item.location_latitude +',' +item.location_longitude +'"><button type="submit" value="Get directions" class="btn_infobox_get_directions">Directions</button></form>' +
					'<a href="'+ item.url_point +'" class="btn_infobox_price">$'+ item.price +'</a>' +
					'</div>' +
					'<a href="'+ item.url_point + '" class="btn_infobox">Details</a>' +
				'</div>',
				disableAutoPan: false,
				maxWidth: 0,
				pixelOffset: new google.maps.Size(10, 125),
				closeBoxMargin: '5px -20px 2px 2px',
				closeBoxURL: "https://www.google.com/intl/en_us/mapfiles/close.gif",
				isHidden: false,
				alignBottom: true,
				pane: 'floatPane',
				enableEventPropagation: true
			});


		};

    });