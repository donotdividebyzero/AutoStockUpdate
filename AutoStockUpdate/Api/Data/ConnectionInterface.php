<?php
namespace DivideByZero\AutoStockUpdate\Api\Data;

/**
 * Interface ConnectionInterface
 * @package DivideByZero\AutoStockUpdate\Api\Data
 */
interface ConnectionInterface
{
    const ID = 'id';
    const IS_ACTIVE = 'is_active';
    const NAME = 'name';
    const USERNAME = 'username';
    const PASSWORD = 'password';
    const HOST = 'host';
    const PORT = 'port';
    const STOCK_FILE_DIRECTORY = 'stock_file_directory';
    const ARCHIVE_FILE_DIRERCTORY = 'archive_file_directory';

    /**
     * @return int
     */
    public function getId(): int;
    /**
     * @return bool
     */
    public function getIsActive() : bool;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getUsername() : string;

    /**
     * @return string
     */
    public function getPassword() : string;

    /**
     * @return string
     */
    public function getHost() : string;

    /**
     * @return string
     */
    public function getPort() : string;

    /**
     * @return string
     */
    public function getStockFileDirectory() : string;

    /**
     * @return string
     */
    public function getArchiveFileDirectory() : string;

    /**
     * @param int $id
     * @return ConnectionInterface
     */
    public function setId($id): self;

    /**
     * @param bool $isActive
     * @return ConnectionInterface
     */
    public function setIsActive(bool $isActive): self;

    /**
     * @param string $name
     * @return ConnectionInterface
     */
    public function setName(string $name): self;

    /**
     * @param string $username
     * @return ConnectionInterface
     */
    public function setUsername(string $username): self;

    /**
     * @param string $password
     * @return ConnectionInterface
     */
    public function setPassword(string $password): self;

    /**
     * @param string $host
     * @return ConnectionInterface
     */
    public function setHost(string $host): self;

    /**
     * @param int $port
     * @return ConnectionInterface
     */
    public function setPort(int $port): self;

    /**
     * @param string $path
     * @return ConnectionInterface
     */
    public function setStockFileDirectory(string $path): self;

    /**
     * @param string $path
     * @return ConnectionInterface
     */
    public function setArchiveFileDirectory(string $path): self;

}
