<?php

namespace SigeTurbo\SMS\Resources;

class Message extends Resource
{
    public function send($to, $txt, $campaign = null)
    {
        $data = array("destinations" => $to, "text" => $txt);
        if (isset($campaign)) {
            $data['campaign'] = $campaign;
        }
        $response = $this->apiClient->post('messages', $data);
        return $response->deliveryToken;
    }
}