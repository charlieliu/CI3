<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* CodeIgniter Redis
*
* A CodeIgniter library to interact with Redis
*
* @package       CodeIgniter
* @category    	Libraries
* @author        	Joël Cox
* @version	v0.4
* @link 	https://github.com/joelcox/codeigniter-redis
* @link		http://joelcox.nl
* @license	http://www.opensource.org/licenses/mit-license.html
* @editer	liuchangli0107@gmail.com
*/
class Redis {

	/**
	* CI
	*
	* CodeIgniter instance
	* @var 	object
	*/
	private $_ci;

	/**
	* Connection
	*
	* Socket handle to the Redis server
	* @var		handle
	*/
	private $_connection;

	/**
	* CRLF
	*
	* User to delimiter arguments in the Redis unified request protocol
	* @var		string
	*/
	const CRLF = "\r\n";

	private $log_str = '' ;
	private $time_mark = 0 ;

	public $total_time = 0 ;

	/**
	* Constructor
	*/
	public function __construct($params = array())
	{
		//$this->write_log('LINE:'.__LINE__.' FUNCTION:'.__FUNCTION__.' start') ;

		$this->_ci = get_instance();
		$this->_ci->load->config('redis');

		// Check for the different styles of configs
		if (isset($params['connection_group']))
		{
			// Specific connection group
			$config = $this->_ci->config->item('redis_' . $params['connection_group']);
		}
		elseif (is_array($this->_ci->config->item('redis_default')))
		{
			// Default connection group
			$config = $this->_ci->config->item('redis_default');
		}
		else
		{
			// Original config style
			$config = array(
				'host' => $this->_ci->config->item('redis_host'),
				'port' => $this->_ci->config->item('redis_port'),
				'password' => $this->_ci->config->item('redis_password'),
			);
		}

		// Connect to Redis
		$this->_connection = @fsockopen($config['host'], $config['port'], $errno, $errstr, 3);

		// Display an error message if connection failed
		if ( !$this->_connection )
		{
			show_error('Could not connect to Redis at ' . $config['host'] . ':' . $config['port']);
		}

		// Authenticate when needed
		$this->_auth($config['password']);
		//$this->write_log('LINE:'.__LINE__.' FUNCTION:'.__FUNCTION__.' end') ;
	}

	/**
	* Call
	*
	* Catches all undefined methods
	* @param	string	method that was called
	* @param	mixed	arguments that were passed
	* @return 	mixed
	*/
	public function __call($method, $arguments)
	{
		$this->_ci->benchmark->mark('__call_start');
		//$this->write_log('LINE:'.__LINE__.' FUNCTION:'.__FUNCTION__.' start') ;
		$request = $this->_encode_request($method, $arguments);
		//$this->write_log('LINE:'.__LINE__.' FUNCTION:'.__FUNCTION__.' $request='.print_r($request,TRUE)) ;
		//$this->write_log('LINE:'.__LINE__.' FUNCTION:'.__FUNCTION__.' end') ;
		$this->_ci->benchmark->mark('__call_end');
		$this->time_mark += $this->_ci->benchmark->elapsed_time('__call_start','__call_end');
		return $this->_write_request($request);
	}

	/**
	* Command
	*
	* Generic command function, just like redis-cli
	* @param	string	full command as a string
	* @return 	mixed
	*/
	public function command($string)
	{
		$this->_ci->benchmark->mark('command_start');
		//$this->write_log('LINE:'.__LINE__.' FUNCTION:'.__FUNCTION__.' start') ;
		//$this->write_log('LINE:'.__LINE__.' FUNCTION:'.__FUNCTION__.' $string='.print_r($string,TRUE)) ;
		$slices = explode(' ', $string);
		//$this->write_log('LINE:'.__LINE__.' FUNCTION:'.__FUNCTION__.' $slices='.print_r($slices,TRUE)) ;
		$request = $this->_encode_request($slices[0], array_slice($slices, 1));
		//$this->write_log('LINE:'.__LINE__.' FUNCTION:'.__FUNCTION__.' $request='.print_r($request,TRUE)) ;
		//$this->write_log('LINE:'.__LINE__.' FUNCTION:'.__FUNCTION__.' end') ;
		$this->_ci->benchmark->mark('command_end');
		$this->time_mark += $this->_ci->benchmark->elapsed_time('command_start','command_end');
		return $this->_write_request($request);
	}

