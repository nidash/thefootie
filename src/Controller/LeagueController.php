<?php
/**
 * Created by PhpStorm.
 * User: nida.sharar
 * Date: 26/10/2018
 * Time: 13:04
 */

namespace App\Controller;

use App\Entity\League;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LeagueController extends ApiController
{

  /**
   * Show all entities (maybe add limit and pagination later).
   * @Route("/leagues", methods={"GET"}, name="league_index")
   */
    public function list(): JsonResponse
    {
        $repository = $this->getDoctrine()->getRepository(League::class);
        $data['data'] = $repository->getLeagues();
        // Return JSON response.
        return $this->sendResponse($data, JsonResponse::HTTP_OK);
    }

    /**
     * Show an entity.
     * @Route("/leagues/{id}", methods={"GET"}, name="league_show")
     *
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function show(int $id)
    {
        $repository = $this->getDoctrine()->getRepository(League::class);
        // Get league by id.
        $data['data'] = $repository->getLeague($id);
        $status = JsonResponse::HTTP_OK;
        if (!$data['data']) {
            // Helpful to return why you got 404, this is different
            // from client sending a wrong URI for eg.
            $data['data'] = 'Id not present';
            $status = JsonResponse::HTTP_NOT_FOUND;
        }
        // Send JSON response with status and headers.
        return $this->sendResponse($data, $status);
    }

    /**
     * Create new entity.
     * @Route("/leagues", methods={"POST"}, name="league_new")
     */
    public function new()
    {
        $request = new Request();
        // Get Repository.
        $repository = $this->getDoctrine()->getRepository(League::class);
        // Get posted data.
        $data = json_decode($request->getContent(), true);
        // Save posted data if valid.
        $response = $repository->save($data);
        // Send status response.
        return $this->sendResponse($response, $response['status']);
    }

    /**
     * Delete entity.
     * @Route("/leagues/{id}", methods={"DELETE"}, name="league_delete")
     *
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Doctrine\ORM\ORMException
     */
    public function delete(int $id)
    {
        $repository = $this->getDoctrine()->getRepository(League::class);
        $response = $repository->delete($id);
        // Send status response.
        return $this->sendResponse($response, $response['status']);
    }

    /**
     * Update existing entity.
     * @Route("/leagues/{id}", methods={"PUT|PATCH"}, name="league_edit")
     *
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Doctrine\ORM\ORMException
     */
    public function edit(int $id)
    {
        $request = new Request();
        $repository = $this->getDoctrine()->getRepository(League::class);
        $league = $repository->find($id);
        if ($league) {
            // Get posted data.
            $data = json_decode($request->getContent(), true);
            $response = $repository->save($data, $league);
        } else {
            $response['status'] = JsonResponse::HTTP_NOT_FOUND;
            $response['data'] = 'Not found';
        }
        // Send status response.
        return $this->sendResponse($response, $response['status']);
    }
}
