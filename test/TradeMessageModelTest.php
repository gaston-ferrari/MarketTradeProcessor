<?php

class TradeMessageModelTest extends PHPUnit_Framework_TestCase {

    public function testInsertionAndDeletion() {
        $model = new \Api\Model\TradeMessageModel();
        $messageId = $model->insert("134256", "EUR", "GBP", 1000, 747.10, 0.7471, 1422106064, "FR");
        $insertedMessage = $model->getMessage($messageId);
        $this->assertEquals('134256', $insertedMessage['user_id']);
        $model->delete($messageId);

        $this->assertEquals(false, $model->getMessage($messageId));
    }

}
