<?php
namespace DivideByZero\AutoStockUpdate\Model\DTO;

class File
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $content;
    /**
     * @var string
     */
    private $extension;

    /**
     * File constructor.
     * @param string $name
     * @param string $content
     * @param string $extension
     */
    public function __construct(string $name, string $content, string $extension)
    {
        $this->name = $name;
        $this->content = $content;
        $this->extension = $extension;
    }

    /**
     * @return string
     */
    public function getExtension(): string
    {
        return $this->extension;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }
}
