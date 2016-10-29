function BX_SetPlacemarks_MAP_d3nUMfwtNk(map)
{
	if(typeof window["BX_YMapAddPlacemark"] != 'function')
	{
		/* If component's result was cached as html,
		 * script.js will not been loaded next time.
		 * let's do it manualy.
		*/

		(function(d, s, id)
		{
			var js, bx_ym = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "/bitrix/templates/modelistam/components/bitrix/map.yandex.view/.default/script.js";
			bx_ym.parentNode.insertBefore(js, bx_ym);
		}(document, 'script', 'bx-ya-map-js'));

		var ymWaitIntervalId = setInterval( function(){
				if(typeof window["BX_YMapAddPlacemark"] == 'function')
				{
					BX_SetPlacemarks_MAP_d3nUMfwtNk(map);
					clearInterval(ymWaitIntervalId);
				}
			}, 300
		);

		return;
	}

	var arObjects = {PLACEMARKS:[],POLYLINES:[]};
	arObjects.PLACEMARKS[arObjects.PLACEMARKS.length] = BX_YMapAddPlacemark(map, {'LON':'30.522500782151','LAT':'50.405839888139','TEXT':'Салон и сервисный центр'});
}
var script = document.createElement('script');
			script.src = 'http://api-maps.yandex.ru/2.0/?load=package.full&mode=release&lang=ru-RU&wizard=bitrix';
			(document.head || document.documentElement).appendChild(script);
			script.onload = function () {
				this.parentNode.removeChild(script);
			};

if (!window.GLOBAL_arMapObjects)
	window.GLOBAL_arMapObjects = {};

function init_MAP_d3nUMfwtNk()
{
	if (!window.ymaps)
		return;

	var node = BX("BX_YMAP_MAP_d3nUMfwtNk");
	node.innerHTML = '';

	var map = window.GLOBAL_arMapObjects['MAP_d3nUMfwtNk'] = new ymaps.Map(node, {
		center: [50.390258902888, 30.56369951262],
		zoom: 11,
		type: 'yandex#map'
	});

	map.behaviors.enable("scrollZoom");
	map.behaviors.enable("dblClickZoom");
	map.behaviors.enable("drag");
	if (map.behaviors.isEnabled("rightMouseButtonMagnifier"))
		map.behaviors.disable("rightMouseButtonMagnifier");
	map.controls.add('zoomControl');
	map.controls.add('miniMap');
	map.controls.add('typeSelector');
	map.controls.add('scaleLine');
	if (window.BX_SetPlacemarks_MAP_d3nUMfwtNk)
	{
		window.BX_SetPlacemarks_MAP_d3nUMfwtNk(map);
	}
}
	ymaps.ready(init_MAP_d3nUMfwtNk);

/* if map inits in hidden block (display:none)
*  after the block showed
*  for properly showing map this function must be called
*/
function BXMapYandexAfterShow(mapId)
{
	if(window.GLOBAL_arMapObjects[mapId] !== undefined)
		window.GLOBAL_arMapObjects[mapId].container.fitToViewport();
}
