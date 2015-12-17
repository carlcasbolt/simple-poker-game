<?php

require 'bootstrap.php';

use PokerGame\Command\PokerCommand;
use PokerGame\Entity\Deck;
use PokerGame\Entity\Player;

$pokerCommand = new PokerCommand(new Deck());

// lets shuffle the cards
$pokerCommand->shuffleCards();

// 4 players join the table
for($i = 0; $i < 4; $i++) {
    $pokerCommand->addPlayer(new Player());
}

// deal the cards to the players
$pokerCommand->dealCards();

// display a summery of the players and the cards they are holding
echo $pokerCommand->displaySummary();
