<?php

namespace App\Controller;

use App\Repository\RecordRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecordController extends AbstractController
{
    /**
     * @return Response HTTP response
     */
    #[Route('/record', name: 'app_record')]
    public function index(RecordRepository $repository): Response
    {
        $records = $repository->findAll();

        return $this->render(
            'record/index.html.twig',
            [
                'controller_name' => 'RecordController',
                'records' => $records,
        ]);
    }

    /**
     * @param RecordRepository $repo
     * @param int $id
     * @return Response HTTP Response
     */
    #[Route(
        '/{id}',
        name: 'record_show',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET'
    )]
    public function show(RecordRepository $repo, int $id): Response
    {
        $record = $repo->findOneById($id);

        return $this->render(
            'record/show.html.twig',
            ['record' => $record]
        );
    }
}
