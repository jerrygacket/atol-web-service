<?php

namespace app\models;


use function print_r;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
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

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_on', 'updated_on'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_on'],
                ],
                'value' => new Expression('NOW()')
            ]
        ];
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
            ->addHeaders(['Content-Type' => 'application/json'])
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
            ->addHeaders(['Content-Type' => 'application/json'])
            ->setData($data)
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
    private function checkTaskStatus($uuid) {
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
            return ['error' => 'Timeout'];
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
        Yii::debug('--- isShiftOpen'.PHP_EOL.print_r($response,true));
        $response = $this->checkTaskStatus($newId);
        Yii::debug('--- checkTaskStatus'.PHP_EOL.print_r($response,true));
        print_r($response);
        Yii::$app->end();

//        return (($response['results'][0]['result']['shiftStatus']['state'] ?? '') == 'opened');
    }

    // Запрос состояния ККТ
    function checkKKT() {
        $newId =  $this->gen_uuid();
        $task = array('uuid' => $newId, 'request' => array('type' => 'getDeviceStatus'));
        $response = $this->postData($task);
        Yii::debug('--- getDeviceStatus'.PHP_EOL.print_r($response,true));
        $response = $this->checkTaskStatus($newId);

        return $response;
    }

    /**
     * Запрос состояния
     *
     * @return bool
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\base\ExitException
     */
    function status() {
        $response = $this->getData('/stat/requests');
        Yii::debug('--- status'.PHP_EOL.print_r($response,true));

        return ($response);
    }

    //Открытие смены
    public function openShift(string $operator = '') {
        if ($this->isShiftOpen()) {
            return ['error' => 'Shift is open'];
        }
        if ($operator == '') {
            return ['error' => 'No operator'];
        }

        $newId = $this->gen_uuid();
        $task = array(
            'uuid' => $newId,
            'request' => array(
                'type' => 'openShift',
                'operator' => array(
                    'name' => $operator //Фамилия и должность оператора
                    //'vatin' => '123654789507' //ИНН оператора
                )
            )
        );
        $response = $this->postData($task);
        Yii::debug('--- openShift'.PHP_EOL.print_r($response,true));
        $response = $this->checkStatus($newId);

        return $response;
    }

    //Закрытие смены
    public function closeShift() {
        if (!$this->isShiftOpen()) {
            return ['error' => 'Shift is closed'];
        }

        $newId = $this->gen_uuid();
        $task = array(
            'uuid' => $newId,
            'request' => array(
                'type' => 'closeShift',
            )
        );
        $response = $this->postData($task);
        Yii::debug('--- closeShift'.PHP_EOL.print_r($response,true));
        $response = $this->checkStatus($newId);

        return $response;
    }

    public function printSellReceipt($data = [], bool $autoOpenShift = true) {
        if (!$this->isShiftOpen()) {
            if ($autoOpenShift) {
                $this->openShift($data['operator'] ?? '');
                if (!$this->isShiftOpen()) {
                    return ['error' => 'Error while open shift'];
                }
            } else {
                return ['error' => 'Shift is closed'];
            }
        }

        $receipt = [];
        $receipt['type'] = 'sell';
        $task['electronically'] = $data['electronically'];
        $receipt['ignoreNonFiscalPrintErrors'] = false;
        $receipt['items'] = $data['goods'];
        $total = 0;
        foreach ($data['goods'] as $item) {
            if (array_key_exists('price',$item) and array_key_exists('quantity',$item)) {
                $total += $item['price'] * $item['quantity'];
            }
        }
        $receipt['payments'] = [['type' => $data['pay_type'], 'sum' => $total]];
        $receipt['total'] = $total;

        $newId = $this->gen_uuid();
        $task = ['uuid' => $newId, 'request' => $receipt];

        $response = $this->postData($task);
        Yii::debug('--- printSellReceipt'.PHP_EOL.print_r($response,true));
        $response = $this->checkStatus($newId);

        return $response;
    }

}
