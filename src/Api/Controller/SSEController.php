<?php

namespace Api\Controller;

class SSEController {

    private $redis;

    public function __construct(\Predis\Client $client) {
        $this->redis = $client;
    }

    function updateStream($request) {
        header("Content-Type: text/event-stream");
        header("Cache-Control: no-cache");
        header("Connection: keep-alive");
        $pubsub = new \Predis\PubSub\Consumer($this->redis);
        $pubsub->subscribe("messageUpdate");
        $id = 0;
        echo "id: $id\n";
        echo "data: {}\n\n";
        $id++;
        ob_flush();
        flush();
        while (true) {
            $message = $pubsub->current();
            if ($message->{'kind'} === "message") {
                $payload = $message->{'payload'};
                echo "id: $id\n";
                echo "data: $payload\n\n";
                $id++;
                ob_flush();
                flush();
            }
            sleep(1);
        }
    }
}
