
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


window.Vue = require('vue');

//window.Echo = require("laravel-echo");
//
//window.Echo = new Echo({
//    driver: 'redis',
//    broadcaster: 'socket.io',
//    host: 'http://192.168.10.10:3000'
//});
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));
Vue.component('messages', require('./components/Messages.vue'));
Vue.component('mydatepicker', require('./components/DatePicker.vue'));
Vue.component('manage-meetings', require('./components/ManageMeetings.vue'));
Vue.component('edit-meeting', require('./components/EditMeeting.vue'));
Vue.component('meeting-page', require('./components/MeetingPage.vue'));



//
const app = new Vue({
    el: '#app'
});

console.log(window.location.pathname);
if(window.location.pathname=='/createevent')
{

    $('#app-tabs .active').removeClass('active');
    $('.tab-content .active').removeClass('active');

    $('#app-tabs').find('.event').addClass('active');
    $('.tab-content .event').addClass('active');
}
if(window.location.pathname=='/your-events'){
    $('#app-tabs .active').removeClass('active');
    $('.tab-content .active').removeClass('active');

    $('#app-tabs').find('.your-events').addClass('active');
    $('.tab-content .your-events').addClass('active');
}


//    socket.on("test-channel:App\\Events\\UserSignedUp", function(data){
//        // increase the power everytime we load test route
//        console.log(data);
//        console.log('test');
//    });
//var socket = io('http://192.168.10.10:3000');
//
//new Vue({
//
//    el: '#messageapp',
//    data: {
//        users: [],
//        messages: []
//    },
//    mounted: function() {
//        socket.on('get-messages:App\\Events\\UserSentMessage', function(data) {
//            console.log(data);
//            this.users.push(data.username);
//            this.messages.push(data.message);
//        }.bind(this));
//    }
//})

document.onreadystatechange = function () {



};