<?php

namespace PokerGame\Entity;

use PokerGame\Exception;

class Card
{
    /**
     * The suit that this card belongs to
     * @var string
     */
    private $suit;

    /**
     * The value of this card
     * @var string
     */
    private $value;

    const allowedSuits = [
        'hearts',
        'clubs',
        'spades',
        'diamonds',
    ];

    const allowedValues = [
        'ace',
        'two',
        'three',
        'four',
        'five',
        'six',
        'seven',
        'eight',
        'nine',
        'ten',
        'jack',
        'queen',
        'king',
    ];

    public function __construct($suit, $value)
    {
        $this->setSuit($suit)->setValue($value);
    }

    /**
     * Get the suit for this card
     *
     * @return string
     */
    public function getSuit()
    {
        return $this->suit;
    }

    /**
     * Get the value of this card
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * clean output for when this class is echo'd to screen
     *
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s of %s', $this->getValue(), $this->getSuit());
    }

    /**
     * private setter methods because you should not be able to change the suit
     * or value of the card once created, but we use these to validate the inputs
     */

    /**
     * set the suit for this card
     *
     * @throws PokerGame\Exception if an invalid suit is passed in
     */
    private function setSuit($suit)
    {
        // force lower case - we'll forgive some people
        $suit = strtolower($suit);

        if (in_array($suit, self::allowedSuits) === false) {
            throw new Exception('Invalid Suit: ' . $suit);
        }
        $this->suit = $suit;

        return $this;
    }

    /**
     * set the value for this card
     *
     * @throws PokerGame\Exception if an invalid value is passed in
     */
    private function setValue($value)
    {
        // force lower case - we'll forgive some people
        $value = strtolower($value);

        if (in_array($value, self::allowedValues) === false) {
            throw new Exception('Invalid Value: ' . $value);
        }
        $this->value = $value;

        return $this;
    }
}
