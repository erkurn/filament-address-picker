import { Loader } from '@googlemaps/js-api-loader';

export default (Alpine) => {
    Alpine.data('addressPickerFormComponent', ({
        state,
        api_key,
        zoom,
        controls,
        defaultLocation
    }) => {
        const loader = new Loader({
            apiKey: api_key,
            version: "weekly",
            libraries: ["places"],
        });

        return {
            state,
            api_key,
            markerLocation: {},
            init: function() {
                loader.loadCallback(e => {
                    if (e) {
                        console.log(e)
                    }

                    var valueLocation = null;
                    if (state instanceof Object) {
                        valueLocation = state.initialValue;
                    } else {
                        valueLocation = JSON.parse(state);
                    }

                    var center = {
                        lat: valueLocation?.lat || defaultLocation.lat,
                        lng: valueLocation?.lng || defaultLocation.lng
                    }

                    var map = new google.maps.Map(this.$refs.map_container, {
                        zoom: zoom,
                        center: center,
                        streetViewControl: false,
                        ...controls
                    });

                    var marker = new google.maps.Marker({
                        map
                    });

                    if (valueLocation?.lat && valueLocation?.lng) {
                        marker.setPosition(valueLocation);
                    }

                    map.addListener('click', (event) => {
                        this.markerLocation = event.latLng.toJSON();
                    });

                    if (controls.searchBoxControl) {
                        const input = this.$refs.map_search;
                        const searchBox = new google.maps.places.SearchBox(input);
                        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
                        searchBox.addListener("places_changed", () => {
                            input.value = ''
                            this.markerLocation = searchBox.getPlaces()[0].geometry.location
                        })
                    }

                    this.$watch('markerLocation', () => {
                        let position = this.markerLocation;
                        this.state = position;
                        marker.setPosition(position);
                        map.panTo(position);
                    })
                })
            },
        }
    })
}
