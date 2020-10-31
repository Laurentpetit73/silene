<?php

namespace App\Entity;

use App\Repository\CalendarRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CalendarRepository::class)
 */
class Calendar
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $DateKey;

    /**
     * @ORM\Column(type="datetime")
     */
    private $Date;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $day;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $month;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $year;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dayName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $monthName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $monthNameMin;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dayOfWeek;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dayNameMin;

    /**
     * @ORM\ManyToOne(targetEntity=Booking::class, inversedBy="period")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $booking;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateKey(): ?string
    {
        return $this->DateKey;
    }

    public function setDateKey(string $DateKey): self
    {
        $this->DateKey = $DateKey;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(\DateTimeInterface $Date): self
    {
        $this->Date = $Date;

        return $this;
    }

    public function getDay(): ?string
    {
        return $this->day;
    }

    public function setDay(string $day): self
    {
        $this->day = $day;

        return $this;
    }

    public function getMonth(): ?string
    {
        return $this->month;
    }

    public function setMonth(string $month): self
    {
        $this->month = $month;

        return $this;
    }

    public function getYear(): ?string
    {
        return $this->year;
    }

    public function setYear(string $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getDayName(): ?string
    {
        return $this->dayName;
    }

    public function setDayName(string $dayName): self
    {
        $this->dayName = $dayName;

        return $this;
    }

    public function getMonthName(): ?string
    {
        return $this->monthName;
    }

    public function setMonthName(string $monthName): self
    {
        $this->monthName = $monthName;

        return $this;
    }

    public function getMonthNameMin(): ?string
    {
        return $this->monthNameMin;
    }

    public function setMonthNameMin(string $monthNameMin): self
    {
        $this->monthNameMin = $monthNameMin;

        return $this;
    }

    public function getDayOfWeek(): ?string
    {
        return $this->dayOfWeek;
    }

    public function setDayOfWeek(string $dayOfWeek): self
    {
        $this->dayOfWeek = $dayOfWeek;

        return $this;
    }

    public function getDayNameMin(): ?string
    {
        return $this->dayNameMin;
    }

    public function setDayNameMin(string $dayNameMin): self
    {
        $this->dayNameMin = $dayNameMin;

        return $this;
    }

    public function getBooking(): ?Booking
    {
        return $this->booking;
    }

    public function setBooking(?Booking $booking): self
    {
        $this->booking = $booking;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }
}
