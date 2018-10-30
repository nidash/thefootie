<?php

namespace App\Controller;

use App\Entity\Team;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TeamController extends ApiController
{
  /**
   * Show all entities (maybe add limit and pagination later).
   * @Route("/teams", methods={"GET"}, name="team_index")
   */
  public function list() :JsonResponse {
    $repository = $this->getDoctrine()->getRepository(Team::class);
    $data['data'] = $repository->getTeams();
    // Return JSON response.
    return $this->sendResponse($data,JsonResponse::HTTP_OK);
  }

  /**
   * Show an entity.
   * @Route("/teams/{id}", methods={"GET"}, name="team_show")
   * @param int $id
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   */
  public function show(int $id)   {
    $repository = $this->getDoctrine()->getRepository(Team::class);
    // Get Team by id.
    $data['data'] = $repository->getTeam($id);
    $status = JsonResponse::HTTP_OK;
    if(! $data['data']) {
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
   * @Route("/teams", methods={"POST"}, name="team_new")
   */
  public function new() {
    $request = new Request();
    // Get Repository.
    $repository = $this->getDoctrine()->getRepository(Team::class);
    // Get posted data.
    $data = json_decode($request->getContent(), TRUE);
    // Save posted data if valid.
    $response = $repository->save($data);
    // Send status response.
    return $this->sendResponse($response, $response['status']);
  }

  /**
   * Delete entity.
   * @Route("/teams/{id}", methods={"DELETE"}, name="team_delete")
   * @param int $id
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   * @throws \Doctrine\ORM\ORMException
   */
  public function delete(int $id) {
    $repository = $this->getDoctrine()->getRepository(Team::class);
    $response = $repository->delete($id);
    // Send status response.
    return $this->sendResponse($response, $response['status']);
  }

  /**
   * Update existing entity.
   * @Route("/teams/{id}", methods={"PUT|PATCH"}, name="team_edit")
   * @param int $id
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   * @throws \Doctrine\ORM\ORMException
   */
  public function edit(int $id) {
    $request = new Request();
    $repository = $this->getDoctrine()->getRepository(Team::class);
    $team = $repository->find($id);
    if ($team) {
      // Get posted data.
      $data = json_decode($request->getContent(), TRUE);
      $response = $repository->save($data, $team);
    }
    else {
      $response['status'] = JsonResponse::HTTP_NOT_FOUND;
      $response['data'] = 'Not found';
    }
    // Send status response.
    return $this->sendResponse($response, $response['status']);
  }
}
