<?php 
/**
 * Integration with SMSPoh REST API
 * @author AsiaCobra(NHS)
 * @link https://github.com/AsiaCobra/smspoh-restApi
 * 
 * 
 * Class Method: 
 *          send_sms($params)
 *          get_balance()
 *          receive_sms()
 *          get_message()
 *          get_message_status()
 *          get_sender()
 *          get_contact_book()
 * 
 */

class SMSPOH{
    private $authToken;

    public $rest_base_url = "https://smspoh.com/api/v2";
    // Sender Name
    private $sender;

    private $rest_commands = array (
        'send_sms' => array('url' => '/send', 'method' => 'POST'),
        'get_balance' => array('url' => '/get-balance', 'method' => 'GET'),
        'receive_sms' => array('url' => '/receive-sms', 'method' => 'GET'),
        'get_message' => array('url' => '/messages', 'method' => 'GET'),
        'get_message_status' => array('url' => '/messages/status', 'method' => 'GET'),
        'get_sender' => array('url' => '/get-sender-names', 'method' => 'GET'),
        'get_contact_book' => array('url' => '/address-book', 'method' => 'GET'),
    );
    // Prepare data for POST request
    public $data = [
        "to"        =>      "09969128296",
        "message"   =>      "Hello SMSPoh",
        "sender"    =>      "Info",
        "test"      =>      true
    ];
    public function __construct($token){
        $this->authToken = $token;
        // $data = $this->get_sender();
        // $this->sender = $data.data[0];
        // $sender
    }

    /**
     * Sending SMS With SMSPOH
     * @param string | Required
     * @param array  | data to sms $this->data | Required
     * @return json_object
     */
    public function sendSMS($params = array()){

        return $this->invokeAPI('send_sms',$params);
    }

    /**
     * Get Sender Name
     * @return Json_object
     */
    public function get_sender(){
        return $this->invokeAPI('get_sender',array());
    }

    /**
     * Get account Pricing
     * @return json_object
     */
    public function get_balance(){

        return $this->invokeAPI('get_balance',array());
    }
    /**
     * Get Receive SMS
     * @param array | can be null
     * This api allows you to fetch inbox messages.
     * The messages limit per page is 20, 
     * use page parameter to get older messages.
     * @return json_object
     */
    public function receive_sms($params = array()){

        return $this->invokeAPI('receive_sms',$params);
    }
    /**
     * Get Previous Message 
     * @param array | Can Be Null
     * This api allows you to fetch previous messages. 
     * The messages limit per page is 20, 
     * use page parameter to get older messages.
     * @return json_object
     */
    public function get_previous_message($params = array()){
        return $this->invokeAPI('get_message',$params);
    }

    /**
     * Get Message Status
     * @param array | required | unique
     * @return json_object message status
     */
    public function get_message_status($params = array() ){
        return $this->invokeAPI('get_message_status',$params);
    }
    /**
     * Get Address Book List
     * 
     * @return json_object
     */

    public function get_contact_book(){
        return $this->invokeAPI('get_contact_book',array());
    }

    /**
     * To invoke SMSPOH API
     * 
     * @param string || array
     * @return json
     */
    public function invokeAPI($command,$params = array()){
        // Get REST URL and HTTP method
        $command_info = $this->rest_commands[$command];
        $url = $this->rest_base_url . $command_info['url'];
        $method = $command_info['method'];

        $params = json_encode($params);
        $rest_request = curl_init();
        if($method == 'POST') {
            curl_setopt($rest_request, CURLOPT_URL, $url);
            curl_setopt($rest_request, CURLOPT_POST, $method == 'POST' ? true: false);
            curl_setopt($rest_request, CURLOPT_POSTFIELDS, $params);
        } else {
            $query_str = null;
            if( $params )
                $query_string = $params;
            curl_setopt($rest_request, CURLOPT_URL, $url.'?'.$query_string);
        }
        curl_setopt($rest_request, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($rest_request, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($rest_request, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $this->authToken,
            'Content-Type: application/json'
        ]);
        $rest_response = curl_exec($rest_request);
        curl_close ($rest_request);

        return $rest_response;
    }
}