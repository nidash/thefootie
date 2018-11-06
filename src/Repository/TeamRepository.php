<?php

namespace App\Repository;

use App\Entity\Team;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Team|null find($id, $lockMode = NULL, $lockVersion = NULL)
 * @method Team|null findOneBy(array $criteria, array $orderBy = NULL)
 * @method Team[]    findAll()
 * @method Team[]    findBy(array $criteria, array $orderBy = NULL, $limit = NULL, $offset = NULL)
 */
class TeamRepository extends ServiceEntityRepository
{
    private $validator;

    public function __construct(
    RegistryInterface $registry,
    ValidatorInterface $validator
  ) {
        parent::__construct($registry, Team::class);
        $this->validator = $validator;
    }

    public function getTeams()
    {
        // Get all Teams.
        $teams = $this->findAll();
        $results = [];
        foreach ($teams as $team) {
            $results[] = $this->getTeam($team->getId());
        }
        // Return Array.
        return $results;
    }

    public function getTeam(int $id)
    {
        // Find by Id.
        $team = $this->find($id);
        $results = [];
        if ($team) {
            $results = [
        'id' => $team->getId(),
        'name' => $team->getName(),
        'strip' => $team->getStrip(),
      ];
        }
        // Return Array.
        return $results;
    }

    /**
     * Validate and save data to database.
     *
     * @param $data
     * @param \App\Entity\Team $team
     *
     * @return mixed
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save($data, Team $team = null)
    {
        // Status for update
        $response['status'] = JsonResponse::HTTP_OK;

        if (!$team) {
            // Add mode.
            $team = new Team();
            // Status for created
            $response['status'] = JsonResponse::HTTP_CREATED;
        }

        $response['data'] = '';

        if (isset($data['name']) && isset($data['strip'])) {
            $team->setName($data['name']);
            $team->setStrip($data['strip']);

            // Validate
            $errors = $this->validator->validate($team);

            if (is_object($errors) && count($errors) > 0) {
                $formattedErrors = [];
                foreach ($errors as $error) {
                    $formattedErrors[$error->getPropertyPath()] = [
            'error' => $error->getMessage(),
          ];
                }
                // Update/Create failed, send 409
                $response['status'] = JsonResponse::HTTP_CONFLICT;
                $response['data'] = $formattedErrors;
            } else {
                // Save to database.
                $em = $this->getEntityManager();
                $em->persist($team);
                $em->flush();
                // Tell user what they have added.
                $response['data'] = $this->getTeam($team->getId());
            }
        } else {
            // Format invalid, Bad Request.
            $response['status'] = JsonResponse::HTTP_BAD_REQUEST;
            $response['data'] = 'Invalid';
        }

        return $response;
    }

    /**
     * Delete record and return a response for api.
     *
     * @param $id
     *
     * @return mixed
     *
     * @throws \Doctrine\ORM\ORMException
     */
    public function delete($id)
    {
        $team = $this->find($id);
        if ($team) {
            $em = $this->getEntityManager();
            $em->remove($team);
            $em->flush();

            // Delete successful 204.
            $response['status'] = JsonResponse::HTTP_NO_CONTENT;
            $response['data'] = '';
        } else {
            // Not found.
            $response['status'] = JsonResponse::HTTP_NOT_FOUND;
            $response['data'] = '';
        }

        return $response;
    }
}
