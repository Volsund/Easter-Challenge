<?php
require_once __DIR__ . '/vendor/autoload.php';

use EasterChallenge\Player;
use EasterChallenge\Battle;
use EasterChallenge\PlayerManager;
use EasterChallenge\DataHandler;
use Medoo\Medoo;

$databaseConfig = require_once __DIR__ . '/config/database.php';

$database = new Medoo($databaseConfig);

while (true) {
    echo PHP_EOL;
    echo " +------------------------------------+\n";
    echo " |  Welcome to Egg Battle Simulator!  | \n";
    echo " +------------------------------------+\n";
    echo "       What would you like to do? \n\n";
    echo "       Register new player:      1\n";
    echo "       Start battle simulation:  2\n";
    echo "       Show all player stats:    3 \n";
    echo "       Show last 50 battles:     4 \n";
    echo "       Exit:                     5 \n\n";

    $choice = (int)readline();

    switch ($choice) {

        case 1:
            $name = readline(" Please enter player name: \n");
            $newPlayer = new Player($name);
            if ($database->has('players', [
                'name' => $name
            ])) {
                throw new InvalidArgumentException("Name already registered in database!\n");
            }
            DataHandler::addNewPlayer($database, $newPlayer);

            echo " Player '$name' has been successfully registered!\n\n";

            break;

        case 2:

            $players = DataHandler::importPlayers($database);

            if (count($players) < 2) {
                echo "Not enough players. Game cannot start! \n";
                exit;
            }

            $winner = false;
            $round = 1;
            $manager = new PlayerManager($players);

            while (!$winner) {

                //Check how many players left with 1 or more eggs
                $playersLeft = $manager->activePlayers();

                //Choose 2 random players to battle
                $fighter1 = array_rand($playersLeft);
                $fighter2 = array_rand($playersLeft);
                if ($fighter1 === $fighter2) {
                    continue;
                }

                //Make new Battle object with 2 players
                $battle = new Battle($playersLeft[$fighter1], $playersLeft[$fighter2]);
                $battle->fight();

                //Add battle to battle history database
                DataHandler::addBattle($database, $battle);

                echo 'Round ' . $round . '  |  ' . $battle->getFighters();
                echo '  |  Winner: ' . $battle->getWinner()->getName() . ' : ' . $battle->getWinner()->getEggs()
                    . ' eggs.' . PHP_EOL;
                $round++;

                //Check if only 1 active player/winner left
                if (count($manager->activePlayers()) === 1) {
                    echo $manager->activePlayers()[0]->getName() . ' is winner with '
                        . $manager->activePlayers()[0]->getEggs() . ' eggs!!! CONGRATULATIONS!' . PHP_EOL;
                    $winner = true;
                }

                //Add win/loss to database to respective players.
                DataHandler::addWinToDatabase($database, $battle);
                DataHandler::addLossToDatabase($database, $battle);

                sleep(1);
            }
            break;

        case 3:
            $manager = new PlayerManager(DataHandler::importPlayers($database));
            echo '+---------Score list:---------- ' . PHP_EOL;
            $counter = 1;
            foreach ($manager->sortedByScore() as $player) {
                echo '| ' . $counter . '#  ' . $player->getName() . ' : ' . $player->getWins() . ' wins ' . PHP_EOL;
                $counter++;
            }

            break;
        case 4:
            echo '------------------------------------Last 50 Battles---------------------------------------------' . PHP_EOL;
            $counter = 1;

            //Import and show last 50 battles from database.
            foreach (DataHandler::importLastBattles($database) as $battle) {
                if ($counter <= 50) {
                    echo $battle['id'] . '  |  Winner: ' . $battle['winner'] . '  |  Loser: ' . $battle['loser']
                        . '  |  Battle date: ' . $battle['created_at'] . PHP_EOL;
                }
                $counter++;

            }
            break;

        case 5;
            exit;
            break;
    }
    sleep(3);
}