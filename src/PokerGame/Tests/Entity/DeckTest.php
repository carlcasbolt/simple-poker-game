<?php

namespace PokerGame\Tests\Entity;

use PokerGame\Entity\Card;
use PokerGame\Entity\Deck;

class DeckTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function constructor()
    {
        $deck     = new Deck();
        $topCard  = new Card('diamonds', 'king');
        $lastCard = new Card('hearts', 'ace');

        self::assertCount(52, $deck->getCards());
        self::assertEquals($topCard, $deck->getCards()[51]);
        self::assertEquals($lastCard, $deck->getCards()[0]);
    }

    /**
     * @test
     */
    public function deckCount()
    {
        $deck = new Deck();
        self::assertSame(52, $deck->count());
    }

    /**
     * @test
     */
    public function getCards()
    {
        $deck = new Deck();
        self::assertCount(52, $deck->getCards());
    }

    /**
     * @test
     */
    public function dealCard()
    {
        $expectedCards = [
            new Card('diamonds', 'king'),
            new Card('diamonds', 'queen'),
            new Card('diamonds', 'jack'),
        ];

        $deck = new Deck();

        foreach ($expectedCards as $expectedCard) {
            self::assertEquals($expectedCard, $deck->dealCard());
        }
    }

    /**
     * @test
     */
    public function shuffle()
    {
        $deck = new Deck();

        $cleanDeck = $deck->getCards();

        $deck->shuffle();

        // the sequence is not the same
        self::assertNotSame($cleanDeck, $deck->getCards());

        // but all the cards are still present
        self::assertCount(52, $deck->getCards());
    }

    /**
     * @test
     */
    public function reset()
    {
        $deck = new Deck();

        $deck->dealCard();
        $deck->dealCard();
        $deck->dealCard();
        $deck->dealCard();

        self::assertSame(48, $deck->count());

        $deck->reset();

        self::assertSame(52, $deck->count());

        $unshuffled = $deck->getCards();

        $deck->shuffle();

        $shuffled = $deck->getCards();

        self::assertNotSame($shuffled, $unshuffled);

        $deck->reset();

        self::assertEquals($unshuffled, $deck->getCards());
    }
}
