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
//        $not_ready = true;
//        $this->error = 1;
//        $counter = 0;
//        while ($not_ready) {
//            $response = $this->getData('/requests/'.$uuid);
//            $not_ready = ($response['results'][0]['status'] != 'ready');
//            sleep(1);
//            $counter++;
//            if ($counter > 30) {break;} //ждем 30 секунд и типа отваливаемся по таймауту
//        }
//        if ($not_ready) {
//            return 'Timeout'.PHP_EOL;
//        } else {
//            $this->status = true;
//            $this->error = $response['results'][0]['errorCode'] ?? 1;
//            return $response;
//        }
        return false;
    }

    //Открытие смены
    function openShift() {
//        if (!$this->connected) {
//            echo 'Not connected'.PHP_EOL;
//            return false;
//        }
//        if ($this->isShiftOpen()) {
//            echo 'Shift is open'.PHP_EOL;
//            return false;
//        }
//        if ($this->operator == '') {
//            echo 'No operator'.PHP_EOL;
//            return false;
//        }
//        $newId = exec('uuidgen -r');
//        $task = array(
//            'uuid' => $newId,
//            'request' => array(
//                'type' => 'openShift',
//                'operator' => array(
//                    'name' => $this->operator //Фамилия и должность оператора
//                    //'vatin' => '123654789507' //ИНН оператора
//                )
//            )
//        );
//        $response = $this->postData($task);
//        if (!empty($response)) {print_r($response);}
//        $response = $this->checkStatus($newId);
//        return $response;
    }

    //Закрытие смены
    function closeShift() {
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
