<?php
namespace DivideByZero\AutoStockUpdate\Model;

use DivideByZero\AutoStockUpdate\Api\ParserInterface;
use DivideByZero\AutoStockUpdate\Api\ParserPoolInterface;

/**
 * Class ParserPool
 * @package DivideByZero\AutoStockUpdate\Model
 */
class ParserPool implements ParserPoolInterface
{
    /**
     * @var array
     */
    private $parsers;

    /**
     * ParserPool constructor.
     * @param array $parsers
     */
    public function __construct(array $parsers)
    {
        $this->parsers = $parsers;
    }

    /**
     * @param string $extension
     * @return ParserInterface
     * @throws \Exception
     */
    public function getByExtension(string $extension): ParserInterface
    {
        if (isset($this->parsers[$extension])) {
            return $this->parsers[$extension];
        }

        throw new \Exception(__("Extension '%1' has not got any parser", $extension));
    }

    /**
     * @return array
     */
    public function handledExtensions(): array
    {
        return array_keys($this->parsers);
    }
}
