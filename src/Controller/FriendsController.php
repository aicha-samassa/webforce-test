<?php

namespace App\Controller;

use App\Entity\Friends;
use App\Form\FriendsType;
use App\Repository\FriendsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/friends")
 */
class FriendsController extends AbstractController
{
    /**
     * @Route("/", name="friends_index", methods={"GET"})
     */
    public function index(FriendsRepository $friendsRepository): Response
    {

        return $this->render('friends/index.html.twig', [
            'friends' => $friendsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="friends_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $friend = new Friends();
        $form = $this->createForm(FriendsType::class, $friend);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($friend);
            $entityManager->flush();

            return $this->redirectToRoute('friends_index');
        }

        return $this->render('friends/new.html.twig', [
            'friend' => $friend,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="friends_show", methods={"GET"})
     */
    public function show(Friends $friend): Response
    {
        return $this->render('friends/show.html.twig', [
            'friend' => $friend,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="friends_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Friends $friend): Response
    {
        $form = $this->createForm(FriendsType::class, $friend);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('friends_index');
        }

        return $this->render('friends/edit.html.twig', [
            'friend' => $friend,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="friends_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Friends $friend): Response
    {
        if ($this->isCsrfTokenValid('delete'.$friend->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($friend);
            $entityManager->flush();
        }

        return $this->redirectToRoute('friends_index');
    }
}
