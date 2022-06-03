
require('./bootstrap');

import Alpine from 'alpinejs';

import {createApp} from 'vue';
import axios from 'axios';
import { add } from 'lodash';


window.Alpine = Alpine;

Alpine.start();

const voting = createApp({

    data() {

        return {

            voting:{},
            events:[],
        
            pagination: {},
            
            loading: true,
            errored: false,

            votes: 0,
            send: false,
            userVoted: false,

            timerText: "00:00",
            totalSeconds: 0,
            intervalId: 0,
            minutes: 0,
            seconds: 0,
            
            winnerEvent: {},
            members: [],
            accepted: false,
            userMadeChoice: false,

            YES: 1,
            NO: 0,

            action:0,
        }
    },

    methods: {

        makeVotingPagination(data) {

            let pagination = {

                current_page: data.current_page,
                last_page: data.last_page,
                prev: data.prev_page_url,
                next: data.next_page_url,
            }

            this.pagination = pagination;
        },

        getVoting(page_url) {

            let url = page_url || 'api/v1/voting-phase-one';

            let config = {

                headers: {
                    Authorization: "Bearer " + token,
                }
            }
            
            axios
                .get( url, config)
                .then( response => {
                    
                    this.voting = response.data.data.voting;
                    this.events = response.data.data.events.data;
                    this.totalSeconds = response.data.data.totalSeconds;
                    this.votes = response.data.data.likesAmount;
                    this.userVoted = response.data.data.userVoted;

                    this.makeVotingPagination(response.data.data.events);
            
                    if (this.userVoted) {

                        this.send = true;
                    }
                })
                .catch( error => {
                    
                    this.errored = true;
                    console.log(error);
                })
                .finally(() => (this.loading = false));

            this.startTimer();
            },
            
            sendVote(id) {

                this.send = true;
    
                let config = {
    
                    headers: {
                        Authorization: "Bearer " + token,
                    }
                }
    
                axios.post('api/v1/likes', {
    
                    voting_id: this.voting.id,
                    event_id: id,
    
                  }, config)
                  .then(function (response) {
                    console.log(response);
                  })
                  .catch(function (error) {
                    console.log(error);
                  })
            },

            startTimer() {

                this.intervalId = setInterval(() => {
                  
                    this.minutes =parseInt(this.totalSeconds / 60, 10);
                    this.seconds =parseInt(this.totalSeconds % 60, 10);
    
                    this.minutes = this.minutes < 10 ? "0" + this.minutes : this.minutes;
                    this.seconds = this.seconds < 10 ? "0" + this.seconds : this.seconds;
                    this.timerText = this.minutes + ":" + this.seconds;
                    --this.totalSeconds;
    
                    if ( this.totalSeconds <= 0) {
    
                        this.stopTimer();
                    }
                    
                }, 1000);
              },
    
    
              clearTimer() {
    
                this.timerText= "00:00";
                this.totalSeconds= 0;
                this.intervalId= 0;
              },
    
              stopTimer() {
    
                clearInterval(this.intervalId);
                this.clearTimer;
              }
            
    },

    mounted() {

        this.getVoting(); 
        
        window.Echo.channel('active-voting')
        .listen('StartVotingEvent', (e) => {
            
            if ( location.pathname != '/voting-events' ) {
                 location.pathname = '/voting-events';
            }
        })
        .listen('AddedNewLikeEvent', (e) => {
            
            if ( this.votes < e.likesAmount ) {
                 this.votes = e.likesAmount;
                
            }
        })
        .listen('VotingFinishedPhaseOneEvent', (e) => {
            
            if ( location.pathname != '/voting-results' ) {
                 location.pathname = '/voting-results';
            }
        })
        .listen('FailVotingEvent', (e) => {
            
            if ( location.pathname != '/voting-failed' ) {
                 location.pathname = '/voting-failed';

                 this.stopTimer();
            }
        })
    }
    

}).mount('#voting');