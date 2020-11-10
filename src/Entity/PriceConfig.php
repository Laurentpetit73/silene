<?php

namespace App\Entity;

use App\Repository\PriceConfigRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PriceConfigRepository::class)
 */
class PriceConfig
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $year;

    /**
     * @ORM\OneToMany(targetEntity=DefaultDay::class, mappedBy="priceConfig")
     */
    private $defaultDays;

    private $manager;

    /**
     * @ORM\OneToMany(targetEntity=SpecialWeek::class, mappedBy="priceConfig")
     */
    private $specialWeeks;

    public function __construct( EntityManagerInterface $manager=null)
    {
        $this->defaultDays = new ArrayCollection();
        $this->manager = $manager;
        $this->specialWeeks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    /**
     * @return Collection|DefaultDay[]
     */
    public function getDefaultDays(): Collection
    {
        return $this->defaultDays;
    }

    public function addDefaultDay(DefaultDay $defaultDay): self
    {
        if (!$this->defaultDays->contains($defaultDay)) {
            $this->defaultDays[] = $defaultDay;
            $defaultDay->setPriceConfig($this);
        }

        return $this;
    }

    public function removeDefaultDay(DefaultDay $defaultDay): self
    {
        if ($this->defaultDays->contains($defaultDay)) {
            $this->defaultDays->removeElement($defaultDay);
            // set the owning side to null (unless already changed)
            if ($defaultDay->getPriceConfig() === $this) {
                $defaultDay->setPriceConfig(null);
            }
        }

        return $this;
    }

    public function setManager($manager){
        $this->manager = $manager;
        return $this;
    }
    public function update(){
        foreach($this->getDefaultDays() as $daydefault){
            $days = $this->manager->createQuery(
                'SELECT  c
                FROM App\Entity\Calendar c
                WHERE c.year = :startdate AND c.dayOfWeek = :number')
                ->setParameter('startdate',$this->year)
                ->setParameter('number',$daydefault->getNumber())
                ->getResult();
            
            foreach($days as $day){
                $day->setPrice($daydefault->getPrice());
                $this->manager->persist($day);
            }

        }
        foreach($this->getspecialWeeks() as $week){
            
            $price = $week->getPrice() / 7 ;
            $days = $this->manager->createQuery(
                'SELECT  c
                FROM App\Entity\Calendar c
                WHERE c.Date >= :startdate')
                ->setParameter('startdate',$week->getStartDate())
                ->setMaxResults(7)
                ->getResult();

            foreach($days as $day){
                $day->setPrice($price);
                $this->manager->persist($day);
            }

        }
      
        $this->manager->flush();
       
    }

    /**
     * @return Collection|SpecialWeek[]
     */
    public function getSpecialWeeks(): Collection
    {
        return $this->specialWeeks;
    }

    public function addSpecialWeek(SpecialWeek $specialWeek): self
    {
        if (!$this->specialWeeks->contains($specialWeek)) {
            $this->specialWeeks[] = $specialWeek;
            $specialWeek->setPriceConfig($this);
        }

        return $this;
    }

    public function removeSpecialWeek(SpecialWeek $specialWeek): self
    {
        if ($this->specialWeeks->contains($specialWeek)) {
            $this->specialWeeks->removeElement($specialWeek);
            // set the owning side to null (unless already changed)
            if ($specialWeek->getPriceConfig() === $this) {
                $specialWeek->setPriceConfig(null);
            }
        }

        return $this;
    }
}
