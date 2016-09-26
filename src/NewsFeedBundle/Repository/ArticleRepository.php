<?php

namespace NewsFeedBundle\Repository;

use Doctrine\ORM\EntityRepository;
use NewsFeedBundle\Entity\User;
use NewsFeedBundle\Entity\Article;

/**
 * ArticleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArticleRepository extends EntityRepository
{
    /**
     * @param  User $user
     * @return Article[]
     */
    public function getListForUser(User $user)
    {
        return $this->findBy(
            [
            'user_id'   => $user->getId(),
            'published' => true
            ], ['id' => 'desc'], 10
        );
    }

    /**
     * @param  User $user
     * @param  int  $id
     * @return Article
     */
    public function getOneForUser(User $user, $id)
    {
        return $this->findOneBy(
            [
            'id'        => $id,
            'user_id'   => $user->getId(),
            'published' => true
            ]
        );
    }

    /**
     * @param  int $id
     * @return Article
     */
    public function getPublicOne($id)
    {
        return $this->findOneBy(
            [
            'id'        => $id,
            'published' => true
            ]
        );
    }

    /**
     * @param  User $user
     * @return Article[]
     */
    public function getPublicList($limit = 10)
    {
        return $this->findBy(
            [
            'published' => true
            ], ['id' => 'desc'], 10
        );
    }

}
