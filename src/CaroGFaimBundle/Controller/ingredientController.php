<?php

namespace CaroGFaimBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use CaroGFaimBundle\Entity\ingredient;
use CaroGFaimBundle\Form\ingredientType;

/**
 * ingredient controller.
 *
 */
class ingredientController extends Controller
{
    /*
    * @var string
    */
    private $path_views;

    public function __construct()
    {
        $this->path_views = 'CaroGFaimBundle:ingredient:';
    }

    /**
     * Lists all ingredient entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $ingredients = $em->getRepository('CaroGFaimBundle:ingredient')->findAll();

        return $this->render("{$this->path_views}index.html.twig", array(
            'ingredients' => $ingredients,
        ));
    }

    /**
     * Creates a new ingredient entity.
     *
     */
    public function newAction(Request $request)
    {
        $ingredient = new ingredient();
        $form = $this->createForm('CaroGFaimBundle\Form\ingredientType', $ingredient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ingredient);
            $em->flush();

            return $this->redirectToRoute('ingredient_show', array('id' => $ingredient->getId()));
        }

        return $this->render("{$this->path_views}new.html.twig", array(
            'ingredient' => $ingredient,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ingredient entity.
     *
     */
    public function showAction(ingredient $ingredient)
    {
        $deleteForm = $this->createDeleteForm($ingredient);

        return $this->render("{$this->path_views}show.html.twig", array(
            'ingredient' => $ingredient,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ingredient entity.
     *
     */
    public function editAction(Request $request, ingredient $ingredient)
    {
        $deleteForm = $this->createDeleteForm($ingredient);
        $editForm = $this->createForm('CaroGFaimBundle\Form\ingredientType', $ingredient);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ingredient);
            $em->flush();

            return $this->redirectToRoute('ingredient_show', array('id' => $ingredient->getId()));
        }

        return $this->render("{$this->path_views}edit.html.twig", array(
            'ingredient' => $ingredient,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a ingredient entity.
     *
     */
    public function deleteAction(Request $request, ingredient $ingredient)
    {
        {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ingredient);
            $em->flush();
        }

        return $this->redirectToRoute('ingredient_index');
    }

    /**
     * Creates a form to delete a ingredient entity.
     *
     * @param ingredient $ingredient The ingredient entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ingredient $ingredient)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ingredient_delete', array('id' => $ingredient->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
