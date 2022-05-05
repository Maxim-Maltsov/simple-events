<?php

namespace App\Jobs;

use App\Events\FailVotingEvent;
use App\Events\VotingFinishedPhaseOneEvent;
use App\Events\VotingFinishedPhaseTwoEvent;
use App\Models\Voting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CalculateVotingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Voting $voting;
    public int $phase;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( Voting $voting, int $phase)
    {
        $this->voting = $voting;
        $this->phase = $phase;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $endVotingPhasesTime = $this->getEndVotingPhasesTime();

        while(true) {

            $nowTime = time();

            if ($nowTime >= $endVotingPhasesTime) {

                if ($this->phase == Voting::PHASE_1 ) {

                    if ($this->voting->hasWinnerEvent()) {

                        $this->voting->winned_event_id = $this->voting->getWinnerEvent()->id;
                        $this->voting->save();

                        VotingFinishedPhaseOneEvent::dispatch();
                        CalculateVotingJob::dispatch($this->voting, Voting::PHASE_2);
                        break;
                    }
                    else {

                        $this->voting->finished = 1;
                        $this->voting->save();

                        FailVotingEvent::dispatch();
                        break;
                    } 
                }

                if ($this->phase == Voting::PHASE_2 ) {

                    $this->voting->finished = 1;
                    $this->voting->save();

                    VotingFinishedPhaseTwoEvent::dispatch();
                    break;
                }
            }
        
            sleep(1);
        }
    }


    public function getEndVotingPhasesTime()
    {

        if ($this->phase == Voting::PHASE_1) {

            return ($this->voting->start_timestamp_phase_1 + $this->voting->time_phase_1);
        }

       if ($this->phase == Voting::PHASE_2) {

            return ($this->voting->start_timestamp_phase_2 + $this->voting->time_phase_2);
        }
    }
    
}
