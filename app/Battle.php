<?php

namespace EasterChallenge;

class Battle
{
    private Player $player1;
    private Player $player2;
    private Player $winner;
    private Player $loser;
    private string $createdAt;


    public function __construct(Player $player1, Player $player2, ?string $createdAt = null)
    {
        $this->player1 = $player1;
        $this->player2 = $player2;
        $this->createdAt = $createdAt ?? date(DATE_ATOM);
    }

    public function fight(): void
    {
        $roll = rand(0, 1);
        if ($roll === 0) {
            $this->player1->addWin();
            $this->player2->removeEgg();
            $this->player2->addLoss();
            $this->winner = $this->player1;
            $this->loser = $this->player2;
        }
        if ($roll === 1) {
            $this->player2->addWin();
            $this->player1->removeEgg();
            $this->player1->addLoss();
            $this->winner = $this->player2;
            $this->loser = $this->player1;
        }

    }

    public function getFighters(): string
    {
        return $this->player1->getName() . ' --VS-- ' . $this->player2->getName();
    }

    public function getWinner(): Player
    {
        return $this->winner;
    }

    public function getLoser(): Player
    {
        return $this->loser;
    }

    public function getDate(): string
    {
        return $this->createdAt;
    }




















    //     public static function fight(Player $player1, Player $player2)
//    {
//        $winOrLose = rand(0, 1);
//
//        if ($winOrLose === 0) {
//            $player1->addWin();
//            $player2->removeEgg();
//            return $player1;
//        } else {
//            $player2->addWin();
//            $player1->removeEgg();
//            return $player2;
//        }
//    }

}