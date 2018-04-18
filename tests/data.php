<?php

return [
    'config' => [
        'MERCHANT_CERTIFICATE_ID' => "00C182B189",
        'MERCHANT_NAME' => "Test shop",
        'PRIVATE_KEY_FN' => "./test-certs/cert.prv",
        'PRIVATE_KEY_PASS' => "nissan",
        'PUBLIC_KEY_FN' => "./test-certs/kkbca.pem",
        'BANK_PUBLIC_KEY_FN' => "./test-certs/kkbca.pem",
        'MERCHANT_ID' => "92061101",
    ],

    'status' => [
        'request' => '<document><merchant id="92061101"><order id="064085"/></merchant><merchant_sign type="RSA" cert_id="00C182B189">RB8oaB0UCAHIb7oyRXS8QhmNUnHcYcS6Dgff5Zmvev87WF07bt72gRmH5Cyss3qZl9j8M1zfuq0eY6aHnumzLw==</merchant_sign></document>',

        'response' => '<document><bank name="Kazkommertsbank JSC"><merchant id="92061101"><order id="064085"/></merchant><merchant_sign type="RSA" cert_id="00C182B189">RB8oaB0UCAHIb7oyRXS8QhmNUnHcYcS6Dgff5Zmvev87WF07bt72gRmH5Cyss3qZl9j8M1zfuq0eY6aHnumzLw==</merchant_sign><response payment="true" status="0" result="0" amount="1000" currencycode="398" timestamp="2018-04-18 11:59:14.0" reference="180418115914" cardhash="440564-XX-XXXX-6150" card_to="" approval_code="115914" msg="preauth" secure="No" card_bin="null" payername="John Doe" payermail="asd@gmail.com" payerphone="null" c_hash="13988BBF7C6649F799F36A4808490A3E" recur="0" OrderID="064085" SessionID="BAEC4CA10CE48263383EAA7552348B6C" intreference="FA20180418115914" AcceptRejectCode="0"/></bank><bank_sign cert_id="00c183d690" type="RSA">qMTKYOZYFwpl58Ogxr5gcHBjBHnNtH9Odeb9C7iI67PM5GpCIsnOF+EZDdfcPBagZPX8/34+pSDt5n9XMLk3QjlbhkphufzgXRUx0NOJkwPHAzjOIAqFbbE0Ei+DCNiyUcqVmiHPhLxbDRS7wj7+d5VWWJXCNYtoD9S0/hF5jg8=</bank_sign></document>'
    ],

    'payment' => [
        'response' => '<document><bank name="Kazkommertsbank JSC"><customer name="John Doe" mail="asd@gmail.com" phone=""><merchant cert_id="00C182B189" name="Test shop"><order order_id="064085" amount="1000" currency="398"><department merchant_id="92061101" amount="1000"/></order></merchant><merchant_sign type="RSA"/></customer><customer_sign type="RSA"/><results timestamp="2018-04-18 11:59:15"><payment merchant_id="92061101" card="440564-XX-XXXX-6150" amount="1000" reference="180418115914" approval_code="115914" response_code="00" Secure="No" card_bin="" c_hash="13988BBF7C6649F799F36A4808490A3E"/></results></bank><bank_sign cert_id="00c183d690" type="SHA/RSA">EpUcI/2F2MTU6l908yXTZHdFaEHB7qd318RUzluzhW7EpWgWyB6jl++QanVnM2bvJRQzS/Ik3nifRPooUxvnm9vK5YevtC8U5/HUwHqqyMghwOxEvWJM6W2bXPbzaM2U/VQRdJeM6ppaeOk10aKDxUBOLFBc7IX5ox6WhN78XUI=</bank_sign></document>'
    ],
];