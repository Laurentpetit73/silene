<?php

namespace App\Entity;

use App\Repository\PasswordUpdateRepository;
use Doctrine\ORM\Mapping as ORM;


class PasswordUpdate
{
   
    private $id;

    
    private $oldPass;

    
    private $newPass;

    
    private $confirmPass;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOldPass(): ?string
    {
        return $this->oldPass;
    }

    public function setOldPass(string $oldPass): self
    {
        $this->oldPass = $oldPass;

        return $this;
    }

    public function getNewPass(): ?string
    {
        return $this->newPass;
    }

    public function setNewPass(string $newPass): self
    {
        $this->newPass = $newPass;

        return $this;
    }

    public function getConfirmPass(): ?string
    {
        return $this->confirmPass;
    }

    public function setConfirmPass(string $confirmPass): self
    {
        $this->confirmPass = $confirmPass;

        return $this;
    }
}
