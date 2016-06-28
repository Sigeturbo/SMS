<?php

namespace SigeTurbo\SMS\Resources;

class User extends Resource
{

    /**
     * Get All Users
     * @return mixed
     */
    public function getAll()
    {
        $response = $this->apiClient->get('users');
        return $response;
    }

    /**
     * Get User
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        $response = $this->apiClient->get('users/' . $id);
        return $response;
    }
}