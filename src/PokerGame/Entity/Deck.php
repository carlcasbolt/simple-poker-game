<?php

namespace PokerGame\Entity;

class Deck
{
    /**
     * The cards in this deck
     * @var array
     */
    private $cards = [];

    public function __construct()
    {
        $this->reset();
    }

    /**
     * Get the total number of cards in the deck
     *
     * @return int
     */
    public function count()
    {
        return count($this->cards);
    }

    /**
     * Get all the cards currently left in the deck
     */
    public function getCards()
    {
        return $this->cards;
    }

    /**
     * Get the next card from the top of the deck
     */
    public function dealCard()
    {
        return array_pop($this->cards);
    }

    /**
     * Shuffle the deck
     */
    public function shuffle()
    {
        shuffle($this->cards);
        return $this;
    }

    /**
     * reset the deck back to a fresh pack in order
     */
    public function reset()
    {
        $this->cards = [];
        foreach(Card::allowedSuits as $suit) {
            foreach (Card::allowedValues as $value) {
                $this->cards[] = new Card($suit, $value);
            }
        }
        return $this;
    }
}
