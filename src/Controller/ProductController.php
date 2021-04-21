<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/product", name="product")
 */
class ProductController extends AbstractController
{

    // Index
    // --
    // url : site.com/products
    // name: product:index

    /**
     * @Route("s", name=":index", methods={"HEAD","GET"})
     */
    public function index(ProductRepository $productRepository): Response
    {
        // Liste des produits
        // --

        // $products = $pdo->query("SELECT * FORM catalog_product");
        $products = $productRepository->findAll();


        // Reponse HTTP
        // -- 

        return $this->render('product/index.html.twig', [
            'products' => $products
        ]);
    }



    // Create
    // --
    // url : site.com/product
    // name: product:create

    /**
     * @Route("", name=":create", methods={"HEAD","GET","POST"})
     */
    public function create(Request $request): Response
    {
        // Creation du forlmulaire
        // --

        // Nouvelle entité
        $product = new Product;

        // Creation du formulaire
        $form = $this->createForm(ProductType::class, $product);
        // $a = $this->createForm(ProductType::class, $product);

        // On capte la methode de requête HTTP
        $form->handleRequest( $request );

        // Traitement du formulaire
        // --

        // if ($_SERVER['REQUEST_METHOD'] === "POST")
        // {
        //     $name = $_POST['name'];
        //     $description = $_POST['description'];
        //     // Controle des données
        //     // Ajout en BDD
        //     $pdo->query("INSERT INTO product ('name') VALUE (\"".$name."\")");
        // }
        if ($form->isSubmitted() && $form->isValid())
        {
            // Recupération du Manager d'Entité (Entity Manager)
            $em = $this->getDoctrine()->getManager();

            // Preparation de la requete sur l'objet $product modifié par le formulaire
            $em->persist( $product );

            // Execute la requete
            $em->flush();



            // Redirige l'utilisateur vers la page du produit
            // --

            // Creation du message de validation de la requete
            $this->addFlash('success', "Le produit ".$product->getName()." a été créé !");


            // Redirection
            return $this->redirectToRoute('product:read', [
                'id' => $product->getId()
            ]);

        }


        // Reposne HTTP
        // --

        // Creation de la vue du formulaire
        $form = $form->createView();
        // $b = $a->createView();

        return $this->render('product/create.html.twig', [

            // Transmission du formulaire à la vue twig
            'form' => $form,
            // 'c' => $b,

        ]);
    }



    // Read
    // --
    // url : site.com/product/42
    // name: product:read

    /**
     * @Route("/{id}", name=":read", methods={"HEAD","GET"})
     */
    public function read(Product $product): Response
    {
        return $this->render('product/read.html.twig', [
            'product' => $product
        ]);
    }



    // Update
    // --
    // url : site.com/product/42/edit
    // name: product:update

    /**
     * @Route("/{id}/edit", name=":update", methods={"HEAD","GET","POST"})
     */
    public function update(Product $product, Request $request): Response
    {
        // Creation du forlmulaire
        // --

        // Nouvelle entité
        // /!\ l'entité est déja créée avec le paramètre $product de la méthode create()

        // Creation du formulaire
        $form = $this->createForm(ProductType::class, $product);

        // On capte la methode de requête HTTP
        $form->handleRequest( $request );

        // Traitement du formulaire
        // --

        if ($form->isSubmitted() && $form->isValid())
        {
            // Recupération du Manager d'Entité (Entity Manager)
            $em = $this->getDoctrine()->getManager();

            // Preparation de la requete sur l'objet $product modifié par le formulaire
            $em->persist( $product );

            // Execute la requete
            $em->flush();



            // Redirige l'utilisateur vers la page du produit
            // --

            // Creation du message de validation de la requete
            $this->addFlash('success', "Le produit ".$product->getName()." a été modifié !");


            // Redirection
            return $this->redirectToRoute('product:read', [
                'id' => $product->getId()
            ]);

        }


        // Reposne HTTP
        // --

        // Creation de la vue du formulaire
        $form = $form->createView();

        return $this->render('product/update.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }



    // Delete
    // --
    // url : site.com/product/42/delete
    // name: product:delete

    /**
     * @Route("/{id}/delete", name=":delete", methods={"HEAD","GET","DELETE"})
     */
    public function delete(Product $product, Request $request): Response
    {
        // Test de la methode HTTP / soumission du formulaire
        // --

        // Test la methode HTTP: doit etre "DELETE"
        if ($request->getMethod() == 'DELETE')
        {
            // Recupération du Manager d'Entité (Entity Manager)
            $em = $this->getDoctrine()->getManager();

            // Preparation de la requete de suppression sur l'objet $product 
            // /!\ on utilise "remove" et non "persist"
            $em->remove( $product );

            // Execute la requete
            $em->flush();


            // Redirection de l'utilisateur vers la liste des produits
            // --

            // Message flash de confirmation de la suppression
            $this->addFlash('success', "Le produit ". $product->getName() ." à été supprimé.");

            // Redirection
            return $this->redirectToRoute('product:index');
        }


        // Affichage du message de confirmation d'execution de la suppression
        // --

        return $this->render('product/delete.html.twig', [
            'product' => $product,
        ]);
    }
}
