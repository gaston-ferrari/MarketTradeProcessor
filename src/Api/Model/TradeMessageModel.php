<?php

namespace Api\Model;

class TradeMessageModel extends BaseModel {

    public function getMessage($id) {
        $dbConn = $this->getConn();
        $id = mysqli_real_escape_string($dbConn, $id);
        $query = "SELECT * FROM trade_message WHERE trade_message_id = '$id'";
        $result = $this->fetchQuery($dbConn, $query);
        $this->closeConnection();
        $res = empty($result) ? FALSE : $result[0];
        return $res;
    }

    public function insert($userId, $currencyFrom, $currencyTo, $amountSell, $amountBuy, $rate, $timePlaced, $originatingCountry) {
        $dbConn = $this->getConn();
        $userId = mysqli_real_escape_string($dbConn, $userId);
        $currencyFrom = mysqli_real_escape_string($dbConn, $currencyFrom);
        $currencyTo = mysqli_real_escape_string($dbConn, $currencyTo);
        $amountSell = mysqli_real_escape_string($dbConn, $amountSell);
        $amountBuy = mysqli_real_escape_string($dbConn, $amountBuy);
        $rate = mysqli_real_escape_string($dbConn, $rate);
        $date = date('Y-m-d H:i:s', $timePlaced);
        $originatingCountry = mysqli_real_escape_string($dbConn, $originatingCountry);
        $query = "INSERT INTO trade_message (user_id, currency_from, currency_to, amount_sell, amount_buy, rate, time_placed, originating_country) 
                  VALUES 
                  ('$userId', '$currencyFrom', '$currencyTo', '$amountSell', '$amountBuy', '$rate', '$date', '$originatingCountry')";

        $id = $this->insertQuery($dbConn, $query);
        $this->closeConnection();
        return $id;
    }

    public function delete($id) {
        $dbConn = $this->getConn();
        $id = mysqli_real_escape_string($dbConn, $id);
        $query = "DELETE FROM trade_message WHERE trade_message_id = '$id'";
        $result = $this->deleteQuery($dbConn, $query);
        $this->closeConnection();
        return $result;
    }

    public function getAllMessages($limit, $offset) {
        $dbConn = $this->getConn();
        $limit = mysqli_real_escape_string($dbConn, $limit);
        $offset = mysqli_real_escape_string($dbConn, $offset);
        $query = "SELECT * FROM trade_message LIMIT $limit OFFSET $offset";
        $result = $this->fetchQuery($dbConn, $query);
        $this->closeConnection();
        return $result;
    }

}
