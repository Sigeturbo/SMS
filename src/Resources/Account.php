<?php

namespace SigeTurbo\SMS\Resources;

class Account extends Resource
{

    /**
     * Get Account
     * @return mixed
     */
    public function get()
    {
        $response = $this->apiClient->get('account');
        return $response;
    }
}
