function initialize() {
		var mapProp = {
			center:new google.maps.LatLng(51.763934, 18.091509),
			zoom:16,
			mapTypeId:google.maps.MapTypeId.ROADMAP,
			disableDefaultUI:true
		};
		var map=new google.maps.Map(document.getElementById("map"),mapProp);
	  
		var marker=new google.maps.Marker({
			position:new google.maps.LatLng(51.763934, 18.091509),
			});

			marker.setMap(map);
	}
	
	google.maps.event.addDomListener(window, 'load', initialize);