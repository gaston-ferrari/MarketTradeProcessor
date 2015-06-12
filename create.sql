CREATE TABLE `trade_message` (
  `trade_message_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(45) NOT NULL,
  `currency_from` varchar(45) NOT NULL,
  `currency_to` varchar(45) NOT NULL,
  `amount_sell` float NOT NULL,
  `amount_buy` float NOT NULL,
  `rate` float NOT NULL,
  `time_placed` datetime NOT NULL,
  `originating_country` varchar(45) NOT NULL,
  PRIMARY KEY (`trade_message_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8$$
