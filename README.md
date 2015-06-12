# MarketTradeProcessor
This test project runs on a LAMP stack with no special configurations.
There should be a MySQL database named test and user 'testUser' should be able to access it with password 'test', create the database with the provided .sql file.

I'd like to say that if this was a feature to be deployed to production I'd probably choose a NoSQL database given that there is no relational data in use and some other databases have better insertion speeds which would be crucial in this case. I could also consider a mixed approach, keeping the most recent transactions in a memory based storage system (e.g. Redis, MongoDB, Cassandra) and using a SQL DB for historical data.

There are also some things that I'd add if I had more time, like a caching strategy and filter features to the API.

