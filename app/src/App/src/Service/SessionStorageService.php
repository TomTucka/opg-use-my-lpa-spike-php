<?php


use App\Handler\Traits\JwtTrait;

class SessionStorageService
{
    use JwtTrait;

    public function storeData($data)
    {
        $this->addTokenData('Data', $data);
    }
}
