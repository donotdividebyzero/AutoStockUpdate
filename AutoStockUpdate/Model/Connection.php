<?php

namespace DivideByZero\AutoStockUpdate\Model;

use DivideByZero\AutoStockUpdate\Api\Data\ConnectionInterface;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Encryption\EncryptorInterface;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;

/**
 * Class Connection
 * @package DivideByZero\AutoStockUpdate\Model
 */
class Connection extends AbstractModel implements ConnectionInterface
{
    public const TABLE_NAME = 'autostock_update_conntection_details';

    /**
     * @var EncryptorInterface
     */
    private $encryptor;

    /**
     * Connection constructor.
     * @param Context $context
     * @param Registry $registry
     * @param EncryptorInterface $encryptor
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        EncryptorInterface $encryptor,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
        $this->encryptor = $encryptor;
    }

    protected function _construct()
    {
        parent::_construct();
        $this->_init(Resource\Connection::class);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->getData(self::ID);
    }

    /**
     * @return bool
     */
    public function getIsActive(): bool
    {
        return $this->getData(self::IS_ACTIVE);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->getData(self::NAME);
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->getData(self::USERNAME);
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->getData(self::PASSWORD);
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->getData(self::HOST);
    }

    /**
     * @return string
     */
    public function getPort(): string
    {
        return $this->getData(self::PORT) ?: '22';
    }

    /**
     * @return string
     */
    public function getStockFileDirectory(): string
    {
        return $this->getData(self::STOCK_FILE_DIRECTORY);
    }

    /**
     * @return string
     */
    public function getArchiveFileDirectory(): string
    {
        return $this->getData(self::ARCHIVE_FILE_DIRERCTORY);
    }

    /**
     * @param int $id
     * @return ConnectionInterface
     */
    public function setId($id): ConnectionInterface
    {
        $this->setData(self::ID, $id);

        return $this;
    }

    /**
     * @param bool $isActive
     * @return ConnectionInterface
     */
    public function setIsActive(bool $isActive): ConnectionInterface
    {
        $this->setData(self::IS_ACTIVE, $isActive);

        return $this;
    }

    /**
     * @param string $name
     * @return ConnectionInterface
     */
    public function setName(string $name): ConnectionInterface
    {
        $this->setData(self::NAME, $name);

        return $this;
    }

    /**
     * @param string $username
     * @return ConnectionInterface
     */
    public function setUsername(string $username): ConnectionInterface
    {
        $this->setData(self::USERNAME, $username);

        return $this;
    }

    /**
     * @param string $password
     * @return ConnectionInterface
     */
    public function setPassword(string $password): ConnectionInterface
    {
        $oldPassword = $this->getData(self::PASSWORD);
        $oldPassword = $oldPassword !== null ? $this->encryptor->decrypt($oldPassword) : null;

        if ($oldPassword !== $password) {
            $this->setData(
                self::PASSWORD,
                $this->encryptor->encrypt($password)
            );
        }

        return $this;
    }

    /**
     * @param string $host
     * @return ConnectionInterface
     */
    public function setHost(string $host): ConnectionInterface
    {
        $this->setData(self::HOST, $host);

        return $this;
    }

    /**
     * @param int $port
     * @return ConnectionInterface
     */
    public function setPort(int $port): ConnectionInterface
    {
        $this->setData(self::PORT, $port);

        return $this;
    }

    /**
     * @param string $path
     * @return ConnectionInterface
     */
    public function setStockFileDirectory(string $path): ConnectionInterface
    {
        $this->setData(self::STOCK_FILE_DIRECTORY, $path);

        return $this;
    }

    /**
     * @param string $path
     * @return ConnectionInterface
     */
    public function setArchiveFileDirectory(string $path): ConnectionInterface
    {
        $this->setData(self::ARCHIVE_FILE_DIRERCTORY, $path);

        return $this;
    }

    /**
     * Convert array of object data with to array with keys requested in $keys array
     *
     * @param array $keys array of required keys
     * @return array
     */
    public function toArray(array $keys = [])
    {
        $data = parent::toArray($keys);

        $data[self::PASSWORD] = $this->encryptor->decrypt($data[self::PASSWORD]);
        return $data;
    }
}
