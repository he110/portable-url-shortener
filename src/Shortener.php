<?php
/**
 * Created by PhpStorm.
 * User: he110
 * Date: 2020-02-21
 * Time: 16:18
 */

namespace He110\UrlShortener;


use duncan3dc\Log\LoggerAwareTrait;
use Hashids\Hashids;
use Medoo\Medoo;

class Shortener
{
    use LoggerAwareTrait;

    private const TABLE_NAME = 'links';

    /** @var Medoo */
    private $connection;

    /** @var int */
    private $hashLength;

    /**
     * Shortener constructor.
     * Creates database file and table
     *
     * @param string $databaseFilePath
     */
    public function __construct(string $databaseFilePath, int $hashLength = 4)
    {
        $this->connection = new Medoo([
            'database_type' => 'sqlite',
            'database_file' => $databaseFilePath
        ]);

        $this->connection->create(self::TABLE_NAME, array(
            'url' => array(
                'VARCHAR(255)',
                'NOT NULL'
            ),
            'hash' => array(
                'VARCHAR(255)',
                'NOT NULL'
            ),
        ));

        $this->hashLength = $hashLength;
    }

    /**
     * @return int
     */
    public function getHashLength(): int
    {
        return $this->hashLength;
    }

    /**
     * @param int $hashLength
     * @return Shortener
     */
    public function setHashLength(int $hashLength): self
    {
        $this->hashLength = $hashLength;
        return $this;
    }

    /**
     * Finds and returns full url, if it has been shortened before
     *
     * @param string $hash
     * @return string|null
     */
    public function getFullUrl(string $hash): ?string
    {
        if ($existed = $this->connection->get(self::TABLE_NAME, ['url'], ['hash' => $hash]))
            return $existed['url'];
        return null;
    }

    /**
     * Saves url to database and returns associated hash
     *
     * @param string $url
     * @return string
     */
    public function generateHash(string $url): string
    {
        if ($existed = $this->connection->get(self::TABLE_NAME, ['hash'], ['url' => $url])) {
            $hash = $existed['hash'];
        } else {
            $hash = $this->getHashByDigit($this->connection->count(self::TABLE_NAME));
            $this->connection->insert(self::TABLE_NAME, array(
                'url' => $url,
                'hash' => $hash
            ));
        }
        return $hash;
    }

    /**
     * Generates hash by digit
     *
     * @param int $digit
     * @return string
     */
    protected function getHashByDigit(int $digit): string
    {
        $service = new Hashids('', $this->getHashLength());
        return $service->encode($digit);
    }
}
