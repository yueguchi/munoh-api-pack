console.log('Loading function');

// TODO dynamo -> lambda -> cloudwatchlogsまではできたので、あとはESにぶっこむだけ。
exports.handler = async (event, context) => {
    //console.log('Received event:', JSON.stringify(event, null, 2));
    event.Records.forEach((record) => {
        console.log(record.eventID);
        console.log(record.eventName);
        console.log('DynamoDB Record: %j', record.dynamodb);
        console.log('word1: %j', record.dynamodb.NewImage.word1['S']);
        console.log('word2: %j', record.dynamodb.NewImage.word2['S']);
        console.log('word3: %j', record.dynamodb.NewImage.word3['S']);
    });
    return `Successfully processed ${event.Records.length} records.`;
};
