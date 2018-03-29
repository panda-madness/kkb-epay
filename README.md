# KKB Epay

Эта библиотека предоставляет функционал для генерирования запросов для и обработки ответов от системы Epay Казкоммерцбанка.

## Установка

Необходимо расширение php_xml.

```
composer require panda-madness/kkb-epay
```

## Использование

```
$epay = new \Epay\Epay([
    'certificate_id' => '00C182B189',
    'merchant_name' => 'Test shop',
    'merchant_id' => '92061101',
    'priv_key_path' => './epay/more2/test_prv.pem',
    'priv_key_pass' => 'nissan',
    'pub_key_path' => './epay/more2/kkbca.pem',
]);

// Основной запрос оплаты
$request = $epay->buildRequest('payment', [
    'order_id' => 1234,
    'amount' => 1000,
    'currency' => 398,
    fields => [
        'RL' => 1234567,
        'abonent_id' => 1234567,
        ...
    ]
])->getXML();

// Статус платежа
$request = $epay->buildRequest('status', ['order_id' => 1234])->getXML();

//Обработка ответов Epay
$response = $epay->parseResponse('payment', $_POST['response']); // $_POST только для примера, не делайте так в реальной жизни

$client = new GuzzleHttp\Client();
$resp = $client->get('https://testpay.kkb.kz/jsp/remote/checkOrdern.jsp?' . urlencode($request));

$response = $epay->parseResponse('status', $resp->getBody()->getContent());

//verify() проверяет подпись ответа.
if($response->verify()) {
    print_r($response->getProps());
    // getProps возвращает массив с параметрами ответа
} else {
    echo 'Response not valid';
}
``` 

## Todo

- Запросы для системы мониторинга платежей (https://testpay.kkb.kz/doc/htm/remote.html)
- Unit тесты
- Докблоки