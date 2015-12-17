<?php

namespace PokerGame\Tests\Command;

use PokerGame\Command\PokerCommand;
use PokerGame\Entity\Deck;
use PokerGame\Entity\Player;

class PokerCommandTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function constructor()
    {
        $deck    = new Deck();
        $command = new PokerCommand($deck);

        self::assertEquals($deck, $command->getDeck());
        self::assertEquals([], $command->getPlayers());
    }

    /**
     * @test
     */
    public function players()
    {
        $command = new PokerCommand(new Deck());

        self::assertCount(0, $command->getPlayers());

        $command->addPlayer(new Player());

        self::assertCount(1, $command->getPlayers());
    }

    /**
     * @test
     * @expectedException PokerGame\Exception
     * @expectedExceptionMessage You cannot add players once a card has been dealt
     */
    public function cannotAddPlayerOnceFirstCardDealt()
    {
        $command = new PokerCommand(new Deck());
        $command->addPlayer(new Player())
            ->addPlayer(new Player())
            ->dealCards()
            ->addPlayer(new Player());
    }

    /**
     * @test
     */
    public function shuffleCards()
    {
        $deck    = new Deck();
        $command = new PokerCommand($deck);

        self::assertEquals($deck, $command->getDeck());

        $command->shuffleCards();

        self::assertNotEquals(new Deck(), $command->getDeck());
    }

    /**
     * @test
     * @expectedException PokerGame\Exception
     * @expectedExceptionMessage You cannot add players once a card has been dealt
     */
    public function shuffleCardsException()
    {
        $command = new PokerCommand(new Deck());
        $command->addPlayer(new Player())
            ->addPlayer(new Player())
            ->dealCards()
            ->shuffleCards();
    }

    /**
     * @test
     */
    public function dealCards()
    {
        $command = new PokerCommand(new Deck());
        $command->addPlayer(new Player())->addPlayer(new Player());

        self::assertCount(52, $command->getDeck()->getCards());

        $command->dealCards();

        self::assertCount(38, $command->getDeck()->getCards());
    }

    /**
     * @test
     * @expectedException PokerGame\Exception
     * @expectedExceptionMessage You cannot deal the cards until more players have joined.
     */
    public function dealCardsExceptionWhenNotEnoughPlayers()
    {
        $command = new PokerCommand(new Deck());
        $command->addPlayer(new Player())->dealCards();
    }

    /**
     * @test
     */
    public function displaySummary()
    {
        $player1 = new Player();
        $player1->setName('John');

        $player2 = new Player();
        $player2->setName('Paul');

        $command = new PokerCommand(new Deck());
        $command->addPlayer($player1)->addPlayer($player2)->dealCards();

        $expectedSummary = <<<SUMMARY
------------------
Poker Game Summary
------------------
 - John
king of diamonds, jack of diamonds, nine of diamonds, seven of diamonds, five of diamonds, three of diamonds, ace of diamonds
 - Paul
queen of diamonds, ten of diamonds, eight of diamonds, six of diamonds, four of diamonds, two of diamonds, king of spades

SUMMARY;

        self::assertEquals($expectedSummary, $command->displaySummary());
    }
}
