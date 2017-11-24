<?php
declare(strict_types=1);


namespace AppBundle\Services\DataFetcher;


use AppBundle\Services\DataFetcher\Contracts\ResponseHeadersInterface;
use AppBundle\Services\DataFetcher\Exceptions\HeaderKeyNotFound;

/**
 * Class ResponseHeaders
 * @package AppBundle\Services\DataFetcher
 */
final class ResponseHeaders implements ResponseHeadersInterface
{

    /**
     * @var array
     */
    private $headers;

    /**
     * ResponseHeaders constructor.
     * @param array $headers
     */
    public function __construct(array $headers)
    {
        $this->headers = $headers;
    }

    /**
     * @return int
     * @throws HeaderKeyNotFound
     */
    public function getStatusCode(): int
    {
        if ($this->hasContentType()) {
            return $this->headers['status_code'];
        }

        throw new HeaderKeyNotFound(printf('Provided key: status_code does not exist'));
    }

    /**
     * @return bool
     */
    public function hasStatusCode(): bool
    {
        return array_key_exists('status_code', $this->headers);
    }

    /**
     * @return string
     * @throws HeaderKeyNotFound
     */
    public function getContentType(): string
    {
        if ($this->hasContentType()) {
            return $this->headers['content_type'];
        }

        throw new HeaderKeyNotFound(printf('Provided key: content_type does not exist'));
    }

    /**
     * @return bool
     */
    public function hasContentType(): bool
    {
        return array_key_exists('content_type', $this->headers);
    }

    /**
     * @return int
     * @throws HeaderKeyNotFound
     */
    public function getHeaderSize(): int
    {
        if ($this->hasHeaderSize()) {
            return $this->headers['header_size'];
        }

        throw new HeaderKeyNotFound(printf('Provided key: header_size does not exist'));
    }

    /**
     * @return bool
     */
    public function hasHeaderSize(): bool
    {
        return array_key_exists('header_size', $this->headers);
    }

    /**
     * @return float
     * @throws HeaderKeyNotFound
     */
    public function getTotalTime(): float
    {
        if ($this->hasTotalTime()) {
            return $this->headers['total_time'];
        }

        throw new HeaderKeyNotFound(printf('Provided key: total_time does not exist'));
    }

    /**
     * @return bool
     */
    public function hasTotalTime(): bool
    {
        return array_key_exists('total_time', $this->headers);
    }


}