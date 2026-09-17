/* Backend-powered Google Maps/Places helper
   - Loads map with a domain-restricted MAP API key (already on the page)
   - Uses backend endpoints with IP-restricted PLACE API key for:
     - Autocomplete:  GET /api/get-map-places-list?input=...
     - Details/Geocode: GET /api/get-map-place-details?place_id=... OR ?latitude=..&longitude=..
*/
(function(global){
    function createSuggestionsContainer($input){
        var $existing = $input.next('#places-suggestions');
        if($existing.length){ return $existing; }
        var $suggestions = $('<div id="places-suggestions" class="list-group" style="position:absolute; z-index: 2000; width: 100%;"></div>');
        $input.after($suggestions); // positioned in normal flow; page should handle layout
        return $suggestions;
    }

    function setFromGeocodeResult(result, latLngObj, selectors, map, marker){
        var address_components = (result && result.address_components) ? result.address_components : [];
        var city, state, country, full_address;
        for (var i = 0; i < address_components.length; i++) {
            var types = address_components[i].types || [];
            if (types.indexOf('locality') !== -1) {
                city = address_components[i].long_name;
            } else if (types.indexOf('administrative_area_level_1') !== -1) {
                state = address_components[i].long_name;
            } else if (types.indexOf('country') !== -1) {
                country = address_components[i].long_name;
            }
        }
        full_address = result && result.formatted_address ? result.formatted_address : '';
        if(selectors.inputSelector){ $(selectors.inputSelector).val(city || ''); }
        if(selectors.citySelector){ $(selectors.citySelector).val(city || ''); }
        if(selectors.countrySelector){ $(selectors.countrySelector).val(country || ''); }
        if(selectors.stateSelector){ $(selectors.stateSelector).val(state || ''); }
        if(selectors.addressSelector){ $(selectors.addressSelector).val(full_address || ''); }
        if(selectors.latitudeSelector){ $(selectors.latitudeSelector).val(latLngObj.lat); }
        if(selectors.longitudeSelector){ $(selectors.longitudeSelector).val(latLngObj.lng); }

        var gLatLng = new google.maps.LatLng(latLngObj.lat, latLngObj.lng);
        map.setCenter(gLatLng);
        map.setZoom(17);
        marker.setPosition(gLatLng);
        marker.setVisible(true);
    }

    function fetchPlaceDetails(params){
        return $.get('/api/get-map-place-details', params);
    }

    function attachAutocomplete($input, selectors, map, marker){
        var $suggestions = createSuggestionsContainer($input);
        var debounceTimer;
        $input.on('input', function(){
            clearTimeout(debounceTimer);
            var q = $(this).val();
            if(!q || q.length < 3){ $suggestions.empty().hide(); return; }
            debounceTimer = setTimeout(function(){
                $.get('/api/get-map-places-list', { input: q })
                    .done(function(resp){
                        var data = resp && resp.data ? resp.data : {};
                        var preds = data.predictions || [];
                        $suggestions.empty();
                        preds.slice(0,7).forEach(function(p){
                            var text = p.description || (p.structured_formatting && p.structured_formatting.main_text) || '';
                            var $item = $('<a href="#" class="list-group-item list-group-item-action"></a>');
                            $item.text(text);
                            $item.on('click', function(e){
                                e.preventDefault();
                                $suggestions.empty().hide();
                                if(p.place_id){
                                    fetchPlaceDetails({ place_id: p.place_id }).done(function(r){
                                        var d = r && r.data ? r.data : {};
                                        var results = d.result ? [d.result] : (d.results || []);
                                        if(results.length){
                                            var geo = (results[0].geometry && results[0].geometry.location) || {};
                                            if(typeof geo.lat === 'number' && typeof geo.lng === 'number'){
                                                setFromGeocodeResult(results[0], { lat: geo.lat, lng: geo.lng }, selectors, map, marker);
                                            }
                                        }
                                    });
                                }
                            });
                            $suggestions.append($item);
                        });
                        if(preds.length){ $suggestions.show(); } else { $suggestions.hide(); }
                    });
            }, 300);
        });
    }

    function initBackendPlacesMap(options){
        var selectors = options || {};
        var defaultLat = parseFloat($(selectors.defaultLatitudeSelector || '#default-latitude').val() || -33.8688);
        var defaultLng = parseFloat($(selectors.defaultLongitudeSelector || '#default-longitude').val() || 151.2195);
        if (isNaN(defaultLat)) defaultLat = -33.8688;
        if (isNaN(defaultLng)) defaultLng = 151.2195;

        var mapEl = document.getElementById(selectors.mapElementId || 'map');
        var map = new google.maps.Map(mapEl, {
            center: { lat: defaultLat, lng: defaultLng },
            zoom: 15
        });
        var marker = new google.maps.Marker({
            draggable: true,
            position: { lat: defaultLat, lng: defaultLng },
            map: map,
            anchorPoint: new google.maps.Point(0, -29)
        });

        // Marker drag → reverse geocode via backend
        google.maps.event.addListener(marker, 'dragend', function(event) {
            var lat = event.latLng.lat();
            var lng = event.latLng.lng();
            fetchPlaceDetails({ latitude: lat, longitude: lng })
                .done(function(resp){
                    var data = resp && resp.data ? resp.data : {};
                    var results = data.results || [];
                    if(results.length){
                        setFromGeocodeResult(results[0], {lat: lat, lng: lng}, selectors, map, marker);
                    }
                });
        });

        // Text input → backend autocomplete + details
        if (selectors.inputSelector) {
            attachAutocomplete($(selectors.inputSelector), selectors, map, marker);
        }

        return { map: map, marker: marker };
    }

    global.initBackendPlacesMap = initBackendPlacesMap;
})(window);


