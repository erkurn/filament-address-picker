import { Loader } from '@googlemaps/js-api-loader';

export default (Alpine) => {
    Alpine.data('addressPickerFormComponent', ({
        state,
        api_key
    }) => {
        const loader = new Loader({
            apiKey: api_key,
            version: "weekly",
            libraries: ["places"],
        });

        return {
            state,
            api_key,
            map: null,
            marker: null,
            coordinate: {
                lat: 0,
                lng: 0
            },
            init: function() {
                if (!(this.state === null || this.state === '')) {
                    this.setState(this.state)
                }

                loader.loadCallback(e => {
                    if (e) {
                        console.log(e)
                    }

                    this.map = new google.maps.Map(this.$refs.map_container, {
                        zoom: 16,
                        center: this.coordinate,
                        streetViewControl: false
                    });

                    if (!this.is_coordinate(this.state)) {
                        const request = {
                            query: this.state,
                            fields: ["name", "geometry"],
                        };
                        let service = new google.maps.places.PlacesService(this.map)
                        service.findPlaceFromQuery(request, (results, status) => {
                            if (status === google.maps.places.PlacesServiceStatus.OK && results) {
                                this.createMark(results[0].geometry.location)
                                this.map.setCenter(results[0].geometry.location);
                            }
                        });
                    }

                    this.createMark()
                })
            },
            createMark: function (position) {
                let map = this.map;
                this.marker = new google.maps.Marker({
                    position: position || this.coordinate,
                    map,
                    title: "Mark",
                    draggable: true
                });

                const parent = this;
                google.maps.event.addListener(this.marker, 'dragend', function(marker) {
                    var latLng = marker.latLng;
                    state = latLng.lat() + ',' + latLng.lng();
                    parent.setState(state);
                });
            },
            is_coordinate: function(value) {
                try {
                    let lat = value.split(',')[0];
                    let lng = value.split(',')[1]

                    return (isFinite(lat) && Math.abs(lat) <= 90) && (isFinite(lng) && Math.abs(lng) <= 180);
                } catch (e) {
                }
                return false;
            },
            setState: function (value) {
                this.state = value;
                if (this.is_coordinate(value)) {
                    this.coordinate.lat = parseFloat(value.split(',')[0]);
                    this.coordinate.lng = parseFloat(value.split(',')[1]);
                }
            },
        }
    })
}
