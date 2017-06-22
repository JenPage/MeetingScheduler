<template>
    <div>
        <div class="row">
            <div class="col-sm-12">
                <h5>Your Events</h5>
                <div v-for="meeting in meetings">

                    <ul style="border: solid 1px #ebebeb; border-radius: 2px; padding: 5px;">

                        <a :href="'/edit-meeting?meeting_id=' + meeting.id" class="pull-right" style="padding: 4px; margin: 4px;">
                            <i class="fa fa-pencil-square-o"></i>
                        </a>
                        <li><strong>Name:</strong> {{meeting.description}}</li>
                        <li><strong>Date:</strong> {{meeting.date_from}} - {{meeting.date_to}}</li>
                        <li><strong>Location: </strong>{{meeting.location}} <i class="fa fa-map-marker"></i></li>
                        <br />
                        <li><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#invite-modal" @click="invite(meeting.id)">Invite </button></li>
                        <br />
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <h4>Your Invites</h4>
                <div v-for="event in invites" style="border: solid 1px #ebebeb; border-radius: 2px; padding: 5px; margin: 3px;">
                    <!-- Single button -->
                    <div class="btn-group pull-right">
                        <button type="button" class="btn btn-sm btn-group-sm btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Status: {{event.response}} <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a @click="eventResponse('attending', event)" href="#"> <i v-if="event.response == 'attending'" class="fa fa-check"></i> Attending</a></li>
                            <li><a @click="eventResponse('declined', event)" href="#"> <i v-if="event.response == 'declined'" class="fa fa-check"></i> Not Attending</a></li>
                        </ul>
                        <br />
                        <a :href="'/event/'+event.meeting_id"  class="btn btn-default" >Go To Event Page <i class="fa fa-angle-right"></i></a>
                    </div>
                    <span class="pull-left col-sm-5 col-sm-offset-1">
                        <strong>Name: </strong>{{event.description}}<br />
                        <strong>Dates: </strong>{{event.date_from}} - {{event.date_to}}<br />
                        <strong>Location: </strong>{{event.location}}<br />
                    </span>
                    <div class="clearfix"></div>

                </div>
                <br />
            </div>
        </div>

        <div id="invite-modal" class="modal fade" role="dialog">
            <div  style="width: 100%; border-radius: 0px;">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Invite Contacts</h4>
                        <p id="added-user" style="display: none" class="bg-success">User Added</p>
                    </div>
                    <div class="clearfix"></div><br />
                    <div class="">
                       <div class="col-sm-4" v-for="contact in contacts" style="border-right: solid 1px #ebebeb">
                           <h5>Contacts</h5>
                           <ul v-for="person in contact">
                               <li>
                                   <div @click="inviteContact(person.id)" style="cursor:pointer; padding: 5px; border: solid 1px #ebebeb; border-radius: 2px;">
                                       {{person.first_name}} {{person.last_name}}<br />
                                       {{person.email}}
                                   </div>
                               </li>
                           </ul>
                           <div class="clearfix"></div>
                       </div>
                        <div class="col-sm-8" style="text-align: center;">
                        <h5>Invited Users</h5>
                        <ul>
                            <li v-if="addedinvite" v-for="invite in addedinvite">
                                {{invite.first_name}} {{ invite.last_name }} <br />
                                {{invite.email}}
                            </li>
                        </ul>
                        <ul v-for="invite in invitees" class="col-sm-6 col-sm-offset-3">
                            <li v-for="person in invite" style="padding: 5px; border: solid 1px #ebebeb">
                                    <span v-for="item in person">
                                        <span v-for="x in item">
                                            {{x.first_name}}{{x.last_name}}<br />
                                            {{x.email}}
                                        </span>
                                    </span>

                            </li>
                        </ul>
                    </div>


                        <div class="clearfix"></div>
                        <br />


                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
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
                placeid: ''
            }
        },
        methods:{

            eventResponse: function(response, event)
            {
                console.log(event.id);
                axios.post('/event-response', {
                    rsvp: response,
                    meeting_id: event.id
                }).then(function(response){

                            this.meetings = (response.data['meetings']);
                            this.invites = (response.data['invites'][0]);

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

                        }.bind(this))
                        .catch(function(error){
                            console.log(error)
                        });
            },

            getMeetings: function()
            {
                console.log('getting meetings');
                axios.get('/get-meetings/')
                        .then(function(response){
                            console.log(response);
                            this.meetings = (response.data['meetings']);
                            this.invites = (response.data['invites'][0]);
                        }.bind(this))
                        .catch(function(error){
                            console.log(error)
                        });
            }
        },
        mounted() {

            this.getMeetings();
            socket.on('invite-contact:App\\Events\\UserMeetingInvite', function(data) {
                if(data)
                {
                    this.getMeetings();
                   console.log('socketdata', data);
                }
            }.bind(this));
        }
    }
</script>

