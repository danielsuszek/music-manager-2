<?php

namespace MusicManager\ManageBundle\Controller;

use MusicManager\ManageBundle\Entity\Album;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

/**
 * Album controller.
 *
 */
class AlbumController extends Controller
{
    /**
     * Lists all album entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $albums = $em->getRepository('MusicManagerManageBundle:Album')->findAllOrderedByName($asc_desc = 'ASC');
//        exit(\Doctrine\Common\Util\Debug::dump($albums));
        return $this->render('album/index.html.twig', array(
            'albums' => $albums,
        ));
    }

    /**
     * Creates a new album entity.
     *
     */
    public function newAction(Request $request)
    {
        $album = new Album();
        $form = $this->createForm('MusicManager\ManageBundle\Form\AlbumType', $album);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $album->getSleevePicFilename();
            
            if ($file !== null) {
                $fileName = md5(uniqid()).'.'.$file->guessExtension();

                $file->move(
                    $this->getParameter('upload_dir_src'),
                    $fileName
                );            

                $album->setSleevePicFilename($fileName);
            } else {
                $album->setSleevePicFilename('brak_obrazka.jpg');
            }
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($album);
            $em->flush();

            return $this->redirectToRoute('album_show', array('id' => $album->getId()));
        }

        return $this->render('album/new.html.twig', array(
            'album' => $album,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a album entity.
     *
     */
    public function showAction(Album $album)
    {
        $deleteForm = $this->createDeleteForm($album);

        return $this->render('album/show.html.twig', array(
            'album' => $album,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing album entity.
     *
     */
    public function editAction(Request $request, Album $album)
    {
        $deleteForm = $this->createDeleteForm($album);

        $file = new File($this->getParameter('upload_dir_src') . '/' . $album->getSleevePicFilename());

        $editForm = $this->createForm('MusicManager\ManageBundle\Form\AlbumType', $album);

        $editForm->handleRequest($request);

        $album->setSleevePicFilename($file);                
        
        if ($editForm->isSubmitted() && $editForm->isValid()) {

            if ($editForm['sleevePicFilename']->getData() !== null) {
                $file = $editForm['sleevePicFilename']->getData();
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move(
                    $this->getParameter('upload_dir_src'),
                    $fileName
                );         

                $album->setSleevePicFilename($fileName);
            } else {
                // set sleevePicFilename as strig - now is File type
                $album->setSleevePicFilename($album->getSleevePicFilename()->getFilename());
            }
            
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('album_edit', array('id' => $album->getId()));
        }

        return $this->render('album/edit.html.twig', array(
            'album' => $album,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a album entity.
     *
     */
    public function deleteAction(Request $request, Album $album)
    {
        $form = $this->createDeleteForm($album);
        $form->handleRequest($request);
        
        $fs = new Filesystem();
        $sleevePicFilename = $album->getSleevePicFilename();
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($album);
            $em->flush();
        }
        if (file_exists($this->getParameter('upload_dir_src') . '/' . $sleevePicFilename)
                && $sleevePicFilename !== 'brak_obrazka.jpg') {
            $fs->remove($this->getParameter('upload_dir_src') . '/' . $sleevePicFilename);
        }
        
        return $this->redirectToRoute('album_index');
    }

    /**
     * Creates a form to delete a album entity.
     *
     * @param Album $album The album entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Album $album)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('album_delete', array('id' => $album->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
