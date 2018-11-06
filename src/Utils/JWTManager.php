<?php
/**
 * Created by PhpStorm.
 * User: nida.sharar
 * Date: 05/11/2018
 * Time: 13:27.
 */

namespace App\Utils;

use Firebase\JWT\JWT;
use Symfony\Component\DependencyInjection\Container;

class JWTManager
{
    /**
     * @var string
     */
    protected $prefix;
    /**
     * @var string
     */
    protected $name;

    /**
     * @var \Firebase\JWT\JWT
     */
    protected $jwt;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var Container
     */
    protected $container;

    /**
     * @var string
     */
    protected $algorithm;

  /**
   * @var mixed
   */
    protected $algorithms;

  /**
   * JWTManager constructor.
   *
   * @param $prefix
   * @param $name
   * @param \Symfony\Component\DependencyInjection\Container $container
   */
    public function __construct($prefix, $name, Container $container)
    {
        $this->prefix = $prefix;
        $this->name = $name;
        $this->jwt = new JWT();
        $this->container = $container;
        $this->key = $this->container->getParameter('jwt.secret_key');
        $this->algorithm = $this->container->getParameter('jwt.default_algorithm');
        $this->algorithms = $this->container->getParameter('jwt.algorithms');

    }

    /**
     * @param \App\Utils\Request $request
     *
     * @return bool|array
     */
    public function extract(Request $request)
    {
        if (!$request->headers->has($this->name)) {
            return false;
        }
        $authorizationHeader = $request->headers->get($this->name);
        if (empty($this->prefix)) {
            return $authorizationHeader;
        }
        $headerParts = explode(' ', $authorizationHeader);
        if (!(2 === count($headerParts) && 0 === strcasecmp($headerParts[0], $this->prefix))) {
            return false;
        }

        return $headerParts[1];
    }

    /**
     * @param array $data
     *
     * @return string
     */
    public function encode(array $data)
    {
        return $this->jwt->encode($data, $this->key, $this->algorithm);
    }

    public function decode(string $string)
    {
        return $this->jwt->decode($string, $this->key, $this->algorithms);
    }
}
