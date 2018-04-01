<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CinemaRepository")
 */
class Cinema
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nome;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $citta;

    /**
     * @ORM\Column(type="integer")
     */
    private $sale;

    public function getId()
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    public function getCitta(): ?string
    {
        return $this->citta;
    }

    public function setCitta(string $citta): self
    {
        $this->citta = $citta;

        return $this;
    }

    public function getSale(): ?int
    {
        return $this->sale;
    }

    public function setSale(int $sale): self
    {
        $this->sale = $sale;

        return $this;
    }
}
