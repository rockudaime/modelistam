console.log('hello2');
if (!window.GLOBAL_arMapObjects)
	window.GLOBAL_arMapObjects = {};

function init_MAP_NBnv7HYUIM()
{
	if (!window.google && !window.google.maps)
		return;

	var opts = {
		zoom: 16,
		center: new google.maps.LatLng(50.015584160077, 36.244976796722),
		scrollwheel: false,
		disableDoubleClickZoom: true,
		draggable: false,
		keyboardShortcuts: true,
		mapTypeControl: false,
		zoomControl: false,
		scaleControl: true,

		mapTypeId: google.maps.MapTypeId.ROADMAP
	};

	window.GLOBAL_arMapObjects['MAP_NBnv7HYUIM'] = new window.google.maps.Map(BX("BX_GMAP_MAP_NBnv7HYUIM"), opts);

}

BX.ready(init_MAP_NBnv7HYUIM);

/* if map inits in hidden block (display:none),
*  after the block showed,
*  for properly showing map this function must be called
*/
function BXMapGoogleAfterShow(mapId)
{
	if(google.maps !== undefined && window.GLOBAL_arMapObjects[mapId] !== undefined)
		google.maps.event.trigger(window.GLOBAL_arMapObjects[mapId],'resize');
}
function BX_SetPlacemarks_MAP_NBnv7HYUIM()
{
	BX_GMapAddPlacemark({'TEXT':'Магазин','LON':'36.243917942047','LAT':'50.015240464108'}, 'MAP_NBnv7HYUIM');
}

function BXShowMap_MAP_NBnv7HYUIM() {
	if(typeof window["BXWaitForMap_view"] == 'function')
	{
		BXWaitForMap_view('MAP_NBnv7HYUIM');
	}
	else
	{
		/* If component's result was cached as html,
		 * script.js will not been loaded next time.
		 * let's do it manualy.
		*/

		(function(d, s, id)
		{
			var js, bx_gm = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "/bitrix/components/bitrix/map.google.view/templates/.default/script.js";
			bx_gm.parentNode.insertBefore(js, bx_gm);
		}(document, 'script', 'bx-google-map-js'));

		var gmWaitIntervalId = setInterval( function(){

				if(typeof window["BXWaitForMap_view"] == 'function')
				{
					BXWaitForMap_view("MAP_NBnv7HYUIM");
					clearInterval(gmWaitIntervalId);
				}
			}, 300
		);
	}
}

BX.ready(BXShowMap_MAP_NBnv7HYUIM);
