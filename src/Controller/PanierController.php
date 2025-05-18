<?php

// src/Controller/CartController.php

namespace App\Controller;

use App\Entity\Livre;
use App\Entity\Livres;
use App\Repository\LivresRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/ajouter-au-panier/{id}", name="ajouter_au_panier")
     */
    public function ajouterAuPanier($id, Request $request): Response
    {
        $livre = $this->entityManager->getRepository(Livres::class)->find($id);
        
        if (!$livre) {
            throw $this->createNotFoundException('Le livre n\'existe pas.');
        }

        $session = $request->getSession();
        $panier = $session->get('panier', []);
        
        if (isset($panier[$id])) {
            $panier[$id]['quantity'] += 1;
        } else {
            $panier[$id] = [
                'title' => $livre->getTitre(),
                'price' => $livre->getPrix(),
                'quantity' => 1,
            ];
        }

        // Sauvegarder le panier dans la session
        $session->set('panier', $panier);

        return $this->redirectToRoute('client_livres'); // Rediriger vers la page du panier
    }

    /**
     * @Route("/panier", name="panier")
     */
    public function afficherPanier(Request $request): Response
    {
        $session = $request->getSession();
        $panier = $session->get('panier', []);

        return $this->render('panier/index.html.twig', [
            'panier' => $panier,
        ]);
    }

    /**
     * @Route("/supprimer-du-panier/{id}", name="supprimer_du_panier")
     */
    public function supprimerDuPanier($id, Request $request): Response
    {
        $session = $request->getSession();
        $panier = $session->get('panier', []);
        
        if (isset($panier[$id])) {
            unset($panier[$id]);
        }

        $session->set('panier', $panier);

        return $this->redirectToRoute('panier');
    }
    #[Route('/panier/modifier/{id}/{action}', name: 'modifier_quantite_panier')]
public function modifierQuantite(int $id, string $action, SessionInterface $session): Response
{
    $panier = $session->get('panier', []);

    if (isset($panier[$id])) {
        if ($action === 'increase') {
            $panier[$id]['quantity'] += 1;
        } elseif ($action === 'decrease' && $panier[$id]['quantity'] > 1) {
            $panier[$id]['quantity'] -= 1;
        }
    }

    $session->set('panier', $panier);
    return $this->redirectToRoute('panier');
}

}


