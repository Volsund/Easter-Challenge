<?php

namespace EasterChallenge;

class Player
{

    private string $name;

    private int $eggs;

    private int $wins;

    private int $losses;

    private string $createdAt;

    public function __construct(string $name, ?int $losses = null, ?int $wins = null, ?string $createdAt = null)
    {
        $this->name = $name;
        $this->eggs = 3;
        $this->wins = $wins ?? 0;
        $this->losses = $losses ?? 0;
        $this->createdAt = $createdAt ?? date(DATE_ATOM);
    }

    public function getEggs(): int
    {
        return $this->eggs;
    }

    public function removeEgg(): void
    {
        $this->eggs--;
    }

    public function addWin(): void
    {
        $this->wins++;
    }

    public function addLoss(): void
    {
        $this->losses++;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getWins(): int
    {
        return $this->wins;
    }

    public function getDate(): string
    {
        return $this->createdAt;
    }

    public function getLosses(): int
    {
        return $this->losses;
    }


}
