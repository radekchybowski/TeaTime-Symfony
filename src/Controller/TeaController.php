<?php
/**
 * Tea controller.
 */

namespace App\Controller;

use App\Entity\Tea;
use App\Entity\User;
use App\Form\Type\TeaType;
use App\Service\TeaServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class TeaController.
 */
#[Route('/tea')]
class TeaController extends AbstractController
{
    /**
     * Tea service.
     */
    private TeaServiceInterface $teaService;

    /**
     * Translator.
     */
    private TranslatorInterface $translator;

    /**
     * Constructor.
     *
     * @param TeaServiceInterface $teaService Tea service
     * @param TranslatorInterface $translator Translator
     */
    public function __construct(TeaServiceInterface $teaService, TranslatorInterface $translator)
    {
        $this->teaService = $teaService;
        $this->translator = $translator;
    }

    /**
     * Index action.
     *
     * @param Request $request HTTP Request
     *
     * @return Response HTTP response
     */
    #[Route(name: 'tea_index', methods: 'GET')]
    public function index(Request $request): Response
    {
        $filters = $this->getFilters($request);
        /** @var User $user * */
        $user = $this->getUser();
        $pagination = $this->teaService->getPaginatedList(
            $request->query->getInt('page', 1),
            $user,
            $filters
        );

        return $this->render('tea/index.html.twig', ['pagination' => $pagination]);
    }

    /**
     * Show action.
     *
     * @param Tea $tea Tea entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}', name: 'tea_show', requirements: ['id' => '[1-9]\d*'], methods: 'GET')]
    #[IsGranted('VIEW', subject: 'tea')]
    public function show(Tea $tea): Response
    {
        return $this->render('tea/show.html.twig', ['tea' => $tea]);
    }

    /**
     * Create action.
     *
     * @param Request $request HTTP request
     *
     * @return Response HTTP response
     */
    #[Route('/create', name: 'tea_create', methods: 'GET|POST')]
    public function create(Request $request): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $tea = new Tea();
        $tea->setAuthor($user);
        $form = $this->createForm(
            TeaType::class,
            $tea,
            ['action' => $this->generateUrl('tea_create')]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->teaService->save($tea);

            $this->addFlash(
                'success',
                $this->translator->trans('message.created_successfully')
            );

            return $this->redirectToRoute('tea_index');
        }

        return $this->render(
            'tea/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param Request $request HTTP request
     * @param Tea     $tea     Tea entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}/edit', name: 'tea_edit', requirements: ['id' => '[1-9]\d*'], methods: 'GET|PUT')]
    #[IsGranted('EDIT', subject: 'tea')]
    public function edit(Request $request, Tea $tea): Response
    {
        $form = $this->createForm(
            TeaType::class,
            $tea,
            [
                'method' => 'PUT',
                'action' => $this->generateUrl('tea_edit', ['id' => $tea->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->teaService->save($tea);

            $this->addFlash(
                'success',
                $this->translator->trans('message.edited_successfully')
            );

            return $this->redirectToRoute('tea_index');
        }

        return $this->render(
            'tea/edit.html.twig',
            [
                'form' => $form->createView(),
                'tea' => $tea,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param Request $request HTTP request
     * @param Tea     $tea     Tea entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}/delete', name: 'tea_delete', requirements: ['id' => '[1-9]\d*'], methods: 'GET|DELETE')]
    #[IsGranted('DELETE', subject: 'tea')]
    public function delete(Request $request, Tea $tea): Response
    {
        $form = $this->createForm(
            FormType::class,
            $tea,
            [
                'method' => 'DELETE',
                'action' => $this->generateUrl('tea_delete', ['id' => $tea->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->teaService->delete($tea);

            $this->addFlash(
                'success',
                $this->translator->trans('message.deleted_successfully')
            );

            return $this->redirectToRoute('tea_index');
        }

        return $this->render(
            'tea/delete.html.twig',
            [
                'form' => $form->createView(),
                'tea' => $tea,
            ]
        );
    }

    /**
     * Get filters from request.
     *
     * @param Request $request HTTP request
     *
     * @return array<string, int> Array of filters
     *
     * @psalm-return array{category_id: int, tag_id: int, status_id: int}
     */
    private function getFilters(Request $request): array
    {
        $filters = [];
        $filters['category_id'] = $request->query->getInt('filters_category_id');
        $filters['tag_id'] = $request->query->getInt('filters_tag_id');

        return $filters;
    }
}
