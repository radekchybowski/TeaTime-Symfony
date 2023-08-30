<!---->
<!--/**-->
<!-- * Avatar service.-->
<!-- */-->
<!---->
<!--namespace App\Service;-->
<!---->
<!--use App\Entity\Avatar;-->
<!--use App\Repository\AvatarRepository;-->
<!--use Symfony\Component\HttpFoundation\File\UploadedFile;-->
<!--use Symfony\Component\Security\Core\User\UserInterface;-->
<!---->
<!--/**-->
<!-- * Class Avatar service.-->
<!-- */-->
<!--class AvatarService implements AvatarServiceInterface-->
<!--{-->
<!--    /**-->
<!--     * Avatar repository.-->
<!--     */-->
<!--    private AvatarRepository $avatarRepository;-->
<!---->
<!--    /**-->
<!--     * File upload service.-->
<!--     */-->
<!--    private FileUploadServiceInterface $fileUploadService;-->
<!---->
<!--    /**-->
<!--     * Constructor.-->
<!--     *-->
<!--     * @param AvatarRepository           $avatarRepository  Avatar repository-->
<!--     * @param FileUploadServiceInterface $fileUploadService File upload service-->
<!--     */-->
<!--    public function __construct(AvatarRepository $avatarRepository, FileUploadServiceInterface $fileUploadService)-->
<!--    {-->
<!--        $this->avatarRepository = $avatarRepository;-->
<!--        $this->fileUploadService = $fileUploadService;-->
<!--    }-->
<!---->
<!--    /**-->
<!--     * Create avatar.-->
<!--     *-->
<!--     * @param UploadedFile  $uploadedFile Uploaded file-->
<!--     * @param Avatar        $avatar       Avatar entity-->
<!--     * @param UserInterface $user         User interface-->
<!--     */-->
<!--    public function create(UploadedFile $uploadedFile, Avatar $avatar, UserInterface $user): void-->
<!--    {-->
<!--        $avatarFilename = $this->fileUploadService->upload($uploadedFile);-->
<!---->
<!--        $avatar->setUser($user);-->
<!--        $avatar->setFilename($avatarFilename);-->
<!--        $this->avatarRepository->save($avatar);-->
<!--    }-->
<!--}-->
