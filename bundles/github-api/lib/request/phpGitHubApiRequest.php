<?php

require_once(dirname(__FILE__).'/phpGitHubApiRequestException.php');

/**
 * Performs requests on GitHub API. API documentation should be self-explanatory.
 *
 * @author    Thibault Duplessis <thibault.duplessis at gmail dot com>
 * @license   MIT License
 */
class phpGitHubApiRequest
{
  /**
   * The request options
   * @var array
   */
  protected $options = array(
    'protocol'    => 'http',
    'url'         => ':protocol://github.com/api/v2/:format/:path',
    'format'      => 'json',
    'user_agent'  => 'php-github-api (http://github.com/ornicar/php-github-api)',
    'http_port'   => 80,
    'timeout'     => 10,
    'login'       => null,
    'token'       => null,
    'debug'       => false
  );

  protected static $history = array();

  /**
   * Instanciate a new request
   *
   * @param  array   $options  Request options
   */
  public function __construct(array $options = array())
  {
    $this->configure($options);
  }

  /**
   * Configure the request
   *
   * @param   array               $options  Request options
   * @return  phpGitHubApiRequest $this     Fluent interface
   */
  public function configure(array $options)
  {
    $this->options = array_merge($this->options, $options);

    return $this;
  }

  /**
   * Send a request to the server, receive a response,
   * decode the response and returns an associative array
   *
   * @param  string   $apiPath        Request API path
   * @param  array    $parameters     Parameters
   * @param  string   $httpMethod     HTTP method to use
   * @param  array    $options        reconfigure the request for this call only
   *
   * @return array                    Data
   */
  public function send($apiPath, array $parameters = array(), $httpMethod = 'GET', array $options = array())
  {
    if(!empty($options))
    {
      $initialOptions = $this->options;
      $this->configure($options);
    }
    
    $response = $this->doSend($apiPath, $parameters, $httpMethod);
    $response = $this->decodeResponse($response);

    if(isset($initialOptions))
    {
      $this->options = $initialOptions;
    }

    return $response;
  }

  /**
   * Send a GET request
   * @see send
   */
  public function get($apiPath, array $parameters = array(), array $options = array())
  {
    return $this->send($apiPath, $parameters, 'GET', $options);
  }

  /**
   * Send a POST request
   * @see send
   */
  public function post($apiPath, array $parameters = array(), array $options = array())
  {
    return $this->send($apiPath, $parameters, 'POST', $options);
  }

  /**
   * Get a JSON response and transform it to a PHP array
   *
   * @return  array   the response
   */
  protected function decodeResponse($response)
  {
    if('text' === $this->options['format'])
    {
      return $response;
    }
    elseif('json' === $this->options['format'])
    {
      return json_decode($response, true);
    }

    throw new Exception(__CLASS__.' only supports json format, '.$this->options['format'].' given.');
  }

  /**
   * Send a request to the server, receive a response
   *
   * @param  string   $apiPath       Request API path
   * @param  array    $parameters    Parameters
   * @param  string   $httpMethod    HTTP method to use
   *
   * @return string   HTTP response
   */
  public function doSend($apiPath, array $parameters = array(), $httpMethod = 'GET')
  {
    $this->updateHistory();

    $url = strtr($this->options['url'], array(
      ':protocol' => $this->options['protocol'],
      ':format'   => $this->options['format'],
      ':path'     => trim($apiPath, '/')
    ));
    
    $curlOptions = array();

    if($this->options['login'] || $this->options['auth_method'] == phpGitHubApi::AUTH_OAUTH)
    {
      switch($this->options['auth_method']) {
        case phpGitHubApi::AUTH_OAUTH:
          $parameters['access_token'] = $this->options['secret'];
          break;
        case phpGitHubApi::AUTH_HTTP_PASSWORD:
          $curlOptions += array(
            CURLOPT_USERPWD => $this->options['login'] . ':' . $this->options['secret'],
          );
          break;
        case phpGitHubApi::AUTH_HTTP_TOKEN:
          $curlOptions += array(
            CURLOPT_USERPWD => $this->options['login'] . '/token:' . $this->options['secret'],
          );
          break;
        case phpGitHubApi::AUTH_URL_TOKEN:
        default:
          $parameters = array_merge(array(
            'login' => $this->options['login'],
            'token' => $this->options['secret']
          ), $parameters);
          break;
      }

    }
    if (!empty($parameters))
    {
      $queryString = utf8_encode(http_build_query($parameters, '', '&'));

      if('GET' === $httpMethod)
      {
        $url .= '?' . $queryString;
      }
      else
      {
        $curlOptions += array(
          CURLOPT_POST        => true,
          CURLOPT_POSTFIELDS  => $queryString
        );
      }
    }

    $this->debug('send '.$httpMethod.' request: '.$url);

    $curlOptions += array(
      CURLOPT_URL             => $url,
      CURLOPT_PORT            => $this->options['http_port'],
      CURLOPT_USERAGENT       => $this->options['user_agent'],
      CURLOPT_FOLLOWLOCATION  => true,
      CURLOPT_RETURNTRANSFER  => true,
      CURLOPT_TIMEOUT         => $this->options['timeout']
    );

    $curl = curl_init();

    curl_setopt_array($curl, $curlOptions);

    $response     = curl_exec($curl);
    $headers      = curl_getinfo($curl);
    $errorNumber  = curl_errno($curl);
    $errorMessage = curl_error($curl);

    curl_close($curl);

    if (!in_array($headers['http_code'], array(0, 200, 201)))
    {
      throw new phpGitHubApiRequestException(null, (int) $headers['http_code']);
    }

    if ($errorNumber != '')
    {
      throw new phpGitHubApiRequestException('error '.$errorNumber);
    }

    return $response;
  }

  /**
   * Records the requests times
   * When 30 request have been sent in less than a minute,
   * sleeps for two second to prevent reaching GitHub API limitation. 
   * 
   * @access protected
   * @return void
   */
  protected function updateHistory()
  {
    self::$history[] = time();
    if(30 === count(self::$history))
    {
      if(reset(self::$history) >= (time() - 30))
      {
        sleep(2);
      }
      array_shift(self::$history);
    }
  }

  /**
   * Change an option value.
   *
   * @param string $name   The option name
   * @param mixed  $value  The value
   *
   * @return dmConfigurable The current object instance
   */
  public function setOption($name, $value)
  {
    $this->options[$name] = $value;

    return $this;
  }

  /**
   * Get an option value.
   *
   * @param  string $name The option name
   *
   * @return mixed  The option value
   */
  public function getOption($name, $default = null)
  {
    return isset($this->options[$name]) ? $this->options[$name] : $default;
  }

  protected function debug($message)
  {
    if($this->options['debug'])
    {
      print $message."\n";
    }
  }
}
