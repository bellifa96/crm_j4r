<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use DateTimeInterface;

Trait TimestampableTrait
{
    /**
     * @var DateTimeInterface
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $date_creation;
    /**
     * @var DateTimeInterface
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_modification;

    /**
     * @return DateTimeInterface
     */
    public function getDateCreation(): DateTimeInterface
    {
        return $this->date_creation;
    }

    /**
     * @param DateTimeInterface $date_creation
     */
    public function setDateCreation(DateTimeInterface $date_creation): void
    {
        $this->date_creation = $date_creation;
    }

    /**
     * @return DateTimeInterface
     */
    public function getDateModification(): DateTimeInterface
    {
        return $this->date_modification;
    }

    /**
     * @param DateTimeInterface $date_modification
     */
    public function setDateModification(DateTimeInterface $date_modification): void
    {
        $this->date_modification = $date_modification;
    }
}
