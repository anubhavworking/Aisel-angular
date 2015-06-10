<?php

namespace Aisel\OrderBundle\Entity;

use Aisel\ResourceBundle\Entity\AbstractCollectionRepository;

/**
 * OrderRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class OrderRepository extends AbstractCollectionRepository
{

    protected $model = 'AiselOrderBundle:Order';

    /**
     * Create from user cart
     *
     * @param \Aisel\FrontendUserBundle\Entity\FrontendUser $user
     * @param string                                        $locale
     * @param string                                        $currencyCode
     * @param mixed                                         $orderInfo
     *
     * @return \Aisel\OrderBundle\Entity\Order $order|false
     */
    public function createOrderFromCartForUser($user, $currencyCode, $orderInfo)
    {
        $order = $this->createEmptyOrder($user, $currencyCode, $orderInfo);
        $em = $this->getEntityManager();
        $total = 0;

        foreach ($user->getCart() as $item) {
            $total = $total + ($item->getProduct()->getPrice() * $item->getQty());
            $orderItem = new OrderItem();
            $orderItem->setName($item->getProduct()->getName());
            $orderItem->setPrice($item->getProduct()->getPrice());
            $orderItem->setQty($item->getQty());
            $orderItem->setProduct($item->getProduct());
            $orderItem->setOrder($order);
            $em->persist($orderItem);
            $em->remove($item);
        }
        $em->flush();

        $order->setTotalAmount($total);
        $em->persist($order);
        $em->flush();

        return $order;
    }

    /**
     * Create from array of product
     *
     * @param \Aisel\FrontendUserBundle\Entity\FrontendUser $user
     * @param string                                        $locale
     * @param array                                         $products
     * @param string                                        $currencyCode
     * @param mixed                                         $orderInfo
     *
     * @return \Aisel\OrderBundle\Entity\Order $order|false
     */
    public function createOrderFromProductsForUser($user, $products, $currencyCode, $orderInfo)
    {
        $order = $this->createEmptyOrder($user, $currencyCode, $orderInfo);
        $em = $this->getEntityManager();
        $total = 0;

        foreach ($products as $product) {
            $total = $total + ($product->getPrice() * 1);
            $orderItem = new OrderItem();
            $orderItem->setName($product->getName());
            $orderItem->setPrice($product->getPrice());
            $orderItem->setQty(1);
            $orderItem->setProduct($product);
            $orderItem->setOrder($order);
            $em->persist($orderItem);
        }
        $em->flush();

        // Set totals
        $order->setTotalAmount($total);
        $em->persist($order);
        $em->flush();

        return $order;
    }

    /**
     * Create empty order
     *
     * @param \Aisel\FrontendUserBundle\Entity\FrontendUser $user
     * @param string                                        $locale
     * @param string                                        $currencyCode
     * @param mixed                                         $orderInfo
     *
     * @return \Aisel\OrderBundle\Entity\Order $order
     */
    public function createEmptyOrder($user, $currencyCode, $orderInfo)
    {
        $em = $this->getEntityManager();
        $order = new Order();
        $order->setTotalAmount(0);
        $order->setLocale($orderInfo['locale']);
        $order->setFrontenduser($user);
        $order->setCurrency($currencyCode);
        $order->setStatus('new');
        $order->setPaymentMethod($orderInfo['payment_method']);
        $order->setCountry($orderInfo['billing_country']);
        $order->setRegion($orderInfo['billing_region']);
        $order->setCity($orderInfo['billing_city']);
        $order->setPhone($orderInfo['billing_phone']);
        $order->setDescription($orderInfo['billing_comment']);
        $em->persist($order);
        $em->flush();

        return $order;
    }

    /**
     * Grab all orders for given $user
     *
     * @param int   $userId
     *
     * @return \Aisel\OrderBundle\Entity\Order $order
     */
    public function findAllOrdersForUser($userId)
    {
        $query = $this->getEntityManager()->createQueryBuilder();
        $orders = $query->select('o')
            ->from('AiselOrderBundle:Order', 'o')
            ->where('o.frontenduser = :userId')->setParameter('userId', $userId)
            ->orderBy('o.id', 'DESC')
            ->getQuery()
            ->execute();

        return $orders;
    }

    /**
     * Grab one order for given $userId
     *
     * @param integer                                       $userId
     * @param integer                                       $orderId
     *
     * @return \Aisel\OrderBundle\Entity\Order $order
     */
    public function findOrderForUser($userId, $orderId)
    {
        $query = $this->getEntityManager()->createQueryBuilder();
        $orders = $query->select('o')
            ->from('AiselOrderBundle:Order', 'o')
            ->where('o.frontenduser = :userId')->setParameter('userId', $userId)
            ->andWhere('o.id = :orderId')->setParameter('orderId', $orderId)
            ->getQuery()
            ->execute();

        return $orders;
    }

}
