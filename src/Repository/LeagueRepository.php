<?php

namespace App\Repository;

use App\Entity\League;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method League|null find($id, $lockMode = NULL, $lockVersion = NULL)
 * @method League|null findOneBy(array $criteria, array $orderBy = NULL)
 * @method League[]    findAll()
 * @method League[]    findBy(array $criteria, array $orderBy = NULL, $limit = NULL, $offset = NULL)
 */
class LeagueRepository extends ServiceEntityRepository
{
    private $validator;

    public function __construct(
    RegistryInterface $registry,
    ValidatorInterface $validator
  ) {
        parent::__construct($registry, League::class);
        $this->validator = $validator;
    }

    public function getLeagues()
    {
        // Get all Leagues.
        $leagues = $this->findAll();
        $results = [];
        foreach ($leagues as $league) {
            $results[] = $this->getLeague($league->getId());
        }
        // Return Array.
        return $results;
    }

    public function getLeague(int $id)
    {
        // Find by Id.
        $league = $this->find($id);
        $results = [];
        if ($league) {
            $results = ['id' => $league->getId(), 'name' => $league->getName()];
        }
        // Return Array.
        return $results;
    }


    /**
     * Validate and save data to database.
     *
     * @param $data
     * @param \App\Entity\League $league
     *
     * @return mixed
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save($data, League $league = null)
    {
        // Status for update
        $response['status'] = JsonResponse::HTTP_OK;

        if (!$league) {
            // Add mode.
            $league = new League();
            // Status for created
            $response['status'] = JsonResponse::HTTP_CREATED;
        }


        $response['data'] = '';

        if (isset($data['name'])) {
            $league->setName($data['name']);

            // Validate
            $errors = $this->validator->validate($league);

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
                $em->persist($league);
                $em->flush();
                // Tell user what they have added.
                $response['data'] = $this->getLeague($league->getId());
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
     * @throws \Doctrine\ORM\ORMException
     */
    public function delete($id)
    {
        $league = $this->find($id);
        if ($league) {
            $em = $this->getEntityManager();
            $em->remove($league);
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
