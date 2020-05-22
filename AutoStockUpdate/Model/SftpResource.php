<?php
namespace DivideByZero\AutoStockUpdate\Model;

use DivideByZero\AutoStockUpdate\Api\Data\ConnectionInterface;
use DivideByZero\AutoStockUpdate\Api\Data\SftpResourceInterface;
use DivideByZero\AutoStockUpdate\Exception\ConnectionException;
use DivideByZero\AutoStockUpdate\Model\DTO\File;
use Magento\Framework\Encryption\EncryptorInterface;
use phpseclib\Net\SFTP;

/**
 * Class SftpResource
 * @package DivideByZero\AutoStockUpdate\Model
 */
class SftpResource implements SftpResourceInterface
{
    /**
     * @var SFTP
     */
    private $connection;

    /**
     * @var ConnectionInterface
     */
    private $connectionDetails;
    /**
     * @var EncryptorInterface
     */
    private $encryptor;

    /**
     * SftpResource constructor.
     * @param ConnectionInterface $connectionDetails
     */
    public function __construct(
        EncryptorInterface $encryptor,
        ConnectionInterface $connectionDetails = null
    )
    {
        $this->connectionDetails = $connectionDetails;
        $this->encryptor = $encryptor;
    }

    /**
     * @return SftpResourceInterface
     * @throws ConnectionException
     * @throws \Exception
     */
    public function open() : SftpResourceInterface
    {
        if (!$this->connectionDetails->getIsActive()) {
            throw new \Exception(__("Synchronization is turned off"));
        }

        $this->connection = new SFTP(
            $this->connectionDetails->getHost(),
            $this->connectionDetails->getPort(),
            5000
        );

        $isLoggedIn = $this->connection->login(
            $this->connectionDetails->getUsername(),
            $this->encryptor->decrypt($this->connectionDetails->getPassword())
        );

        if ($isLoggedIn !== false) {
            $this->checkForArchiveDir();

            return $this;
        }

        throw new ConnectionException(__("Can't login to remote server (perhaps invalid credentials)"));
    }

    /**
     * @return mixed|void
     */
    public function close()
    {
        $this->connection->_disconnect(0);
    }

    /**
     *
     */
    public function chdirStockFile()
    {
        $this->connection->chdir($this->connectionDetails->getStockFileDirectory());
    }

    /**
     * @param array|null $handledExtensions
     * @return array|mixed
     */
    public function ls(array $handledExtensions)
    {
        return array_filter(
            $this->connection->nlist(),
            $this->allowedExtensions($handledExtensions)
        );
    }

    /**
     * @param File $file
     * @return bool
     * @throws \Exception
     */
    public function moveToArchive(File $file) : bool
    {
        $result = $this->connection->put(
            sprintf("%s/%s", $this->connectionDetails->getArchiveFileDirectory(), $file->getName()),
            $file->getContent()
        );

        if (!$result) {
            throw new \Exception(__("Could not move file: {$file->getName()}"));
        }

        return $result;
    }

    /**
     * @param string $fileName
     * @return File
     * @throws \Exception
     */
    public function getFile(string $fileName) : File
    {
        $content = $this->connection->get($fileName);

        if ($content !== false) {
            return new File($fileName, $content, pathinfo($fileName, PATHINFO_EXTENSION));
        }

        throw new \Exception(__('Could not fetch file: %1'), $fileName);
    }

    /**
     * @param File $file
     * @return bool
     */
    public function delete(File $file) : bool
    {
        $path = sprintf(
            "%s/%s",
            $this->connectionDetails->getStockFileDirectory(),
            $file->getName()
        );

        return $this->connection->delete($path, true);
    }

    /**
     * @throws \Exception
     */
    private function checkForArchiveDir()
    {
        $archiveDirectory = $this->connection->realpath($this->connectionDetails->getArchiveFileDirectory());

        if (!$this->connection->is_dir($archiveDirectory)) {
            $isCreated = $this->connection->mkdir($archiveDirectory, -1, true);

            if ($isCreated === false) {
                throw new \Exception(__("Can't create archive directory"));
            }
        }
    }

    /**
     * @param array $allowedExtensions
     * @return \Closure
     */
    private function allowedExtensions(array $allowedExtensions) {

        return function ($fileName) use ($allowedExtensions) {
            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

            return in_array($fileExtension, $allowedExtensions, true);
        };
    }
}
