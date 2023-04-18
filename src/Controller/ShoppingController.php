<?php
namespace App\Controller;

use App\Entity\ShoppingList;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShoppingController extends AbstractController
{
    #[Route('/', name: 'intro')]
    public function shopping(): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        return $this->render('shopping/intro.html.twig', [

        ]);
    }

    #[Route('/home', name: 'home')]
    public function shoppingHome(EntityManagerInterface $entityManager): Response
    {
        $userId =  $this->getUser()->getId();
        $listId = $entityManager->getRepository(ShoppingList::class)->findOneByUserId($userId)->getId();

        return $this->render('shopping/shopping.html.twig', [
            "userId" => $userId,
            "listId" => $listId
        ]);
    }
}