<?php

use Doctrine\ORM\Mapping\ClassMetadataInfo;

$metadata->setInheritanceType(ClassMetadataInfo::INHERITANCE_TYPE_NONE);
$metadata->customRepositoryClassName = 'AppBundle\Repository\userRepository';
$metadata->setChangeTrackingPolicy(ClassMetadataInfo::CHANGETRACKING_DEFERRED_IMPLICIT);
$metadata->mapField(array(
   'fieldName' => 'id',
   'type' => 'integer',
   'id' => true,
   'columnName' => 'id',
  ));
$metadata->mapField(array(
   'columnName' => 'name',
   'fieldName' => 'name',
   'type' => 'string',
   'length' => 255,
  ));
$metadata->mapField(array(
   'columnName' => 'email',
   'fieldName' => 'email',
   'type' => 'string',
   'length' => 255,
   'unique' => true,
  ));
$metadata->mapField(array(
   'columnName' => 'password',
   'fieldName' => 'password',
   'type' => 'string',
   'length' => 255,
  ));
$metadata->mapField(array(
   'columnName' => 'photo',
   'fieldName' => 'photo',
   'type' => 'string',
   'length' => 255,
  ));
$metadata->mapField(array(
   'columnName' => 'lat',
   'fieldName' => 'lat',
   'type' => 'bigint',
  ));
$metadata->mapField(array(
   'columnName' => 'lng',
   'fieldName' => 'lng',
   'type' => 'bigint',
  ));
$metadata->setIdGeneratorType(ClassMetadataInfo::GENERATOR_TYPE_AUTO);