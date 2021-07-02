<?php

return [
    'files_repository' => env('STATAMIC_FILES_REPOSITORY', null),
    'files_repository_name' => env('STATAMIC_FILES_REPOSITORY_NAME', ''),

    'git' => [
        'user_name' => env('STATAMIC_GIT_NAME', ''),
        'user_email' => env('STATAMIC_GIT_EMAIL', '')
    ],

    'symlinks' => [
        'content' => sprintf(
            '%s/%s',
            env('STATAMIC_FILES_REPOSITORY_NAME', ''),
            'content'
        ),
        'resources/blueprints' => sprintf('%s/%s',
            env('STATAMIC_FILES_REPOSITORY_NAME', ''),
            'resources/blueprints'
        ),
        'resources/fieldsets' => sprintf('%s/%s',
            env('STATAMIC_FILES_REPOSITORY_NAME', ''),
            'resources/fieldsets'
        ),
        'resources/forms' => sprintf('%s/%s',
            env('STATAMIC_FILES_REPOSITORY_NAME', ''),
            'resources/forms'
        ),
        'resources/users' => sprintf('%s/%s',
            env('STATAMIC_FILES_REPOSITORY_NAME', ''),
            'resources/users'
        ),
        'users' => sprintf('%s/%s',
            env('STATAMIC_FILES_REPOSITORY_NAME', ''),
            'users'
        ),
    ],

    'event_subscriber' => \StatamicVaporCompatibility\Listeners\StatamicVaporFileModificationSubscriber::class,

    'events' => [
        // \Statamic\Events\AssetContainerDeleted::class,
        // \Statamic\Events\AssetContainerSaved::class,
        // \Statamic\Events\AssetDeleted::class,
        // \Statamic\Events\AssetFolderDeleted::class,
        // \Statamic\Events\AssetFolderSaved::class,
        // \Statamic\Events\AssetSaved::class,
        \Statamic\Events\BlueprintDeleted::class => \StatamicVaporCompatibility\Listeners\CommitBlueprintDeleted::class,
        \Statamic\Events\BlueprintSaved::class => \StatamicVaporCompatibility\Listeners\CommitBlueprintSaved::class,
        \Statamic\Events\CollectionDeleted::class => \StatamicVaporCompatibility\Listeners\CommitCollectionDeleted::class,
        \Statamic\Events\CollectionSaved::class => \StatamicVaporCompatibility\Listeners\CommitCollectionSaved::class,
        \Statamic\Events\CollectionTreeDeleted::class => \StatamicVaporCompatibility\Listeners\CommitCollectionTreeDeleted::class,
        \Statamic\Events\CollectionTreeSaved::class => \StatamicVaporCompatibility\Listeners\CommitCollectionTreeSaved::class,
        \Statamic\Events\EntryDeleted::class => \StatamicVaporCompatibility\Listeners\CommitEntryDeleted::class,
        \Statamic\Events\EntrySaved::class => \StatamicVaporCompatibility\Listeners\CommitEntrySaved::class,
        \Statamic\Events\FieldsetDeleted::class => \StatamicVaporCompatibility\Listeners\CommitFieldsetDeleted::class,
        \Statamic\Events\FieldsetSaved::class => \StatamicVaporCompatibility\Listeners\CommitFieldsetSaved::class,
        \Statamic\Events\FormDeleted::class => \StatamicVaporCompatibility\Listeners\CommitFormDeleted::class,
        \Statamic\Events\FormSaved::class => \StatamicVaporCompatibility\Listeners\CommitFormSaved::class,
        \Statamic\Events\GlobalSetDeleted::class => \StatamicVaporCompatibility\Listeners\CommitGlobalSetDeleted::class,
        \Statamic\Events\GlobalSetSaved::class => \StatamicVaporCompatibility\Listeners\CommitGlobalSetSaved::class,
        \Statamic\Events\NavDeleted::class => \StatamicVaporCompatibility\Listeners\CommitNavDeleted::class,
        \Statamic\Events\NavSaved::class => \StatamicVaporCompatibility\Listeners\CommitNavSaved::class,
        \Statamic\Events\NavTreeDeleted::class => \StatamicVaporCompatibility\Listeners\CommitNavTreeDeleted::class,
        \Statamic\Events\NavTreeSaved::class => \StatamicVaporCompatibility\Listeners\CommitNavTreeSaved::class,
        \Statamic\Events\RoleDeleted::class => \StatamicVaporCompatibility\Listeners\CommitRoleDeleted::class,
        \Statamic\Events\RoleSaved::class => \StatamicVaporCompatibility\Listeners\CommitRoleSaved::class,
        \Statamic\Events\SubmissionDeleted::class => \StatamicVaporCompatibility\Listeners\CommitSubmissionDeleted::class,
        \Statamic\Events\SubmissionSaved::class => \StatamicVaporCompatibility\Listeners\CommitSubmissionSaved::class,
        \Statamic\Events\TaxonomyDeleted::class => \StatamicVaporCompatibility\Listeners\CommitTaxonomyDeleted::class,
        \Statamic\Events\TaxonomySaved::class => \StatamicVaporCompatibility\Listeners\CommitTaxonomySaved::class,
        \Statamic\Events\TermDeleted::class => \StatamicVaporCompatibility\Listeners\CommitTermDeleted::class,
        \Statamic\Events\TermSaved::class => \StatamicVaporCompatibility\Listeners\CommitTermSaved::class,
        \Statamic\Events\UserDeleted::class => \StatamicVaporCompatibility\Listeners\CommitUserDeleted::class,
        \Statamic\Events\UserSaved::class => \StatamicVaporCompatibility\Listeners\CommitUserSaved::class,
        \Statamic\Events\UserGroupDeleted::class => \StatamicVaporCompatibility\Listeners\CommitUserGroupDeleted::class,
        \Statamic\Events\UserGroupSaved::class => \StatamicVaporCompatibility\Listeners\CommitUserGroupSaved::class,
        \Statamic\Events\DuplicateIdRegenerated::class => \StatamicVaporCompatibility\Listeners\CommitDuplicateIdRegenerated::class,
    ]
];
