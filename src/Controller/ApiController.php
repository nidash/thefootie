<?php
/**
 * Created by PhpStorm.
 * User: nida.sharar
 * Date: 26/10/2018
 * Time: 13:04
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ApiController extends Controller {

  /**
   * @param array $data
   * @param int $status
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   */
  public function sendResponse(array $data, int $status)   {
    $response = $this->json($data, $status);
    $response->headers->set('Content-Type', 'application/json');
    // Return JSON response.
    return $response;
  }

}