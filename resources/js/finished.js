
require('./bootstrap');

import Alpine from 'alpinejs';

import {createApp} from 'vue';
import axios from 'axios';
import { add } from 'lodash';

window.Alpine = Alpine;

Alpine.start();

const finished = createApp({

    data() {

      
    },

    mounted() {
       
        window.Echo.channel('active-voting')
                .listen('StartVotingEvent', (e) => {
                    
                    if ( location.pathname != '/voting-events' ) {
                         location.pathname = '/voting-events';
                    }
                })
    }

}).mount('#finished');