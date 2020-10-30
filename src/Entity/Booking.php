<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=BookingRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Booking
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startDate;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\GreaterThan(propertyPath="startDate", message="La date départ doit être superieur à celle d'arrivée")
     */
    private $endDate;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="booking", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $customer;

    /**
     * @ORM\OneToMany(targetEntity=Calendar::class, mappedBy="booking")
     */
    private $period;

    private $manager;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbJour;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->period = new ArrayCollection();
        $this->manager = $manager;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getCustomer(): ?User
    {
        return $this->customer;
    }

    public function setCustomer(User $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @return Collection|Calendar[]
     */
    public function getPeriod(): Collection
    {
        return $this->period;
    }

    public function addPeriod(Calendar $period): self
    {
        if (!$this->period->contains($period)) {
            $this->period[] = $period;
            $period->setBooking($this);
        }

        return $this;
    }

   
    public function setPeriod(): self
    { 
        $days =  $this->manager->createQuery(
            'SELECT  c
            FROM App\Entity\Calendar c
            WHERE c.Date >= :startdate')
            ->setParameter('startdate',date_format($this->getStartDate(), 'Y-m-d 00:00:00'))
            ->setMaxResults($this->nbJour)
            ->getResult();
       
        //dump(date_format($this->getStartDate(), 'Y-m-d 00:00:00'));
        //die();
       

        foreach($days as $day){
            $this->addPeriod($day);
            $this->manager->persist($day);
            
            
        } 
        
        return $this;
    }

    public function removePeriod(Calendar $period): self
    {
        if ($this->period->contains($period)) {
            $this->period->removeElement($period);
            // set the owning side to null (unless already changed)
            if ($period->getBooking() === $this) {
                $period->setBooking(null);
            }
        }

        return $this;
    }

    public function setAmount(): self
    {
       $amont = 0;
       foreach ($this->getPeriod() as $day){
           $amont += $day->getPrice();
       } 
        $this->amount = $amont;
        return $this;
    }

    public function getAmount(): float
    {
      return $this->amount;
    }

    public function getNbJour(): ?int
    {
        return $this->nbJour;
    }


    public function setNbJour(): self
    {
        $this->nbJour =(int)(date_diff($this->getStartDate(), $this->getEndDate()))->days;
        return $this;
    }

     /** 
    * @ORM\PrePersist
    * @ORM\PreUpdate
    */

    public function initialise():self
    {
        $this->setNbJour();
        
        $this->setPeriod();
        
        $this->setAmount();

        return $this;

    }

}
