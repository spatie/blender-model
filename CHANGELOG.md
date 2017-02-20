# Changelog

All notable changes to `blender-model` will be documented in this file

## 5.1.2 - 2017-02-20
- Fixed old collection call for L5.4

## 5.1.1 - 2017-02-20
- Removed `fragment` usages

## 5.0.2 - 2017-02-16
- Fixed `updateDates`

## 5.0.1 - 2017-02-03
- make compatible with `spatie/laravel-medialibrary` v5

## 5.0.0 - 2017-02-03
- make compatible with `spatie/laravel-medialibrary` v5

## 4.2.14 - 2017-02-16
- Fixed `updateDates`

## 4.2.13 - 2017-02-03
- make compatible with `spatie/laravel-medialibrary` v5

## 4.2.12 - 2016-01-24
- allow drafts in `Controller::find`

## 4.2.9 - 2016-01-24
- improve support for Laravel 5.4

## 4.2.8 - 2016-01-13
- rename `temp` to `draft` in media custom properties

## 4.2.7 - 2016-01-12
- fix typehint of `hasContentBlocks`

## 4.2.6 - 2016-01-12
- fix typehint of `hasContentBlocks`

## 4.2.5 - 2016-01-12
- add `hasContentBlocks`

## 4.2.4 - 2016-01-12
- Use SortableScope on all front models

## 4.2.3 - 2016-01-11
- Content block tweaks

## 4.2.2 - 2016-01-10
- Media collection regression fixes

## 4.2.0 - 2016-01-10
- Add content blocks
- Transformers now live here too

## 4.1.0 - 2016-01-10
- Add sortable scope

## 4.0.4 - 2016-01-05
- Fix for scope to filter draft media

## 4.0.3 - 2016-01-05
- Use scope to filter draft media

## 4.0.2 - 2016-01-05
- Do not display temp media on front site

## 4.0.1 - 2016-01-04
- Fix non-draft scope

## 4.0.0 - 2016-01-04
- Added `NonDraftScope` and `OnlineScope`

## 3.1.1 - 2016-11-29
- The `mediaLibraryCollections` property should now be an associative array with the collection type

## 3.0.1 - 2016-11-28
- Fix tag updater

## 3.0.0 - 2016-11-28
- Make compatible with laravel-tags

## 2.1.3 - 2016-11-23
- Flush cache after `changeOrder`

## 2.1.2 - 2016-11-17
- PR #8

## 2.1.1 - 2016-11-08
- fix for saving custom properties on media

## 2.1.0 - 2016-11-08
- Updated Vuex to 2.0.0-rc

## 2.0.1 - 2016-11-07
- remove unused `hasTags`

## 2.0.0 - 2016-11-07
- rename all usages of `url` to `slug`
- add support for `spatie/laravel-tags`

## 1.0.11 - 2017-01-03
- Fix `updateTranslations` request check

## 1.0.10 - 2016-11-23
- Flush cache afters `changeOrder`

## 1.0.9 - 2016-10-26
- Fix destroy method

## 1.0.8 - 2016-10-25
- Pass all create method parameters to make method

## 1.0.7 - 2016-10-25
- Made `DateUpdater` much more generic

## 1.0.6 - 2016-10-22
- Allow eloquent-sortable v3

## 1.0.5 - 2016-10-20
- Added `updateFields` to `Controller`

## 1.0.4 - 2016-10-20
- Fixed `Sortable` check in `Controller`

## 1.0.3 - 2016-10-20
- Controller module name resolve fix
- Removed `Repository`

## 1.0.2 - 2016-10-20
- Controller module name resolve fix

## 1.0.1 - 2016-10-18
- Repository namespace fix

## 1.0.0 - 2016-10-18

- First release
