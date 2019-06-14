<?php

namespace app\models;

use yii\httpclient\Client;
use yii\httpclient\Response;

/**
 * This is the model class for table "printers".
 *
 * @property int $id
 * @property string $printer_id
 * @property string $printer_name
 * @property string $description
 * @property string $connect_string
 * @property string $created_on
 * @property string $updated_on
 */
class Printers extends PrintersBase
{
    public $client;
    public $timeout;

    public function __construct($config = [])
    {
        parent::__construct($config);

        $this->client = new Client([
            'baseUrl' => $this->connect_string,
            'requestConfig' => [
                'format' => Client::FORMAT_JSON
            ],
            'responseConfig' => [
                'format' => Client::FORMAT_JSON
            ],
        ]);
        $this->timeout = 30; //seconds
        //TODO: get timeout from config
    }

    /**
     * Generate uuid v4
     *
     * @return string
     */
    private function gen_uuid() {
        return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

            // 16 bits for "time_mid"
            mt_rand( 0, 0xffff ),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand( 0, 0x0fff ) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand( 0, 0x3fff ) | 0x8000,

            // 48 bits for "node"
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
    }

    /**
     * read data from printer
     *
     * @param $uri
     * @param array $data
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     * @var $response Response
     */
    private function getData($uri, $data = []) {
        $response = $this->client->createRequest()
            ->setMethod('GET')
            ->setUrl($uri)
            ->setData($data)
            ->send();
        if (!$response->isOk) {
            return false;
        }

        return $response->data;
    }

    /**
     * write data to printer
     *
     * @param $data
     * @return bool
     * @throws \yii\base\InvalidConfigException
     * * @var $response Response
     */
    private function postData($data) {
        $response = $this->client->createRequest()
            ->setMethod('POST')
            ->setUrl('/requests')
            ->setData(['json' => $data])
            ->send();
        if (!$response->isOk) {
            return false;
        }

        return $response->data;
    }

    /**
     * check task status by uuid
     *
     * @param $uuid
     * @return mixed|string
     * @throws \yii\base\InvalidConfigException
     */
    private function checkStatus($uuid) {
        $ready = false;
        $counter = 0;
        while (!$ready) {
            $response = $this->getData('/requests/'.$uuid);
            $ready = ($response['results'][0]['status'] == 'ready');
            sleep(1);
            $counter++;
            if ($counter > $this->timeout) {break;} //ждем 30 секунд и типа отваливаемся по таймауту
        }
        if (!$ready) {
            return 'Timeout'.PHP_EOL;
        } else {
            $this->status = true;
            $this->error = $response['results'][0]['errorCode'] ?? 1;
        }
        return $response;
    }

    /**
     * Запрос состояния смены
     *
     * @return bool
     * @throws \yii\base\InvalidConfigException
     */
    function isShiftOpen() {
        $newId = $this->gen_uuid();
        $task = [
            'uuid' => $newId,
            'request' => ['type' => 'getShiftStatus'],
        ];

        $response = $this->postData($task);
        if (!empty($response)) {print_r($response);}
        $response = $this->checkStatus($newId);

        return (($response['results'][0]['result']['shiftStatus']['state'] ?? '') == 'opened');
    }

    //Открытие смены
    public function openShift() {
        if ($this->isShiftOpen()) {
            echo 'Shift is open'.PHP_EOL;
            return false;
        }
        if ($this->operator == '') {
            echo 'No operator'.PHP_EOL;
            return false;
        }
        $newId = exec('uuidgen -r');
        $task = array(
            'uuid' => $newId,
            'request' => array(
                'type' => 'openShift',
                'operator' => array(
                    'name' => $this->operator //Фамилия и должность оператора
                    //'vatin' => '123654789507' //ИНН оператора
                )
            )
        );
        $response = $this->postData($task);
        if (!empty($response)) {print_r($response);}
        $response = $this->checkStatus($newId);
        return $response;
    }

    //Закрытие смены
    public function closeShift() {
//        if (!$this->connected) {
//            echo 'Not connected'.PHP_EOL;
//            return false;
//        }
//        if (!$this->isShiftOpen()) {
//            echo 'Shift is closed'.PHP_EOL;
//            return false;
//        }
//        $newId = exec('uuidgen -r');
//        $task = array(
//            'uuid' => $newId,
//            'request' => array(
//                'type' => 'closeShift',
//            )
//        );
//        $response = $this->postData($task);
//        if (!empty($response)) {print_r($response);}
//        $response = $this->checkStatus($newId);
//        return $response;
    }

    public function printSellReceipt() {
//        if (!$this->isShiftOpen()) {
//            $this->openShift();
//            if (!$this->isShiftOpen()) {
//                echo 'Error open shift'.PHP_EOL;
//                return false;
//            }
//        }
//        //~ "clientInfo": {
//        //~ "emailOrPhone": "+79161234567"
//        //~ },
//        $receipt = array();
//        $receipt['type'] = 'sell';
//        //$task['electronically'] = false;
//        $receipt['ignoreNonFiscalPrintErrors'] = false;
//        //~ $receipt['taxationType'] = 'usnIncome';
//        // $receipt['operator']['name'] = $this->operator;
//        $receipt['items'] = $items;
//        $total = 0;
//        foreach ($items as $item) {
//            if (array_key_exists('price',$item) and array_key_exists('quantity',$item)) {
//                $total += $item['price'] * $item['quantity'];
//            }
//        }
//        $receipt['payments'] = array(array('type' => 'electronically', 'sum' => $total));
//        $receipt['total'] = $total;
//        $newId = exec('uuidgen -r');
//        $task = array('uuid' => $newId, 'request' => $receipt);
//        $response = $this->postData($task);
//        if (!empty($response)) {print_r($response);}
//        $response = $this->checkStatus($newId);
//        return $response;
    }

}
