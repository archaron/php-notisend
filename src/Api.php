<?php
/**
 * @link https://github.com/archaron/yii2-notisend
 * @copyright Copyright (c) 2021 Alexander Tischenko (tsm@archaron.ru)
 * @license https://github.com/archaron/yii2-notisend/blob/main/LICENSE
 */
namespace archaron\notisend {

    use archaron\notisend\exceptions\ConfigException;
    use yii\base\Component;
    use yii\httpclient\Client;
    use Yii;
    use yii\httpclient\Exception;

    class Api extends Component
    {

        private ?yii\httpclient\Client $httpClient = null;
        public bool $apiKey = false;
        public string $baseUrl = "https://api.notisend.ru/v1";

        /**
         * @return yii\httpclient\Client
         */
        public function getHttpClient() : yii\httpclient\Client
        {
            if (!is_object($this->httpClient)) {
                $this->httpClient =new Client([
                    'baseUrl' => $this->baseUrl,
                    'requestConfig' => [
                        'format' => Client::FORMAT_JSON,
                        'headers' => [
                            'Authorization' => 'Bearer ' . $this->apiKey,
                        ]
                    ],
                    'responseConfig' => [
                        'format' => Client::FORMAT_JSON
                    ],
                ]);
            }
            return $this->httpClient;
        }

        /**
         * @throws ConfigException
         */
        public function init()
        {
            if (!$this->apiKey) {
                throw new ConfigException("apikey is not set");
            }
            parent::init();
        }

        /**
         * @throws Exception
         */
        private function doRequest(string $url): \yii\httpclient\Response
        {
            return $this->getHttpClient()->get($url)->send();
        }

        /**
         * @throws Exception
         */
        private function doPostRequest(string $url, array $data): \yii\httpclient\Response
        {
            return $this->getHttpClient()->post($url, $data)->send();
        }


        /**
         * @throws Exception
         */
        public function EmailLists()
        {
            return $this->doRequest("email/lists")->data;
        }

        /**
         * @throws Exception
         */
        public function EmailListParameters(int $id)
        {
            return $this->doRequest("email/lists/".$id.'/parameters')->data;
        }

        /**
         * @throws Exception
         */
        public function EmailListAddRecipient(int $list_id, array $recipient)
        {
            return $this->doPostRequest("email/lists/".$list_id.'/recipients', $recipient)->data;
        }

        /**
         * @throws Exception
         */
        public function EmailListRecipientInfo(int $list_id, int $recipient_id)
        {
            return $this->doRequest("email/lists/".$list_id.'/recipients/'.$recipient_id)->data;
        }

        /**
         * @throws Exception
         * @example  $api->EmailListRecipientSearch('some@e-mail.com');
         */
        public function EmailListRecipientSearch(string $email)
        {
            return $this->doRequest("email/recipients/search?email=".urlencode($email))->data;
        }
    }
}