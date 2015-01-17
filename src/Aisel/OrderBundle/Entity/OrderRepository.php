<?php

namespace Aisel\OrderBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * OrderRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class OrderRepository extends EntityRepository
{

    /**
     * Create from user cart
     *
     * @param \Aisel\FrontendUserBundle\Entity\FrontendUser $user
     * @param string $locale
     * @param string $currencyCode
     *
     * @return \Aisel\OrderBundle\Entity\Order $order|false
     */
    public function createOrderFromCartForUser($user, $locale, $currencyCode)
    {
        $order = $this->createEmptyOrder($user, $locale, $currencyCode);
        // Set product items and remove from cart
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
            $orderItem->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
            $orderItem->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
            $em->persist($orderItem);
            $em->flush();

            $em->remove($item);
            $em->flush();
        }

        // Set totals
        $order->setTotalAmount($total);
        $order->setSubtotal($total);
        $order->setGrandtotal($total);
        $em->persist($order);
        $em->flush();

        return $order;
    }

    /**
     * Create from array of product
     *
     * @param \Aisel\FrontendUserBundle\Entity\FrontendUser $user
     * @param string $locale
     * @param array $products
     * @param string $currencyCode
     *
     * @return \Aisel\OrderBundle\Entity\Order $order|false
     */
    public function createOrderFromProductsForUser($user, $locale, $products, $currencyCode)
    {
        $order = $this->createEmptyOrder($user, $locale, $currencyCode);
        // Set product items
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
            $orderItem->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
            $orderItem->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
            $em->persist($orderItem);
            $em->flush();
        }

        // Set totals
        $order->setSubtotal($total);
        $order->setGrandtotal($total);
        $em->persist($order);
        $em->flush();
        return $order;
    }

    /**
     * Create empty order
     *
     * @param \Aisel\FrontendUserBundle\Entity\FrontendUser $user
     * @param string $locale
     * @param string $currencyCode
     *
     * @return \Aisel\OrderBundle\Entity\Order $order|false
     */
    public function createEmptyOrder($user, $locale, $currencyCode)
    {
        $em = $this->getEntityManager();
        $order = new Order();
        $order->setLocale($locale);
        $order->setFrontenduser($user);
        $order->setClientId($user->getId());
        $order->setClientEmail($user->getEmail());
        $order->setStatus('new');
        $order->setDetails('');
        $order->setCurrencyCode('...');
        $order->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $order->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $em->persist($order);
        $em->flush();

        return $order;
    }

    /**
     * Grab all orders for given $user
     *
     * @param \Aisel\FrontendUserBundle\Entity\FrontendUser $user
     *
     * @return \Aisel\OrderBundle\Entity\Order $order
     */
    public function findAllOrdersForUser($user)
    {
        $query = $this->getEntityManager()->createQueryBuilder();
        $orders = $query->select('o')
            ->from('AiselOrderBundle:Order', 'o')
            ->where('o.frontenduser = :userId')->setParameter('userId', $user->getId())
            ->orderBy('o.id', 'DESC')
            ->getQuery()
            ->execute();
        return $orders;
    }

    /**
     * Grab one order for given $user
     *
     * @param \Aisel\FrontendUserBundle\Entity\FrontendUser $user
     * @param integer $orderId
     *
     * @return \Aisel\OrderBundle\Entity\Order $order
     */
    public function findOrderForUser($user, $orderId)
    {
        $query = $this->getEntityManager()->createQueryBuilder();
        $orders = $query->select('o')
            ->from('AiselOrderBundle:Order', 'o')
            ->where('o.frontenduser = :userId')->setParameter('userId', $user->getId())
            ->andWhere('o.id = :orderId')->setParameter('orderId', $orderId)
            ->getQuery()
            ->execute();
        return $orders;
    }


}
