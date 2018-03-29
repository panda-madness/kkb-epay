# KKB Epay

Эта библиотека предоставляет функционал для генерирования запросов для и обработки ответов от системы Epay Казкоммерцбанка.

## Установка

Необходимо расширение php_xml.

```
composer require panda-madness/kkb-epay
```

## Использование

```
$epay = new \KkbEpay\Epay([
    'MERCHANT_CERTIFICATE_ID' => 'c183c6c7',
    'MERCHANT_NAME' => 'Tele2',
    'PRIVATE_KEY_FN' => 'resources/epay2/cert.prv',
    'PRIVATE_KEY_PASS' => '1q2w3e4r',
    'PUBLIC_KEY_FN' => 'resources/epay2/cert.cer',
    'MERCHANT_ID' => '98375106',
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