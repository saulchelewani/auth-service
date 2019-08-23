<?php


namespace TNM\AuthService\Exceptions;

use Exception;

abstract class AbstractException extends Exception
{

    abstract protected function addMessage(): string;

    abstract protected function addCode(): int;

    public function __construct()
    {
        parent::__construct($this->addMessage(), $this->addCode());
    }

    public function render()
    {
        return response()->json(["message" => $this->getMessage()], $this->getCode());
    }
}
