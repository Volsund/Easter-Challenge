<?php

namespace EasterChallenge;


abstract class DataHandler
{

    public static function importPlayers($database): array
    {
        $rawPlayers = $database->select('players', '*');
        $players = [];
        foreach ($rawPlayers as $player) {
            $players[] = new Player($player['name'], $player['losses'], $player['wins'], $player['created_at']);
        }
        return $players;
    }

    public static function importLastBattles($database): array
    {

        $rawBattles = $database->select('games', '*');
        $allBattles = [];
        foreach ($rawBattles as $battle) {
            $allBattles[] = $battle;
        }
        $lastFiftyBattles =[];
        $counter = count($allBattles)-50;
        for($i=$counter; $i<50+$counter; $i++){
            $lastFiftyBattles[]=$allBattles[$i];
        }

        return $lastFiftyBattles;
    }

    public static function addNewPlayer($database, Player $newPlayer): void
    {
        $database->insert('players', [
            'name' => $newPlayer->getName(),
            'wins' => $newPlayer->getWins(),
            'created_at' => $newPlayer->getDate()
        ]);
    }

    public static function addBattle($database, Battle $battle): void
    {
        $database->insert('games', [
            'winner' => $battle->getWinner()->getName(),
            'loser' => $battle->getLoser()->getName(),
            'created_at' => $battle->getDate()
        ]);
    }

    public static function addWinToDatabase($database, Battle $battle): void
    {
        $database->update('players', [
            'wins[+]' => 1
        ], [
            'name' => $battle->getWinner()->getName()
        ]);
    }

    public static function addLossToDatabase($database, Battle $battle): void
    {
        $database->update('players', [
            'losses[+]' => 1
        ], [
            'name' => $battle->getLoser()->getName()
        ]);
    }

}