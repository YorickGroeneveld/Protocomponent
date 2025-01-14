<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

use DateTime;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;


/**
 * An resource representing a log line.
 *
 * This entity represents a product that can be ordered via the OrderRegistratieComponent.
 *
 * @author Ruben van der Linde <ruben@conduction.nl>
 *
 * @category Entity
 *
 * @license EUPL <https://github.com/ConductionNL/productenendienstencatalogus/blob/master/LICENSE.md>
 *
 * @ApiResource(
 *     normalizationContext={"groups"={"read"}, "enable_max_depth"=true},
 *     denormalizationContext={"groups"={"write"}, "enable_max_depth"=true}
 * )  
 * @ApiFilter(OrderFilter::class, properties={
 * 		"application","request",
 * 		"user",
 * 		"subject",
 * 		"processs",
 * 		"resource",
 * 		"resourceType",
 * 		"endpoint",
 * 		"contentType",
 * 		"content",
 * 		"session",
 * 		"dateCreated",
 * 		"dateModified",
 * })
 * @ApiFilter(SearchFilter::class, properties={ 
 * 		"applicationId": "exact",
 * 		"request": "exact",
 * 		"user": "exact",
 * 		"subject": "exact",
 * 		"processs": "exact",
 * 		"resource": "exact",
 * 		"resourceType": "partial",
 * 		"endpoint": "exact",
 * 		"contentType": "exact",
 * 		"content": "exact",
 * 		"session": "exact",
 * })
 * @ApiFilter(DateFilter::class, properties={"dateCreated","dateModified" })
 * @ORM\Entity(repositoryClass="App\Repository\AuditTrailRepository")
 */
class AuditTrail
{
	/**
	 * @var UuidInterface The UUID identifier of this object
	 *
	 * @example e2984465-190a-4562-829e-a8cca81aa35d
	 *
	 * @Assert\Uuid
	 * @Groups({"read"})
	 * @ORM\Id
	 * @ORM\Column(type="uuid", unique=true)
	 * @ORM\GeneratedValue(strategy="CUSTOM")
	 * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
	 */
	private $id;
	
	/**
	 * @var string A note conserning this log lin
	 *
	 * @example This log line is suspicius
	 *
	 * @Assert\Length(
	 *      max = 2555
	 * )
	 * @Groups({"read","write"})
	 * @ORM\Column(type="text", nullable=true)
	 */
	private $note;

    /**    
     * @var sting $application The application that made the request
     * 
     * @Assert\Url
     * @Assert\Length(
     *      max = 255
     * )
	 * @Groups({"read"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $application;

    /**
     * @var sting $request The id of the request within that application
     * 
     * @Assert\Url
     * @Assert\Length(
     *      max = 255
     * )
	 * @Groups({"read"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $request;

    /**
     * @var sting $user The user on behalf of wich the request was made
     * 
     * @Assert\Url
     * @Assert\Length(
     *      max = 255
     * )
	 * @Groups({"read"})
     * @ORM\Column(type="string", length=255, nullable=true, name="username")
     */
    private $user;

    /**
     * @var sting $subject ???
     * 
     * @Assert\Length(
     *      max = 255
     * )
	 * @Groups({"read"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subject;

    /**
     * @var sting $process The procces on behalf of wich the request was made
     * 
     * @Assert\Length(
     *      max = 255
     * )
	 * @Groups({"read"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $process;

    /**
     * @var array $dataElements The moment this request was created
     * 
	 * @Groups({"read"})
     * @ORM\Column(type="array", nullable=true)
     */
    private $dataElements = [];

    /**
     * @var array $dataSubjects The moment this request was created
     * 
	 * @Groups({"read"})
     * @ORM\Column(type="array", nullable=true)
     */
    private $dataSubjects = [];

    /**
     * @var sting $resource The resource that was requested 
     * 
     * @Assert\Length(
     *      max = 255
     * )
	 * @Groups({"read"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $resource;

    /**
     * @var sting $resourceType The type of the resource that was requested 
     * 
     * @Assert\Length(
     *      max = 255
     * )
	 * @Groups({"read"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $resourceType;

    /**
     * @var sting $route The moment this request was created
     * 
     * @Assert\Length(
     *      max = 255
     * )
	 * @Groups({"read"})
     * @ORM\Column(type="string", length=255)
     */
    private $route;

    /**
     * @var sting $endpoint The endpoint that the request was made to
     * 
     * @Assert\Length(
     *      max = 255
     * )
	 * @Groups({"read"})
     * @ORM\Column(type="string", length=255)
     */
    private $endpoint;

    /**
     * @var sting $method The method that was used
     * 
     * @Assert\Length(
     *      max = 255
     * )
	 * @Groups({"read"})
     * @ORM\Column(type="string", length=10)
     */
    private $method; 
    
