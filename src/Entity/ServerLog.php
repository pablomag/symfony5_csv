<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ServerLog
 *
 * @ORM\Table(name="server_log")
 * @ORM\Entity(repositoryClass="App\Repository\ServerLogRepository")
 */
class ServerLog
{
    /**
	 * @var int
	 *
     * @ORM\Id()
     * @ORM\Column(name="id", type="integer", unique=true)
     */
    private $id;

    /**
	 * @var string
	 *
     * @ORM\Column(name="timestamp", type="string", length=28, unique=true)
     */
    private $timestamp;

    /**
	 * @var string
	 *
     * @ORM\Column(name="domain_name", type="string", length=255)
     */
    private $domainName;

    /**
	 * @var int
	 *
     * @ORM\Column(name="filesize_bytes", type="bigint")
     */
    private $filesizeBytes;

    /**
	 * @var string
	 *
     * @ORM\Column(name="file_path", type="string", length=255)
     */
    private $filePath;

    /**
	 * @var string
	 *
     * @ORM\Column(name="user_agent", type="string", length=255)
     */
    private $userAgent;

	/**
	 * @var int
	 *
	 * @ORM\Column(name="http_response_status", type="integer")
	 */
	private $httpResponseStatus;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="http_request_method", type="string", length=10)
	 */
	private $httpRequestMethod;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="content_type", type="string", length=255)
	 */
	private $contentType;

	/**
	 * @return int
	 */
    public function getId(): ?int
    {
        return $this->id;
    }

	/**
	 * @param int $id
	 * @return $this
	 */
	public function setId($id): self
	{
		$this->id = $id;

		return $this;
	}

	/**
	 * @return string
	 */
    public function getTimestamp(): ?string
    {
        return $this->timestamp;
    }

	/**
	 * @param string $timestamp
	 * @return $this
	 */
    public function setTimestamp(string $timestamp): self
    {
        $this->timestamp = $timestamp;

        return $this;
    }

	/**
	 * @return string
	 */
    public function getDomainName(): ?string
    {
        return $this->domainName;
    }

	/**
	 * @param string $domainName
	 * @return $this
	 */
    public function setDomainName(string $domainName): self
    {
        $this->domainName = $domainName;

        return $this;
    }

	/**
	 * @return string
	 */
    public function getFilesizeBytes(): ?string
    {
        return $this->filesizeBytes;
    }

	/**
	 * @param string $filesizeBytes
	 * @return $this
	 */
    public function setFilesizeBytes(string $filesizeBytes): self
    {
        $this->filesizeBytes = $filesizeBytes;

        return $this;
    }

	/**
	 * @return string
	 */
    public function getFilePath(): ?string
    {
        return $this->filePath;
    }

	/**
	 * @param string $filePath
	 * @return $this
	 */
    public function setFilePath(string $filePath): self
    {
        $this->filePath = $filePath;

        return $this;
    }

	/**
	 * @return string
	 */
    public function getUserAgent(): ?string
    {
        return $this->userAgent;
    }

	/**
	 * @param string $userAgent
	 * @return $this
	 */
    public function setUserAgent(string $userAgent): self
    {
        $this->userAgent = $userAgent;

        return $this;
    }

	/**
	 * @return int
	 */
    public function getHttpResponseStatus(): ?int
	{
		return $this->httpResponseStatus;
	}

	/**
	 * @param int $httpResponseStatus
	 * @return $this
	 */
	public function setHttpResponseStatus(int $httpResponseStatus): self
	{
		$this->httpResponseStatus = $httpResponseStatus;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getHttpRequestMethod(): ?string
	{
		return $this->httpRequestMethod;
	}

	/**
	 * @param string $httpRequestMethod
	 * @return $this
	 */
	public function setHttpRequestMethod(string $httpRequestMethod): self
	{
		$this->httpRequestMethod = $httpRequestMethod;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getContentType(): ?string
	{
		return $this->contentType;
	}

	/**
	 * @param string $contentType
	 * @return $this
	 */
	public function setContentType(string $contentType): self
	{
		$this->contentType = $contentType;

		return $this;
	}
}
