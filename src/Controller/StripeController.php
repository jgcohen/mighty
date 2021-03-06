<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Order;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StripeController extends AbstractController
{
    /**
     * @Route("/commande/create-session/{reference}", name="stripe_create_session")
     */
    public function index(Cart $cart,$reference, EntityManagerInterface $entitymanager): Response
    {

        $product_for_stripe = [];
        $YOUR_DOMAIN = 'http://localhost:8000';

        $order = $entitymanager->getRepository(Order::class)->findOneBy(array('reference'=>$reference));
       if(!$order){
           return $this->redirectToRoute('cart');
       }
        foreach ($order->getOrderDetails()->getValues() as $product) {
            $product_object = $entitymanager->getRepository(Product::class)->findOneBy(array('name'=>$product->getProduct()));
            $product_for_stripe[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $product->getPrice(),
                    'product_data' => [
                        'name' => $product->getProduct(),
                        'images' => [$YOUR_DOMAIN."/uploads/".$product_object->getIllustration()]
                    ]
                ],
                'quantity' => $product->getQuantity(),
            ];

        }
            $product_for_stripe[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $order->getCarrierPrice()*100,
                    'product_data' => [
                        'name' => $order->getCarrierName(),
                        // 'images' => [$YOUR_DOMAIN."/uploads/".$product_object->getIllustration()]
                    ]
                ],
                'quantity' => 1,
            ];
        \Stripe\Stripe::setApiKey('sk_test_51JdGLKLXl6JZC1riGvgqhA9BayMGQZMmlAQpP2lkJyXQU9saRoWlT0toGGvrOwnIXAA6UlWBEglduyy0T4r7zGWF00Ns9jZLzd');
        $checkout_session = \Stripe\Checkout\Session::create([
            'customer_email'=>$this->getUser()->getEmail(),
            'line_items' => [$product_for_stripe],
            'payment_method_types' => [
                'card',
            ],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/commande/merci/{CHECKOUT_SESSION_ID}',
            'cancel_url' => $YOUR_DOMAIN . '/commande/erreur/{CHECKOUT_SESSION_ID}',
        ]);
        
        $order->setStripeSessionId($checkout_session->id);
        $entitymanager->flush();
        return $this->redirect($checkout_session->url,303);
    }
}
