<?php

namespace App\Controller;


use App\Classe\Cart;
use App\Entity\Carrier;
use App\Entity\Order;
use App\Entity\OrderDetails;
use App\Entity\Product;
use App\Form\OrderType;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;


class OrderController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/commande", name="order")
     */
    public function index(Cart $cart): Response

    {
        if (!$this->getUser()->getAddresses()->getValues()) {
            return $this->redirectToRoute('add_account_address');
        }
        $form = $this->createForm(OrderType::class, null, ['user' => $this->getUser()]);

        return $this->render('order/index.html.twig', [
            'form' => $form->createView(),
            'cart' => $cart->getFull()
        ]);
    }

    /**
     * @Route("/commande/recapitulatif", name="order_recap", methods={"POST"})
     */
    public function add(Cart $cart, Request $request): Response
    {

        $form = $this->createForm(OrderType::class, null, ['user' => $this->getUser()]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $date = new DateTimeImmutable();
            $delivery = $form->get('addresses')->getData();
            $delivery_content = $delivery->getFirstname() . ' ' . $delivery->getLastname();
            $delivery_content .= '<br/>' . $delivery->getPhone();
            if ($delivery->getCompany()) {
                $delivery_content .= '<br/>' . $delivery->getCompany();
            }
            $delivery_content .= '<br/>' . $delivery->getAddress();
            $delivery_content .= '<br/>' . $delivery->getPostal() . ' ' . $delivery->getCity();
            $delivery_content .= '<br/>' . $delivery->getCountry();


            $order = new Order();
            $reference = $date->format('dmY') . '-' . uniqid();
            $order->setReference($reference);
            $order->setUser($this->getUser());
            $order->setCreatedAt($date);
            $order->setDelivery($delivery_content);
            $order->setState(0);

            $this->entityManager->persist($order);
            $mug = false;
            $totalOfMug = 0;
            foreach ($cart->getFull() as $product) {


                $orderDetails = new OrderDetails();
                $orderDetails->setMyOrder($order);
                $orderDetails->setProduct($product['product']->getName());
                $thecategoryiamlookingfor = $this->entityManager->getRepository(Product::class)->findOneBy(array('name' => $product['product']->getName()));
                $anothercate = $thecategoryiamlookingfor->getCategory()->getId();
                $orderDetails->setQuantity($product['quantity']);

                if ($anothercate === 5) {
                    $mug = true;
                    $quantityofthatorder = $orderDetails->getQuantity($product['quantity']);
                    $totalOfMug = $totalOfMug + $quantityofthatorder;
                }
                $orderDetails->setprice($product['product']->getPrice());
                $orderDetails->setTotal($product['product']->getPrice() * $product['quantity']);
                $this->entityManager->persist($orderDetails);
            }
            var_dump($totalOfMug);
            $carrierss = $this->entityManager->getRepository(Carrier::class)->findAll();
            if ($mug === true &&  $totalOfMug === 1) {
                $carriers = $carrierss[0];
            } else if ($mug === true &&  $totalOfMug === 2) {
                $carriers = $carrierss[2];
            } else if ($mug === true &&  $totalOfMug === 3) {
                $carriers = $carrierss[3];
            } else if ($mug === true &&  $totalOfMug === 4) {
                $carriers = $carrierss[4];
            } else if ($mug === true &&  $totalOfMug === 5) {
                $carriers = $carrierss[5];
            } else if ($mug === true &&  $totalOfMug === 10) {
                $carriers = $carrierss[6];
            } else {
                $carriers = $carrierss[1];
            }
            $order->setCarrierName($carriers->getName());
            $order->setCarrierPrice($carriers->getPrice());
            $this->entityManager->flush();





            return $this->render('order/add.html.twig', [
                'cart' => $cart->getFull(),
                'carrier' => $carriers,
                'delivery' => $delivery_content,
                'reference' => $order->getReference()

            ]);
        }
        return $this->redirectToRoute('cart');
    }
}
