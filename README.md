# KKB Epay

Эта библиотека предоставляет функционал для генерирования запросов для и обработки ответов от системы Epay Казкоммерцбанка.

В папке `test-certs` лежат тестовые сертификаты, которые используются в тестах. 

## Установка

Необходимо расширение php_xml.

```
composer require panda-madness/kkb-epay
```

## Использование

```php
$epay = new \KkbEpay\Epay([
    'MERCHANT_CERTIFICATE_ID' => '12345678',
    'MERCHANT_NAME' => 'Test Shop',
    'PRIVATE_KEY_FN' => './epay/cert.prv',
    'PRIVATE_KEY_PASS' => '1q2w3e4r',
    'PUBLIC_KEY_FN' => './epay/cert.cer',
    'MERCHANT_ID' => '12345678',
]);

// Основной запрос оплаты (Signed_Order_B64)
$request = $epay->buildRequest('payment', [
    'order_id' => 1234,
    'amount' => 1000,
    'currency' => 398,
    'fields' => [
        'RL' => 1234567,
        'abonent_id' => 1234567,
        ...
    ],
    'links' => [
        'BackLink' => '...',
        'FailureBackLink' => '...',
        'PostLink' => '...',
        'FailurePostLink' => '...',
    ]
]);

// Статус платежа
$request = $epay->buildRequest('status', ['order_id' => 1234]);
```
```php
//Обработка ответов Epay

// PostLink
$response = $epay->parseResponse('payment', $_POST['response']);

// Ответ на запрос о статусе платежа
$curl = curl_init('https://testpay.kkb.kz/jsp/remote/checkOrdern.jsp?' . urlencode($request));

curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
));

$result = curl_exec($curl);
curl_close($curl);

$response = $epay->parseResponse('status', $result);

//verify() проверяет подпись ответа.
if($response->verify()) {
    print_r($response->get());
    // get возвращает массив с параметрами ответа
} else {
    echo 'Response not valid';
}
``` 

## Todo

- Запросы для системы мониторинга платежей (https://testpay.kkb.kz/doc/htm/remote.html)
- Unit тесты
- Докблоки