	/**
	* Auth
	*
	* Runs the AUTH command when password is set
	* @param 	string	password for the Redis server
	* @return 	void
	*/
	private function _auth($password = NULL)
	{
		//$this->write_log('LINE:'.__LINE__.' FUNCTION:'.__FUNCTION__.' start') ;
		// Authenticate when password is set
		if ( !empty($password) )
		{
			// See if we authenticated successfully
			if ($this->command('AUTH ' . $password) !== 'OK')
			{
				//$this->write_log('LINE:'.__LINE__.' FUNCTION:'.__FUNCTION__.' Could not connect to Redis, invalid password') ;
				show_error('Could not connect to Redis, invalid password');
			}

		}
		//$this->write_log('LINE:'.__LINE__.' FUNCTION:'.__FUNCTION__.' end') ;
	}

	/**
	* Clear Socket
	*
	* Empty the socket buffer of theconnection so data does not bleed over
	* to the next message.
	* @return 	NULL
	*/
	public function _clear_socket()
	{
		//$this->write_log('LINE:'.__LINE__.' FUNCTION:'.__FUNCTION__) ;
		// Read one character at a time
		fflush($this->_connection);
		return NULL;
	}

	/**
	* Write request
	*
	* Write the formatted request to the socket
	* @param	string 	request to be written
	* @return 	mixed
	*/
	private function _write_request($request)
	{
		$this->_ci->benchmark->mark('_write_request_start');
		//$this->write_log('LINE:'.__LINE__.' FUNCTION:'.__FUNCTION__.' start') ;
		//$this->write_log('LINE:'.__LINE__.' FUNCTION:'.__FUNCTION__.' $request='.print_r($request,TRUE)) ;

		// How long is the data we are sending?
		$value_length = strlen($request);

		// If there isn't any data, just return
		if ($value_length <= 0) return NULL;


		// Handle reply if data is less than or equal to 8192 bytes, just send it over
		if ($value_length <= 8192)
		{
			fwrite($this->_connection, $request);
		}
		else
		{
			while ($value_length > 0)
			{
				// If we have more than 8192, only take what we can handle
				if ($value_length > 8192)
				{
					$send_size = 8192;
				}

				// Send our chunk
				fwrite($this->_connection, $request, $send_size);

				// How much is left to send?
				$value_length = $value_length - $send_size;

				// Remove data sent from outgoing data
				$request = substr($request, $send_size, $value_length);
			}// while ($value_length > 0)
		}

		// Read our request into a variable
		$return = $this->_read_request();
		//$this->write_log('LINE:'.__LINE__.' FUNCTION:'.__FUNCTION__.' $return='.print_r($return,TRUE)) ;

		// Clear the socket so no data remains in the buffer
		$this->_clear_socket();
		$this->_ci->benchmark->mark('_write_request_end');
		$this->time_mark += $this->_ci->benchmark->elapsed_time('_write_request_start','_write_request_end');
		//$this->write_log('LINE:'.__LINE__.' FUNCTION:'.__FUNCTION__.' endtime='.$this->time_mark.'<br>',TRUE) ;
		$this->count_time() ;
		return $return;
	}

	/**
	* Read request
	*
	* Route each response to the appropriate interpreter
	* @return 	mixed
	*/
	private function _read_request()
	{
		//$this->write_log('LINE:'.__LINE__.' FUNCTION:'.__FUNCTION__.' start') ;
		$type = fgetc($this->_connection);
		//$this->write_log('LINE:'.__LINE__.' FUNCTION:'.__FUNCTION__.' $type='.print_r($type,TRUE)) ;

		// Times we will attempt to trash bad data in search of a
		// valid type indicator
		$response_types = array('+', '-', ':', '$', '*');
		$type_error_limit = 50;
		$try = 0;

		while ( ! in_array($type, $response_types) && $try < $type_error_limit)
		{
			$type = fgetc($this->_connection);
			//$this->write_log('LINE:'.__LINE__.' FUNCTION:'.__FUNCTION__.' $type='.print_r($type,TRUE)) ;
			$try++;
		}

		//$this->write_log('LINE:'.__LINE__.' FUNCTION:'.__FUNCTION__.' $type='.print_r($type,TRUE)) ;
		switch ($type)
		{
			case '+':
				return $this->_single_line_reply();
				break;
			case '-':
				return $this->_error_reply();
				break;
			case ':':
				return $this->_integer_reply();
				break;
			case '$':
				return $this->_bulk_reply();
				break;
			case '*':
				return $this->_multi_bulk_reply();
				break;
			default:
				return FALSE;
		}// switch ($type)
		//$this->write_log('LINE:'.__LINE__.' FUNCTION:'.__FUNCTION__.' end') ;
	}

