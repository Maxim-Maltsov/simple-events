require('./bootstrap');

import Alpine from 'alpinejs';

import {createApp} from 'vue';
import axios from 'axios';
import { add } from 'lodash';


window.Alpine = Alpine;

Alpine.start();

const results = createApp({

    data() {

        return {

            voting:{},
            events:[],
        
            pagination: {},
            
            loading: true,
            errored: false,

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
 
        getVotingResults() {

            let config = {

                headers: {
                    Authorization: "Bearer " + token,
                }
            }

            axios
                .get('api/v1/voting-phase-two', config)
                .then( response => {
                    
                    this.voting = response.data.data.voting;
                    this.events = response.data.data.events;
                    this.totalSeconds = response.data.data.totalSeconds;
                    this.winnerEvent = response.data.data.winnerEvent;
                    this.members = response.data.data.members;
                    this.userMadeChoice = response.data.data.userMadeChoice;

                    if (this.userMadeChoice) {

                        this.accepted = true;
                    }
                })
                .catch( error => {
                    
                    this.errored = true;
                })
                .finally(() => (this.loading = false));

            this.startTimer();
        },

        takePart(action) {
            
            this.accepted = true;

            let config = {

                headers: {
                    Authorization: "Bearer " + token,
                }
            }
            
            axios.post('api/v1/members', {

                voting_id: this.voting.id,
                winned_event_id: this.winnerEvent.id,
                action: action,

              }, config)
              .then(function (response) {
                console.log(response);
              })
              .catch(function (error) {
                console.log(error);
              });
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
        
        
        this.getVotingResults();

        window.Echo.channel('active-voting')
                    .listen('AddedNewMemberEvent', (e) => {
                                    
                        this.action = e.action;
                        
                        if (this.action == this.YES) {
                            
                            this.members.push(e.user);
                        }
                    })
                    .listen('VotingFinishedPhaseTwoEvent', (e) => {
                                
                        if ( location.pathname != '/voting-finished' ) {
                                location.pathname = '/voting-finished';
                        }
                    });           
    }
    

}).mount('#results');