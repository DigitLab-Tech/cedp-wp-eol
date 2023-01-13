<?php

namespace CEDP\WPEOL\App;

class AjaxResponse
{
    public function __construct(
        protected string $msg = '', 
        protected array $data = [],  
        protected bool $hasError = false,
        protected string $json = ''
    ){}

    public function getMsg(): string{
        return $this->msg;
    }

    public function getData(): array{
        return $this->data;
    }

    public function getHasError(): bool{
        return $this->hasError;
    }

    public function getJson(): string{
        return $this->json;
    }

    public function setMsg(string $msg): self{
        $this->msg = $msg;
        return $this;
    }

    public function setData(array $data): self{
        $this->data = $data;
        return $this;
    }

    public function setHasError(bool $hasError): self{
        $this->hasError = $hasError;
        return $this;
    }

    public function setJson(string $json): self{
        $this->json = $json;
        return $this;
    }

    public function toJson(): string{
        return json_encode([
            'msg' => $this->getMsg(),
            'data' => $this->getData(),
            'hasError' => $this->getHasError(),
            'json' => json_decode($this->getJson())
        ]);
    }
}