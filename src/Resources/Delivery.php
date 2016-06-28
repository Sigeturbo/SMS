<?php

namespace SigeTurbo\SMS\Resources;

class Delivery extends Resource
{

    public function get($id)
    {
        $response = $this->apiClient->get('messages/' . $id);
        return $response;
    }
}