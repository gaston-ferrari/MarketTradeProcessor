<?php

namespace Api\Controller;

class TradeMessageController {

    private $messageModel;
    private $redis;

    public function __construct(\Api\Model\TradeMessageModel $messageModel, \Predis\Client $redis) {
        $this->messageModel = $messageModel;
        $this->redis = $redis;
    }

    function getMessage($request) {
        $reqData = $request->getData();
        $id = filter_var($reqData['id'], FILTER_VALIDATE_INT);
        if ($id === FALSE) {
            throw new \Exception("Invalid input.");
        }
        $message = $this->messageModel->getMessage($id);
        if ($message !== FALSE) {
            return $message;
        } else {
            throw new \Exception("Message not found");
        }
    }

    function getMessages($request) {
        $messages = $this->messageModel->getAllMessages();
        return $messages;
    }

    function addMessage($request) {
        $reqData = $request->getData();
        $userId = isset($reqData['userId']) ? $reqData['userId'] : FALSE;
        $currencyFrom = isset($reqData['currencyFrom']) ? $reqData['currencyFrom'] : FALSE;
        $currencyTo = isset($reqData['currencyTo']) ? $reqData['currencyTo'] : FALSE;
        $amountSell = isset($reqData['amountSell']) ? $reqData['amountSell'] : FALSE;
        $amountBuy = isset($reqData['amountBuy']) ? $reqData['amountBuy'] : FALSE;
        $rate = isset($reqData['rate']) ? $reqData['rate'] : FALSE;
        $timePlaced = isset($reqData['timePlaced']) ? $reqData['timePlaced'] : FALSE;
        $originatingCountry = isset($reqData['originatingCountry']) ? $reqData['originatingCountry'] : FALSE;
        if (!$userId || !$currencyFrom || !$currencyTo || !$amountSell || !$amountBuy || !$rate || !$originatingCountry) {
            throw new \Exception("Invalid input.");
        }
        if ($timePlaced) {
            $date = \DateTime::createFromFormat('d-M-y H:i:s', $timePlaced);
            $timePlaced = $date->getTimestamp();
        } else {
            $timePlaced = time();
        }

        $res = $this->messageModel->insert($userId, $currencyFrom, $currencyTo, $amountSell, $amountBuy, $rate, $timePlaced, $originatingCountry);
        if ($res) {
            $this->redis->publish("messageUpdate", json_encode($this->messageModel->getMessage($res)));
            return ["messageId" => $res];
        } else {
            throw new \Exception("There was an error inserting the address.");
        }
    }

}
