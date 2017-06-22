<template>
    <div>
<div class="col-sm-12" style="padding: 0px;">
    <div class="col-xs-4 col-md-3 pull-left" style="padding-left: 0px;">
        <ul v-for="contact in contacts" style="position: relative; bottom: 0px;">
            <li v-for="person in contact" style="border-bottom:solid 1px #ebebeb; margin: 4px 0px; cursor: pointer">
                <div @click="chat(person.id, $event)" style="padding: 5px; padding-left: 0px; padding-right: 0px; margin-left: 0px;">
                    <span class="pull-left" style="display: inline-block;">
                       {{ person.first_name}}{{ person.last_name}}<br />
                       {{ person.email }}<br />
                   </span>
                    <span class="pull-right valign-wrapper" style="margin-top: 10px; display: inline-block;">
                        <span v-bind:id="person.id" style="display: none;" class="new badge"></span>
                    </span>
                    <div class="clearfix"></div>
                </div>

                <div class="clearfix"></div>
            </li>
        </ul>
    </div>
    <div class="col-xs-8 col-sm-8 col-md-9 pull-right" style="border-left: solid 1px #ebebeb; padding-right: 0px;">
        <ul v-for="convo in last_convo">
            <li v-for="con in convo" >
                <div class="section" style="display: block; text-align: left;">

                <strong>From: </strong> {{con.from}}<br />
                <strong>Subject: </strong> {{con.subject}}<br />
                {{con.body}}
                    <div class="clearfix"></div>
                    <div class="divider"></div>
                    </div>
            </li>
            <!--<li v-if="messages">-->
                <!--<p v-for="message in messages" class="truncate"> <span v-if="message">{{message.subject}} {{message.body}}</span></p>-->
            <!--</li>-->
        </ul>
    </div>
</div>

        <!--<ul>-->
            <!--<li v-for="message in messages">-->
                <!--{{ message }}-->
            <!--</li>-->
        <!--</ul>-->

        <div class="clearfix"></div>
        <div class="col-md-9 pull-right">
            <div class="form-group">
                <label for="chatmessage"></label>
                <textarea class="form-control" rows="5" id="chatmessage" v-model="chatmessage"></textarea>
            </div>
            <button class="btn btn-primary pull-right" @click="sendChat(chatwith, chatmessage)">Send</button>
        </div>
    </div>
</template>
<script>

    var socket = io('http://192.168.10.10:3000');

    export default{
        props:{

        },
        data: function(){
            return{
                messages: [],
                user: '',
                contacts: [],
                last_convo: [],
                newmessage: '',
                chatwith: [],
                chatmessage: [],
            }
        },
        watch: {
            chatwith: function(el) {

            },
        },
        methods: {

            sendChat: function(user, chatmessage)
            {
                axios.post('/create_message', {
                    type: 'broadcast',
                    subject: 'chat message',
                    body: chatmessage,
                    status: 'send',
                    recipient: user,
                }).then(function(response){
                            this.chat(user);
                            var chatbox = document.getElementById('chatmessage');
                    chatbox.value='';
                    this.chatmessage = '';

                        }.bind(this))
                        .catch(function(error){
                            console.log(error)
                        });
            },

            chat: function(person, e)
            {
                this.last_convo = [];
                this.chatwith = [person];

                axios.get('/get-messages/?id='+person)
                        .then(function(response){
                            this.last_convo.push(response.data);
                        }.bind(this))
                        .catch(function(error){
                            console.log(error)
                        });

            },
            getMessages: function()
            {
                var getmessages = axios.create();

                let mycontacts = this.contacts;
                let convo = this.last_convo;
                let chatuser = this.chatwith;
                getmessages({
                    method: 'get',
                    url: '/get-messages/',
                }).then(function (response) {
                    mycontacts.push(response.data.contacts.company_contacts);
                    convo.push(response.data.last_convo);
                    chatuser.push(response.data.latest_chat.last_contact.id);
                }).catch(function (error) {
                    console.log(error);
                });
            }
        },
        mounted: function()
        {
            this.getMessages();
            socket.on('get-messages:App\\Events\\UserSentMessage', function(data) {

                this.user = data.user.id;
                this.newmessage = data.message;

                if(data.message)
                {
                    var newbutton = document.getElementById(this.newmessage.sender);
                    if(newbutton)
                    {
                        document.getElementById(this.newmessage.sender).style.display = "block";
                    }
                }
            this.messages.push(data.message);
            }.bind(this));

        }
    }
</script>