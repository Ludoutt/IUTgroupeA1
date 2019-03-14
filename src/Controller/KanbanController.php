<?php

namespace App\Controller;

use App\Entity\Kanban;
use App\Form\KanbanType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
     * @Route("/kanban")
*/
class KanbanController extends AbstractController
{
    /**
     * @Route("/", name="kanban")
     */
    public function index()
    {
        $kanbans=$this->getDoctrine()->getRepository(Kanban::class)->findAll();
        return $this->render('kanban/index.html.twig', [
            'kanbans'=>$kanbans
        ]);
    }

    /**
     * @Route("/create", name="create_kanban")
     */
    public function create(Request $request): Response
    {
        $kanban = new Kanban();
        $form = $this->createForm(KanbanType::class, $kanban);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $last = $em->getRepository(Kanban::class)->findLast();
            $rank = empty($last) ? 0 : $last[0]->getId();
            $kanban->setRank($rank);
            $em->persist($kanban);
            $em->flush();

            return $this->redirectToRoute('kanban');
        }

        return $this->render('kanban/create.html.twig', [
            'kanban' => $kanban,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit_kanban")
     */
    public function edit(Request $request,Kanban $kanban): Response
    {
       
     
        $form = $this->createForm(KanbanType::class, $kanban);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('kanban');
        }

        return $this->render('kanban/edit.html.twig', [
            'kanban' => $kanban,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/show", name="show_kanban")
     */
    public function show(Kanban $kanban){
        return $this->render('kanban/show.html.twig', [
            'kanban' => $kanban,
            
        ]);
    }


    /**
     * @Route("/{id}/delete", name="delete_kanban")
     */
    public function delete(Request $request,Kanban $kanban): Response{
        if ($this->isCsrfTokenValid('delete' . $kanban->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($kanban);
            $em->flush();
        }

        return $this->redirectToRoute('kanban');
    }
}