	/**
	* Single line reply
	*
	* Reads the reply before the EOF
	* @return 	mixed
	*/
	private function _single_line_reply()
	{
		//$this->write_log('LINE:'.__LINE__.' FUNCTION:'.__FUNCTION__.' start') ;
		$value = rtrim(fgets($this->_connection));
		//$this->write_log('LINE:'.__LINE__.' FUNCTION:'.__FUNCTION__.' $value='.print_r($value,TRUE)) ;
		$this->_clear_socket();
		//$this->write_log('LINE:'.__LINE__.' FUNCTION:'.__FUNCTION__.' end') ;
		return $value;
	}

	/**
	* Error reply
	*
	* Write error to log and return false
	* @return 	bool
	*/
	private function _error_reply()
	{
		//$this->write_log('LINE:'.__LINE__.' FUNCTION:'.__FUNCTION__.' start') ;
		// Extract the error message
		$error = substr(rtrim(fgets($this->_connection)), 4);
		//$this->write_log('LINE:'.__LINE__.' FUNCTION:'.__FUNCTION__.' $error='.print_r($error,TRUE)) ;

		$this->_clear_socket();
		//$this->write_log('LINE:'.__LINE__.' FUNCTION:'.__FUNCTION__.' end') ;
		return FALSE;
	}

	/**
	* Integer reply
	*
	* Returns an integer reply
	* @return 	int
	*/
	private function _integer_reply()
	{
		//$this->write_log('LINE:'.__LINE__.' FUNCTION:'.__FUNCTION__) ;
		return (int) rtrim(fgets($this->_connection));
	}

	/**
	* Bulk reply
	*
	* Reads to amount of bits to be read and returns value within
	* the pointer and the ending delimiter
	* @return  string
	*/
	private function _bulk_reply()
	{
		//$this->write_log('LINE:'.__LINE__.' FUNCTION:'.__FUNCTION__.' start') ;

		// How long is the data we are reading? Support waiting for data to
		// fully return from redis and enter into socket.
		$value_length = (int) fgets($this->_connection);

		if ($value_length <= 0) return NULL;

		$response = '';
		//$this->write_log('LINE:'.__LINE__.' FUNCTION:'.__FUNCTION__.' $response='.print_r($response,TRUE)) ;

		// Handle reply if data is less than or equal to 8192 bytes, just read it
		if ($value_length <= 8192)
		{
			$response = fread($this->_connection, $value_length);
			//$this->write_log('LINE:'.__LINE__.' FUNCTION:'.__FUNCTION__.' $response='.print_r($response,TRUE)) ;
		}
		else
		{
			$data_left = $value_length;

			// If the data left is greater than 0, keep reading
			while ($data_left > 0 )
			{

				// If we have more than 8192, only take what we can handle
				if ($data_left > 8192)
				{
					$read_size = 8192;
				}
				else
				{
					$read_size = $data_left;
				}

				// Read our chunk
				$chunk = fread($this->_connection, $read_size);

				// Support reading very long responses that don't come through
				// in one fread

				$chunk_length = strlen($chunk);
				while ($chunk_length < $read_size)
				{
					$keep_reading = $read_size - $chunk_length;
					$chunk .= fread($this->_connection, $keep_reading);
					$chunk_length = strlen($chunk);
				}

				$response .= $chunk;
				//$this->write_log('LINE:'.__LINE__.' FUNCTION:'.__FUNCTION__.' $chunk='.print_r($chunk,TRUE)) ;

				// Re-calculate how much data is left to read
				$data_left = $data_left - $read_size;

			}// while ($data_left > 0 )
		}
		// Handle reply if data is less than or equal to 8192 bytes, just read it end
		//$this->write_log('LINE:'.__LINE__.' FUNCTION:'.__FUNCTION__.' $response='.print_r($response,TRUE)) ;

		// Clear the socket in case anything remains in there
		$this->_clear_socket();
		//$this->write_log('LINE:'.__LINE__.' FUNCTION:'.__FUNCTION__.' end') ;
		return isset($response) ? $response : FALSE;
	}

