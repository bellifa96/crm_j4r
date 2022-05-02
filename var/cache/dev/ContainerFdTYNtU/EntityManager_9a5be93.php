<?php

namespace ContainerFdTYNtU;
include_once \dirname(__DIR__, 4).'/vendor/doctrine/persistence/src/Persistence/ObjectManager.php';
include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/EntityManagerInterface.php';
include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/EntityManager.php';

class EntityManager_9a5be93 extends \Doctrine\ORM\EntityManager implements \ProxyManager\Proxy\VirtualProxyInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager|null wrapped object, if the proxy is initialized
     */
    private $valueHolder03290 = null;

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $initializere5899 = null;

    /**
     * @var bool[] map of public properties of the parent class
     */
    private static $publicProperties01ef2 = [
        
    ];

    public function getConnection()
    {
        $this->initializere5899 && ($this->initializere5899->__invoke($valueHolder03290, $this, 'getConnection', array(), $this->initializere5899) || 1) && $this->valueHolder03290 = $valueHolder03290;

        return $this->valueHolder03290->getConnection();
    }

    public function getMetadataFactory()
    {
        $this->initializere5899 && ($this->initializere5899->__invoke($valueHolder03290, $this, 'getMetadataFactory', array(), $this->initializere5899) || 1) && $this->valueHolder03290 = $valueHolder03290;

        return $this->valueHolder03290->getMetadataFactory();
    }

    public function getExpressionBuilder()
    {
        $this->initializere5899 && ($this->initializere5899->__invoke($valueHolder03290, $this, 'getExpressionBuilder', array(), $this->initializere5899) || 1) && $this->valueHolder03290 = $valueHolder03290;

        return $this->valueHolder03290->getExpressionBuilder();
    }

    public function beginTransaction()
    {
        $this->initializere5899 && ($this->initializere5899->__invoke($valueHolder03290, $this, 'beginTransaction', array(), $this->initializere5899) || 1) && $this->valueHolder03290 = $valueHolder03290;

        return $this->valueHolder03290->beginTransaction();
    }

    public function getCache()
    {
        $this->initializere5899 && ($this->initializere5899->__invoke($valueHolder03290, $this, 'getCache', array(), $this->initializere5899) || 1) && $this->valueHolder03290 = $valueHolder03290;

        return $this->valueHolder03290->getCache();
    }

    public function transactional($func)
    {
        $this->initializere5899 && ($this->initializere5899->__invoke($valueHolder03290, $this, 'transactional', array('func' => $func), $this->initializere5899) || 1) && $this->valueHolder03290 = $valueHolder03290;

        return $this->valueHolder03290->transactional($func);
    }

    public function wrapInTransaction(callable $func)
    {
        $this->initializere5899 && ($this->initializere5899->__invoke($valueHolder03290, $this, 'wrapInTransaction', array('func' => $func), $this->initializere5899) || 1) && $this->valueHolder03290 = $valueHolder03290;

        return $this->valueHolder03290->wrapInTransaction($func);
    }

    public function commit()
    {
        $this->initializere5899 && ($this->initializere5899->__invoke($valueHolder03290, $this, 'commit', array(), $this->initializere5899) || 1) && $this->valueHolder03290 = $valueHolder03290;

        return $this->valueHolder03290->commit();
    }

    public function rollback()
    {
        $this->initializere5899 && ($this->initializere5899->__invoke($valueHolder03290, $this, 'rollback', array(), $this->initializere5899) || 1) && $this->valueHolder03290 = $valueHolder03290;

        return $this->valueHolder03290->rollback();
    }

    public function getClassMetadata($className)
    {
        $this->initializere5899 && ($this->initializere5899->__invoke($valueHolder03290, $this, 'getClassMetadata', array('className' => $className), $this->initializere5899) || 1) && $this->valueHolder03290 = $valueHolder03290;

        return $this->valueHolder03290->getClassMetadata($className);
    }

    public function createQuery($dql = '')
    {
        $this->initializere5899 && ($this->initializere5899->__invoke($valueHolder03290, $this, 'createQuery', array('dql' => $dql), $this->initializere5899) || 1) && $this->valueHolder03290 = $valueHolder03290;

        return $this->valueHolder03290->createQuery($dql);
    }

    public function createNamedQuery($name)
    {
        $this->initializere5899 && ($this->initializere5899->__invoke($valueHolder03290, $this, 'createNamedQuery', array('name' => $name), $this->initializere5899) || 1) && $this->valueHolder03290 = $valueHolder03290;

        return $this->valueHolder03290->createNamedQuery($name);
    }

    public function createNativeQuery($sql, \Doctrine\ORM\Query\ResultSetMapping $rsm)
    {
        $this->initializere5899 && ($this->initializere5899->__invoke($valueHolder03290, $this, 'createNativeQuery', array('sql' => $sql, 'rsm' => $rsm), $this->initializere5899) || 1) && $this->valueHolder03290 = $valueHolder03290;

        return $this->valueHolder03290->createNativeQuery($sql, $rsm);
    }

    public function createNamedNativeQuery($name)
    {
        $this->initializere5899 && ($this->initializere5899->__invoke($valueHolder03290, $this, 'createNamedNativeQuery', array('name' => $name), $this->initializere5899) || 1) && $this->valueHolder03290 = $valueHolder03290;

        return $this->valueHolder03290->createNamedNativeQuery($name);
    }

    public function createQueryBuilder()
    {
        $this->initializere5899 && ($this->initializere5899->__invoke($valueHolder03290, $this, 'createQueryBuilder', array(), $this->initializere5899) || 1) && $this->valueHolder03290 = $valueHolder03290;

        return $this->valueHolder03290->createQueryBuilder();
    }

    public function flush($entity = null)
    {
        $this->initializere5899 && ($this->initializere5899->__invoke($valueHolder03290, $this, 'flush', array('entity' => $entity), $this->initializere5899) || 1) && $this->valueHolder03290 = $valueHolder03290;

        return $this->valueHolder03290->flush($entity);
    }

    public function find($className, $id, $lockMode = null, $lockVersion = null)
    {
        $this->initializere5899 && ($this->initializere5899->__invoke($valueHolder03290, $this, 'find', array('className' => $className, 'id' => $id, 'lockMode' => $lockMode, 'lockVersion' => $lockVersion), $this->initializere5899) || 1) && $this->valueHolder03290 = $valueHolder03290;

        return $this->valueHolder03290->find($className, $id, $lockMode, $lockVersion);
    }

    public function getReference($entityName, $id)
    {
        $this->initializere5899 && ($this->initializere5899->__invoke($valueHolder03290, $this, 'getReference', array('entityName' => $entityName, 'id' => $id), $this->initializere5899) || 1) && $this->valueHolder03290 = $valueHolder03290;

        return $this->valueHolder03290->getReference($entityName, $id);
    }

    public function getPartialReference($entityName, $identifier)
    {
        $this->initializere5899 && ($this->initializere5899->__invoke($valueHolder03290, $this, 'getPartialReference', array('entityName' => $entityName, 'identifier' => $identifier), $this->initializere5899) || 1) && $this->valueHolder03290 = $valueHolder03290;

        return $this->valueHolder03290->getPartialReference($entityName, $identifier);
    }

    public function clear($entityName = null)
    {
        $this->initializere5899 && ($this->initializere5899->__invoke($valueHolder03290, $this, 'clear', array('entityName' => $entityName), $this->initializere5899) || 1) && $this->valueHolder03290 = $valueHolder03290;

        return $this->valueHolder03290->clear($entityName);
    }

    public function close()
    {
        $this->initializere5899 && ($this->initializere5899->__invoke($valueHolder03290, $this, 'close', array(), $this->initializere5899) || 1) && $this->valueHolder03290 = $valueHolder03290;

        return $this->valueHolder03290->close();
    }

    public function persist($entity)
    {
        $this->initializere5899 && ($this->initializere5899->__invoke($valueHolder03290, $this, 'persist', array('entity' => $entity), $this->initializere5899) || 1) && $this->valueHolder03290 = $valueHolder03290;

        return $this->valueHolder03290->persist($entity);
    }

    public function remove($entity)
    {
        $this->initializere5899 && ($this->initializere5899->__invoke($valueHolder03290, $this, 'remove', array('entity' => $entity), $this->initializere5899) || 1) && $this->valueHolder03290 = $valueHolder03290;

        return $this->valueHolder03290->remove($entity);
    }

    public function refresh($entity)
    {
        $this->initializere5899 && ($this->initializere5899->__invoke($valueHolder03290, $this, 'refresh', array('entity' => $entity), $this->initializere5899) || 1) && $this->valueHolder03290 = $valueHolder03290;

        return $this->valueHolder03290->refresh($entity);
    }

    public function detach($entity)
    {
        $this->initializere5899 && ($this->initializere5899->__invoke($valueHolder03290, $this, 'detach', array('entity' => $entity), $this->initializere5899) || 1) && $this->valueHolder03290 = $valueHolder03290;

        return $this->valueHolder03290->detach($entity);
    }

    public function merge($entity)
    {
        $this->initializere5899 && ($this->initializere5899->__invoke($valueHolder03290, $this, 'merge', array('entity' => $entity), $this->initializere5899) || 1) && $this->valueHolder03290 = $valueHolder03290;

        return $this->valueHolder03290->merge($entity);
    }

    public function copy($entity, $deep = false)
    {
        $this->initializere5899 && ($this->initializere5899->__invoke($valueHolder03290, $this, 'copy', array('entity' => $entity, 'deep' => $deep), $this->initializere5899) || 1) && $this->valueHolder03290 = $valueHolder03290;

        return $this->valueHolder03290->copy($entity, $deep);
    }

    public function lock($entity, $lockMode, $lockVersion = null)
    {
        $this->initializere5899 && ($this->initializere5899->__invoke($valueHolder03290, $this, 'lock', array('entity' => $entity, 'lockMode' => $lockMode, 'lockVersion' => $lockVersion), $this->initializere5899) || 1) && $this->valueHolder03290 = $valueHolder03290;

        return $this->valueHolder03290->lock($entity, $lockMode, $lockVersion);
    }

    public function getRepository($entityName)
    {
        $this->initializere5899 && ($this->initializere5899->__invoke($valueHolder03290, $this, 'getRepository', array('entityName' => $entityName), $this->initializere5899) || 1) && $this->valueHolder03290 = $valueHolder03290;

        return $this->valueHolder03290->getRepository($entityName);
    }

    public function contains($entity)
    {
        $this->initializere5899 && ($this->initializere5899->__invoke($valueHolder03290, $this, 'contains', array('entity' => $entity), $this->initializere5899) || 1) && $this->valueHolder03290 = $valueHolder03290;

        return $this->valueHolder03290->contains($entity);
    }

    public function getEventManager()
    {
        $this->initializere5899 && ($this->initializere5899->__invoke($valueHolder03290, $this, 'getEventManager', array(), $this->initializere5899) || 1) && $this->valueHolder03290 = $valueHolder03290;

        return $this->valueHolder03290->getEventManager();
    }

    public function getConfiguration()
    {
        $this->initializere5899 && ($this->initializere5899->__invoke($valueHolder03290, $this, 'getConfiguration', array(), $this->initializere5899) || 1) && $this->valueHolder03290 = $valueHolder03290;

        return $this->valueHolder03290->getConfiguration();
    }

    public function isOpen()
    {
        $this->initializere5899 && ($this->initializere5899->__invoke($valueHolder03290, $this, 'isOpen', array(), $this->initializere5899) || 1) && $this->valueHolder03290 = $valueHolder03290;

        return $this->valueHolder03290->isOpen();
    }

    public function getUnitOfWork()
    {
        $this->initializere5899 && ($this->initializere5899->__invoke($valueHolder03290, $this, 'getUnitOfWork', array(), $this->initializere5899) || 1) && $this->valueHolder03290 = $valueHolder03290;

        return $this->valueHolder03290->getUnitOfWork();
    }

    public function getHydrator($hydrationMode)
    {
        $this->initializere5899 && ($this->initializere5899->__invoke($valueHolder03290, $this, 'getHydrator', array('hydrationMode' => $hydrationMode), $this->initializere5899) || 1) && $this->valueHolder03290 = $valueHolder03290;

        return $this->valueHolder03290->getHydrator($hydrationMode);
    }

    public function newHydrator($hydrationMode)
    {
        $this->initializere5899 && ($this->initializere5899->__invoke($valueHolder03290, $this, 'newHydrator', array('hydrationMode' => $hydrationMode), $this->initializere5899) || 1) && $this->valueHolder03290 = $valueHolder03290;

        return $this->valueHolder03290->newHydrator($hydrationMode);
    }

    public function getProxyFactory()
    {
        $this->initializere5899 && ($this->initializere5899->__invoke($valueHolder03290, $this, 'getProxyFactory', array(), $this->initializere5899) || 1) && $this->valueHolder03290 = $valueHolder03290;

        return $this->valueHolder03290->getProxyFactory();
    }

    public function initializeObject($obj)
    {
        $this->initializere5899 && ($this->initializere5899->__invoke($valueHolder03290, $this, 'initializeObject', array('obj' => $obj), $this->initializere5899) || 1) && $this->valueHolder03290 = $valueHolder03290;

        return $this->valueHolder03290->initializeObject($obj);
    }

    public function getFilters()
    {
        $this->initializere5899 && ($this->initializere5899->__invoke($valueHolder03290, $this, 'getFilters', array(), $this->initializere5899) || 1) && $this->valueHolder03290 = $valueHolder03290;

        return $this->valueHolder03290->getFilters();
    }

    public function isFiltersStateClean()
    {
        $this->initializere5899 && ($this->initializere5899->__invoke($valueHolder03290, $this, 'isFiltersStateClean', array(), $this->initializere5899) || 1) && $this->valueHolder03290 = $valueHolder03290;

        return $this->valueHolder03290->isFiltersStateClean();
    }

    public function hasFilters()
    {
        $this->initializere5899 && ($this->initializere5899->__invoke($valueHolder03290, $this, 'hasFilters', array(), $this->initializere5899) || 1) && $this->valueHolder03290 = $valueHolder03290;

        return $this->valueHolder03290->hasFilters();
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

        $instance->initializere5899 = $initializer;

        return $instance;
    }

    protected function __construct(\Doctrine\DBAL\Connection $conn, \Doctrine\ORM\Configuration $config, \Doctrine\Common\EventManager $eventManager)
    {
        static $reflection;

        if (! $this->valueHolder03290) {
            $reflection = $reflection ?? new \ReflectionClass('Doctrine\\ORM\\EntityManager');
            $this->valueHolder03290 = $reflection->newInstanceWithoutConstructor();
        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $this, 'Doctrine\\ORM\\EntityManager')->__invoke($this);

        }

        $this->valueHolder03290->__construct($conn, $config, $eventManager);
    }

    public function & __get($name)
    {
        $this->initializere5899 && ($this->initializere5899->__invoke($valueHolder03290, $this, '__get', ['name' => $name], $this->initializere5899) || 1) && $this->valueHolder03290 = $valueHolder03290;

        if (isset(self::$publicProperties01ef2[$name])) {
            return $this->valueHolder03290->$name;
        }

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder03290;

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

        $targetObject = $this->valueHolder03290;
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
        $this->initializere5899 && ($this->initializere5899->__invoke($valueHolder03290, $this, '__set', array('name' => $name, 'value' => $value), $this->initializere5899) || 1) && $this->valueHolder03290 = $valueHolder03290;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder03290;

            $targetObject->$name = $value;

            return $targetObject->$name;
        }

        $targetObject = $this->valueHolder03290;
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
        $this->initializere5899 && ($this->initializere5899->__invoke($valueHolder03290, $this, '__isset', array('name' => $name), $this->initializere5899) || 1) && $this->valueHolder03290 = $valueHolder03290;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder03290;

            return isset($targetObject->$name);
        }

        $targetObject = $this->valueHolder03290;
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
        $this->initializere5899 && ($this->initializere5899->__invoke($valueHolder03290, $this, '__unset', array('name' => $name), $this->initializere5899) || 1) && $this->valueHolder03290 = $valueHolder03290;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder03290;

            unset($targetObject->$name);

            return;
        }

        $targetObject = $this->valueHolder03290;
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
        $this->initializere5899 && ($this->initializere5899->__invoke($valueHolder03290, $this, '__clone', array(), $this->initializere5899) || 1) && $this->valueHolder03290 = $valueHolder03290;

        $this->valueHolder03290 = clone $this->valueHolder03290;
    }

    public function __sleep()
    {
        $this->initializere5899 && ($this->initializere5899->__invoke($valueHolder03290, $this, '__sleep', array(), $this->initializere5899) || 1) && $this->valueHolder03290 = $valueHolder03290;

        return array('valueHolder03290');
    }

    public function __wakeup()
    {
        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $this, 'Doctrine\\ORM\\EntityManager')->__invoke($this);
    }

    public function setProxyInitializer(\Closure $initializer = null) : void
    {
        $this->initializere5899 = $initializer;
    }

    public function getProxyInitializer() : ?\Closure
    {
        return $this->initializere5899;
    }

    public function initializeProxy() : bool
    {
        return $this->initializere5899 && ($this->initializere5899->__invoke($valueHolder03290, $this, 'initializeProxy', array(), $this->initializere5899) || 1) && $this->valueHolder03290 = $valueHolder03290;
    }

    public function isProxyInitialized() : bool
    {
        return null !== $this->valueHolder03290;
    }

    public function getWrappedValueHolderValue()
    {
        return $this->valueHolder03290;
    }
}

if (!\class_exists('EntityManager_9a5be93', false)) {
    \class_alias(__NAMESPACE__.'\\EntityManager_9a5be93', 'EntityManager_9a5be93', false);
}
