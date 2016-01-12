<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\UserBundle\Manager;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Aisel\UserBundle\Entity\User;
use Aisel\ResourceBundle\Utility\PasswordUtility;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * UserManager
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class UserManager implements UserProviderInterface
{

    /**
     * @var EncoderFactory
     */
    protected $encoder;

    /**
     * @var SecurityContext
     */
    protected $securityContext;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var UserMailManager
     */
    protected $mailer;

    /**
     * Constructor
     *
     * @param EntityManager $entityManager
     * @param EncoderFactory $encoder
     * @param SecurityContext $securityContext
     * @param UserMailManager $mailer
     */
    public function __construct(
        EntityManager $entityManager,
        EncoderFactory $encoder,
        SecurityContext $securityContext,
        UserMailManager $mailer
    )
    {
        $this->mailer = $mailer;
        $this->encoder = $encoder;
        $this->em = $entityManager;
        $this->securityContext = $securityContext;
    }

    /**
     * Get current user entity
     *
     * @param int $userId
     *
     * @return User $currentUser
     */
    public function getUser($userId = null)
    {
        if ($userId) return $this->loadById($userId);

        $userToken = $this->securityContext->getToken();
        if ($userToken) {
            $user = $userToken->getUser();

            if ($user !== 'anon.') {
                $roles = $user->getRoles();

                if (in_array(User::ROLE_USER, $roles)) return $user;
            }
        }

        return false;
    }

    /**
     * authenticatedUser
     *
     * @return User|boolean
     */
    public function getAuthenticatedUser()
    {
        $userToken = $this->securityContext->getToken();

        if ($userToken) {
            /** @var User $user */
            $user = $userToken->getUser();

            if ($user !== 'anon.') {
                $roles = $user->getRoles();

                if (in_array(User::ROLE_USER, $roles)) {
                    return $user;
                }
            }
        }
    }

    /**
     * Is user password correct
     *
     * @param User $user
     * @param string $password
     *
     * @return boolean $isValid
     */
    public function checkUserPassword(User $user, $password)
    {
        $encoder = $this->encoder->getEncoder($user);

        if (!$encoder) {
            return false;
        }
        $isValid = $encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt());

        return $isValid;
    }

    /**
     * registerFixturesUser
     *
     * @param array $userData
     *
     * @return User $user
     */
    public function registerFixturesUser(array $userData)
    {
        $user = new User();
        $user->setEmail($userData['email']);
        $user->setPlainPassword($userData['password']);
        $user->setRoles($userData['roles']);
        $user->setEnabled($userData['enabled']);
        $user->setLocked($userData['locked']);
        $user->setLastLogin(new \DateTime(date('Y-m-d H:i:s')));
        $user->setPhone($userData['phone']);
        $user->setWebsite($userData['website']);
        $user->setFacebook($userData['facebook']);
        $user->setTwitter($userData['twitter']);
        $user->setAbout($userData['about']);

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    /**
     * Update User details
     *
     * @param array $userData
     *
     * @return string $message
     */
    public function updateDetailsForUser(array $userData)
    {
        $user = $this->securityContext->getToken()->getUser();

        if (isset($userData['phone'])) $user->setPhone($userData['phone']);
        if (isset($userData['website'])) $user->setWebsite($userData['website']);
        if (isset($userData['about'])) $user->setAbout($userData['about']);
        if (isset($userData['facebook'])) $user->setFacebook($userData['facebook']);
        if (isset($userData['twitter'])) $user->setTwitter($userData['twitter']);

        $this->em->persist($user);
        $this->em->flush();
    }

    /**
     * registerUser
     *
     * @param array $userData
     * @return mixed
     */
    public function registerUser(array $userData)
    {
        $user = $this->loadUserByEmail($userData['email']);

        if (!$user) {
            $user = new User();
            $user->setEmail($userData['email']);
            $user->setPlainPassword($userData['password']);
            $user->setEnabled(true);
            $user->setLocked(false);

            $this->em->persist($user);
            $this->em->flush();
            $this->mailer->sendRegisterUserMail($user, $userData['password']);
        }

        return $user;
    }

    /**
     * resetPassword
     *
     * @param User $user
     * @return mixed
     */
    public function resetPassword(User $user)
    {
        if ($user) {
            $utility = new PasswordUtility();
            $password = $utility->generatePassword();

            $user->setPlainPassword($password);
            $user->setPassword($password);

            $this->em->persist($user);
            $this->em->flush();

            $this->mailer->sendNewPasswordEmail($user, $password);
        }
    }

    /**
     * loadUserByEmail
     *
     * @param string $email
     * @return User|null|object
     */
    public function loadUserByEmail($email)
    {
        return $this->loadUserByUsername($email);
    }

    /**
     * {@inheritDoc}
     */
    public function loadUserByUsername($email)
    {
        $user = $this
            ->em
            ->getRepository(User::class)
            ->findOneBy(array('email' => $email));

        return $user;
    }

    /**
     * {@inheritDoc}
     */
    public function refreshUser(UserInterface $user)
    {
        $class = get_class($user);

        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(
                sprintf(
                    'Instances of "%s" are not supported.',
                    $class
                )
            );
        }
        $user = $this
            ->em
            ->getRepository(User::class)
            ->find($user->getId());


        return $user;
    }

    /**
     * {@inheritDoc}
     */
    public function supportsClass($class)
    {
        $name = 'Aisel\UserBundle\Entity\User';

        return $name === $class || is_subclass_of($class, $name);
    }

}
