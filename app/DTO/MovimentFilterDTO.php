<?php

namespace App\DTO;

use DateTime;

class MovimentFilterDTO
{
    private ?int $id = null;
    private ?string $description = null;
    private ?int $value = null;
    private ?DateTime $date = null;
    private ?string $type = null;
    private ?string $category = null;
    private bool $byPeriod = false;

    public function id(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): static
    {
        $this->id = $id;
        return $this;
    }

    public function description(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function value(): ?int
    {
        return $this->value;
    }

    public function setValue(?int $value): static
    {
        $this->value = $value;
        return $this;
    }

    public function date(): ?DateTime
    {
        return $this->date;
    }

    public function setDate(?string $date): static
    {
        $this->date = DateTime::createFromFormat('d/m/Y', $date);
        return $this;
    }

    public function type(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): static
    {
        $this->type = $type;
        return $this;
    }

    public function category(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): static
    {
        $this->category = $category;
        return $this;
    }
}
