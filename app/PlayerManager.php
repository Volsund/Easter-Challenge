<?php

namespace EasterChallenge;

class PlayerManager
{
    private array $players;

    public function __construct(array $players)
    {
        $this->players = $players;

    }

    public function activePlayers(): array
    {
        $activePlayers = [];
        foreach ($this->players as $player) {
            if ($player->getEggs() > 0) {
                $activePlayers[] = $player;
            }
        }
        return $activePlayers;
    }

   public function sortedByScore(): array
    {
        usort($this->players, array($this, 'mySort'));
        return $this->players;

    }

    public function mySort(Player $a, Player $b)
    {
        if ($a->getWins() == $b->getWins()) return 0;
        return ($a->getWins() < $b->getWins()) ? 1 : -1;
    }


}