    /**
     * @var sting $Accept The contentType that was reqousted
     *
     * @Assert\Length(
     *      max = 255
     * )
     * @Groups({"read"})
     * @ORM\Column(type="string", length=255)
     */
    private $accept;
    
    /**
     * @var sting $contentType The contentType that was suplieds
     * 
     * @Assert\Length(
     *      max = 255
     * )
	 * @Groups({"read"})
     * @ORM\Column(type="string", length=255)
     */
    private $contentType;

    /**
     * @var sting $content The moment this request was created
     * 
     * @Assert\Length(
     *      max = 2555
     * )
	 * @Groups({"read"})
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;
    
    /**
     * @var sting $ip The moment this request was created
     *
     * @Assert\Length(
     *      max = 255
     * )
     * @Groups({"read"})
     * @ORM\Column(type="string", length=255)
     */
    private $ip;

    /**
     * @var sting $session The moment this request was created
     * 
     * @Assert\Length(
     *      max = 255
     * )
	 * @Groups({"read"})
     * @ORM\Column(type="string", length=255)
     */
    private $session;
    
    /**
     * @var Datetime $dateCreated The moment this request was created
     *
     * @Assert\DateTime
     * @Groups({"read"})
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateCreated;
    
    /**
     * @var Datetime $dateModified  The moment this request last Modified
     *
     * @Assert\DateTime
     * @Groups({"read"})
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateModified;
    
    public function getId(): Uuid
    {
    	return $this->id;
    }
    
    public function setId(Uuid $id): self
    {
    	$this->id = $id;
    	
    	return $this;
    }

    public function setApplication(?string $application): self
    {
        $this->application = $application;

        return $this;
    }

    public function getRequest(): ?string
    {
        return $this->request;
    }

    public function setRequest(?string $request): self
    {
        $this->request = $request;

        return $this;
    }

    public function getUser(): ?string
    {
        return $this->user;
    }

    public function setUser(?string $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(?string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getProcess(): ?string
    {
        return $this->process;
    }

    public function setProcess(?string $process): self
    {
        $this->process = $process;

        return $this;
    }

    public function getDataElements(): ?array
    {
        return $this->dataElements;
    }

    public function setDataElements(?array $dataElements): self
    {
        $this->dataElements = $dataElements;

        return $this;
    }

    public function getDataSubjects(): ?array
    {
        return $this->dataSubjects;
    }

    public function setDataSubjects(?array $dataSubjects): self
    {
        $this->dataSubjects = $dataSubjects;

        return $this;
    }

    public function getResource(): ?string
    {
        return $this->resource;
    }

    public function setResource(?string $resource): self
    {
    	$this->resource = $resource;

        return $this;
    }

    public function getResourceType(): ?string
    {
    	return $this->resourceType;
    }

    public function setResourceType(string $resourceType): self
    {
    	$this->resourceType = $resourceType;

        return $this;
    }

    public function getRoute(): ?string
    {
    	return $this->resourceType;
    }

    public function setRoute(string $route): self
    {
        $this->route = $route;

        return $this;
    }

    public function getEndpoint(): ?string
    {
        return $this->endpoint;
    }

    public function setEndpoint(string $endpoint): self
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    public function getMethod(): ?string
    {
        return $this->method;
    }

    public function setMethod(string $method): self
    {
        $this->method = $method;

        return $this;
    } 
    
    public function getAccept(): ?string
    {
    	return $this->accept;
    }
    
    public function setAccept(string $accept): self
    {
    	$this->accept= $accept;
    	
    	return $this;
    }

    public function getContentType(): ?string
    {
        return $this->contentType;
    }

    public function setContentType(string $contentType): self
    {
        $this->contentType = $contentType;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }
    
    public function getIp(): ?string
    {
    	return $this->ip;
    }
    
    public function setIp(string $ip): self
    {
    	$this->ip = $ip;
    	
    	return $this;
    }

    public function getSession(): ?string
    {
        return $this->session;
    }

    public function setSession(string $session): self
    {
        $this->session = $session;

        return $this;
    }
    
    public function getDateCreated(): ?\DateTimeInterface
    {
    	return $this->dateCreated;
    }
    
    public function setDateCreated(\DateTimeInterface $dateCreated): self
    {
    	$this->dateCreated= $dateCreated;
    	
    	return $this;
    }
    
    public function getDateModified(): ?\DateTimeInterface
    {
    	return $this->dateModified;
    }
    
    public function setDateModified(\DateTimeInterface $dateModified): self
    {
    	$this->dateModified = $dateModified;
    	
    	return $this;
    }
}
