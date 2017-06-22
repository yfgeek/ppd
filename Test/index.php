<?php
include 'function.php';

    $url = "http://gw.open.ppdai.com/invest/LLoanInfoService/LoanList";
    $request = '{
      "PageIndex": 1,
      "StartDateTime": "2015-11-11 12:00:00.000"
    }';
    $result = send($url, $request);
    print $result;