<?php

namespace MusicManager\ManageBundle\Controller;

use MusicManager\ManageBundle\Entity\Song;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Song controller.
 *
 */
class SongController extends Controller
{
    /**
     * Lists all song entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $songs = $em->getRepository('MusicManagerManageBundle:Song')->findAll();

        return $this->render('song/index.html.twig', array(
            'songs' => $songs,
        ));
    }

    /**
     * Creates a new song entity.
     *
     */
    public function newAction(Request $request)
    {
        $song = new Song();
        $form = $this->createForm('MusicManager\ManageBundle\Form\SongType', $song);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($song);
            $em->flush();

            return $this->redirectToRoute('song_show', array('id' => $song->getId()));
        }

        return $this->render('song/new.html.twig', array(
            'song' => $song,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a song entity.
     *
     */
    public function showAction(Song $song)
    {
        $deleteForm = $this->createDeleteForm($song);

        return $this->render('song/show.html.twig', array(
            'song' => $song,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing song entity.
     *
     */
    public function editAction(Request $request, Song $song)
    {
        $deleteForm = $this->createDeleteForm($song);
        $editForm = $this->createForm('MusicManager\ManageBundle\Form\SongType', $song);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('song_edit', array('id' => $song->getId()));
        }

        return $this->render('song/edit.html.twig', array(
            'song' => $song,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a song entity.
     *
     */
    public function deleteAction(Request $request, Song $song)
    {
        $form = $this->createDeleteForm($song);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($song);
            $em->flush();
        }

        return $this->redirectToRoute('song_index');
    }

    /**
     * Creates a form to delete a song entity.
     *
     * @param Song $song The song entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Song $song)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('song_delete', array('id' => $song->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
