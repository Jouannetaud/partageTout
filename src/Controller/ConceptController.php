<?php

namespace App\Controller;

use App\Entity\Concept;
use App\Form\ConceptType;
use App\Repository\ConceptRepository;
use Doctrine\DBAL\Types\TextType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class ConceptController extends AbstractController
{
    /**
     * @Route("/", name="concept_home",methods={"GET"})
     */
    public function index(EntityManagerInterface $em): Response
    {
       $repo = $em->getRepository(Concept ::class);

       $concepts = $repo->findAll();



        return $this->render('concept/index.html.twig', [
            'concepts' => $concepts,
        ]);
    }

         /**
     * @Route("/concept/{id<[0-9]+>}", name="concept_show",methods={"GET"})
     */
    public function show(ConceptRepository $repo,int $id): Response
    {
        $concept = $repo->find($id);

        if($concept === null){
            throw $this->createNotFoundException('concept' . $id .  'n\'existe pas');
        }

        return $this->render('concept/show.html.twig',['concept' => $concept]);
    }

     
    
  
    /**
     * @Route("/concept/create", name="concept_create", methods={"GET","POST"})
     */
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $concept = new Concept;

       $form = $this->createForm(ConceptType::class, $concept);
       
        

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           
            
            $em->persist($concept);
            $em->flush();

            $this->addFlash('succes','création de concept réussi');

            return $this->redirectToRoute('concept_show', ['id' => $concept->getId()]);

        }


        return $this->render('concept/create.html.twig', [
            'concept' => $concept,
           'form' => $form->createView(),
           

        ]);
    }

    /**
     * @Route("/concept/edit/{id<[0-9]+>}", name="concept_edit",methods={"POST","GET"})
     */
    public function edit(Concept $concept,Request $request,EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ConceptType::class,$concept);
        
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           
            
            $em->persist($concept);
            $em->flush();

            $this->addFlash('succes','modification de concept enregistré');

            return $this->redirectToRoute('concept_home', ['id' => $concept->getId()]);    

        
        }

        return $this->render('concept/edit.html.twig', [
            'concept' => $concept,
           'form' => $form->createView(),
        ]);   
    }


      /**
     * @Route("/concept/delete/{id<[0-9]+>}", name="concept_delete",methods={"GET"})
     */
    public function delete(Concept $concept,EntityManagerInterface $em): Response
    {
        
        $em->remove($concept);
        $em->flush();

        $this->addFlash('succes','suppresion de concept réussi');

        return $this->redirectToRoute('concept_home');  
    }
}
