# smspoh-restApi
This is my personal library to make it easier for developers. This is not offical SDK for smspoh. 

# Usage
```
require "smspoh-restApi/smspoh.php";
$authToken = "Your Token";
$smspoh = new SMSPOH($authToken);
```

# Sending SMS
```
$data = [
  "to"    => "09969128296",
  "message"=> "Hello World",
  "sender"  => "Info",
  "test"    => true
];

$smspoh->sendSMS($data);
```
# get Balance 

```
  $balance = $smspoh->get_balance();
```

# Methods 

```
          receive_sms()
          get_message()
          get_message_status()
          get_sender()
          get_contact_book()
```
