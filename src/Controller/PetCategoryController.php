<?php

namespace App\Controller;

use App\Entity\PetCategory;
use App\Form\PetCategoryType;
use App\Repository\PetCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/pet/category')]
class PetCategoryController extends AbstractController
{
    #[Route('/', name: 'pet_category_index', methods: ['GET'])]
    public function index(PetCategoryRepository $petCategoryRepository): Response
    {
        return $this->render('pet_category/index.html.twig', [
            'pet_categories' => $petCategoryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'pet_category_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $petCategory = new PetCategory();
        $form = $this->createForm(PetCategoryType::class, $petCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($petCategory);
            $entityManager->flush();

            return $this->redirectToRoute('pet_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pet_category/new.html.twig', [
            'pet_category' => $petCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'pet_category_show', methods: ['GET'])]
    public function show(PetCategory $petCategory): Response
    {
        return $this->render('pet_category/show.html.twig', [
            'pet_category' => $petCategory,
        ]);
    }

    #[Route('/{id}/edit', name: 'pet_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PetCategory $petCategory, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PetCategoryType::class, $petCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('pet_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pet_category/edit.html.twig', [
            'pet_category' => $petCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'pet_category_delete', methods: ['POST'])]
    public function delete(Request $request, PetCategory $petCategory, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$petCategory->getId(), $request->request->get('_token'))) {
            $entityManager->remove($petCategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('pet_category_index', [], Response::HTTP_SEE_OTHER);
    }
}
