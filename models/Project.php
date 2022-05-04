<?php

namespace App\Models;

class Project extends Deserializer
{
    public string $uid;
    public string $name;
    public string $status;
    public string $sourceLang;
    public array $targetLangs;

    /**
     * @return string
     */
    public function getUid(): string
    {
        return $this->uid;
    }

    /**
     * @param string $id
     */
    public function setUid(string $uid): void
    {
        $this->uid = $uid;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getSourceLang(): string
    {
        return $this->sourceLang;
    }

    /**
     * @param string $sourceLang
     */
    public function setSourceLang(string $sourceLang): void
    {
        $this->sourceLang = $sourceLang;
    }

    /**
     * @return array
     */
    public function getTargetLangs(): array
    {
        return $this->targetLangs;
    }

    /**
     * @param array $targetLangs
     */
    public function setTargetLangs(array $targetLangs): void
    {
        $this->targetLangs = $targetLangs;
    }


}