	/**
	* Multi bulk reply
	*
	* Reads n bulk replies and return them as an array
	* @return 	array
	*/
	private function _multi_bulk_reply()
	{
		//$this->write_log('LINE:'.__LINE__.' FUNCTION:'.__FUNCTION__.' start') ;
		// Get the amount of values in the response
		$response = array();
		$total_values = (int) fgets($this->_connection);

		// Loop all values and add them to the response array
		for ($i = 0; $i < $total_values; $i++)
		{
			// Remove the new line and carriage return before reading
			// another bulk reply
			fgets($this->_connection, 2);

			// If this is a second or later pass, we also need to get rid
			// of the $ indicating a new bulk reply and its length.
			if ($i > 0)
			{
				fgets($this->_connection);
				fgets($this->_connection, 2);
			}

			$response[] = $this->_bulk_reply();
		}
		// Loop all values and add them to the response array end
		//$this->write_log('LINE:'.__LINE__.' FUNCTION:'.__FUNCTION__.' $response='.print_r($response,TRUE)) ;

		// Clear the socket
		$this->_clear_socket();
		//$this->write_log('LINE:'.__LINE__.' FUNCTION:'.__FUNCTION__.' end') ;
		return isset($response) ? $response : FALSE;
	}

	/**
	* Encode request
	*
	* Encode plain-text request to Redis protocol format
	* @link 	http://redis.io/topics/protocol
	* @param 	string 	request in plain-text
	* @param   string  additional data (string or array, depending on the request)
	* @return 	string 	encoded according to Redis protocol
	*/
	private function _encode_request($method, $arguments = array())
	{
		//$this->write_log('LINE:'.__LINE__.' FUNCTION:'.__FUNCTION__.' start') ;
		$request = '$' . strlen($method) . self::CRLF . $method . self::CRLF;
		//$this->write_log('LINE:'.__LINE__.' FUNCTION:'.__FUNCTION__.' $request='.print_r($request,TRUE)) ;
		//$this->write_log('LINE:'.__LINE__.' FUNCTION:'.__FUNCTION__.' $arguments='.print_r($arguments,TRUE)) ;
		$_args = 1;

		// Append all the arguments in the request string
		foreach ($arguments as $argument)
		{
			if (is_array($argument))
			{
				foreach ($argument as $key => $value)
				{
					// Prepend the key if we're dealing with a hash
					if (!is_int($key))
					{
						$request .= '$' . strlen($key) . self::CRLF . $key . self::CRLF;
						$_args++;
					}

					$request .= '$' . strlen($value) . self::CRLF . $value . self::CRLF;
					$_args++;
				}
			}
			else
			{
				$request .= '$' . strlen($argument) . self::CRLF . $argument . self::CRLF;
				$_args++;
			}
		}

		$request = '*' . $_args . self::CRLF . $request;
		//$this->write_log('LINE:'.__LINE__.' FUNCTION:'.__FUNCTION__.' $request='.print_r($request,TRUE)) ;
		//$this->write_log('LINE:'.__LINE__.' FUNCTION:'.__FUNCTION__.' end') ;
		return $request;
	}

	/**
	* Info
	*
	* Overrides the default Redis response, so we can return a nice array
	* of the server info instead of a nasty string.
	* @return 	array
	*/
	public function info($section = FALSE)
	{
		//$this->write_log('LINE:'.__LINE__.' FUNCTION:'.__FUNCTION__.' start') ;
		if ($section !== FALSE)
		{
			$response = $this->command('INFO '. $section);
		}
		else
		{
			$response = $this->command('INFO');
		}

		$data = array();
		$lines = explode(self::CRLF, $response);

		// Extract the key and value
		foreach ($lines as $line)
		{
			$parts = explode(':', $line);
			if (isset($parts[1])) $data[$parts[0]] = $parts[1];
		}
		//$this->write_log('LINE:'.__LINE__.' FUNCTION:'.__FUNCTION__.' end') ;
		return $data;
	}

	private function write_log($str='',$is_write=FALSE)
	{
		$this->log_str .= $str.'<br>' ;
		if( $is_write ){
			$this->set_log() ;
		}
	}

	private function set_log()
	{
		$this->_ci->load->library('session');
		$this->_ci->session->set_userdata('redis_log', $this->log_str);
	}

	private function count_time()
	{
		$this->total_time += $this->time_mark;
		$this->time_mark = 0 ;
	}

	/**
	* Destructor
	*
	* Kill the connection
	* @return 	void
	*/
	function __destruct()
	{
		if ($this->_connection) fclose($this->_connection);
	}
}