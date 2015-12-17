<?php

namespace PokerGame\Tests\Entity;

use PokerGame\Entity\Card;

class CardTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function constants()
    {
        $suits  = Card::allowedSuits;
        $values = Card::allowedValues;

        self::assertCount(4,  $suits);
        self::assertCount(13, $values);

        $expectedSuits = [
            'hearts',
            'clubs',
            'spades',
            'diamonds',
        ];

        $expectedValues = [
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

        self::assertEquals($expectedSuits, $suits);
        self::assertEquals($expectedValues, $values);
    }

    /**
     * @test
     * @dataProvider repeat10times
     */
    public function constructor()
    {
        // grab a random suit & value
        $suit  = Card::allowedSuits[rand(0,3)];
        $value = Card::allowedValues[rand(0,12)];

        $card = new Card($suit, $value);

        self::assertEquals($card->getSuit(),  $suit);
        self::assertEquals($card->getValue(), $value);
    }

    /**
     * @test
     */
    public function __toString()
    {
        $card = new Card('spades', 'seven');

        self::assertEquals('seven of spades', $card);
    }

    /**
     * @test
     * @dataProvider invalidSuits
     * @expectedException PokerGame\Exception
     * @expectedExceptionMessage Invalid Suit:
     */
    public function invalidSuit($suit)
    {
        new Card($suit, 'ace');
    }

    /**
     * @test
     * @dataProvider invalidValues
     * @expectedException PokerGame\Exception
     * @expectedExceptionMessage Invalid Value:
     */
    public function invalidValue($value)
    {
        new Card('hearts', $value);
    }

    // data providers

    public function repeat10times()
    {
        return [
            [], [], [], [], [], [], [], [], [], [],
        ];
    }

    public function invalidSuits()
    {
        return [
            ['hello'],
            ['heart'],
            ['moon'],
            [null],
            [true],
            [false],
            [98234234],
        ];
    }

    public function invalidValues()
    {
        return [
            [1],
            [0],
            [true],
            [false],
            ['hello'],
            ['     '],
            [null]
        ];
    }
}
