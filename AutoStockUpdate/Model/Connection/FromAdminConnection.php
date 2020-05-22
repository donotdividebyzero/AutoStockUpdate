<?php
namespace DivideByZero\AutoStockUpdate\Model\Connection;

use DivideByZero\AutoStockUpdate\Api\Data\ConnectionInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Encryption\EncryptorInterface;

/**
 * Class FromAdminConnection
 * @package DivideByZero\AutoStockUpdate\Model\Connection
 */
class FromAdminConnection implements ConnectionInterface
{
    /**
     * @var ScopeConfigInterface
     */
    private $config;

    /**
     * @var EncryptorInterface
     */
    private $encryptor;

    /**
     * ConnectionDetails constructor.
     * @param ScopeConfigInterface $config
     * @param EncryptorInterface $encryptor
     */
    public function __construct(
        ScopeConfigInterface $config,
        EncryptorInterface $encryptor
    )
    {
        $this->config = $config;
        $this->encryptor = $encryptor;
    }

    /**
     * @return bool
     */
    public function getIsActive() : bool
    {
        return (bool)$this->config->getValue($this->getConfigPath('active'));
    }

    /**
     * @return string
     */
    public function getUsername() : string
    {
        return $this->config->getValue($this->getConfigPath('username'));
    }

    /**
     * @return string
     */
    public function getPassword() : string
    {
        $password = $this->config->getValue($this->getConfigPath('password'));
        return $this->encryptor->decrypt($password);
    }

    /**
     * @return string
     */
    public function getHost() : string
    {
        return $this->config->getValue($this->getConfigPath('host'));
    }

    /**
     * @return string
     */
    public function getPort() : string
    {
        return $this->config->getValue($this->getConfigPath('port')) ?: "22";
    }

    /**
     * @return string
     */
    public function getStockFileDirectory() : string
    {
        return $this->config->getValue($this->getConfigPath('file_directory_stock'));
    }

    /**
     * @return string
     */
    public function getArchiveFileDirectory() : string
    {
        return $this->config->getValue($this->getConfigPath('file_directory_archive'));
    }

    /**
     * @param string $setting
     * @return string
     */
    private function getConfigPath(string $setting) : string
    {
        return sprintf("amasty_multi_inventory/stock_update_cron/%s", $setting);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'Default - Legacy';
    }

    /**
     * @param bool $isActive
     * @return ConnectionInterface
     */
    public function setIsActive(bool $isActive): ConnectionInterface
    {
        return $this;
    }

    /**
     * @param string $name
     * @return ConnectionInterface
     */
    public function setName(string $name): ConnectionInterface
    {
        return $this;
    }

    /**
     * @param string $username
     * @return ConnectionInterface
     */
    public function setUsername(string $username): ConnectionInterface
    {
        return $this;
    }

    /**
     * @param string $password
     * @return ConnectionInterface
     */
    public function setPassword(string $password): ConnectionInterface
    {
        return $this;
    }

    /**
     * @param string $host
     * @return ConnectionInterface
     */
    public function setHost(string $host): ConnectionInterface
    {
        return $this;
    }

    /**
     * @param int $port
     * @return ConnectionInterface
     */
    public function setPort(int $port): ConnectionInterface
    {
        return $this;
    }

    /**
     * @param string $path
     * @return ConnectionInterface
     */
    public function setStockFileDirectory(string $path): ConnectionInterface
    {
        return $this;
    }

    /**
     * @param string $path
     * @return ConnectionInterface
     */
    public function setArchiveFileDirectory(string $path): ConnectionInterface
    {
        return $this;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return 0;
    }

    /**
     * @param int $id
     * @return ConnectionInterface
     */
    public function setId($id): ConnectionInterface
    {
        return $this;
    }
}
