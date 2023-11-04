import './bootstrap';

import moment from 'moment';

import Pikaday from 'pikaday';
import 'pikaday/css/pikaday.css';

window.Pikaday = Pikaday;

var channel = window.Pusher.subscribe('user.' + window.UserId);

channel.bind('notification', function (data) {
    var x = document.getElementById("audio");
    x.play();
});
