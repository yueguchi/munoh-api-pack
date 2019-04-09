import boto3
import requests
import logging
logger = logging.getLogger()
logger.setLevel(logging.INFO)
from requests_aws4auth import AWS4Auth

region = 'ap-northeast-1'
service = 'es'
credentials = boto3.Session().get_credentials()
awsauth = AWS4Auth(credentials.access_key, credentials.secret_key, region, service, session_token=credentials.token)

host = 'https://search-munoh-search-bz33yvrlve67kvwg5plleuzwli.ap-northeast-1.es.amazonaws.com' # the Amazon ES domain, with https://
index = 'words'
type = 'word'
url = host + '/' + index + '/' + type + '/'

headers = { "Content-Type": "application/json" }

def handler(event, context):
    logger.info('got event{}'.format(event))
    count = 0
    for record in event['Records']:
        # Get the primary key for use as the Elasticsearch ID
        id = record['dynamodb']['Keys']['id']['S']

        if record['eventName'] == 'REMOVE':
            r = requests.delete(url + id, auth=awsauth)
        else:
            document = record['dynamodb']['NewImage']
            r = requests.put(url + id, auth=awsauth, json=document, headers=headers)
        count += 1
    return str(count) + ' records processed.'
