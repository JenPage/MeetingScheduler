<template>
    <div>
        <div class="col-md-12">
            <h5>Location</h5>
            <input id="pac-input" class="controls" type="text"  placeholder="Enter Location" v-model="address">
            <div id="floating-panel">
                <input id="place-id" type="hidden" v-model="placeid" value="">
            </div>

            <div id="map" style="height: 200px;"></div>
            <div id="infowindow-content">
                <span id="place-name"  class="title"></span><br>
                <input type="hidden" value="" id="place-id2" v-model="placeid"/><br>
                <span id="place-address"></span>
            </div>
        </div>
        <div class="col-md-12">
            <h5>Announcements</h5>

        </div>
        <div class="col-md-12">
            <h5>Live Stream</h5>
            <div class="form-group">
                <label for="broadcastmessage"></label>
                    <textarea class="form-control" rows="5" id="broadcastmessage" v-model="broadcastmessage"></textarea>
            </div>
            <button class="btn btn-primary pull-right" @click="sendBroadcast(broadcastmessage)">Send</button>
        </div>


    </div>
</template>
<script>

    export default{
        data () {
            return {
                address: '',
                placeid: '',
                broadcastmessage: '',
                meeting: '',
                attendees: []
            }
        },
        methods: {
            getAnnouncements: function()
            {
                console.log(window.location);
                axios.get(window.location)
                        .then(function(response){
                            this.meeting = response.data.meeting[0];
                            this.attendees = response.data.users;
                            this.placeid = response.data.meeting[0].placeid;
                            this.address = response.data.meeting[0].location;
                            console.log(response);

                        }.bind(this))
                        .catch(function(error){
                            console.log(error)
                        });
            },
            sendBroadcast(broadcastmessage)
            {
                axios.post('/broadcast', {
                    broadcastmessage: this.broadcastmessage

                }).then(function(response){
                    console.log(response);
                        }.bind(this))
                        .catch(function(error){
                            console.log(error);
                        })
            }
        },
        mounted: function()
        {
            this.getAnnouncements();
        }
    }
</script>