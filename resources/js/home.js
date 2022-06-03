
require('./bootstrap');

import Alpine from 'alpinejs';

import {createApp} from 'vue';
import axios from 'axios';
import { add } from 'lodash';


window.Alpine = Alpine;

Alpine.start();

const home = createApp({

    data() {

        return {

            events:[],
            pagination: {},
            
            loading: true,
            errored: false, 
        }
    },

    methods: {

        makePagination(data) {

            let pagination = {

                current_page: data.meta.current_page,
                last_page: data.meta.last_page,
                prev: data.links.prev,
                next: data.links.next,
            }

            this.pagination = pagination;
        },

        getEvents(page_url) {
            
            let url = page_url || 'api/v1/events';
    
            let config = {
    
                headers: {
                    Authorization: "Bearer " + token,
                }
            }
            
            axios
                .get( url , config)
                .then( response => {
                    
                    this.events = response.data.data;
                    this.makePagination(response.data);
                })
                .catch( error => {
                    
                    this.errored = true;
                    console.log(error);
                })
                .finally(() => (this.loading = false));
        },

    },

    mounted() {
        
        window.Echo.channel('events')
                   .listen('AddedNewEventEvent', (e) => {
                        
                       this.events.push(e.event);
                   });

        window.Echo.channel('active-voting')
                   .listen('StartVotingEvent', (e) => {
                        
                       if ( location.pathname != '/voting-events' ) {
                           location.pathname = '/voting-events';
                       }
                   });

        this.getEvents();
    }
    
}).mount('#home');