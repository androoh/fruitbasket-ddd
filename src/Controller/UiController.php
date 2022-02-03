<?php

namespace FruitBasket\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class UiController extends AbstractController
{
    public function index(Request $request)
    {
        return $this->render('vue.html.twig', [
            'apiUrl' => $request->getBaseUrl()
        ]);
    }

}