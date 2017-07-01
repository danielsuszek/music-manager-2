<?php

namespace MusicManager\ManageBundle\Controller;

use MusicManager\ManageBundle\Entity\Album;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;

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
//            exit(\Doctrine\Common\Util\Debug::dump($album));            
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            $file->move(
                $this->getParameter('upload_dir_src'),
                $fileName
            );            
//            exit(\Doctrine\Common\Util\Debug::dump($this->getParameter('upload_dir_src')));            
            
            $album->setSleevePicFilename($fileName);
//            exit(\Doctrine\Common\Util\Debug::dump($album));                        
            
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
        $filename = $album->getSleevePicFilename();

        
        $deleteForm = $this->createDeleteForm($album);
//        exit(\Doctrine\Common\Util\Debug::dump($album));                                    
//                $album->setSleevePicFilename(
//            new File($this->getParameter('upload_dir_src') . '/' . $album->getSleevePicFilename())
//        );
        $file = new File($this->getParameter('upload_dir_src') . '/' . $album->getSleevePicFilename());
//        exit(\Doctrine\Common\Util\Debug::dump($album));                                    

        $editForm = $this->createForm('MusicManager\ManageBundle\Form\AlbumType', $album);
        

        $editForm->handleRequest($request);
//        exit(\Doctrine\Common\Util\Debug::dump($file->getFilename()));                                        
//        exit(\Doctrine\Common\Util\Debug::dump($album->getSleevePicFilename()));                                
//        exit(\Doctrine\Common\Util\Debug::dump($album));                            

        $album->setSleevePicFilename($file);                
        
//        exit(\Doctrine\Common\Util\Debug::dump($album->getSleevePicFilename()));                                        
        if ($editForm->isSubmitted() && $editForm->isValid()) {
//        exit(\Doctrine\Common\Util\Debug::dump($editForm['name']->getData()));                                
//              $fileName = $editForm['sleevePicFilename']->getData()->getFilename();
              $file = $editForm['sleevePicFilename']->getData();
              $fileName = md5(uniqid()).'.'.$file->guessExtension();
//        exit(\Doctrine\Common\Util\Debug::dump($fileName));    
            $file->move(
                $this->getParameter('upload_dir_src'),
                $fileName
            );         
//            exit(\Doctrine\Common\Util\Debug::dump($album->getSleevePicFilename()->getFilename()));    
            
            
            
//            $filename = $album->getSleevePicFilename()->getFilename();
            $album->setSleevePicFilename($fileName);
            
//            exit(\Doctrine\Common\Util\Debug::dump($album));                                
            
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

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($album);
            $em->flush();
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
