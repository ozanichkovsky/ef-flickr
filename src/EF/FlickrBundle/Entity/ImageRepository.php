<?php
/**
 * Created by PhpStorm.
 * User: sasha
 * Date: 10.03.14
 * Time: 16:23
 */

namespace EF\FlickrBundle\Entity;

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityRepository;

class ImageRepository extends EntityRepository
{
    public function findByPageNumber($pageNumber, $params = array())
    {
        $builder = $this->getEntityManager()->createQueryBuilder()
            ->select('i, o');
        $builder = $this->getQueryBuilder($builder, $params);

        /* @var \Doctrine\ORM\Query $query */
        $query = $builder->getQuery()->
            setFirstResult(($pageNumber - 1) * 20)->
            setMaxResults(20);

        try {
            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

    public function getCount($params = array())
    {
        /* @var \Doctrine\ORM\QueryBuilder $builder */
        $builder = $this->getEntityManager()->createQueryBuilder();
        $builder->select('count(i)');
        $builder = $this->getQueryBuilder($builder, $params);

        return $builder->getQuery()->getScalarResult();

    }

    protected function getQueryBuilder(QueryBuilder $builder, $params = array())
    {
        $builder->from('EFFlickrBundle:Image', 'i')->join('i.owner', 'o');

        $hasWhere = false;

        foreach ($params as $key => $value)
        {
            if (!empty($value))
            {
                switch($key)
                {
                    case 'owner':
                        $expr = $builder->expr()->like('o.name', ':' . $key);
                        $builder->setParameter($key, '%' . $value . '%');
                        break;
                    case 'title':
                        $expr = $builder->expr()->like('i.' . $key, ':' . $key);
                        $builder->setParameter($key, '%' . $value . '%');
                        break;
                    default:
                        $expr = $builder->expr()->eq('i.' . $key, ':' . $key);
                        $builder->setParameter($key, $value);
                        break;
                }
                if ($hasWhere)
                {
                    $builder->andWhere($expr);
                }
                else
                {
                    $hasWhere = true;
                    $builder->where($expr);
                }
            }
        }
        return $builder;
    }
} 