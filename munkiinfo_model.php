<?php
/**
 * Munkiinfo Model
 * 
 * Stores and processes Munki preference information from clients.
 * Supports both plist and YAML data formats for future compatibility.
 * 
 * @package munkireport/munkiinfo
 */

use CFPropertyList\CFPropertyList;

// Include the DataParser for YAML support
require_once __DIR__ . '/lib/DataParser.php';
use munkireport\munkiinfo\lib\DataParser;

class munkiinfo_model extends \Model
{

    public function __construct($serial = '')
    {
          parent::__construct('id', 'munkiinfo'); //primary key, tablename
          $this->rs['id'] = 0;
          $this->rs['serial_number'] = $serial;
          $this->rs['munkiinfo_key'] = '';
          $this->rs['munkiinfo_value'] = '';

        if ($serial) {
            $this->retrieve_record($serial);
          
            $this->serial = $serial;
        }
    }

  /**
   * Process data sent by postflight
   *
   * @param string data
   * @author erikng
   **/
    public function process($data)
    {
        // Use DataParser to handle both plist and YAML formats
        $parsedData = DataParser::parse($data);
        
        if (!$parsedData) {
            return;
        }

        $this->deleteWhere('serial_number=?', $this->serial_number);
        $item = array_pop($parsedData);
        if (!$item || !is_array($item)) {
            return;
        }
        reset($item);
        foreach($item as $key => $val) {
                $this->munkiinfo_key = $key;
                $this->munkiinfo_value = $val;

                $this->id = '';
                $this->save();
        }
    }
}
