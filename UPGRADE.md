# Upgrade to 2.x -> 3.x

With Twill 3.x some files and classes are moved.

We provide an automated upgrade path using `php artisan twill:upgrade`.


What changed:

- The `resources/views/admin` folder should be renamed `resources/views/twill`
- The `routes/admin.php` file should be renamed to `routes/twill.php`

Namespace changes:
```
app/Http/Controllers/Admin -> app/Http/Controllers/Twill
app/Http/Requests/Admin -> app/Http/Requests/Twill
```

## withVideo on media defaults to false

Previously `withVideo` was true by default, if you relied on this you have to update these media fields to
`'withVideo' => true`.

## media/file library

The default for media and file libraries are now local and glide, if you relied on the default config for aws
then you now need to specify this in your `.env`.

## Block editor render children

The `renderBlocks` method now by default will NOT render the nested repeaters below the block. If you relied on this
you now need to update to `renderBlocks(true)`

## Crops

Model crops are now a global config, if you do not need model specific crops you can manage them globally from your
config.