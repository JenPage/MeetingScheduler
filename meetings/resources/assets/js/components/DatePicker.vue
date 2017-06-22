<template>
    <div id="">

<div class="clearfix"></div><br />

        <div class=" col-sm-6 col-sm-offset-3" >
            <select class="browser-default" v-model="type">
                <option value="">Event Type</option>
                <option value="1">Public Conference</option>
                <option value="2">Private Conference</option>
                <option value="3">Public Meeting</option>
                <option value="3">Private Meeting</option>
            </select>

        </div>
<div class="clearfix"></div><br />
        <div class="form-group col-xs-6 col-xs-offset-0 col-sm-4 col-sm-offset-2" style="border: solid 1px #ebebeb; border-radius: 2px;">
            <label for="date-from" class="col-2 col-form-label pull-left" style="font-size: 16px; font-weight: bold; margin-top: 8px; margin-left: 10px;">Date From: </label>
            <div class="col-sm-12 pull-right">
                <input class="form-control" type="date" value=""  v-model="date_from" id="date-from">
            </div>
        </div>

        <div class="form-group col-xs-6 col-xs-offset-0 col-sm-4 col-sm-offset-1" style="border: solid 1px #ebebeb; border-radius: 2px;">
            <label for="date-to" class="col-2 col-form-label pull-left" style="font-size: 16px; font-weight: bold; margin-top: 8px; margin-left: 10px;">Date To: </label>
            <div class="col-sm-12 pull-right">
                <input class="form-control" type="date" value="" v-model="date_to" id="date-to">
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row" style="border: solid 1px #ebebeb; border-radius: 2px; padding: 5px">
            <div class="col-sm-3 pull-left">
                <label class="pull-left" style="font-size: 16px; font-weight: bold; margin-top: 8px; margin-left: 10px; color: #9e9e9e">Event Description: </label>
            </div>
            <div class="col-sm-7">
                <textarea v-model="event_description" class="materialize-textarea"></textarea>
            </div>
        </div>

        <div class="row">

            <div class="col-sm-12">
                <input id="pac-input" class="controls" type="text" placeholder="Enter a location">
                <div id="map"></div>
                <div id="infowindow-content">
                    <span id="place-name"  class="title"></span><br>
                    <span style="display: none" id="place-id" v-model="placeid" /><br>
                    <span id="place-address"></span>
                </div>
                <div class="clearfix"></div>
                <br />
                <button class="btn btn-primary pull-right" @click="createEvent()">Save</button>
            </div>

        </div>



    </div>
</template>



<script>

    import Datepicker from 'vuejs-datepicker';
    var state = {
        date1: new Date()
    }
    export default{

        data () {
            return {
                format: 'd MMMM yyyy',
                loc: 'test',
                range: {},
                eventMsg: null,
                state: state,
                placeid: '',
                place_address: '',
                event_description: '',
                date_to: '',
                date_from: '',
                type: '',
                meetings: [],
                invites: [],

            }
        },
        methods: {



            createEvent: function()
            {
                var place = document.getElementById('place-id');
                var place_id = place.innerHTML;
                var address = document.getElementById('place-address');
                var place_address = address.innerHTML;

                console.log(this.date_to, this.date_from);

                axios.post('/create_meeting', {
                    placeid: place_id,
                    description: this.event_description,
                    address: place_address,
                    from: this.date_from,
                    to: this.date_to,
                    type: this.type
                }).then(function(response){
                    console.log(response);
                        }.bind(this))
                        .catch(function(error){
                            console.log(error)
                        });

                axios.get('/get-meetings/')
                        .then(function(response){

//                            location.reload();
//                            var event = document.getElementById('edit-event');
//                            event.style.display="block";
//                            setTimeout(function(){ event.style.display="none"; }, 5000);


                        }.bind(this))
                        .catch(function(error){
                            console.log(error)
                        });
            },

            saveMeeting: function(){
                var meetingupdate = axios.create();
                meetingupdate({
                    method: 'post',
                    url: '/create_meeting/',
                    data: [this.range, this.loc],
//                    onDownloadProgress: function(progressEvent){
//                        // Event.fire('saving')
//                    }
                }).then(function (response) {
                  console.log('sent', response);
            }).catch(function (error) {
                    console.log(error);
                });
        }
    },
        mounted: function()
        {


        }
    }
</script>




