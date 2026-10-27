# phpBB Active Topics

## Changelog

### v1.4.0 (27-10-2026)
- Fixed: Wrong label id in html template.
- Fixed: The memory allocated for an SQL query is not released.
- Fixed: `validate_start()` for pagination has an incorrect parameter.
- Requirement check
    - Fixed: The last 0 in the version number is truncated.
    - Fixed: Incorrect conversion of the version number with a tilde.
    - Added: Requirement check expanded to include wildcards in version numbers.
- Added: Range check for requested variables.
- Added: Display forum inside the topic row of active topics.
- Added: Store the sort days in a cookie and load the cookie variable as the default setting.
- Changed: Build select box with a TWIG macro.
- Changed: Encoding query parameters for the pagination URL.
- Changed: The position and parent forum settings from radio button to select box.

### v1.3.2 (25-09-2026)
- Fixed: PHP error `Undefined array key` when moved topic in category.
- Changed: The trim() function is backward-compatible with PHP 8.6.
- Changed: Use TWIG to build html code for parent forum links.

### v1.3.1 (15-08-2026)
- Fixed: The SQL query to check the number of topics does not work with PostgreSQL.
- Changed: Language variable improved.
- Changed: The SearchParams variable has been replaced by the event's variable.

### v1.3.0 (20-07-2026)
- Fixed: In the version-checking class, the logical OR was used instead of the bitwise OR
- Changed: Use just one SQL query to retrieve the parent forums
- Changed: Display only parent forums that are subordinate to the current category
- Changed: jQuery was replaced with vanilla JS, because the page flickered when loading
- Changed: Update `license.txt`
- Added: Display active topics in multiple pages (pagination)

### v1.2.0 (01-05-2026)
- Removed unused language class
- Improved sql-query for parent forums
- Renamed `activetopics.js` to `imcger_activetopics.js`
- Var names changed in acp listener
- Method name changed in main listener
- Use acp template event to insert forum settings
- Use `composer.json` requirements in `ext.php`
  - Added class `imcger_ext_requirements`
- Use event to get forum data in main listener

### v1.1.1 (13-10-2024)
- Minor change

### v1.1.0 (15-12-2023)
- Published

