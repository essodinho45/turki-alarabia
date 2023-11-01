import './bootstrap';

import moment from 'moment';

import Pikaday from 'pikaday';
import 'pikaday/css/pikaday.css';

window.Pikaday = Pikaday;

function playAudio() {
    var x = document.getElementById("audio");
    x.play();
}

window.playAudio = playAudio;
