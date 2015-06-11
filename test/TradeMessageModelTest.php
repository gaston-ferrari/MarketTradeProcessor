<?php

class TradeMessageModelTest extends PHPUnit_Framework_TestCase {
    
    public function testInsertionAndDeletion (){
        $model = new \Api\Model\TradeMessageModel();
        $messageId = $model->insert("134256", "EUR", "GBP", 1000, 747.10, 0.7471, "24-JAN-15 10:27:44", "FR");
        $insertedMessage = $model->getMessage($messageId);
        $this->assertEquals('134256', $insertedMessage['userId']);
        $model->delete($messageId);
        
        $this->assertEquals(false, $model->getMessage($messageId));
    }
}
