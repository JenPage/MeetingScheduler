<template>

    <div>

    <div class="clearfix"></div>

        <div class="col-sm-12" v-for="meeting in meetings">

            <h5>Edit Event</h5>
            <p id="edited-event" style="display: none" class="bg-success">Event Saved</p>
            <div class="clearfix"></div><br />

            <div class=" col-sm-6 col-sm-offset-3" >
                <select class="browser-default" v-model="meeting.type">
                    <option value="">Event Type</option>
                    <option value="1">Public Conference</option>
                    <option value="2">Private Conference</option>
                    <option value="3">Public Meeting</option>
                    <option value="3">Private Meeting</option>
                </select>
            </div>

            <div class="clearfix"></div><br />

            <div class="form-group col-xs-6 col-xs-offset-0 col-sm-5 col-sm-offset-1" style="border: solid 1px #ebebeb; border-radius: 2px;">
                <label for="date-from" class="col-2 col-form-label pull-left" style="font-size: 16px; font-weight: bold; margin-top: 8px; margin-left: 10px;">Date From: </label>
                <div class="col-sm-12 pull-right">
                    <input class="form-control" type="date" value=""  v-model="meeting.date_from" id="date-from">
                </div>
            </div>

            <div class="form-group col-xs-6 col-xs-offset-0 col-sm-5 col-sm-offset-0" style="border: solid 1px #ebebeb; border-radius: 2px;">
                <label for="date-to" class="col-2 col-form-label pull-left" style="font-size: 16px; font-weight: bold; margin-top: 8px; margin-left: 10px;">Date To: </label>
                <div class="col-sm-12 pull-right">
                    <input class="form-control" type="date" value="" v-model="meeting.date_to" id="date-to">
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row" style="border: solid 1px #ebebeb; border-radius: 2px; padding: 5px">
                <div class="col-sm-3 pull-left">
                    <label class="pull-left" style="font-size: 16px; font-weight: bold; margin-top: 8px; margin-left: 10px; color: #9e9e9e">Event Description: </label>
                </div>
                <div class="col-sm-7">
                    <textarea v-model="meeting.description" class="materialize-textarea"></textarea>
                </div>
            </div>

            <div class="clearfix"></div>


        </div>

        <div class="clearfix"></div>

        <div id="floating-panel">
            <input id="place-id" type="hidden" v-model="placeid" value="">
        </div>

        <div id="map" style="height: 200px;"></div>

        <div class="clearfix"></div>
        <div class="col-md-12">
            <input id="pac-input" class="controls" type="text"  placeholder="Enter Location" v-model="address">

            <div id="infowindow-content">
                <span id="place-name"  class="title"></span><br>
                <input type="hidden" value="" id="place-id2" v-model="placeid"/><br>
                <span id="place-address"></span>
            </div>
        </div>
        <div class="clearfix"></div>
        <input type="hidden" id="newplace" v-model="newplaceid" value=""/>

        <button type="button" class="pull-left btn btn-primary red" @click="deleteMeeting()">Delete</button>
        <button type="button" class="pull-right btn btn-primary" @click="updateMeeting()">Save</button>

    </div>

</template>

<script>
    export default {
        data: function(){
            return{
                meetings: [],
                contacts: [],
                invitees: [],
                meeting_invite: '',
                invites: [],
                addedinvite: [],
                event_description: [],
                date_from: '',
                date_to: '',
                placeid: '',
                newplaceid: '',
                address: ''
            }
        },
        methods:{

            clearplace: function()
            {
              this.placeid='';
            },

            updateMeeting: function()
            {
                var placeid = document.getElementById('newplace').value;
                var address = document.getElementById('pac-input').value;

                if(placeid)
                {
                    this.meetings[0].placeid =  placeid;
                }

                this.meetings[0].location = address;
                console.log(address, placeid);

                axios.post('/save-meeting/', {
                    meeting: this.meetings[0],
                }).then(function(response){
                            console.log(response);
                        }.bind(this))
                        .catch(function(error){
                            console.log(error)
                        });
            },

            deleteMeeting: function()
            {

                axios.get('/delete-meeting'+window.location.search).
                then(function(response){
                            console.log(response);
                        }.bind(this))
                        .catch(function(error){
                            console.log(error)
                        });
            },

            edit: function(meeting_id)
            {
                axios.get('/meeting-invite/?meeting_id='+meeting_id)
                        .then(function(response){
                            this.contacts = [response.data.contacts.company_contacts];
                            this.invitees = [response.data.invitees[0]];
                            console.log(response);
                        }.bind(this))
                        .catch(function(error){
                            console.log(error)
                        });

            },
            invite: function(meeting_id)
            {
                this.meeting_invite = meeting_id;
                console.log(meeting_id);
                axios.get('/meeting-invite/?meeting_id='+meeting_id)
                        .then(function(response){
                            this.contacts = [response.data.contacts.company_contacts];
                            this.invitees = [response.data.invitees[0]];
                            console.log(response);
                        }.bind(this))
                        .catch(function(error){
                            console.log(error)
                        });

            },

            inviteContact: function(personid)
            {
                var invite = this.addedinvite;

                axios.post('/invite-contact', {
                    user_id: personid,
                    meeting_id: this.meeting_invite
                }).then(function(response){
                            var user = document.getElementById('added-user');
                            user.style.display="block";
                            setTimeout(function(){ user.style.display="none"; }, 1000);

                            invite.push(response.data[0]);

                            console.log(response);
                        }.bind(this))
                        .catch(function(error){
                            console.log(error)
                        });
            },

            getMeetings: function()
            {
                let mymeetings = this.meetings;
                let place = this.placeid;
                axios.get('/get-meetings/')
                        .then(function(response){
                            mymeetings.push(response.data['meetings'][0]);
                            this.invites.push(response.data['invites']);
                            this.placeid= mymeetings[0].placeid;
                            this.address = mymeetings[0].location;
                            console.log(this.placeid);
                            console.log(response.data);
                        }.bind(this))
                        .catch(function(error){
                            console.log(error)
                        });
            },

            editMeetings: function()
            {
                let mymeetings = this.meetings;
                let place = this.placeid;

                axios.get('/edit-meeting'+window.location.search)
                        .then(function(response){
                            console.log(response);
                            mymeetings.push(response.data['meeting'][0]);
                            this.invites.push(response.data['invites']);
                            this.placeid= mymeetings[0].placeid;
                            this.address = mymeetings[0].location;
                        }.bind(this))
                        .catch(function(error){
                            console.log(error)
                        });
            }
        },
        mounted() {

           // this.getMeetings();

            this.editMeetings();
            socket.on('get-messages:App\\Events\\UserMeetingInvite', function(data) {
                if(data)
                {
                    console.log(data);
                }
            }.bind(this));
        }
    }
</script>