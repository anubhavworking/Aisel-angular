<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ResourceBundle\Controller;

use Aisel\ResourceBundle\Controller\ApiController;
use Symfony\Component\HttpFoundation\Request;

/**
 * BaseApiNodeController
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ApiNodeController extends ApiController
{

    /**
     * getNodeCollectionAction
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function getNodeCollectionAction(Request $request)
    {
        /**
         * @var $repo \Aisel\ResourceBundle\Entity\AbstractCollectionRepository
         */
        $repo = $this
            ->container
            ->get('doctrine.orm.entity_manager')
            ->getRepository($this->model);

        $locale = $request->get('locale');
        $tree = $repo->getNodesAsTree($locale);

        return $tree;
    }

    /**
     * getNodeCollectionAction
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function getNodeCollectionEnabledAction(Request $request)
    {
        /**
         * @var $repo \Aisel\ResourceBundle\Entity\AbstractCollectionRepository
         */
        $repo = $this
            ->container
            ->get('doctrine.orm.entity_manager')
            ->getRepository($this->model);

        $locale = $request->get('locale');
        $tree = $repo->getNodesAsTree($locale, $onlyEnabled = true);

        return $tree;
    }

    /**
     * categoryListAction
     *
     * @param Request $request
     * @param string  $locale
     * @return array $categoryList
     */
    public function categoryListAction(Request $request, $locale)
    {
        $params = array(
            'current' => $request->query->get('current'),
            'limit' => $request->query->get('limit'),
            'locale' => $locale,
        );

        /** @var \Aisel\ResourceBundle\Entity\AbstractCollectionRepository $repo */
        $repo = $this->getEntityManager()->getRepository($this->model);
        $total = $repo->getTotalFromRequest($params);
        $categories = $repo->getCurrentCategoriesFromRequest($params);
        $return = array(
            'total' => $total,
            'categories' => $categories
        );

        return $return;
    }


}
