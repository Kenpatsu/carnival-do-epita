<?php
namespace Hackathon\PlayerIA;
use Hackathon\Game\Result;


class KenpatsuPlayer extends Player
{
    protected $mySide;
    protected $opponentSide;
    protected $result;

    /**
     * @return boolean
     * Check if we are in a loosing streak
     */
    protected function cCheck($list) {
        $act = $list[sizeof($list) - 6];
        for ($i = sizeof($list) - 5 ; $i < sizeof($list) - 1 ; $i++) {
            if ($list[$i] != $act)
                return false;
        }
        if ($this->result->getLastScoreFor($this->mySide) == 0)
            return true;
        return false;
    }

    public function getChoice()
    {
        $rockNumber = 0;
        $paperNumber = 0;
        $scissorsNumber = 0;
        $oppChoice = $this->result->getChoicesFor($this->opponentSide);
        $myChoice = $this->result->getChoicesFor($this->mySide);
        //Reach opp Choices list and count occurence of each type of choice
        foreach ($oppChoice as $choice) {
            if ($choice == parent::paperChoice())
                $paperNumber ++;
            if ($choice == parent::rockChoice())
                $rockNumber ++;
            if ($choice == parent::scissorsChoice())
                $scissorsNumber ++;
        }
        //If we are in a loosing streak, change choice for only one move to disturb algorithm
        if ($rockNumber + $scissorsNumber + $paperNumber > 6) {
            $check = $this->cCheck($myChoice);
            if ($check == true && $this->result->getLastChoiceFor($this->mySide) == parent::rockChoice())
                return parent::scissorsChoice();
            if ($check == true && $this->result->getLastChoiceFor($this->mySide) == parent::paperChoice())
                return parent::rockChoice();
            if ($check == true && $this->result->getLastChoiceFor($this->mySide) == parent::scissorsChoice())
                return parent::paperChoice();
        }
        //Count occurences and make choice
        if (($paperNumber > $rockNumber) && ($paperNumber > $scissorsNumber))
            return parent::scissorsChoice();
        if (($rockNumber > $paperNumber) && ($rockNumber > $scissorsNumber))
            return parent::paperChoice();
        if (($scissorsNumber > $paperNumber) && ($scissorsNumber > $rockNumber))
            return parent::rockChoice();
        return parent::paperChoice();
        // -------------------------------------    -----------------------------------------------------
        // How to get my Last Choice           ?    $this->result->getLastChoiceFor($this->mySide) -- if 0 (first round)
        // How to get the opponent Last Choice ?    $this->result->getLastChoiceFor($this->opponentSide) -- if 0 (first round)
        // -------------------------------------    -----------------------------------------------------
        // How to get my Last Score            ?    $this->result->getLastScoreFor($this->mySide) -- if 0 (first round)
        // How to get the opponent Last Score  ?    $this->result->getLastScoreFor($this->opponentSide) -- if 0 (first round)
        // -------------------------------------    -----------------------------------------------------
        // How to get all the Choices          ?    $this->result->getChoicesFor($this->mySide)
        // How to get the opponent Last Choice ?    $this->result->getChoicesFor($this->opponentSide)
        // -------------------------------------    -----------------------------------------------------
        // How to get my Last Score            ?    $this->result->getLastScoreFor($this->mySide)
        // How to get the opponent Last Score  ?    $this->result->getLastScoreFor($this->opponentSide)
        // -------------------------------------    -----------------------------------------------------
        // How to get the stats                ?    $this->result->getStats()
        // How to get the stats for me         ?    $this->result->getStatsFor($this->mySide)
        //          array('name' => value, 'score' => value, 'friend' => value, 'foe' => value
        // How to get the stats for the oppo   ?    $this->result->getStatsFor($this->opponentSide)
        //          array('name' => value, 'score' => value, 'friend' => value, 'foe' => value
        // -------------------------------------    -----------------------------------------------------
        // How to get the number of round      ?    $this->result->getNbRound()
        // -------------------------------------    -----------------------------------------------------
        // How can i display the result of each round ? $this->prettyDisplay()
        // -------------------------------------    -----------------------------------------------------

    }
};