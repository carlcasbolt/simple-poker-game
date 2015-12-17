<?php

namespace PokerGame\Command;

use PokerGame\Entity\Deck;
use PokerGame\Entity\Card;
use PokerGame\Entity\Player;
use PokerGame\Exception;

class PokerCommand
{
    /**
     * The pack of cards
     * @var Deck
     */
    private $deck;

    /**
     * Current players
     * @var array
     */
    private $players = [];

    public function __construct(Deck $deck)
    {
        $this->deck = $deck;
    }

    /**
     * add a new player to the game - will throw an exception if cards are currently
     * in play - as you cannot join mid deal.
     *
     * @param Player $player
     * @return PokerGame
     * @throws PokerGame\Exception if cards have already been dealt
     */
    public function addPlayer(Player $player)
    {
        if ($this->deck->count() < 52) {
            throw new Exception('You cannot add players once a card has been dealt.');
        }
        $this->players[] = $player;
        return $this;
    }

    /**
     * get all the current players in this game
     */
    public function getPlayers()
    {
        return $this->players;
    }

    /**
     * get all the cards currently in the deck
     */
    public function getDeck()
    {
        return $this->deck;
    }

    /**
     * Shuffle the cards in the deck - you shouldn't re-shuffle the deck once a card
     * has been dealt.
     *
     * We'll shuffle the cards 3 times here, because no dealer would accept just one shuffle
     *
     * @return PokerCommand
     * @throws PokerGame\Exception if cards have already been dealt
     */
    public function shuffleCards()
    {
        if ($this->deck->count() < 52) {
            throw new Exception('You cannot add players once a card has been dealt.');
        }
        $this->deck->shuffle();
        $this->deck->shuffle();
        $this->deck->shuffle();
        return $this;
    }

    /**
     * deal 7 cards to each player
     *
     * @return PokerCommand
     * @throws PokerGame\Exception
     */
    public function dealCards()
    {
        if (count($this->players) < 2) {
            throw new Exception('You cannot deal the cards until more players have joined.');
        }

        for ($i = 0; $i < 7; $i++) {
            foreach ($this->players as $player) {
                $player->addCard($this->deck->dealCard());
            }
        }
        return $this;
    }

    /**
     * Return a string representing the status of this game
     *
     * @return string
     */
    public function displaySummary()
    {
        $output[] = "------------------";
        $output[] = "Poker Game Summary";
        $output[] = "------------------";

        foreach ($this->players as $player) {
            $output[] = $player->displaySummary();
        }
        $output[] = '';
        return implode("\n", $output);
    }
}
