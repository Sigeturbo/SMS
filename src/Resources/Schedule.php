<?php

namespace SigeTurbo\SMS\Resources;

class Schedule extends Resource
{

    /**
     * Schedule Message
     * @param $to
     * @param $txt
     * @param $date
     * @param null $campaign
     * @return mixed
     */
    public function schedule($to, $txt, $date, $campaign = null)
    {
        $data = array("destinations" => $to, "text" => $txt, "scheduleDate" => $date);
        if (isset($campaign)) {
            $data['campaign'] = $campaign;
        }
        $response = $this->apiClient->post('messages', $data);
        return $response->scheduleId;
    }

    /**
     * Get Message
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        $response = $this->apiClient->get('schedules/' . $id);
        return $response;
    }

    /**
     * Get All Messages
     * @return mixed
     */
    public function getAll()
    {
        $response = $this->apiClient->get('schedules/scheduled');
        return $response;
    }

    /**
     * Unschedule Message
     * @param $id
     */
    public function unschedule($id)
    {
        $this->apiClient->delete('schedules/' . $id);
    }
}

?>