<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\NavigationBundle\Entity;

use Aisel\ResourceBundle\Repository\CollectionRepository;

/**
 * Repository for Menu entity
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class MenuRepository extends CollectionRepository
{

    protected $model = 'AiselNavigationBundle:Menu';

}
