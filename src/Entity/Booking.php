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
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="booking")
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

    /**
     * @ORM\Column(type="boolean")
     */
    private $IsBooking;

    /**
     * @ORM\Column(type="boolean")
     */
    private $IsPay;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->period = new ArrayCollection();
        $this->manager = $manager;
        $this->IsBooking = false;
        $this->IsPay = false;
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

    public function getCalendars():array
    {
        return $this->manager->createQuery(
            'SELECT  c
            FROM App\Entity\Calendar c
            WHERE c.Date >= :startdate')
            ->setParameter('startdate',date_format($this->getStartDate(), 'Y-m-d 00:00:00'))
            ->setMaxResults($this->nbJour)
            ->getResult();

    }

   
    public function setPeriod(): self
    { 
        $days  = $this->getCalendars(); 
        $i=0;
        $end = count($days)-1;
        foreach($days as $day){
            if($i === 0){
                $day->setIsStart(true);
            }
            if($end === $i){
                $day->setIsEnd(true);
            }
            $i++;
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
       if($this->IsBooking){
        $days = $this->getPeriod();
        }else{
        $days = $this->getCalendars();
        }
       foreach ($days as $day){
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
        if($this->IsPay == true){
            return $this;
        }
        $this->setNbJour();

        if($this->IsBooking){
            $this->setPeriod();
        }
        $this->setAmount();

        return $this;

    }

    public function getIsBooking(): ?bool
    {
        return $this->IsBooking;
    }

    public function setIsBooking(bool $IsBooking): self
    {
        $this->IsBooking = $IsBooking;

        return $this;
    }

    public function getIsPay(): ?bool
    {
        return $this->IsPay;
    }

    public function setIsPay(bool $IsPay): self
    {
        $this->IsPay = $IsPay;

        return $this;
    }

    public function setManager($manager): self
    {
        $this->manager = $manager;

        return $this;
    }

}
