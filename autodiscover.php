<?php
header('Content-Type: application/xml');
function outputXML($data, $error)
{
    if ($error) {
        http_response_code(400);
        $xml = new SimpleXMLElement('<Error/>');
        $xml->addChild('Description', $data);
    } else {
        $xml = $data;
    }
    print($xml->asXML());
    die();
}
if (is_readable('autodiscover.settings.php')) {
    require_once('autodiscover.settings.php');
} else {
    outputXML('cant find or read autodiscover.settings.php', true);
}
$request = file_get_contents("php://input");
if ($settings['debugtofile']) {
    file_put_contents('request.log', $request . "\n", FILE_APPEND);
}
$xml = simplexml_load_string($request);
if (!$xml->Request) {
    outputXML('Missing Request', true);
}
if (!$xml->Request->EMailAddress) {
    outputXML('Missing EMailAddress', true);
}
$email = $xml->Request->EMailAddress;
if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
    outputXML('Invalid EMailAddress', true);
}
if (!$xml->Request->AcceptableResponseSchema) {
    outputXML('Missing AcceptableResponseSchema', true);
}
preg_match("/mobilesync/", $xml->Request->AcceptableResponseSchema, $mobilesync);
$domain = substr(strrchr($email, "@"), 1);
$xml = new SimpleXMLElement('<Autodiscover xmlns="http://schemas.microsoft.com/exchange/autodiscover/responseschema/2006" />');
if (count($mobilesync) > 0) {
    if ($settings['activesync']['enabled'] == false) {
        outputXML('you havnt enabled activesync', true);
    }
    $response = $xml->addChild('Response', '', 'http://schemas.microsoft.com/exchange/autodiscover/mobilesync/responseschema/2006a');
    $response->addChild('Culture', 'en:us');
    $user = $response->addChild('User');
    $user->addChild('DisplayName', $email);
    $user->addChild('EMailAddress', $email);
    $server = $response->addChild('Action')->addChild('Settings')->addChild('Server');
    $server->addChild('Type', 'MobileSync');
    $server->addChild('Url', ($settings['activesync']['ssl'] ? 'https' : 'http') . "://" . $settings['activesync']['server'] . "/Microsoft-Server-ActiveSync");
    $server->addChild('Name', ($settings['activesync']['ssl'] ? 'https' : 'http') . "://" . $settings['activesync']['server'] . "/Microsoft-Server-ActiveSync");
} else {
    $response = $xml->addChild('Response', '', 'http://schemas.microsoft.com/exchange/autodiscover/outlook/responseschema/2006a');
    $account = $response->addChild('Account');
    $account->addChild('AccountType', 'email');
    $account->addChild('Action', 'settings');
    $list = ['imap', 'smtp', 'pop'];
    foreach ($list as $value) {
        if ($settings[$value]['enabled']) {
            $protocol = $account->addChild('Protocol');
            $protocol->AddChild('Type', strtoupper($value));
            $protocol->AddChild('Server', $settings[$value]['server']);
            $protocol->AddChild('LoginName', $email);
            $protocol->AddChild('Port', $settings[$value]['port']);
            $protocol->AddChild('SPA', ($settings[$value]['spa'] ? 'on' : 'off'));
            $protocol->AddChild('SSL', ($settings[$value]['ssl'] ? 'on' : 'off'));
            $protocol->AddChild('DomainRequired', ($settings[$value]['domainrequired'] ? 'on' : 'off'));
            $protocol->AddChild('AuthRequired', ($settings[$value]['authrequired'] ? 'on' : 'off'));
            if ($value == 'smtp') {
                $protocol->AddChild('UsePOPAuth', ($settings[$value]['usepopauth'] ? 'on' : 'off'));
                $protocol->AddChild('SMTPLast', ($settings[$value]['smtplast'] ? 'on' : 'off'));
            }
        }
    }
}
outputXML($xml, false);