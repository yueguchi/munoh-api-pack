# munoh-api-pack

# 環境構築

```
$docker-compose up -d --build
```

# env

```
cp .env.example .env
※dynamodbにwordテーブルがあることが前提
```

# DynamoDBのデータを検索用にES(ElasticSearch)Serviceに移行するためのpython

```
lambda下の*をzip -r lambda.zip ./*して、lambdaにuploadする。
(DynamoのStreamを有効にしていること。IAMでlambda dynamo ESへのアクセス権限があること。ESでドメインを作って、インデックス/タイプを指定したデータ登録があ行えること(PUT))
```
