<?php

return [
    'status' => [
        'request' => '<document><merchant id="92061101"><order id="001234"/></merchant><merchant_sign type="RSA" cert_id="00C182B189">KRb4oQ4z4clKiFYS64WnageGbiYvpx+WOUPTb0Tef5f3NfVZSMxKLlVb+Qk54DywIDx3ez4Ng2lpir+POiXfDg==</merchant_sign></document>',

        'response' => '<document><bank name="Kazkommertsbank JSC"><merchant id="92061101"><order id="001234"/></merchant><merchant_sign type="RSA" cert_id="00C182B189">KRb4oQ4z4clKiFYS64WnageGbiYvpx+WOUPTb0Tef5f3NfVZSMxKLlVb+Qk54DywIDx3ez4Ng2lpir+POiXfDg==</merchant_sign><response payment="false" status="8" result="8" amount="" currencycode="" timestamp="" reference="" cardhash="" card_to="" approval_code="" msg="noaction" secure="" card_bin="null" payername="" payermail="" payerphone="" c_hash="" recur="0" OrderID="001234" SessionID="563A54B12930848855003E2C3A8E8700" intreference="" AcceptRejectCode="8"/></bank><bank_sign cert_id="00c183d690" type="RSA">owEt6TnMO1SIt07bLm24E8LXyOJHsa0N9VmDH++IGEcW3HCy2XNz2rFZhH2sN2WcQeucD69xWNVMPYXmtOpLU7tliw3+S9WZqkjdzo/3Cc6AcRh+vtAY9YtndiNYRYzogsf0dCcvh7BccAE5E9n3dgY5tYvKS1rQTMhaFeB9O3Y=</bank_sign></document>'
    ],

    'payment' => [
        'response' => '<document><bank name="Kazkommertsbank JSC"><customer name="Ucaf Test Maest" mail="SeFrolov@kkb.kz" phone=""><merchant cert_id="00C182B189" name="test merch"><order order_id="0706172110" amount="1000" currency="398"><department merchant_id="92056001" amount="1000"/></order></merchant><merchant_sign type="RSA"/></customer><customer_sign type="RSA"/><results timestamp="2006-07-06 17:21:50"><payment merchant_id="92056001" amount="1000" reference="618704198173" approval_code="447753" response_code="00"/></results></bank><bank_sign cert_id="00C18327E8" type="SHA/RSA">xjJwgeLAyWssZr3/gS7TI/xaajoF3USk0B/ZfLv6SYyY/3H8tDHUiyGcV7zDO5+rINwBoTn7b9BrnO/kvQfebIhHbDlCSogz2cB6Qa2ELKAGqs8aDZDekSJ5dJrgmFT6aTfgFgnZRmadybxTMHGR6cn8ve4m0TpQuaPMQmKpxTI=</bank_sign ></document>'
    ],
];