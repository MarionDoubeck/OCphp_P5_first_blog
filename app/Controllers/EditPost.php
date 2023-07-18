<?php
namespace App\Controllers;

use App\Models\Post;
use App\services\Session;
use App\services\Files;
use App\db\DatabaseConnection;
use App\services\Helpers;

/**
 * EditPost class
 * To update a post in the admin part
 */
class EditPost
{

    /**
     * Session
     *
     * @var Session
     */
    private $session;

    /**
     * Files
     *
     * @var Files
     */
    private $files;


    /**
     * Constructor that inject dependencies to avoid static access to classes like PostGlobal::get()
     *
     * @param Session $session Session
     * @param Files   $files   Files
     *
     * @return void
     */
    public function __construct(Session $session, Files $files)
    {
        $this->session = $session;
        $this->files = $files;

    }//end __construct()


    /**
     * Method to modify a post
     *
     * @param int        $identifier Post Id
     * @param array|null $input      Original Post data
     *
     * @return void
     */
    public function execute(int $identifier, ?array $input)
    {
        $helper = new Helpers;
        $role = $this->session->get('role');
        if ($role !== 'admin') {?>
            <?= '<script>window.location.href = "index.php/?action=AccesNonAutorisé";</script>'; ?>
        <?php }

        // Submission management if there is an entry.
        if ($input !== null) {
            $title = null;
            $content = null;
            $chapo = null;
            if (empty($input['title']) === FALSE && empty($input['chapo']) === FALSE && empty($input['content']) === FALSE) {
                $title = strip_tags($input['title']);
                $chapo = strip_tags($input["chapo"]);
                $content = strip_tags($input['content']);
            } else {
                throw new \Exception('les données du formulaire sont incomplètes');
            }

            // Check if an image was uploaded.
            if (empty($this->files->file('image','tmp_name')) === FALSE) {
                // Process the uploaded image.
                $image_data = $this->files->getFileContent('image','tmp_name');
                $image_type = $this->files->file('image','tmp_name');
            } else {
                $image_data = null;
                $image_type = null;
            }

            $postRepository = new Post();
            $postRepository->connection = new DatabaseConnection();
            $success = $postRepository->editPost($identifier, $content, $title, $chapo, $image_data, $image_type);

            if ($success === FALSE) {
                throw new \Exception('Impossible de modifier l\'article !');
            } else {
                $postRepository = new Post();
                $postRepository->connection = new DatabaseConnection();
                $post = $postRepository->getPost($identifier);
                ?>
                <script language="javascript"> 
                alert("article modifié!");
                document.location.href = '/index.php?action=adminAllPosts';
                </script>
                <?php
            }
        }// end if
        // Displays the form if there is no entry and at the beginning.
        $postRepository = new Post();
        $postRepository->connection = new DatabaseConnection();
        $post = $postRepository->getPost($identifier);

        if ($post === null) {
            throw new \Exception("L'article $identifier n'existe pas.");
        }

        // Prepare post's data for display.
        $title = $post->getTitle();
        // No accents in title with this font.
        $title = preg_replace('/[\p{M}]/u', '', \Normalizer::normalize($title, \Normalizer::FORM_D));
        $author = $post->getUsername();
        $created_at = $post->getFrenchCreationDate();
        $chapo = $post->getChapo();
        $content = $post->getContent();
        $imageData = $post->getImageData();
        $imageType = $post->getImageType();

        $helper->renderView('app/views/admin/edit-post.php', [
                                                             'title' => $title,
                                                             'chapo' => $chapo,
                                                             'content' => $content,
                                                             'imageData' => $imageData,
                                                             'imageType' => $imageType,
                                                            ]
        );

    }//end execute()


}//end class
