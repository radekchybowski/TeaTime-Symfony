<?php
/**
 * Comment controller.
 */

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Tea;
use App\Entity\User;
use App\Form\Type\CommentType;
use App\Service\CommentServiceInterface;
use App\Service\TeaServiceInterface;
use Doctrine\ORM\NonUniqueResultException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class CommentController.
 */
#[Route('/comment')]
class CommentController extends AbstractController
{
    /**
     * Comment service.
     */
    private CommentServiceInterface $commentService;

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
     * @param CommentServiceInterface $commentService      Comment service
     * @param TeaServiceInterface     $teaService          Tea service
     * @param TranslatorInterface     $translatorInterface Translator interface
     */
    public function __construct(CommentServiceInterface $commentService, TeaServiceInterface $teaService, TranslatorInterface $translatorInterface)
    {
        $this->commentService = $commentService;
        $this->teaService = $teaService;
        $this->translator = $translatorInterface;
    }

    /**
     * Index action.
     *
     * @param Request $request HTTP Request
     *
     * @return Response HTTP response
     */
    #[Route(name: 'comment_index', methods: 'GET')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(Request $request): Response
    {
        $pagination = $this->commentService->getPaginatedList(
            $request->query->getInt('page', 1)
        );

        return $this->render('comment/index.html.twig', ['pagination' => $pagination]);
    }

    /**
     * Show action.
     *
     * @param Comment $comment Comment
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}',
        name: 'comment_show',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET'
    )]
    #[IsGranted('ROLE_ADMIN')]
    public function show(Comment $comment): Response
    {
        var_dump($comment);
        return $this->render('comment/show.html.twig', ['record' => $comment]);
    }

    /**
     * Create action.
     *
     * @param Request  $request HTTP request
     * @param int|null $id      Comment id
     *
     * @return Response HTTP response
     *
     * @throws NonUniqueResultException
     */
    #[Route(
        '/create/{id}',
        name: 'comment_create',
        requirements: ['id' => '[0-9]+'],
        defaults: ['id' => null],
        methods: 'GET|POST'
    )]
    public function create(Request $request, ?int $id): Response
    {
        $comment = new Comment();
        /** @var Tea|null $tea */
        $tea = null;

        /** @var User $user */
        $user = $this->getUser();
        $comment->setAuthor($user);

        if (null !== $id) {
            $tea = $this->teaService->findOneById($id);
            $comment->setTea($tea);
        }

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->commentService->save($comment);

            $this->addFlash(
                'success',
                $this->translator->trans('message.created_successfully')
            );

            if (null === $tea) {
                return $this->redirectToRoute('comment_index');
            }

            return $this->redirectToRoute('tea_show', ['id' => $tea->getId()]);
        }

        return $this->render(
            'comment/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param Request $request HTTP request
     * @param Comment $comment Comment entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}/edit', name: 'comment_edit', requirements: ['id' => '[1-9]\d*'], methods: 'GET|PUT')]
    #[IsGranted('EDIT', subject: 'comment')]
    public function edit(Request $request, Comment $comment): Response
    {
        $form = $this->createForm(
            CommentType::class,
            $comment,
            [
                'method' => 'PUT',
                'action' => $this->generateUrl('comment_edit', ['id' => $comment->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->commentService->save($comment);

            $this->addFlash(
                'success',
                $this->translator->trans('message.created_successfully')
            );

            return $this->redirectToRoute('tea_show', ['id' => $comment->getTea()->getId()]);
        }

        return $this->render(
            'comment/edit.html.twig',
            [
                'form' => $form->createView(),
                'comment' => $comment,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param Request $request HTTP request
     * @param Comment $comment Comment entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}/delete', name: 'comment_delete', requirements: ['id' => '[1-9]\d*'], methods: 'GET|DELETE')]
    #[IsGranted('DELETE', subject: 'comment')]
    public function delete(Request $request, Comment $comment): Response
    {
        $form = $this->createForm(
            FormType::class,
            $comment,
            [
                'method' => 'DELETE',
                'action' => $this->generateUrl('comment_delete', ['id' => $comment->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->commentService->delete($comment);

            $this->addFlash(
                'success',
                $this->translator->trans('message.deleted_successfully')
            );

            return $this->redirectToRoute('tea_show', ['id' => $comment->getTea()->getId()]);
        }

        return $this->render(
            'comment/delete.html.twig',
            [
                'form' => $form->createView(),
                'comment' => $comment,
            ]
        );
    }
}
