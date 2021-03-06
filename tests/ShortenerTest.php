<?php
/**
 * Created by PhpStorm.
 * User: he110
 * Date: 2020-02-21
 * Time: 16:50
 */

namespace He110\UrlShortenerTests;

use He110\UrlShortener\Shortener;
use PHPUnit\Framework\TestCase;

class ShortenerTest extends TestCase
{
    /** @var Shortener */
    private $service;

    private $databaseFile = 'test.db';

    public function setUp(): void
    {
        $this->service = new Shortener($this->databaseFile);
    }

    public function tearDown(): void
    {
        unset($this->service);
        $this->service = null;
        unlink($this->databaseFile);
    }

    /** @test */
    public function can_generate_hash()
    {
        $result = $this->service->generateHash('https://example.domain/');
        $this->assertIsString($result);
    }

    /** @test */
    public function can_find_existed_hash()
    {
        $url1 = 'https://example.domain/1';
        $url2 = 'https://example.domain/2';
        $result1 = $this->service->generateHash($url1);
        $result2 = $this->service->generateHash($url2);
        $result3 = $this->service->generateHash($url2);

        $this->assertNotEquals($result1, $result2);
        $this->assertSame($result2, $result3);
    }

    /** @test */
    public function can_find_full_url()
    {
        $url = 'https://example.domain/';
        $hash = $this->service->generateHash($url);
        $result = $this->service->getFullUrl($hash);
        $this->assertSame($url, $result);
    }

    /** @test */
    public function can_return_null_for_non_existed_hash()
    {
        $result = $this->service->getFullUrl('non_existed');
        $this->assertNull($result);
    }

    /** @test */
    public function can_change_hash_length()
    {
        $currentLength = $this->service->getHashLength();

        $default = $this->service->generateHash('https://example.domain/');
        $this->assertTrue(strlen($default) == $currentLength);

        $this->service->setHashLength($currentLength+6);
        $newLength = $this->service->getHashLength();

        $result = $this->service->generateHash('https://another.domain/');

        $this->assertNotEquals($currentLength, $newLength);
        $this->assertTrue(strlen($result) == $newLength);
    }
}
