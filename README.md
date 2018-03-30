# KKB Epay

Эта библиотека предоставляет функционал для генерирования запросов для и обработки ответов от системы Epay Казкоммерцбанка.

## Установка

Необходимо расширение php_xml.

```
composer require panda-madness/kkb-epay
```

## Использование

```php
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
    'fields' => [
        'RL' => 1234567,
        'abonent_id' => 1234567,
        ...
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
    CURLOPT_POST => 1,
    CURLOPT_POSTFIELDS => [
        'Signed_Order_B64' => $request,
        'BackLink' => 'asdads',
        'PostLink' => 'asdads',
        'FailurePostLink' => 'asdads',
    ]
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