<?php
namespace App\Controller;

use App\Entity\Reclamations;
use App\Form\ReclamationsType;
use App\Repository\ReclamationsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/reclamation')]
class ReclamationController extends AbstractController
{
    #[Route('/', name: 'app_reclamation_index', methods: ['GET'])]
    public function index(ReclamationsRepository $reclamationsRepository): Response
    {
        return $this->render('reclamation/index.html.twig', [
            'reclamations' => $reclamationsRepository->findAll(),
        ]);
    }


    #[Route('/reclamationA', name: 'app_reclamation_indexA', methods: ['GET'])]
    public function indexA(ReclamationsRepository $reclamationsRepository): Response
    {
        return $this->render('reclamation/Admin/index.html.twig', [
            'reclamation' => $reclamationsRepository->findAll(),
        ]);
    }




    #[Route('/new', name: 'app_reclamation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ReclamationsRepository $reclamationsRepository): Response
    {
        $reclamation = new Reclamations();
        $form = $this->createForm(ReclamationsType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$user = $this->getUser(); // récupérer l'utilisateur actuellement connecté
            //$reclamation->setUser($user); // associer l'utilisateur à la réclamation
            $reclamationsRepository->save($reclamation, true);
            return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamation/new.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reclamation_show', methods: ['GET'])]
    public function show(Reclamations $reclamation): Response
    {
        return $this->render('reclamation/show.html.twig', [
            'reclamation' => $reclamation,
        ]);
    }

    
    

    #[Route('/{id}/edit', name: 'app_reclamation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reclamations $reclamation, ReclamationsRepository $reclamationsRepository): Response
    {
        $form = $this->createForm(ReclamationsType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reclamationsRepository->save($reclamation, true);

            return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamation/edit.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form, 
        ]);
    }

    #[Route('/{id}', name: 'app_reclamation_delete', methods: ['POST'])]
    public function delete(Request $request, Reclamations $reclamation, ReclamationsRepository $reclamationsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reclamation->getId(), $request->request->get('_token'))) {
            $reclamationsRepository->remove($reclamation, true);
        }

        return $this->redirectToRoute('app_reclamation_indexA', [], Response::HTTP_SEE_OTHER);
    }
}
