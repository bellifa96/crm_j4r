<?php

namespace Container93psNC5;
include_once \dirname(__DIR__, 4).'/vendor/doctrine/persistence/src/Persistence/ObjectManager.php';
include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/EntityManagerInterface.php';
include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/EntityManager.php';

class EntityManager_9a5be93 extends \Doctrine\ORM\EntityManager implements \ProxyManager\Proxy\VirtualProxyInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager|null wrapped object, if the proxy is initialized
     */
    private $valueHolder2f47e = null;

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $initializer59a6e = null;

    /**
     * @var bool[] map of public properties of the parent class
     */
    private static $publicProperties94f2b = [
        
    ];

    public function getConnection()
    {
        $this->initializer59a6e && ($this->initializer59a6e->__invoke($valueHolder2f47e, $this, 'getConnection', array(), $this->initializer59a6e) || 1) && $this->valueHolder2f47e = $valueHolder2f47e;

        return $this->valueHolder2f47e->getConnection();
    }

    public function getMetadataFactory()
    {
        $this->initializer59a6e && ($this->initializer59a6e->__invoke($valueHolder2f47e, $this, 'getMetadataFactory', array(), $this->initializer59a6e) || 1) && $this->valueHolder2f47e = $valueHolder2f47e;

        return $this->valueHolder2f47e->getMetadataFactory();
    }

    public function getExpressionBuilder()
    {
        $this->initializer59a6e && ($this->initializer59a6e->__invoke($valueHolder2f47e, $this, 'getExpressionBuilder', array(), $this->initializer59a6e) || 1) && $this->valueHolder2f47e = $valueHolder2f47e;

        return $this->valueHolder2f47e->getExpressionBuilder();
    }

    public function beginTransaction()
    {
        $this->initializer59a6e && ($this->initializer59a6e->__invoke($valueHolder2f47e, $this, 'beginTransaction', array(), $this->initializer59a6e) || 1) && $this->valueHolder2f47e = $valueHolder2f47e;

        return $this->valueHolder2f47e->beginTransaction();
    }

    public function getCache()
    {
        $this->initializer59a6e && ($this->initializer59a6e->__invoke($valueHolder2f47e, $this, 'getCache', array(), $this->initializer59a6e) || 1) && $this->valueHolder2f47e = $valueHolder2f47e;

        return $this->valueHolder2f47e->getCache();
    }

    public function transactional($func)
    {
        $this->initializer59a6e && ($this->initializer59a6e->__invoke($valueHolder2f47e, $this, 'transactional', array('func' => $func), $this->initializer59a6e) || 1) && $this->valueHolder2f47e = $valueHolder2f47e;

        return $this->valueHolder2f47e->transactional($func);
    }

    public function wrapInTransaction(callable $func)
    {
        $this->initializer59a6e && ($this->initializer59a6e->__invoke($valueHolder2f47e, $this, 'wrapInTransaction', array('func' => $func), $this->initializer59a6e) || 1) && $this->valueHolder2f47e = $valueHolder2f47e;

        return $this->valueHolder2f47e->wrapInTransaction($func);
    }

    public function commit()
    {
        $this->initializer59a6e && ($this->initializer59a6e->__invoke($valueHolder2f47e, $this, 'commit', array(), $this->initializer59a6e) || 1) && $this->valueHolder2f47e = $valueHolder2f47e;

        return $this->valueHolder2f47e->commit();
    }

    public function rollback()
    {
        $this->initializer59a6e && ($this->initializer59a6e->__invoke($valueHolder2f47e, $this, 'rollback', array(), $this->initializer59a6e) || 1) && $this->valueHolder2f47e = $valueHolder2f47e;

        return $this->valueHolder2f47e->rollback();
    }

    public function getClassMetadata($className)
    {
        $this->initializer59a6e && ($this->initializer59a6e->__invoke($valueHolder2f47e, $this, 'getClassMetadata', array('className' => $className), $this->initializer59a6e) || 1) && $this->valueHolder2f47e = $valueHolder2f47e;

        return $this->valueHolder2f47e->getClassMetadata($className);
    }

    public function createQuery($dql = '')
    {
        $this->initializer59a6e && ($this->initializer59a6e->__invoke($valueHolder2f47e, $this, 'createQuery', array('dql' => $dql), $this->initializer59a6e) || 1) && $this->valueHolder2f47e = $valueHolder2f47e;

        return $this->valueHolder2f47e->createQuery($dql);
    }

    public function createNamedQuery($name)
    {
        $this->initializer59a6e && ($this->initializer59a6e->__invoke($valueHolder2f47e, $this, 'createNamedQuery', array('name' => $name), $this->initializer59a6e) || 1) && $this->valueHolder2f47e = $valueHolder2f47e;

        return $this->valueHolder2f47e->createNamedQuery($name);
    }

    public function createNativeQuery($sql, \Doctrine\ORM\Query\ResultSetMapping $rsm)
    {
        $this->initializer59a6e && ($this->initializer59a6e->__invoke($valueHolder2f47e, $this, 'createNativeQuery', array('sql' => $sql, 'rsm' => $rsm), $this->initializer59a6e) || 1) && $this->valueHolder2f47e = $valueHolder2f47e;

        return $this->valueHolder2f47e->createNativeQuery($sql, $rsm);
    }

    public function createNamedNativeQuery($name)
    {
        $this->initializer59a6e && ($this->initializer59a6e->__invoke($valueHolder2f47e, $this, 'createNamedNativeQuery', array('name' => $name), $this->initializer59a6e) || 1) && $this->valueHolder2f47e = $valueHolder2f47e;

        return $this->valueHolder2f47e->createNamedNativeQuery($name);
    }

    public function createQueryBuilder()
    {
        $this->initializer59a6e && ($this->initializer59a6e->__invoke($valueHolder2f47e, $this, 'createQueryBuilder', array(), $this->initializer59a6e) || 1) && $this->valueHolder2f47e = $valueHolder2f47e;

        return $this->valueHolder2f47e->createQueryBuilder();
    }

    public function flush($entity = null)
    {
        $this->initializer59a6e && ($this->initializer59a6e->__invoke($valueHolder2f47e, $this, 'flush', array('entity' => $entity), $this->initializer59a6e) || 1) && $this->valueHolder2f47e = $valueHolder2f47e;

        return $this->valueHolder2f47e->flush($entity);
    }

    public function find($className, $id, $lockMode = null, $lockVersion = null)
    {
        $this->initializer59a6e && ($this->initializer59a6e->__invoke($valueHolder2f47e, $this, 'find', array('className' => $className, 'id' => $id, 'lockMode' => $lockMode, 'lockVersion' => $lockVersion), $this->initializer59a6e) || 1) && $this->valueHolder2f47e = $valueHolder2f47e;

        return $this->valueHolder2f47e->find($className, $id, $lockMode, $lockVersion);
    }

    public function getReference($entityName, $id)
    {
        $this->initializer59a6e && ($this->initializer59a6e->__invoke($valueHolder2f47e, $this, 'getReference', array('entityName' => $entityName, 'id' => $id), $this->initializer59a6e) || 1) && $this->valueHolder2f47e = $valueHolder2f47e;

        return $this->valueHolder2f47e->getReference($entityName, $id);
    }

    public function getPartialReference($entityName, $identifier)
    {
        $this->initializer59a6e && ($this->initializer59a6e->__invoke($valueHolder2f47e, $this, 'getPartialReference', array('entityName' => $entityName, 'identifier' => $identifier), $this->initializer59a6e) || 1) && $this->valueHolder2f47e = $valueHolder2f47e;

        return $this->valueHolder2f47e->getPartialReference($entityName, $identifier);
    }

    public function clear($entityName = null)
    {
        $this->initializer59a6e && ($this->initializer59a6e->__invoke($valueHolder2f47e, $this, 'clear', array('entityName' => $entityName), $this->initializer59a6e) || 1) && $this->valueHolder2f47e = $valueHolder2f47e;

        return $this->valueHolder2f47e->clear($entityName);
    }

    public function close()
    {
        $this->initializer59a6e && ($this->initializer59a6e->__invoke($valueHolder2f47e, $this, 'close', array(), $this->initializer59a6e) || 1) && $this->valueHolder2f47e = $valueHolder2f47e;

        return $this->valueHolder2f47e->close();
    }

    public function persist($entity)
    {
        $this->initializer59a6e && ($this->initializer59a6e->__invoke($valueHolder2f47e, $this, 'persist', array('entity' => $entity), $this->initializer59a6e) || 1) && $this->valueHolder2f47e = $valueHolder2f47e;

        return $this->valueHolder2f47e->persist($entity);
    }

    public function remove($entity)
    {
        $this->initializer59a6e && ($this->initializer59a6e->__invoke($valueHolder2f47e, $this, 'remove', array('entity' => $entity), $this->initializer59a6e) || 1) && $this->valueHolder2f47e = $valueHolder2f47e;

        return $this->valueHolder2f47e->remove($entity);
    }

    public function refresh($entity)
    {
        $this->initializer59a6e && ($this->initializer59a6e->__invoke($valueHolder2f47e, $this, 'refresh', array('entity' => $entity), $this->initializer59a6e) || 1) && $this->valueHolder2f47e = $valueHolder2f47e;

        return $this->valueHolder2f47e->refresh($entity);
    }

    public function detach($entity)
    {
        $this->initializer59a6e && ($this->initializer59a6e->__invoke($valueHolder2f47e, $this, 'detach', array('entity' => $entity), $this->initializer59a6e) || 1) && $this->valueHolder2f47e = $valueHolder2f47e;

        return $this->valueHolder2f47e->detach($entity);
    }

    public function merge($entity)
    {
        $this->initializer59a6e && ($this->initializer59a6e->__invoke($valueHolder2f47e, $this, 'merge', array('entity' => $entity), $this->initializer59a6e) || 1) && $this->valueHolder2f47e = $valueHolder2f47e;

        return $this->valueHolder2f47e->merge($entity);
    }

    public function copy($entity, $deep = false)
    {
        $this->initializer59a6e && ($this->initializer59a6e->__invoke($valueHolder2f47e, $this, 'copy', array('entity' => $entity, 'deep' => $deep), $this->initializer59a6e) || 1) && $this->valueHolder2f47e = $valueHolder2f47e;

        return $this->valueHolder2f47e->copy($entity, $deep);
    }

    public function lock($entity, $lockMode, $lockVersion = null)
    {
        $this->initializer59a6e && ($this->initializer59a6e->__invoke($valueHolder2f47e, $this, 'lock', array('entity' => $entity, 'lockMode' => $lockMode, 'lockVersion' => $lockVersion), $this->initializer59a6e) || 1) && $this->valueHolder2f47e = $valueHolder2f47e;

        return $this->valueHolder2f47e->lock($entity, $lockMode, $lockVersion);
    }

    public function getRepository($entityName)
    {
        $this->initializer59a6e && ($this->initializer59a6e->__invoke($valueHolder2f47e, $this, 'getRepository', array('entityName' => $entityName), $this->initializer59a6e) || 1) && $this->valueHolder2f47e = $valueHolder2f47e;

        return $this->valueHolder2f47e->getRepository($entityName);
    }

    public function contains($entity)
    {
        $this->initializer59a6e && ($this->initializer59a6e->__invoke($valueHolder2f47e, $this, 'contains', array('entity' => $entity), $this->initializer59a6e) || 1) && $this->valueHolder2f47e = $valueHolder2f47e;

        return $this->valueHolder2f47e->contains($entity);
    }

    public function getEventManager()
    {
        $this->initializer59a6e && ($this->initializer59a6e->__invoke($valueHolder2f47e, $this, 'getEventManager', array(), $this->initializer59a6e) || 1) && $this->valueHolder2f47e = $valueHolder2f47e;

        return $this->valueHolder2f47e->getEventManager();
    }

    public function getConfiguration()
    {
        $this->initializer59a6e && ($this->initializer59a6e->__invoke($valueHolder2f47e, $this, 'getConfiguration', array(), $this->initializer59a6e) || 1) && $this->valueHolder2f47e = $valueHolder2f47e;

        return $this->valueHolder2f47e->getConfiguration();
    }

    public function isOpen()
    {
        $this->initializer59a6e && ($this->initializer59a6e->__invoke($valueHolder2f47e, $this, 'isOpen', array(), $this->initializer59a6e) || 1) && $this->valueHolder2f47e = $valueHolder2f47e;

        return $this->valueHolder2f47e->isOpen();
    }

    public function getUnitOfWork()
    {
        $this->initializer59a6e && ($this->initializer59a6e->__invoke($valueHolder2f47e, $this, 'getUnitOfWork', array(), $this->initializer59a6e) || 1) && $this->valueHolder2f47e = $valueHolder2f47e;

        return $this->valueHolder2f47e->getUnitOfWork();
    }

    public function getHydrator($hydrationMode)
    {
        $this->initializer59a6e && ($this->initializer59a6e->__invoke($valueHolder2f47e, $this, 'getHydrator', array('hydrationMode' => $hydrationMode), $this->initializer59a6e) || 1) && $this->valueHolder2f47e = $valueHolder2f47e;

        return $this->valueHolder2f47e->getHydrator($hydrationMode);
    }

    public function newHydrator($hydrationMode)
    {
        $this->initializer59a6e && ($this->initializer59a6e->__invoke($valueHolder2f47e, $this, 'newHydrator', array('hydrationMode' => $hydrationMode), $this->initializer59a6e) || 1) && $this->valueHolder2f47e = $valueHolder2f47e;

        return $this->valueHolder2f47e->newHydrator($hydrationMode);
    }

    public function getProxyFactory()
    {
        $this->initializer59a6e && ($this->initializer59a6e->__invoke($valueHolder2f47e, $this, 'getProxyFactory', array(), $this->initializer59a6e) || 1) && $this->valueHolder2f47e = $valueHolder2f47e;

        return $this->valueHolder2f47e->getProxyFactory();
    }

    public function initializeObject($obj)
    {
        $this->initializer59a6e && ($this->initializer59a6e->__invoke($valueHolder2f47e, $this, 'initializeObject', array('obj' => $obj), $this->initializer59a6e) || 1) && $this->valueHolder2f47e = $valueHolder2f47e;

        return $this->valueHolder2f47e->initializeObject($obj);
    }

    public function getFilters()
    {
        $this->initializer59a6e && ($this->initializer59a6e->__invoke($valueHolder2f47e, $this, 'getFilters', array(), $this->initializer59a6e) || 1) && $this->valueHolder2f47e = $valueHolder2f47e;

        return $this->valueHolder2f47e->getFilters();
    }

    public function isFiltersStateClean()
    {
        $this->initializer59a6e && ($this->initializer59a6e->__invoke($valueHolder2f47e, $this, 'isFiltersStateClean', array(), $this->initializer59a6e) || 1) && $this->valueHolder2f47e = $valueHolder2f47e;

        return $this->valueHolder2f47e->isFiltersStateClean();
    }

    public function hasFilters()
    {
        $this->initializer59a6e && ($this->initializer59a6e->__invoke($valueHolder2f47e, $this, 'hasFilters', array(), $this->initializer59a6e) || 1) && $this->valueHolder2f47e = $valueHolder2f47e;

        return $this->valueHolder2f47e->hasFilters();
    }

    /**
     * Constructor for lazy initialization
     *
     * @param \Closure|null $initializer
     */
    public static function staticProxyConstructor($initializer)
    {
        static $reflection;

        $reflection = $reflection ?? new \ReflectionClass(__CLASS__);
        $instance   = $reflection->newInstanceWithoutConstructor();

        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $instance, 'Doctrine\\ORM\\EntityManager')->__invoke($instance);

        $instance->initializer59a6e = $initializer;

        return $instance;
    }

    protected function __construct(\Doctrine\DBAL\Connection $conn, \Doctrine\ORM\Configuration $config, \Doctrine\Common\EventManager $eventManager)
    {
        static $reflection;

        if (! $this->valueHolder2f47e) {
            $reflection = $reflection ?? new \ReflectionClass('Doctrine\\ORM\\EntityManager');
            $this->valueHolder2f47e = $reflection->newInstanceWithoutConstructor();
        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $this, 'Doctrine\\ORM\\EntityManager')->__invoke($this);

        }

        $this->valueHolder2f47e->__construct($conn, $config, $eventManager);
    }

    public function & __get($name)
    {
        $this->initializer59a6e && ($this->initializer59a6e->__invoke($valueHolder2f47e, $this, '__get', ['name' => $name], $this->initializer59a6e) || 1) && $this->valueHolder2f47e = $valueHolder2f47e;

        if (isset(self::$publicProperties94f2b[$name])) {
            return $this->valueHolder2f47e->$name;
        }

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder2f47e;

            $backtrace = debug_backtrace(false, 1);
            trigger_error(
                sprintf(
                    'Undefined property: %s::$%s in %s on line %s',
                    $realInstanceReflection->getName(),
                    $name,
                    $backtrace[0]['file'],
                    $backtrace[0]['line']
                ),
                \E_USER_NOTICE
            );
            return $targetObject->$name;
        }

        $targetObject = $this->valueHolder2f47e;
        $accessor = function & () use ($targetObject, $name) {
            return $targetObject->$name;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = & $accessor();

        return $returnValue;
    }

    public function __set($name, $value)
    {
        $this->initializer59a6e && ($this->initializer59a6e->__invoke($valueHolder2f47e, $this, '__set', array('name' => $name, 'value' => $value), $this->initializer59a6e) || 1) && $this->valueHolder2f47e = $valueHolder2f47e;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder2f47e;

            $targetObject->$name = $value;

            return $targetObject->$name;
        }

        $targetObject = $this->valueHolder2f47e;
        $accessor = function & () use ($targetObject, $name, $value) {
            $targetObject->$name = $value;

            return $targetObject->$name;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = & $accessor();

        return $returnValue;
    }

    public function __isset($name)
    {
        $this->initializer59a6e && ($this->initializer59a6e->__invoke($valueHolder2f47e, $this, '__isset', array('name' => $name), $this->initializer59a6e) || 1) && $this->valueHolder2f47e = $valueHolder2f47e;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder2f47e;

            return isset($targetObject->$name);
        }

        $targetObject = $this->valueHolder2f47e;
        $accessor = function () use ($targetObject, $name) {
            return isset($targetObject->$name);
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = $accessor();

        return $returnValue;
    }

    public function __unset($name)
    {
        $this->initializer59a6e && ($this->initializer59a6e->__invoke($valueHolder2f47e, $this, '__unset', array('name' => $name), $this->initializer59a6e) || 1) && $this->valueHolder2f47e = $valueHolder2f47e;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder2f47e;

            unset($targetObject->$name);

            return;
        }

        $targetObject = $this->valueHolder2f47e;
        $accessor = function () use ($targetObject, $name) {
            unset($targetObject->$name);

            return;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $accessor();
    }

    public function __clone()
    {
        $this->initializer59a6e && ($this->initializer59a6e->__invoke($valueHolder2f47e, $this, '__clone', array(), $this->initializer59a6e) || 1) && $this->valueHolder2f47e = $valueHolder2f47e;

        $this->valueHolder2f47e = clone $this->valueHolder2f47e;
    }

    public function __sleep()
    {
        $this->initializer59a6e && ($this->initializer59a6e->__invoke($valueHolder2f47e, $this, '__sleep', array(), $this->initializer59a6e) || 1) && $this->valueHolder2f47e = $valueHolder2f47e;

        return array('valueHolder2f47e');
    }

    public function __wakeup()
    {
        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $this, 'Doctrine\\ORM\\EntityManager')->__invoke($this);
    }

    public function setProxyInitializer(\Closure $initializer = null) : void
    {
        $this->initializer59a6e = $initializer;
    }

    public function getProxyInitializer() : ?\Closure
    {
        return $this->initializer59a6e;
    }

    public function initializeProxy() : bool
    {
        return $this->initializer59a6e && ($this->initializer59a6e->__invoke($valueHolder2f47e, $this, 'initializeProxy', array(), $this->initializer59a6e) || 1) && $this->valueHolder2f47e = $valueHolder2f47e;
    }

    public function isProxyInitialized() : bool
    {
        return null !== $this->valueHolder2f47e;
    }

    public function getWrappedValueHolderValue()
    {
        return $this->valueHolder2f47e;
    }
}

if (!\class_exists('EntityManager_9a5be93', false)) {
    \class_alias(__NAMESPACE__.'\\EntityManager_9a5be93', 'EntityManager_9a5be93', false);
}
