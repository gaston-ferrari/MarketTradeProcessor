<?php

class TradeMessageControllerTest extends PHPUnit_Framework_TestCase {

    public function testGetMessage() {
        $model = new \Api\Model\TradeMessageModel();
        //userId, currencyFrom, currencyTo, amountSell, amountBuy, rate, timePlaced, originatingCountry
        $messageId = $model->insert("134256", "EUR", "GBP", 1000, 747.10, 0.7471, 1422106064, "FR");
        $redis = new \Predis\Client();
        $controller = new Api\Controller\TradeMessageController($model, $redis);
        $req = new \Api\Util\Request();
        $req->setData(['id' => $messageId]);
        $message = $controller->getMessage($req);
        $this->assertEquals('134256', $message['user_id']);
        $this->assertEquals(1000, $message['amount_sell']);

        $req->setData(['id' => "i"]);
        $threwException = false;
        try {
            $message = $controller->getMessage($req);
        } catch (Exception $e) {
            $threwException = true;
        }
        $this->assertEquals(true, $threwException);

        $model->delete($messageId);
    }

    public function testInsertMessage() {
        $model = new \Api\Model\TradeMessageModel();
        $prevAmount = count($model->getAllMessages(9999, 0));
        $redis = new \Predis\Client();
        $controller = new Api\Controller\TradeMessageController($model, $redis);
        $req = new \Api\Util\Request();
        $messageData = ['userId' => '134256', 'currencyFrom' => 'EUR', 'currencyTo' => 'GBP', 'amountSell' => 1000
            , 'amountBuy' => 747.10, 'rate' => 0.7471, 'timePlaced' => '24-JAN-15 10:27:44', 'originatingCountry' => 'FR'];
        $req->setData($messageData);
        $messageId = FALSE;
        try {
            $res = $controller->addMessage($req);
            $messageId = $res["messageId"];
        } catch (Exception $e) {
            $this->assertEquals("It didn't crash", "It crashed");
        }

        $newAmount = count($model->getAllMessages(999,0));
        $this->assertEquals($prevAmount + 1, $newAmount);

        $messageData = ['userId' => '134256', 'currencyFrom' => 'EUR'];
        $req->setData($messageData);
        $threwException = false;
        try {
            $controller->addMessage($req);
        } catch (Exception $e) {
            $threwException = true;
        }
        $this->assertEquals(true, $threwException);

        if ($messageId) {
            $model->delete($messageId);
        }
    }

}
