<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class InitialTest extends TestCase
{
    /**
     * @test
     */
    public function trueTest(): void
    {
        self::assertSame(1,1);
    }

    /**
     * @test
     */
    public function trueTest2(): void
    {
        self::assertSame(2,2);
    }
}
