<?php

use App\Infrastructure\DbalType\ContentType;
use App\Infrastructure\DbalType\DisplayNameType;
use App\Infrastructure\DbalType\EmailType;
use App\Infrastructure\DbalType\ImageType;
use App\Infrastructure\DbalType\PasswordType;
use App\Infrastructure\DbalType\PostIdType;
use App\Infrastructure\DbalType\PublishedType;
use App\Infrastructure\DbalType\TitleType;
use App\Infrastructure\DbalType\UpdatedType;
use App\Infrastructure\DbalType\UserIdType;
use Doctrine\DBAL\Types\Type;

$types =  [
    UserIdType::NAME => UserIdType::class,
    DisplayNameType::NAME => DisplayNameType::class,
    EmailType::NAME => EmailType::class,
    PasswordType::NAME => PasswordType::class,
    ImageType::NAME => ImageType::class,
    PostIdType::NAME => PostIdType::class,
    TitleType::NAME => TitleType::class,
    ContentType::NAME => ContentType::class,
    PublishedType::NAME => PublishedType::class,
    UpdatedType::NAME => UpdatedType::class,
];

foreach ($types as $doctrineTypeId => $classType) {
    Type::addType($doctrineTypeId, $classType);
}
