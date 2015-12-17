<?php

namespace PokerGame\Tests\Entity;

use PokerGame\Entity\Card;
use PokerGame\Entity\Player;

class PlayerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function constructor()
    {
        $player = new Player();

        self::assertNotEquals('', $player->getName());
    }

    /**
     * @test
     * @dataProvider names
     */
    public function name($name)
    {
        $player = new Player();
        $player->setName($name);

        self::assertEquals($name, $player->getName());
    }

    /**
     * @test
     */
    public function cards()
    {
        $player = new Player();

        self::assertCount(0, $player->getCards());

        $player->addCard(new Card('diamonds', 'five'));
        $player->addCard(new Card('diamonds', 'king'));
        $player->addCard(new Card('clubs', 'ten'));

        self::assertCount(3, $player->getCards());

        $player->fold();

        self::assertCount(0, $player->getCards());
    }

    /**
     * @test
     */
    public function displaySummary()
    {
        $player = new Player();
        $player->setName('Sam');
        $player->addCard(new Card('diamonds', 'five'));
        $player->addCard(new Card('diamonds', 'king'));
        $player->addCard(new Card('clubs', 'ten'));

        $expectedSummary = " - Sam\nfive of diamonds, king of diamonds, ten of clubs";

        self::assertEquals($expectedSummary, $player->displaySummary());
    }

    /**
     * @test
     */
    public function __toString()
    {
        $player = new Player();
        $player->setName('Sam');
        $player->addCard(new Card('diamonds', 'five'));
        $player->addCard(new Card('diamonds', 'king'));
        $player->addCard(new Card('clubs', 'ten'));

        $expectedSummary = " - Sam\nfive of diamonds, king of diamonds, ten of clubs";

        self::assertEquals($expectedSummary, $player);
    }

    // data providers

    public function names()
    {
        return [
            ['dave'],
            ['paul'],
            ['john'],
            ['andrew'],
            ['steve'],
            ['tony'],
        ];
    }
}
